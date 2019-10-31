<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/10/28
 * Time: 10:33
 */
namespace app\api\controller;
use app\data\model\Category;
use app\data\model\Good;
use app\data\model\SoftOrder;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

class Software extends Base
{
    /**
     * 软件定制分类
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function soft_type()
    {
        $data = (new Category()) ->select()->toArray();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 软件定制商品列表
     * @throws \think\exception\DbException
     */
    public function soft_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new Good();

        $uid = Session::get("uid");

        if($uid){

            $uid = Session::get("uid");
            $data = $good->user_good_list($param,$uid);

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }
            $data = $good->good_list($param);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 商品详情
     * @param $goods_id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function soft_detail($goods_id)
    {
        $good = new Good();
        $data = $good->good_detail($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 商品评论
     * @param $goods_id
     */
    public function soft_reviews($goods_id)
    {
        $good = new Good();
        $data = $good->good_review($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 推荐商品
     * @return $data
     */
    public function soft_push()
    {
        $data = db('good')->orderRaw('rand()')->where(['del_time'=>null])
            ->field('id,goods_name,goods_images,period')->limit(6)->select();
        foreach ($data as $k=>$v){
            $att=explode(',',$v["goods_images"]);
            $data[$k]['img'] = $att[0];
            unset($data[$k]['goods_images']);
        }
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 软件定制订单
     * @author fyk
     * @return \think\Response
     */
    public function soft_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        if(!$param['pay_type'])returnJson(0,'类型不能为空');
        $type = $param['pay_type'];
        switch ($type){

            case 4://银行卡支付
                $validate = new Validate([
                    ['goods_id', 'require', '商品id不能为空'],
                    ['sid','require','规格id不能为空'],
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

    /**
     * 支付订单
     * @author fyk
     * @return array|string|\think\response\Json
     */
    public function get_pay()
    {
        $request = Request::instance();
        $param = $request->param();
        $type = $param['type']; //1微信,2支付宝,3余额
        $id = $param['order_id'];
        switch($type) {
            case 1:
                // 查询订单信息
                $url = 'https://manage.siring.com.cn/api/JoinOrder/app_notice';
                $order = db('soft_order')->getById($id);

                $pay = 0.1;//先测试1分钱
                if (!$order)returnJson(0, '当前订单不存在');
                //        if($order['status'] = 2)returnJson(0,'当前订单已支付');
                $title = '软件/定制商品';
                $wechatpay = new WechatPay();
                $res = $wechatpay->pay($title,['no'], $pay, $url);

                return $res;exit();
                break;   // 跳出循环
            case 2:

                returnJson(0, '暂未支付宝开通');

                break; // 跳出循环
        }
    }

}
