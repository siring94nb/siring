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
     * 添加
     */


}