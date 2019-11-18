<?php

namespace app\data\model;
use think\Model;
use traits\model\SoftDelete;


/**
 * lilu
 * 定制需求订单
 */
class NeedOrder extends Model
{
   
        use SoftDelete;
        protected $deleteTime = 'del_time';
        protected $createTime = 'create_time';
        protected $updateTime = 'update_time';
        protected $table="need_order";
        protected $resultSetType = 'collection';
    
        /**
         * lilu
         * 定制需求添加订单
         * param   订单参数
         */
        public function order_add()
        {
            $data = new SoftOrder;
            return $data !== false ? $data : false;
        }
    
    


}