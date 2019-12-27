<?php

namespace app\data\model;
use think\Model;
use think\Db;
use traits\model\SoftDelete;


/**
 * lilu
 * 定制需求订单
 */
class NeedOrder extends Model
{

        use SoftDelete;
        protected $deleteTime = 'del_time';
        protected $createTime = 'create_time';
        protected $updateTime = 'update_time';
        protected $table="need_order";
        protected $resultSetType = 'collection';

        /**
         * lilu
         * 定制需求添加订单
         * param   订单参数
         */
        public function order_add()
        {
            $data = new SoftOrder;
            return $data !== false ? $data : false;
        }

        /**
         * @author fyk
         * 获取定制需求订单
         */
        public function get_need_order($param,$po)
        {
            $where=[];
            $where['del_time'] = null;
            if($po == 1){
                $where['user_id'] = $param['user_id'];
            }

            if(!empty($param['title'])){
                $where['need_order|need_phone'] = $param['title'];
            }

            if(!empty($param['start_time'])){
                $param['start_time'] = strtotime($param['start_time']);
                $where['create_time'] = ['gt',$param['start_time']];
            }
            if(!empty($param['end_time'])){
                $param['end_time'] = strtotime($param['end_time']);
                $where['create_time'] = ['lt',$param['end_time']];
            }
            if(!empty($param['start_time']) && !empty($param['end_time'])){
                $where['create_time'] = ['between',[$param['start_time'],$param['end_time']]];
            }

            if(empty($param['page'])){
                $param['page'] = 1;
            }
            $field = '*';
            $order = 'create_time desc';
            $list = NeedOrder::field($field) -> where( $where ) -> order( $order )
                -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

            foreach ($list['data'] as $k =>$v){

                $terminal= json_decode( $v['need_terminal'] , true );
                if(!empty($terminal)){
                    $res = join('/',$terminal);
                    $list['data'][$k]['terminal'] = $res;
                }else{
                    $list['data'][$k]['terminal'] = "无";
                }
            }

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
    public function pay($id,$money,$pay_type,$password,$unionpay)
    {
        $data = self::get($id);
        if(!$data) returnJson(0,'订单有误');
        if($data['pay_type'] == 2) returnJson(0,'当前订单已支付');
        //查询等级
        $user = UserGrade::get(['user_id'=>$data['user_id']]);
        //查询比例
        $grade = JoinRole::member_details($user['grade']);
        //算出金额
        $pay_money = $data['need_money'] * ($grade['discount']/100) * 0.7;
        //比较
        if($money != $pay_money) returnJson(0,'系统有误');

        switch ($pay_type){
            case 1://支付宝支付

                $pay = 0.01 ;//先测试1分钱
                $title = '软件定制' ;
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_return'; // 异步通知 url，*强烈建议加上本参数*
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; // 同步通知 url，*强烈建议加上本参数*
                $res = ( new Alipay()) ->get_alipay($notify_url,$return_url,$data['need_order'],$pay,$title);

                self::save(['alipay' => $res],['id' => $id]);
                return $res; exit();
                break;
            case 2://微信支付

                // 回调地址
                $url = 'https://manage.siring.com.cn/api/NeedOrder/app_notice';

                $pay = 1;//先测试1分钱

                $title = '软件定制';
                $res = (new WechatPay())->pay($title,$data['need_order'], $pay, $url);

                return $res; exit();


            break;

            case 3://银联卡支付

                $this->startTrans();
                try {
                    $data_need = [
                        'need_pay_type'=>3,
                        'unionpay'=> $unionpay,
                    ];
                    self::where('id', $id)->update($data_need);

                    $off = (new Offline())->get_add($data['need_order'],$data['user_id'],$unionpay);

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
                //pp($fund);die;
                if (password_verify($password ,$fund['pay_password'])) {
                    $this->startTrans();
                    try {
                        //减去余额
                        $re = (new UserFund())::where('user_id', $data['user_id'])->setDec('money', $pay_money);
                        //修改订单表
                        $data_need = [
                            'need_pay_type'=>4,
                            'pay_type'=> 2,
                            'pay_time'=> time(),
                            'process'=>1,
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
