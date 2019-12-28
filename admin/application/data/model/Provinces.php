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
//            ['type', 'require', '城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $data =  Provinces::all(['pid'=>$param['pid']]);

        return $data ? $data->toArray() : returnJson(0,'数据不存在');
    }

    //城市新增
    public function city_add($param)
    {
        $validate = new Validate([
            ['pid', 'require', '省份id不能为空'],
            ['name', 'require', '城市名称不能为空'],
            ['type', 'require', '城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $data   = new Provinces;

        $res = $data->save($param);

        return $res;

    }

    //城市特级
    public function city_eidt($pid)
    {
        $model = new Provinces;
        $arr =  $model->all(['pid'=>$pid])->toArray();
        //pp($arr);die;
        $map = ["zero","one","two","three"];

        foreach ($arr as $key=>$val){
            $arr[$key]['type_name'] = $map[$val['type']];//映射
        }

        $data = [];
        foreach ($arr as $key=>$val){

            $data[$val['type_name']][] = $val;
        }

        return $data;
    }


    /**
     * 删除城市
     * @param $cid
     * @return int
     */
    public function city_del($cid)
    {
        $data = Provinces::destroy($cid);

        return $data;
    }

    /**
     * 移动城市
     *
     */
    public function move($param)
    {
        $validate = new Validate([
            ['cid', 'require', '当前城市id不能为空'],
            ['type', 'require', '移入城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        //print_r($param);die;
        $data   = new Provinces;

        $res = $data->save([
            'type'  => $param['type'],
        ],['id' => $param['cid']]);

        return $res;
    }

    //查询城市名
    public static function province_query($cid)
    {
        return self::get(['id'=>$cid]);
    }

}
