<?php

namespace app\data\model;

use think\Model;

class Collection extends Model
{
    protected $table = "collection";
    protected $resultSetType = 'collection';

    public function user_pro($gid,$uid)
    {
        $res = self::get(['pro_id'=>$gid,'user_id'=>$uid]);

        return $res ? 1 : 0;
    }
}
