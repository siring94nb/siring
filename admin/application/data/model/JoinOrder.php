<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/9
 * Time: 14:11
 */
namespace app\data\model;

use think\Model;

class JoinOrder extends Model
{
    protected $table = "order";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
//    protected $hidden = ['created_at','updated_at'];1572839536


    /**
     * 新增订单
     * @param $role_type
     * @param $uid
     * @param $pay_type
     * @param $num
     * @param $money
     * @param $dev
     * @param $grade
     * @param $con
     * @return JoinOrder|bool
     */
    public function order_add($role_type,$uid,$pay_type,$num,$money,$dev,$grade,$con)
    {
        $data = new JoinOrder;
        $data->save([
            'type' => $role_type,
            'user_id' => $uid,
            'pay_type' => $pay_type,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'payment' => 1,
            'status' => 1,
            'dev' => $dev,
            'city_id' => $grade,
            'con' =>$con,
            'created_at' => time(),

        ]);

        return $data !== false ? $data : false;
    }

    /**
     * 生成订单号
     * @return string
     */
    function get_sn() {
        return 'JS'.date('YmdHis').rand(100000, 999999);
    }

    /**
     * 获取全部数据
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function join_order_list()
    {

        return self::all()->toArray();

    }


    /**
     * 加盟角色订单列表分类
     * @author fyk
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function join_list($param)
    {

        $where = [];
        $where['a.type'] = $param['type'];
        if(!empty($param['user_id'])){
            $where['a.user_id'] = $param['user_id'];
        }
        if(!empty($param['phone'])){
            $where['b.phone'] = ['like','%'.$param['phone'].'%'];
        }
        if(!empty($param['start_time'])){
            $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
            $where['a.created_at'] = ['gt',$param['start_time']];
        }
        if(!empty($param['end_time'])){
            $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
            $where['a.created_at'] = ['lt',$param['end_time']];
        }
        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['a.created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = 'a.id,a.type,a.user_id,a.pay_type,a.pay_time,a.created_at,
        a.no,a.money,a.payment,a.status,a.grade,a.dev,a.updated_at,b.phone';
        $order = 'a.id desc';

        $list =  JoinOrder::where( $where )
            ->alias('a')->join('user b','a.user_id=b.id','inner')
            -> field( $field ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list;
    }


    /**
     * 支付流程
     * @author fyk
     * @param $id
     * @param $money
     * @param $pay_type
     * @param $password
     * @param $unionpay
     * @return array|mixed|string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function pay($id,$money,$pay_type,$password,$unionpay,$ratio,$notify_url,$return_url,$wx_url)
    {
        $data = self::get($id);
        if(!$data) returnJson(0,'订单有误');
        if($data['payment'] == 2) returnJson(0,'当前订单已支付');
        //查询等级
        $user = UserGrade::get(['user_id'=>$data['user_id']]);
        //查询比例
        $grade = JoinRole::member_details($user['grade']);
        //算出金额
        $pay_money = $data['money'] * ($grade['discount']/100) * $ratio;
        //比较
        if($money != $pay_money) returnJson(0,'系统有误');

        switch ($pay_type){
            case 1://支付宝支付

                $pay = 0.01 ;//先测试1分钱
                $title = '软件定制' ;
                $res = ( new Alipay()) ->get_alipay($notify_url,$return_url,$data['no'],$pay,$title);

                self::save(['alipay' => $res],['id' => $id]);
                return $res; exit();
                break;
            case 2://微信支付

                $pay = 1;//先测试1分钱

                $title = '软件定制';
                $res = (new WechatPay())->pay($title,$data['no'], $pay, $wx_url);

                return $res; exit();


                break;

            case 3://银联卡支付

                $this->startTrans();
                try {
                    $data_need = [
                        'pay_type'=>3,
                        'payment'=> 2,
                        'unionpay'=> $unionpay,
                    ];
                    self::where('id', $id)->update($data_need);

                    $off = (new Offline())->get_add($data['no'],$data['user_id'],$unionpay);

                    $this->commit();

                    return $off ? returnJson(1, '提交成功，请等待审核', $off) : returnJson(0, '提交失败', $off);


                } catch (\Exception $e) {

                    $this->rollback();

                    returnJson(0,'事务失败');exit();
                }
                break;
            case 4://余额支付

                // 判断密码是否正确
                $fund = UserFund::user($data['user_id']);
                if($fund['money'] < $pay_money )returnJson(0,'余额不足请充值');
                //pp($fund);die;
                if (password_verify($password ,$fund['pay_password'])) {
                    $this->startTrans();
                    try {
                        //减去余额
                        $re = (new UserFund())::where('user_id', $data['user_id'])->setDec('money', $pay_money);
                        //修改订单表
                        $data_need = [
                            'pay_type'=>4,
                            'payment'=> 2,
                            'pay_time'=> time(),
                            'need_status'=> 4,
                        ];
                        self::save($data_need,['id' => $id]);
                        //订单统计表添加
                        $role_type = 4;
                        $budget_type = 1;
                        $income = '';//收入金额
                        (new AllOrder())->allorder_add($role_type,$budget_type,$data,$pay_money,$income);

                        $this->commit();

                        return $re ? returnJson(1, '支付成功', $re) : returnJson(0, '支付失败', $re);

                    } catch (\Exception $e) {

                        $this->rollback();

                        returnJson(0,'事务失败');exit();
                    }
                }else{
                    returnJson(0, '支付密码错误');
                }
                break;
            default:
                returnJson(0,'参数有误');
        }

    }
}
