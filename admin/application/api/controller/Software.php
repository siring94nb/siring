<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/10/28
 * Time: 10:33
 */
namespace app\api\controller;
use app\data\model\Alipay;
use app\data\model\Payoff;
use app\data\model\Category;
use app\data\model\Good;
use app\data\model\SoftOrder;
use app\data\model\Special;
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

            foreach ($data['data'] as $k=>$v){
                $res = Special::spec_pro($v['id']);//规格
                $res1 = $res[0]['attr_title'];
                $data['data'][$k]['sub_title'] = $res1;
            }

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }
            $data = $good->good_list($param);

            foreach ($data['data'] as $k=>$v){
                $res = Special::spec_pro($v['id']);//规格
                $res1 = $res[0]['attr_title'];
                $data['data'][$k]['sub_title'] = $res1;
            }


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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function soft_reviews($goods_id)
    {
        $good = new Good();
        $data = $good->good_review($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 推荐商品
     * @throws \think\exception\DbException
     */
    public function soft_push()
    {
        $data = db('good')->orderRaw('rand()')
            ->alias('a')->join('category b','a.category_id=b.id','left')
            ->where(['a.del_time'=>null])
            ->field('a.id,a.goods_name,a.goods_images,a.period,a.category_id,b.category_name')
            ->limit(7)->select();

        foreach ($data as $k=>$v){

            $res = Special::spec_pro($v['id']);//规格
            $res1 = $res[0]['attr_title'];
            $data[$k]['sub_title'] = $res1;
            //图片
            $att=explode(',',$v["goods_images"]);
            $data[$k]['img'] = $att[0];
            unset($data[$k]['goods_images']);
        }
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 商品演示
     * @param $goods_id
     */
    public function soft_demo($goods_id)
    {
        $data = Good::where('id',$goods_id)->value('goods_detail');
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
        $user_id = Session::get("uid");
        if($user_id){
            $param["user_id"] = Session::get("uid");
        }else{
            $param["user_id"] = $param["user_id"];
        }
        $validate = new Validate([
            ['user_id', 'require', '用户id不能为空'],
            ['goods_id', 'require', '商品id不能为空'],
            ['sid','require','规格id不能为空'],
            ['yid','require','优惠券id必须'],
            ['price','require','支付价格必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
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

            $data = (new SoftOrder())->order_add($param);

            Db::commit();

            return $data ? returnJson(1,'提交成功',$data['id']) : returnJson(0,'提交失败',$data['id']);

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }

    }

    /**
     * 支付订单
     * @author
     * @return array|mixed|string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function get_pay()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['type', 'require', '支付分类不能为空'],
            ['order_id', 'require', '商品id不能为空'],
            ['money','require','支付金额不能为空'],
            ['pay_type','require','支付方式必须'],
            ['password','require','余额密码必须'],
            ['unionpay','require','银行卡支付参数必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        switch ($param['type']) {
            case 1://软件定制
                $ratio = 1;
                $data =(new Payoff())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'], $param['unionpay'], $ratio);

                return $data;

        }
    }

    /**
     * 店铺支付成功微信回调demo
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function app_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);

            $where = array('no'=>$rstArr['out_trade_no']);

            $orderArr = Db::table('join_order')->where($where)->field('id,user_id,payment,status,no')->find();
            if (empty($orderArr)) {
                // 如果订单不存在
                returnJson(0,'订单不存在');
            }
            if ($orderArr['payment'] == 2) {
                returnJson(0,'订单已支付'); // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $result = Db::transaction(function()use ( $orderArr,$where ){
                    //用户表
                    $user = Db::table('user')->where('id',$orderArr['user_id'])->update(array('type' => 2));
                    //订单表
                    $order_data = Db::table('join_order')->where($where)->update(array('payment' => 2,'status' => 2, "pay_time" => time()));

                    return $user && $order_data ? true : false;

                });

            }
            return $result  ? returnJson(1,'支付成功') : returnJson(0,'支付失败');
        });
        // 将响应输出
        return $response;
    }

}
