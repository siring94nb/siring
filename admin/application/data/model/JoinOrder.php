<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/9
 * Time: 14:11
 */
namespace app\data\model;

use think\Model;

class JoinOrder extends Model
{
    protected $table = "join_order";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
//    protected $hidden = ['created_at','updated_at'];1572839536
//    protected $auto = ['created_at'];
//    protected $update = ['updated_at'];
//    public function setTimeAttr()
//    {
//        return time();
//    }
//
//    public function setTimeUpdateAttr()
//    {
//        return time();
//    }

    //新增订单
    public function order_add($role_type,$uid,$pay_type,$num,$money,$dev,$grade,$con)
    {
        $data = new JoinOrder;
        $data->save([
            'role_type' => $role_type,
            'user_id' => $uid,
            'pay_type' => $pay_type,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'payment' => 1,
            'status' => 1,
            'dev' => $dev,
            'grade' => $grade,
            'con' =>$con,
            'created_at' => time(),

        ]);

        return $data !== false ? $data : false;
    }

    //生成订单号
    function get_sn() {
        return 'JS'.date('YmdHi').rand(100000, 999999);
    }

    //展示
    public function join_order_list()
    {

        return self::all()->toArray();

    }

//    //当前用户
//    public function user($id)
//    {
//        return self::get(['id'=>$id]);
//    }

    /**
     * 加盟角色订单列表分类
     * @author fyk
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function join_list($param)
    {

        $where = [];
        $where['role_type'] = $param['type'];
        if(!empty($param['phone'])){
            $where['b.phone'] = ['like','%'.$param['phone'].'%'];
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
        $field = 'a.id,a.role_type,a.user_id,a.pay_type,a.pay_time,a.created_at,
        a.no,a.money,a.payment,a.status,a.grade,a.dev,a.updated_at,b.phone';
        $order = 'a.id desc';

        $list =  JoinOrder::where( $where )
            ->alias('a')->join('user b','a.user_id=b.id','inner')
            -> field( $field ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list;
    }
}
