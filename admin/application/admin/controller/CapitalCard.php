<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/27
 * Time: 16:22
 */
namespace app\admin\controller;
use app\data\model\AllOrder;
use app\data\model\Offline;
use app\data\model\NeedOrder;
use think\Request;
use think\Db;
use think\Validate;

class CapitalCard extends Base
{

    /**
     * 线下订单审核
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();

        $where['del_time'] = null;

        if (!empty($param['name'])) {
            $where['name'] = ['like', '%' . $param['name'] . '%'];
        }

        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['size'])) {
            $param['size'] = 10;
        }

        $field = 'a.* ,b.phone';
        $order = 'a.id asc';

        $list = ( new Offline()) ->alias('a')->join('user b','a.member_account=b.id','left')
            -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();


        return $this -> buildSuccess( array(
            'list' => $list['data'],
            'count' => $list['total'],
        ) );

    }

    /**
     * 订单审核
     * @return array
     */
    public function upd()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '缺少必要参数ID'],
            ['type', 'require', '2为通过，3为驳回'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        //判断审核状态
        if($param['type'] == 2){
            $res = Db::transaction( function() use ( $param ){

                $off = Offline::get($param['id']);
                //更改审核状态
                $res1 = Offline::update(['order_status'=>$param['type']],['id'=>$param['id']]);

                //更改订单状态
                $data = NeedOrder::get(['need_order'=>$off['order_number']]);
                $res2 = NeedOrder::update([
                    'need_pay_type'  => 3,
                    'need_status'  => 4,
                    'update_time' => time()
                ],['id' => $data['id']]);

                //订单统计表添加
                $role_type = 4;
                $budget_type = 1;
                $income = '';//收入金额
                $res3 = (new AllOrder())->allorder_add($role_type,$budget_type,$data,$off['pay_money'],$income);

                return $res1 && $res2  && $res3 ? true : false;
            });

            return $res  !== false  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1006 , '用户修改失败' );;

        }else{
            $res = Db::transaction( function() use ( $param ){

                $off = Offline::get($param['id']);
                //更改审核状态
                $res1 = Offline::where('id',$param['id'])->update(['order_status'=>$param['type']]);

                //更改订单状态
                $res2 = NeedOrder::where('need_order',$off['order_number'])->update([
                    'need_pay_type'  => 3,
                    'pay_type' => 1,
                    'pay_time' => ''
                ]);

                return $res1 && $res2   ? true : false;
            });
            return $res  !== false  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1006 , '用户修改失败' );

        }


    }
}
