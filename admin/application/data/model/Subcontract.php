<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/14
 * Time: 10:46
 */
namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 分包商项目
 * Class Subcontract
 * @package app\data\model
 */
class Subcontract extends Model
{
    use SoftDelete;
    protected $deleteTime = 'deleted_at';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    protected $table = "subcontract";
    protected $resultSetType = 'collection';

}
