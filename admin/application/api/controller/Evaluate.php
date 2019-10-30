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
        $plate_id=$request->post();
        // $plate_id=explode(',',$plate_id['id']);
        $plate_list=[];
        foreach($plate_id['id'] as $k =>$v){
            halt($v);
            //1.获取平台
            $plate_list[$k]['plate_from']=Eva::getStatusAttr($v);
            $plate_list[$k]['plate_from_id']=$v;                                //平台id
            //2.获取平台对应的分类
            $evaluate_type=Eva::getEvaluate_type($v);     //$v=>平台id 
            //3.获取分类下对应的model
            $model2=[];
            foreach($evaluate_type as $k2 =>$v2){
                $mo=Eva::getEvaluate_model($v,$v2);
                $model2=array_merge($model2,$mo); 
            }
            //4.获取对应模型下面的功能点
            foreach($model2 as $k4 =>$v4){
                $model[$k][$k4]['evaluate_type']=$v4['evaluate_type'];
                $model[$k][$k4]['checkedCities']=[];
                $model[$k][$k4]['checkAll']=false;
                if($k4==0){
                    $model[$k][$k4]['model_num']=Db::table('evaluate')->where(['plate_form'=>$v,'evaluate_type'=>$v4['evaluate_type']])->group('model')->count();
                }elseif($model2[$k4-1]['evaluate_type'] == $model2[$k4]['evaluate_type']){
                    $model[$k][$k4]['model_num']=0;
                }else{
                    $model[$k][$k4]['model_num']=Db::table('evaluate')->where(['plate_form'=>$v,'evaluate_type'=>$v4['evaluate_type']])->group('model')->count();
                }
                $model[$k][$k4]['model_name']=$v4['model'];
                $model[$k][$k4]['function_point']=Eva::getEvaluate_function($v,$v4['model']);   //获取功能点
            }
        }
        $data['plate_form']=$plate_list;
        $data['model']=$model;
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }



}