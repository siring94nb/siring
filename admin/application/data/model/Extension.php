<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class Extension extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $table = "extension";
    protected $resultSetType = 'collection';
}
