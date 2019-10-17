<?php

namespace app\data\model;

use think\Model;

class Feedback extends Model
{
    protected $table = "suggest";
    protected $resultSetType = 'collection';

    /**
     * 用户列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function suggest_list($param)
    {

        $where = array();
        $where['deleted_at'] = null;
        if( $param['status'] != -1 ){
            $where['c.grade'] = $param['status'];
        }
        if(!empty($param['keywords'])){
            $where['b.phone|b.realname'] = ['like','%'.$param['keywords'].'%'];
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
        $field = '*';
        $order = 'a.id desc';

        $user = new Feedback();
        $list = $user ->alias('a')
            ->join( 'user b ' , 'a.user_id = b.id' )
            ->join( 'user_grade c ' , 'a.user_id = c.user_id' )
            -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['grade_name'] = $v['grade'] == 0 ? '黄金会员' : ( $v['grade'] == 1 ? '白金会员' : '钻石会员' );
        }
        return $list;
    }
}
