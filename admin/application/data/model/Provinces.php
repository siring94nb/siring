<?php

namespace app\data\model;

use think\Model;
use think\Validate;

class Provinces extends Model
{
    protected $table = "provinces";
    protected $resultSetType = 'collection';


    //省份
    public function province_index()
    {
        return Provinces::where('pid',0)->select() ? Provinces::where('pid',0)->field('id,name')->select() : returnJson(0,'数据不存在');
    }
    
    //城市
    public function city_index($param)
    {
        $validate = new Validate([
            ['pid', 'require', '省份id不能为空'],
            ['type', 'require', '城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $data =  Provinces::all(['pid'=>$param['pid'],'type'=>$param['cid']]);

        return $data ? $data->toArray() : returnJson(0,'数据不存在');
    }
}
