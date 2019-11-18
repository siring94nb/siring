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
use app\data\model\Special;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;
use EasyAlipay\Factory;
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
     */
    public function soft_reviews($goods_id)
    {
        $good = new Good();
        $data = $good->good_review($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 推荐商品
     * @author fyk
     * @return \think\Response
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
                $url = 'https://manage.siring.com.cn/api/Software/app_notice';
                $order = db('soft_order')->getById($id);

                $pay = 1;//先测试1分钱
                if (!$order)returnJson(0, '当前订单不存在');
                //        if($order['status'] = 2)returnJson(0,'当前订单已支付');
                $title = '软件/定制商品';
                $wechatpay = new WechatPay();
                $res = $wechatpay->pay($title,$order['no'], $pay, $url);

                return $res;exit();
                break;   // 跳出循环
            case 2:

                $options = [
                    'app_id'                   => '2016051900098985',
                    'gateway_url'              => "https://openapi.alipaydev.com/gateway.do",//示例中使用的是沙箱环境网关，线上gateway_url：https://openapi.alipay.com/gateway.do
                    'sign_type'                => "RSA",
                    'charset'                  => "UTF-8",
                    'alipay_public_key'        => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB',
                    'merchant_private_key'     => 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJlJ7tgZ4vI2Nnxt7DzznbhVwGN8INQ1s/ZnXYgtRMmvbNKLTHZ1SbRmiAKixn3TDbzkHMvo0jY7ldb7puqUJUKZuKfVwaRcAYgI6NamflqtTDWhSq+hPZ5ZrB36lx7N7AxlMD038WvJC5pHbld06DDxhlUslS3pJCGrB9P6HO0RAgMBAAECgYArrFTQXQ+70pZTfT4BX6dgDY5yybrQuzw6x9huI/elPsXSdr2iQmhtbYjyt022K5uOZa+OqRa7PN7EEY7M5sh2cFRX5P77o2vN61Gwklc11iaJIpPgUOZUmAG8jHnj3lf40+YtMwdPxQfbiZ36UOebQYPc8iuJczUNoVtSPP3IwQJBAMZzCSV7pjTQ4mp2MNT/h3/5ZhaQnqlO4wm0etekKDDTrpvUlSN8MjRjhyJhRvulKd0zUdfrjASEUjZhsZydEAMCQQDFviiKquR0TgYK0eircDwR89XHUBKoblPLYi/GSdPXSL92AzyvDIyNF/GPwHOkc1c+BA/4ocuW/T+u4KfYWBRbAkEAvV/Rfp98gDJFnmqjNt+SIqGQtj/T6KWLKxu7jkTsxYt7uOEoYPCHyE6iCkDiSAnY5Wmv1GjG+Rh8i8C2iUmomQJBAIaeVmtQvAaRt3tWO9e6qKpwHXF7Cbiwo0sqpOuRBy7gz7c/rOhe2rCTRFhg5FloTFRj35ucSkWYUupy9tFJ5VECQDyK++bn0ZpJG/HRNJHvuKOSUM8U6LSvQrTGpyvKlj5wLcOniDAYEcCzkapY/wHAUMshD0eoFY2X3F/3PcuIgW4=',
                    // ...
                ];

                //本测试用例提供的是沙箱环境的配置信息，线上调用请更改为自己应用对应的信息
                //app_id，alipay_public_key（支付宝公钥），merchant_private_key（应用私钥）为必填项
                //gateway_url不设置就默认线上网关
                //sign_type 不设置就默认RSA2（目前线上环境支持RSA）
                //charset  不设置就默认UTF-8

                //接口测试用例
                $app = Factory::payment($options);
                var_dump($app['query']->query("1561946980099_demo_pay"));
                //returnJson(0, '暂未支付宝开通');

                break; // 跳出循环
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
