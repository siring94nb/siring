<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * lilu
 * 行业模板订单
 */
class MealOrder extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $table="model_order";
    protected $resultSetType = 'collection';

    /**
     * lilu
     * 获取Saas店铺订单
     * param   param    [page   size   order_status   title    start_time   end_time]
     */
    public function get_saas_order($param)
    {
        $where=[];
        $where['del_time'] = null;
        if(array_key_exists('title',$parsm)){
            if($parsm['order_number']!==0){
                $where['order_number']=$parsm['order_number'];
            }
        }
        if(array_key_exists('order_status',$parsm)){
            if($parsm['order_status']!==0){
                $where['order_status']=$parsm['order_status'];
            }
        }
        if(array_key_exists('start_time',$parsm)){
            $where['create_time']=$parsm['goods_name'];
        }
        if(array_key_exists('end_time',$parsm)){
            $where['create_time']=$parsm['category_id'];
        }
        if(empty($parsm['page'])){
            $parsm['page'] = 1;
        }
        $field = '*';
        $order = 'create_tiem desc';
        $mealorder = new MealOrder();
        $list = $mealorder->field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $parsm['size'] , false , array( 'page' => $parsm['page'] ) ) -> toArray();
        return $list;

    }

}