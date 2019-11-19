<?php

namespace app\data\model;

use think\Model;
use think\Db;
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
    public function get_saas_order($parsm)
    {
        $where=[];
        $where['del_time'] = null;
        if(array_key_exists('title',$parsm) && !empty($parsm['title'])){
                $where['order_number']=$parsm['title'];
        }
        if(array_key_exists('order_status',$parsm)){
            if(!empty($parsm['order_status'])){
                $where['order_status']=$parsm['order_status'];
            }
        }
        if(!empty($parsm['start_time']) && !empty($parsm['end_time']))
        {
            $where['create_time']=array('between',array(strtotime($parsm['start_time']),strtotime($parsm['end_time'])));
        }elseif(!empty($parsm['start_time']) && empty($parsm['end_time'])){
            $where['create_time']=array('between',array(strtotime($parsm['start_time']),time()));
        }elseif(empty($parsm['start_time']) && !empty($parsm['end_time'])){
            $where['create_time']=array('between',array(time()-86400*30,strtotime($parsm['end_time'])));
        }
        if(empty($parsm['page'])){
            $parsm['page'] = 1;
        }
        $field = 'a.*,u.phone';
        $order = 'create_time desc';
        $mealorder = new MealOrder();
        $list = Db::table('model_order')->alias('a')->join('user u', 'u.id=a.member_account','left' )->field($field) -> where( $where ) -> order( $order )
            -> paginate( $parsm['size'] , false , array( 'page' => $parsm['page'] ) ) -> toArray();
        return $list;

    }

}