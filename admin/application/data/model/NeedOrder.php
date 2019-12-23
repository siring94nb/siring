<?php

namespace app\data\model;
use think\Model;
use think\Db;
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

        /**
         * lilu
         * 获取定制需求订单
         */
        public function get_need_order($parsm,$po)
        {
            $where=[];
            $where['del_time'] = null;
            if($po==1){
                $where['user_id'] = $parsm['user_id'];
            }
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
            $field = '*';
            $order = 'create_time desc';
            $list = Db::table('need_order')->field($field) -> where( $where ) -> order( $order )
                -> paginate( $parsm['size'] , false , array( 'page' => $parsm['page'] ) ) -> toArray();

            foreach ($list['data'] as $k =>$v){
                $terminal= json_decode( $v['need_terminal'] , true );
                if(!empty($terminal)){
                    $res = join('/',$terminal);
                    $list['data'][$k]['terminal'] = $res;
                }else{
                    $list['data'][$k]['terminal'] = "无";
                }
            }

            return $list;
        }


}
