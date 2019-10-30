<?php
namespace app\data\model;
use think\Model;

/**
 * lilu
 * 快捷估价
 */
class Evaluate extends Model
{
    protected $table = "evaluate";
    protected $resultSetType = 'collection';

    //获取器
    public static function getStatusAttr($value)
    {
        //1  原型ui   2后端管理   3PC   4 h5    5  ios   6  andarod    7  小程序  
        $status = [1=>'原型ui',2=>'后台',3=>'PC',4=>'移动H5',5=>'APP苹果',6=>'APP安卓',7=>'小程序'];
        return $status[$value];
    }

    /**
     * lilu
     * 获取快捷估价平台下的分类（1个平台）
     */
    public static function getEvaluate_type($value){
        $evaluate= new Evaluate();
        $plate_form=$evaluate->where('plate_form',$value)->field('evaluate_type')->group('evaluate_type')->order('id')->select()->toArray();
        return $plate_form;
    }
   
    /**
     * lilu
     * 获取快捷估价平台下的分类（1个平台下的当前分类）
     */
    public static function getEvaluate_type2($value,$model){
        $evaluate= new Evaluate();
        $evaluate_type=$evaluate->where(['plate_form'=>$value,'model'=>$model])->field('evaluate_type')->group('evaluate_type')->find()->toArray();
        return $evaluate_type['evaluate_type'];
    }

    /**
     * lilu
     * 获取快捷估价分类下的model
     * parsm  $plate_form   (平台id)
     */
    public static function getEvaluate_model($plate_form,$evaluate_type){
        $evaluate= new Evaluate();
        $model=$evaluate->where(['evaluate_type'=>$evaluate_type['evaluate_type'],'plate_form'=>$plate_form])->field('model,evaluate_type')->group('model')->order('id')->select()->toArray();
        return $model;
    }

    /**
     * lilu
     * 获取快捷估价分类下的model
     * parsm  $plate_form   (平台id)
     * parsm  $model   模型
     */
    public static function getEvaluate_function($plate_form,$model){
        $evaluate= new Evaluate();
        $function_point=$evaluate->where(['plate_form'=>$plate_form,'model'=>$model])->field('id,function_point,price_down,price_up,work_hours')->group('function_point')->order('id')->select()->toArray();
        return $function_point;
    }




}