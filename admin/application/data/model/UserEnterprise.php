<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class UserEnterprise extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $table="user_enterprise";
    protected $resultSetType = 'collection';

    /**
     * 新增
     * @param $param
     * @return UserEnterprise|bool
     */
    public function add($param)
    {
        $user = new UserEnterprise;
        $user->save([
            'user_id' => $param['uid'],
            'name' => $param['title'],
            'duty' => $param['duty'],
            'business_license' => $param['business_license'],
            'id_card_just' => $param['id_card_just'],
            'id_card_back' => $param['id_card_back'],
        ]);
        return $user  !== false ? $user : false;
    }

    /**
     * 修改
     * @param $param
     * @return UserEnterprise|bool
     */
    public function edit($param)
    {
        $user = new UserEnterprise;
        $user->save([
            'user_id' => $param['uid'],
            'name' => $param['title'],
            'duty' => $param['duty'],
            'business_license' => $param['business_license'],
            'id_card_just' => $param['id_card_just'],
            'id_card_back' => $param['id_card_back'],
        ],['id'=>$param['id']]);
        return $user  !== false ? $user : false;
    }
}
