<?php

namespace app\data\model;

use think\Model;

class Reviews extends Model
{
    protected $table = "reviews";
    protected $resultSetType = 'collection';

    /**
     * 评论数量
     * @param $gid
     * @return int|string
     */
    public static function num($gid)
    {
        return self::where(['goods_id'=>$gid,'delect_at'=>null])->count();

    }

    /**
     * 二级评论
     * @param $cid
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function two_level($cid)
    {
        return self::where(['cid'=>$cid,'delect_at'=>null])->select();

    }
    
    /**
     * 二级评论
     * @param $cid
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function two_level_del($cid)
    {
        return self::where(['cid'=>$cid,'delect_at'=>null])->select();

    }
}
