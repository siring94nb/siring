<?php

namespace app\data\model;

use think\Model;

class Banner extends Model
{
    /**
     * 首页轮播model
     * @var string
     */
    protected $table = "banner";
    protected $resultSetType = 'collection';

    /**
     * 查询全部轮播图
     * @throws \think\exception\DbException
     */
    public function banner_list()
    {
        return self::all() ? self::all()->toArray() : returnJson(0,'数据有误');
    }
}
