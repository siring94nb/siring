<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * lilu
 * 线下支付审核
 */
class Offline extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $table="offline";
    protected $resultSetType = 'collection';

    /**
     * 生成线下支付订单
     * @param $no
     * @param $uid
     * @param $unipay
     * @return false|int
     */
    public function get_add($no,$uid,$unipay)
    {

        $unionpay = json_decode($unipay,true);

        return $this->save([
            'order_number' => $no,
            'member_account' => $uid,
            'bank_name' => $unionpay['bank_name'],
            'bank_number' => $unionpay['bank_number'],
            'pay_money' => $unionpay['pay_money'],
            'comment' => $unionpay['comment'],
            'account_number' => $unionpay['account_number'],
            'type' => $unionpay['type'],
            'order_status' => 1,
            'create_time' => time(),
        ]);


    }

}
