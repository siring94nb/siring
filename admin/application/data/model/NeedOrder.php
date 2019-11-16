<?php

namespace app\data\model;
use think\Model;
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
        protected $table="neen_order";
        protected $resultSetType = 'collection';
    
        /**
         * lilu
         * 定制需求添加订单
         * param   订单参数
         */
        public function order_add($pay_type,$uid,$sid,$yid,$goods_id,$paid_price,$balance,$money,$invite_code,$bank_card,$bank_pay_time,$con)
        {
            $data = new SoftOrder;
            $data->save([
                'pay_type' => $pay_type,
                'user_id' => $uid,
                'sid' => $sid,
                'yid' => $yid,
                'no' => $this->get_sn(),
                'goods_id' => $goods_id,
                'paid_price' => $paid_price,
                'balance_price' => $balance,
                'money' => $money,
                'invite_code' => $invite_code,
                'bank_card' => $bank_card,
                'bank_pay_time' => $bank_pay_time,
                'con' =>$con,
                'create_time'=>time(),

            ]);

            return $data !== false ? $data : false;
        }
    
    


}