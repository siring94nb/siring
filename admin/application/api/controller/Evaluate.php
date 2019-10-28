<?php
namespace app\api\controller;

use think\Request;
use think\Validate;
use think\Controller;
use think\Session;
use think\Db;
use app\util\ReturnCode;
use app\data\model\Evaluate as Eva;

/**
 * lilu
 * 快捷估价控制器
 */
class Evaluate extends Controller{


    /**
     * lilu
     * 获取快捷估价的平台(所有)
     */
    public function get_plate_form(){
        $plate_list=Eva::group('plate_form')->column('id,plate_form');
        foreach($plate_list as $k =>$v){
            $plate_list[$k]=Eva::getStatusAttr($v);
        }
        return $plate_list ? returnJson(1,'获取成功',$plate_list) : returnJson(0,'获取失败',$plate_list);
    }

    /**
     * lilu
     * 获取平台对应的分类以及其他信息
     * parsm  id(平台id)
     */
    public function get_plate_list(){
        $request=Request::instance();
        $plate_id=$request->param();
         //halt($plate_id);
        //postman测试模拟
        // $plate_id=explode(',',$plate_id['id']);
        $plate_list=[];
        foreach($plate_id['id'] as $k =>$v){
            //1.获取平台
            $plate_list[$v]['plate_from']=Eva::getStatusAttr($v);
            $plate_list[$v]['plate_from_id']=$v;                                //平台id
            //2.获取分类对应的模块
                //获取分类下面的模型
           $model=Eva::getEvaluate_model($v);     //$v=>平台id 
                //3.获取对应模型下面的功能点
            foreach($model as $k3 =>$v3){
                    $plate_list[$v]['model'][$k3]['evaluate_type']=Eva::getEvaluate_type($v,$v3['model']);
                    if($k3==0){
                        //统计分类下的model数量
                        $plate_list[$v]['model'][$k3]['model_num']=Db::table('evaluate')->where(['plate_form'=>$v,'evaluate_type'=>$plate_list[$v]['model'][$k3]['evaluate_type']])->group('model')->count();
                    }else{
                        $plate_list[$v]['model'][$k3]['model_num']=0;
                    }
                    $plate_list[$v]['model'][$k3]['model_name']=$v3['model'];
                    $plate_list[$v]['model'][$k3]['function_point']=Eva::getEvaluate_function($v,$v3['model']);   //获取功能点
                }
        }
        return $plate_list ? returnJson(1,'获取成功',$plate_list) : returnJson(0,'获取失败',$plate_list);
    }



}