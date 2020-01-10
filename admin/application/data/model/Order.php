<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/3
 * Time: 10:47
 */
namespace app\data\model;

use think\Model;

class Order extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime  = 'end_time';
    protected $table = "order";
    protected $resultSetType = 'collection';

    /**
     * 订单列表
     * @param $param
     * @param $uid
     * @param $type
     * @return array
     * @throws \think\exception\DbException
     */
    public function order_list($param,$uid,$type)
    {

        $where['user_id'] = $uid;
        $where['type'] = $type;
        if(!empty($param['title'])){
            $where['no|phone'] = $param['title'];
        }
        if(!empty($param['type'])){
            $where['payment'] = $param['type'];
        }
        if(!empty($param['start_time'])){
            $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
            $where['created_at'] = ['gt',$param['start_time']];
        }
        if(!empty($param['end_time'])){
            $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
            $where['created_at'] = ['lt',$param['end_time']];
        }
        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = 'id,type,no,user_id,phone,model_type,model_meal_type,money,pay_type,payment,created_at,end_time';
        $order = 'id desc';


        $list = (new Order()) -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list;

    }
}
