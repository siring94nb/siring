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
         * @author fyk
         * 获取定制需求订单
         */
        public function get_need_order($param,$po)
        {
            $where=[];
            $where['del_time'] = null;
            if($po == 1){
                $where['user_id'] = $param['user_id'];
            }

            if(!empty($param['title'])){
                $where['need_order|need_phone'] = $param['title'];
            }

            if(!empty($param['start_time'])){
                $param['start_time'] = strtotime($param['start_time']);
                $where['create_time'] = ['gt',$param['start_time']];
            }
            if(!empty($param['end_time'])){
                $param['end_time'] = strtotime($param['end_time']);
                $where['create_time'] = ['lt',$param['end_time']];
            }
            if(!empty($param['start_time']) && !empty($param['end_time'])){
                $where['create_time'] = ['between',[$param['start_time'],$param['end_time']]];
            }

            if(empty($param['page'])){
                $param['page'] = 1;
            }
            $field = '*';
            $order = 'create_time desc';
            $list = NeedOrder::field($field) -> where( $where ) -> order( $order )
                -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

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
