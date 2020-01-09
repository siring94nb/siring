<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class Member extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $table = "member";
    protected $resultSetType = 'collection';
}
