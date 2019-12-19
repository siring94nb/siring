<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/19
 * Time: 12:00
 */
namespace app\data\model;

use think\Model;

class CashWith extends Model
{
    protected $table = "cash_with";
    protected $resultSetType = 'collection';

    public function add($uid,$money,$card)
    {
        return $this->save([
        'user_id' => $uid,
        'cash_money' => $money,
        'account_no' => $card,
        'cash_mode' => 1,
        'created_at' => time(),
        ]);

    }

}
