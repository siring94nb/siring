<?php
namespace app\data\model;
use think\Model;
use think\Db;

/**
 * lilu
 * 行业模板套餐
 */
class ModelMeal extends Model
{
    /**
     * 用户model
     * @var string
     */
    protected $table = "model_meal";
    protected $resultSetType = 'collection';

    /**
     * lilu
     * 获取分类模板套餐list
     * model_meal_category     1  diy   2 固定样式
     */
    public function get_model_meal($model_meal_category)
    {
        return self::all(['model_meal_category'=>$model_meal_category,'del_time'=>null])->toArray();
    }



}