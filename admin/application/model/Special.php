<?php
namespace app\model;

use traits\model\SoftDelete;

/**
 * lilu
 * 商品规格
 */
class Special extends Base
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table = "special";
    protected $resultSetType = 'collection';
    protected $createTime   = 'create_time';
    protected $updateTime    = 'update_time';



    /**
     * lilu
     * 根据商品的id获取商品的规格信息
     */
    public static function getSpecialInfo($goods_id){
        $goods=new Special();
        $special=$goods->where('goods_id',$goods_id)->select();
        return $special;
    }

}