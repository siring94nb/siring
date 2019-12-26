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


    public function pay($id,$money,$pay_type,$password,$unionpay)
    {
        switch ($pay_type){
            case 1://支付宝支付
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
                $pay = 1;//先测试1分钱

                $title = '软件定制';
                $res = ( new Alipay()) ->get_alipay($data['need_order'],$pay,$title);

                return $res; exit();
                break;
            case 2://微信支付
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

                // 查询订单信息
                $url = 'https://manage.siring.com.cn/api/NeedOrder/app_notice';

                $pay = 1;//先测试1分钱

                $title = '软件定制';
                $res = (new WechatPay())->pay($title,$data['need_order'], $pay, $url);

                return $res; exit();



            break;

            case 3://银联卡支付

                $data = [
                    'need_pay_type'=>3,
                    'unionpay'=> $unionpay,
                ];
                $re = self::where('id', $id)->update($data);

                return $re ? returnJson(1, '提交成功，请等待审核', $re) : returnJson(0, '提交失败', $re);

                break;
            case 4://余额支付

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
                // 判断密码是否正确
                $fund = UserFund::user($data['user_id']);
                //pp($fund);die;
                if (password_verify($password ,$fund['pay_password'])) {
                    $re = db('user_fund')->where('user_id', $data['user_id'])->setDec('money', $pay_money);

                    return $re ? returnJson(1, '支付成功', $re) : returnJson(0, '支付失败', $re);
                }else{
                    returnJson(0, '支付密码错误');
                }
                break;
            default:
                returnJson(0,'参数有误');
        }

    }


}
