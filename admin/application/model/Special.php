<?php
namespace app\model;

use traits\model\SoftDelete;
use app\model\Good;

/**
 * lilu
 * 商品规格
 */
class Special extends Base
{
    use SoftDelete;
    protected $table = "special";
    protected $resultSetType = 'collection';
    protected $deleteTime = 'del_time';
    protected $createTime   = 'create_time';
    protected $updateTime    = 'update_time';



    /**
     * lilu
     * 根据商品的id获取商品的规格信息
     */
    public static function getSpecialInfo($goods_id){
        $special=new Special();
        $field="id,attr_title,price,bottom_price,cycle_time,goods_id";
        $where['del_time']=null;
        $list = $special->where($where)->field($field)-> where('goods_id',$goods_id )
        -> paginate( 10 , false , array( 'page' => 1 ) ) -> toArray();
        return $list;
    }
    /**
     * test
     */
    public  static function getGoodsList($parsm)
    {
        $where=[];
        if(array_key_exists('category_id',$parsm)){
            if($parsm['category_id']!==0){
                $where['category_id']=$parsm['category_id'];
            }
        }
        if(array_key_exists('goods_recomment_status',$parsm)){
            if($parsm['goods_recomment_status']!==0){
                $where['category_id']=$parsm['category_id'];
            }
        }
        if(array_key_exists('goods_name',$parsm)){
            $where['goods_name']=$parsm['goods_name'];
        }
        if(empty($parsm['page'])){
            $parsm['page'] = 1;
        }
        $field = '*';
        $order = 'id desc';
        $goods = new Good();
        $list = $goods->field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $parsm['size'] , false , array( 'page' => $parsm['page'] ) ) -> toArray();
        return $list;
    }

}