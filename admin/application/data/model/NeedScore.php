<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/24
 * Time: 15:21
 */
namespace app\data\model;

use think\Model;

class NeedScore extends Model
{
    protected $table = "need_score";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
}
