<?php

namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;
use app\data\model\JoinOrder as JoinOrderAll;
class JoinOrder extends Base {
	/**
     * 会员订单列表
     * @author fyk
     * @time 2019/10/09
     */
    public function index(){
     $request = Request::instance();
     $param = $request->param();

     if(!empty($param['nickname'])){
          $where['b.nickname'] = ['like','%'.$param['nickname'].'%'];
     }
     if(!empty($param['start_time'])){
          $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
          $where['a.created_at'] = ['gt',$param['start_time']];
     }
     if(!empty($param['end_time'])){
          $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
          $where['a.created_at'] = ['lt',$param['end_time']];
     }
     if(!empty($param['start_time']) && !empty($param['end_time'])){
          $where['a.created_at'] = ['between',[$param['start_time'],$param['end_time']]];
     }
     if(empty($param['page'])){
          $param['page'] = 1;
     }
     if(empty($param['size'])){
          $param['size'] = 10;
     }
     //条件
     $where['role_type'] = 1;
     $field = 'a.id,a.role_type,a.user_id,a.pay_type,a.created_at,
     a.no,a.money,a.payment,a.status,a.grade,a.updated_at,b.phone';
     $order = 'a.id desc';
     $count = Db::table('join_order')->alias('a')->join('user b','a.user_id=b.id','inner')
     ->where($where)->count();

     $list = Db::table('join_order')->alias('a')->join('user b','a.user_id=b.id','inner')
     ->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();//join查询表的数据

//        foreach ( $list as $k => $v ){
//             $list[$k]['pay_type'] = $v['pay_type'] == 1 ? '支付宝' : ( $v['pay_type'] == 2 ? '微信' : '汇款' );
//             $list[$k]['status'] = $v['status'] == 1 ? '未审核' : ( $v['status'] == 2 ? '已审核' : '失败' );
//        }
         return $this -> buildSuccess([
           'count'=>$count,
           'list'=>$list,
       ]);
    }
     /**
     * 订单审核
     * @author fyk
     * @time 2019/10/09
     */
     public function upd()
     {
  		  $id = $this -> request -> post( 'id' , 0 );
          $status = $this -> request -> post( 'status' , 1 );

          $info = Db::table('join_order') -> where('id',$id ) -> find();
          if($info['status'] === 2){
              return $this -> buildSuccess( [] , '当前状态不能更改' );
          } else {
            $update_date = [
              'status' => $status,
              'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $res = Db::table('join_order') -> where('id',$id ) -> update( $update_date );

            return $res !== false ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );

        }
     }

    /**
     * 城市合伙人您订单
     * @return array
     * @throws \think\exception\DbException
     */
    public function partner()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 2 ;

        $partner = new JoinOrderAll();

        $data = $partner->join_list($param);
        //pp($data);die;
        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

}
