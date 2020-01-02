<?php

namespace app\data\model;

use think\Model;

class PromotionOrder extends Model
{
    protected $table = "order";
    protected $resultSetType = 'collection';


    public function order_add($role_type,$uid,$title,$object,$num,$yid,$tid,$ask,$money,$grade,$con,$resume,$url)
    {

        $data = new PromotionOrder;
        $data->save([
            'type'=> 5,
            'role_type' => $role_type,
            'user_id' => $uid,
            'name' => $title,
            'resume' => $object,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'model_id' => $tid,
            'need_status'=>$ask,
            'yid' => $yid,
            'grade' => $grade,
            'con' => $con,
            'resume' => $resume,
            'url'=>$url,
            'status' =>1,
            'created_at'=>time(),

        ]);

        return $data !== false ? $data : false;
    }

    /**
     * 生成单号
     * @return string
     */
    function get_sn() {
        return 'TG'.date('YmdHis').rand(100000, 999999);
    }

    /**
     * 用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function promotion_list($param,$uid)
    {
        $where['type'] = 5;
        $where['user_id'] = $uid;
        if(!empty($param['process'])){
            $where['oeder_status'] = $param['process'];

        }
        if(!empty($param['title'])){
            $where['title|no'] = ['like','%'.$param['title'].'%'];
        }

        if(!empty($param['role_type'])){
            $where['role_type'] = $param['role_type'];
        }

        if(!empty($param['start_time'])){
            $where['created_at'] = ['gt',$param['start_time']];
        }

        if(!empty($param['end_time'])){
            $where['created_at'] = ['lt',$param['end_time']];
        }

        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 6;
        }

        $field = 'id,no,name,role_type,model_id,money,created_at';
        $order = 'id desc';

        $list = PromotionOrder::with('Extension') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['package_fee'] = $val['extension']['name'].'￥'.$val['extension']['money'];

            unset($list['data'][$key]['extension']);
        }

        return $list;
    }

    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function Extension()
    {
        return $this->belongsTo('Extension', 'model_id', 'id');
    }
}
