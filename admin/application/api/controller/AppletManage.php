<?php

namespace app\api\controller;

use think\Request;
use think\Controller;
use think\Session;
use think\Db;
use app\model\Templete;

/**
 * lilu
 * 前端-行业模板
 */
class AppletManage extends Base {
    
    /**
     * lilu
     * 获取行业模板列表
     * param     model_type    1   diy    0   固定样式
     */
    public function get_model_list()
    {
        $request=Request::instance();
        $postAData=$request->param();
        $model_list=Templete::all()->toArray();
        if($model_list){
            return json(['code'=>1,'msg'=>'获取列表成功','data'=>$model_list]);
        }else{
            return json(['code'=>0,'msg'=>'获取失败']);
        }
    }

    /**
     * lilu
     * 获取模板套餐
     * param  model_meal_category   1   diy    2 固定
     */
    public function get_model_meal_by_category()
    {
        $request=Request::instance();
        $postAData=$request->param();
        $model_list=Templete::all(function($query){
            $where['model_meal_category']=$postAData['model_meal_category'];
            $query->where($where)->field('id,model_name,model_image,model_type')->order('model_rank');
        })->toArray();
        if($model_list){
            return json(['code'=>1,'msg'=>'获取模板套餐成功','data'=>$model_list]);
        }else{
            return json(['code'=>0,'msg'=>'获取模板套餐失败']);
        }

    }


}
