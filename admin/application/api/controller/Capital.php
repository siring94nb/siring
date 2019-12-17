<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/16
 * Time: 17:21
 */
namespace app\api\controller;
use app\data\model\AllOrder;
use app\data\model\InvestmentProject;
use app\data\model\SoftOrder;
use app\data\model\MealOrder;
use app\data\model\PromotionOrder;
use app\data\model\UserFund;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

/**
 * 资金明细
 * @author fyk
 * Class Capital
 * @package app\api\controller
 */
class Capital extends Base
{
    /**
     * 资金明细
     */
    public function capital_detailed()
    {
        $request = Request::instance();
        $param = $request->param();


        $where = [];
        if(!empty($param['budget_type'])){
            $where['budget_type'] = $param['budget_type'];
        }
        if(!empty($param['role_type'])){
            $where['role_type'] = $param['role_type'];
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
        $field = 'id,role_type,budget_type,phone,income,money,money,pay_type,created_at';
        $order = 'id desc';

        $user = new AllOrder();
        $list = $user -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list ? returnJson(1,'获取成功',$list) : returnJson(0,'获取失败',$list);
    }

    /**
     * 剩余开票金额
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function invoice_amount()
    {
        $uid = Session::get("uid");
        $data =   (new UserFund())->where('user_id',$uid)->find();

        return $data ? returnJson(1,'获取成功',$data['money_invoice']) : returnJson(0,'暂无余额',$data['money_invoice']);
    }



}
