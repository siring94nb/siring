<?php

namespace app\model;

use traits\model\SoftDelete;

/**
 * lilu
 * 行业模板套餐
 */
class Templete extends  Base{

    use SoftDelete;
    protected $table="hy_model";
    protected $deleteTime = 'del_time';
    protected $resultSetType = 'collection';
    protected $createTime   = 'created_time';
    protected $updateTime    = 'update_time';



}