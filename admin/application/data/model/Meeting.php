<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/26
 * Time: 17:16
 */
namespace app\data\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;

/**
 * lilu
 * 行业模板订单
 */
class Meeting extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $table = "meeting";
    protected $resultSetType = 'collection';

}
