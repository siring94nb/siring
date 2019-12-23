<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class Discount extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $table = "discount";
    protected $resultSetType = 'collection';
}
