<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 19:46
 */

namespace app\model;

use traits\model\SoftDelete;
/**
 * lilu
 * 商品模型
 */
class Goods extends  Base{

    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table = "goods";
    protected $resultSetType = 'collection';
    protected $createTime   = 'create_time';
    protected $updateTime    = 'update_time';

    /**
     * 关联表
     * @return \think\model\relation\HasOne
     */
    public function grade(){
        return $this -> hasOne( 'special' , 'goods_id' , 'id' );
    }

    /**
     * lilu
     * 获取商品列表
     */
    public  function getGoodsList($parsm)
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

        $goods = new Goods();
        $list = $goods -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $parsm['size'] , false , array( 'page' => $parsm['page'] ) ) -> toArray();

        return $list;
    }
    




}