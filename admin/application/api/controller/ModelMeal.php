<?php
namespace app\api\controller;

use app\data\model\ModelMeal as Model;
use think\Request;
use think\Controller;
use think\Session;
use think\Db;
/**
 * lilu
 * Class 模板套餐
 * @package app\api\controller
 * @time 2019/10/10
 */
class ModelMeal extends Base
{

    /**
     * lilu
     * 获取模板套餐列表
     * model_meal_category
     */
    public function model_meal_list()
    {
        $request=Request::instance();
        $postData=$request->param();
        $model= new Model();
        $result=$model->get_model_meal($postData['model_meal_category']);
        return json($result)  ? json($result)  :  returnJson(0,'获取失败')  ;
    }




}