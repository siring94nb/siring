<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/17
 * Time: 11:13
 */
namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class Course extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $table = "course";
    protected $resultSetType = 'collection';
}
