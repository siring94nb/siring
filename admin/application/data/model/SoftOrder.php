<?php

namespace app\data\model;

use think\Model;

class SoftOrder extends Model
{
    protected $table = "order";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime  = 'updated_at';


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
    public function order_add($param)
    {

        $data = new SoftOrder;
        $data->save([
            'type' => 4,
            'user_id' => $param['user_id'],
            'sid' => $param['sid'],
            'yid' => $param['yid'],
            'no' => $this->get_sn(),
            'goods_id' => $param['goods_id'],
            'money' => $param['price'],
            'invite_code' => $param['invitation'],
            //'created_at'=>time(),

        ]);

        return $data !== false ? $data : false;
    }

    /**
     * 生成单号--软件定制订单
     * @return string
     */
    function get_sn() {
        return 'RJ'.date('YmdHis').rand(100000, 999999);
    }
}
