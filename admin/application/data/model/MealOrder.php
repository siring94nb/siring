<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * lilu
 * 行业模板订单
 */
class MealOrder extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $table="model_order";
    protected $resultSetType = 'collection';


}