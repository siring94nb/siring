<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/18
 * Time: 14:57
 */
namespace app\data\model;

use think\Model;

class Recharge extends Model
{
    protected $table = "recharge_order";
    protected $resultSetType = 'collection';
    protected $createTime = 'created_at';

    //新增订单
    public function order_add($type, $uid, $money,$coupon)
    {

        $data = new Recharge;
        $data->save([
            'type' => $type,
            'user_id' => $uid,
            'no' => $this->get_sn(),
            'money' => $money,
            'coupon' => $coupon,
            'status' => 1,
            'created_at' => time(),

        ]);

        return $data !== false ? $data : false;
    }

    //生成订单号
    function get_sn()
    {
        return 'CZ' . date('YmdHi') . rand(100000, 999999);
    }


}
