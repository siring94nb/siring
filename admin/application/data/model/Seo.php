<?php

namespace app\data\model;

use think\Model;

class Seo extends Model
{
    protected $table = "seo";
    protected $resultSetType = 'collection';

    //获取信息
    public function seo_index()
    {
        return self::get(1) ? self::get(1)->toArray() : returnJson(0,'数据有误');
    }
}
