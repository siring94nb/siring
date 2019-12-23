<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * lilu
 * 用户银行卡表
 */
class UserCard extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $table="user_card";
    protected $resultSetType = 'collection';

    /**
     * 新增
     * @param $param
     * @return false|int
     */
    public function add($param)
    {
        return $this->save([
            'user_id' => $param['user_id'],
            'card_number' => $param['card_number'],
            'card_name' => $param['card_name'],
            'bank_branch' => $param['bank_branch'],
            'bank_name' => $param['bank_name'],
            'province' => $param['province'],
            'city' => $param['city'],
            'area' => $param['area'],
            'create_time' => time(),
        ]);

    }


}
