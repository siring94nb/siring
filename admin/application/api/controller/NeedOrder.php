<?php
namespace  app\api\controller;


use app\data\model\Category;
use app\data\model\Good;
use app\data\model\SoftOrder;
use app\data\model\Special;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;


class  NeedOrder  extends  Base{
    /**
     * 软件定制订单
     * @author fyk
     * @return \think\Response
     */
    public function soft_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
                ['project_name', 'require', '需求名称不能为空'],
                ['order_type','require','分类不能为空'],
                ['yid','require','优惠券id必须'],
                ['balance','require','余额必须'],
                ['money','require','原价必须'],
                ['price','require','支付价格必须'],
                ['bank_card','require','银行卡必须'],
                ['bank_pay_time','require','银行卡支付时间必须'],
        ]);
                if(!$validate->check($param)){
                    returnJson (0,$validate->getError());exit();
                }
                $user_id = Session::get("uid");
                if($user_id){
                    $user_id = Session::get("uid");
                }else{
                    $user_id = $param["user_id"];
                }
                //判断邀请码
                if(empty($param['invitation'])){
                    $param['invitation'] = '';
                }else{
                    $user = new \app\data\model\User();
                    $user->invitation($param['invitation']);
                }
                if(empty($param['con'])){
                    $param['con'] = '';
                }
                //开启事务
                Db::startTrans();
                try{
                    $city = new SoftOrder();

                    $data = $city->order_add($type,$user_id,$param['sid'],$param['yid'],$param['goods_id'],$param['price'],
                        $param['balance'],$param['money'],$param['invitation'],$param['bank_card'],$param['bank_pay_time'], $param['con']);
                    $order_id = $data->id;

                    Db::commit();

                    return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);

                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return false;
                }
                    break;
            default://其他支付
                $validate = new Validate([
                    ['goods_id', 'require', '商品id不能为空'],
                    ['sid','require','规格id不能为空'],
                    ['yid','require','优惠券id必须'],
                    ['balance','require','余额必须'],
                    ['money','require','原价必须'],
                    ['price','require','支付价格必须'],
                ]);
                if(!$validate->check($param)){
                    returnJson (0,$validate->getError());exit();
                }
                $user_id = Session::get("uid");
                if($user_id){
                    $user_id = Session::get("uid");
                }else{
                    $user_id = $param["user_id"];
                }
                //判断邀请码
                if(empty($param['invitation'])){
                    $param['invitation'] = '';
                }else{
                    $user = new \app\data\model\User();
                    $user->invitation($param['invitation']);
                }
                //开启事务
                Db::startTrans();
                try{
                    $city = new SoftOrder();

                    $data = $city->order_add($type,$user_id,$param['sid'],$param['yid'],$param['goods_id'],$param['price'],
                        $param['balance'],$param['money'],$param['invitation'],'','','');
                    $order_id = $data->id;

                    Db::commit();

                    return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);

                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return false;
                }

                break;
        }

    }


}
