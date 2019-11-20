<?php

namespace app\data\model;

use think\Model;

class SoftOrder extends Model
{
    protected $table = "soft_order";
    protected $resultSetType = 'collection';
//    protected $autoWriteTimestamp = true;
//    protected $createTime = 'create_time';


    /**
     * 新增订单
     * @param $pay_type
     * @param $uid
     * @param $yid
     * @param $goods_id
     * @param $paid_price
     * @param $balance
     * @param $money
     * @param $invite_code
     * @param $bank_card
     * @param $bank_pay_time
     * @param $con
     * @return JoinOrder|bool
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

    /**
     * 生成单号--软件定制订单
     * @return string
     */
    function get_sn() {
        return 'RJ'.date('YmdHi').rand(100000, 999999);
    }
}
