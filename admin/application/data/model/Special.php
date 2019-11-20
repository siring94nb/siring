<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class Special extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table = "special";
    protected $resultSetType = 'collection';

    /**
     * 规格详情
     * @param $gid
     * @return Special[]|false
     * @throws \think\exception\DbException
     */
    public static function spec_pro($gid)
    {
        $res = self::all(function($query)use($gid){
            $query->where('goods_id', $gid)->order('id', 'asc')->field('id,attr_title,price,bottom_price,cycle_time,goods_id');
        });

        return $res;
    }
}
