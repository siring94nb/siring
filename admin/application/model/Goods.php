<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 19:46
 */

namespace app\model;

use traits\model\SoftDelete;
/**
 * lilu
 * 商品模型
 */
class Goods extends  Base{

    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $table = "product";
    protected $resultSetType = 'collection';
    protected $createTime   = 'created_at';
    protected $updateTime    = 'end_time';

    


}