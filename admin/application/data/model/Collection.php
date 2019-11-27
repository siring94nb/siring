<?php

namespace app\data\model;

use think\Model;

/**
 * 用户收藏、用户关注
 * Class Collection
 * @package app\data\model
 */
class Collection extends Model
{
    protected $table = "collection";
    protected $resultSetType = 'collection';

    public static function user_pro($type,$gid,$uid)
    {
        $res = self::get(['type'=>$type,'pro_id'=>$gid,'user_id'=>$uid]);

        return $res ? 1 : 0;
    }
}
