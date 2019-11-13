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


}