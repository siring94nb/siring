<?php

namespace app\data\model;

use think\Model;

class About extends Model
{
    protected $table = "about";
    protected $resultSetType = 'collection';


    //关于我们
    public function about_index($type)
    {
        return About::where('type',$type)->value('con') ? About::where('type',$type)->value('con') : returnJson(0,'数据不存在, 请先检查类型');
    }



}
