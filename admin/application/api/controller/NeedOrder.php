<?php

namespace  app\api\controller;


use app\data\model\Category;
use app\data\model\Good;
use app\data\model\NeedOrder as Need;
use app\data\model\NeedScore;
use app\data\model\Special;
use app\data\model\UserGrade;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;
use Yansongda\Pay\Pay;
use EasyWeChat\Foundation\Application;

class  NeedOrder  extends  Base
{

    /**
     * 需求定制订单
     * @author 李禄
     * @return \think\Response
     */
    public function need_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['need_name', 'require', '需求名称不能为空'],
            ['need_category', 'require', '分类不能为空'],
            ['need_budget_down', 'require', '低价预算不能不好空'],
            ['need_budget_up', 'require', '高价预算不能不好空'],
            ['need_phone', 'require', '手机必须'],
            ['need_desc', 'require', '需求描述必须'],
            ['need_terminal', 'require', '需求终端必须'],
//            ['need_file','require','附件必须'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());
            exit();
        }
        $user_id = Session::get("uid");
        if ($user_id) {
            $uid = Session::get("uid");
        } else {
            $uid = $param["user_id"];
        }
        if(empty($param['need_qq'])){
            $param['need_qq'] = '';
        }
        if(empty($param['need_wx'])){
            $param['need_wx'] = '';
        }
        if(empty($param['need_other'])){
            $param['need_other'] = '';
        }
        $need = [
            'user_id'=>$uid,
            'name'=>$param["need_name"],
            'need_category'=>$param["need_category"],
            'need_budget_down'=>$param["need_budget_down"],
            'need_budget_up'=>$param["need_budget_up"],
            'phone'=>$param["need_phone"],
            'con'=>$param["need_desc"],
            'no'=>'DZ' . date('Ymdhis') . mt_rand('111111', '999999'),
            'dev'=>json_encode($param['need_terminal']),
            'created_at'=>time(),
            'type'=>7,
            'qq'=>$param['need_qq'],
            'wx'=>$param['need_wx'],
            'other'=>$param['need_other'],

        ];
        //开启事务
        Db::startTrans();
        try {
            $data = Need::create($need);
            $order_id = $data['id'];
            Db::commit();
            return $data ? returnJson(1, '提交成功', $order_id) : returnJson(0, '提交失败', $order_id);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }

    /**
     * lilu
     * 定制需求列表
     * user_id
     */
    public function need_order_list()
    {
        $request = Request::instance();
        $postData = $request->param();
        $param['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $param['page'] = $this->request->get('page', 1);
        $param['title'] = $this->request->get('title', '');
        $param['order_status'] = $this->request->get('order_status', '');
        $param['start_time'] = $this->request->get('start_time', '');
        $param['end_time'] = $this->request->get('end_time', '');

        $user_id = Session::get("uid");
        if ($user_id) {
            $postData["user_id"] = Session::get("uid");
        } else {
            $postData["user_id"] = $postData["user_id"];
        }

        if ($postData) {
            $need = new Need();
            $param['user_id'] = $postData['user_id'];
            $data = $need->get_need_order($param,1);

            return $data ? returnJson(1, '获取成功', $data) : returnJson(0, '获取失败');

        } else {

            returnJson(0, '获取失败');exit();
        }
    }

    /**
     * lilu
     * 中止项目/确认需求
     * param  status   需求状态
     * param  user_id  客户id
     * param  id       需求订单id
     */
    public function change_status()
    {
        //获取参数
        $request = Request::instance();
        $postData = $request->param();
        $need = new Need();
        if ($postData) {
            if ($postData['status'] == '0') {
                //中止需求
                $res = $need->where('id', $postData['id'])->update(['need_status'=>8]);
            } else {
                //进行下一步  need_status=8
                $res = $need->where('id', $postData['id'])->update(['need_status' => $postData['status']]);
            }
            return $res ? returnJson(1, '操作成功', $res) : returnJson(0, '操作失败');
        } else {
            returnJson(0, '获取参数失败');exit();
        }
    }

    /**
     * lilu
     * 需求确认修改
     */
    public function confirm_need_order()
    {
        //获取参数
        $request = Request::instance();
        $param = $request->param();
        //必填字段验证
        $validate = new Validate([
            ['need_name', 'require', '需求名称不能为空'],
            ['need_category', 'require', '分类不能为空'],
            ['need_budget_down', 'require', '低价预算不能不好空'],
            ['need_budget_up', 'require', '高价预算不能不好空'],
            ['need_phone', 'require', '手机必须'],
            ['need_desc', 'require', '需求描述必须'],
            // ['need_file','require','附件必须'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());
            exit();
        }
        $user_id = Session::get("uid");
        if ($user_id) {
            $uid = Session::get("uid");
        } else {
            $uid = $param["user_id"];
        }
        if(empty($param['need_qq'])){
            $param['need_qq'] = '';
        }
        if(empty($param['need_wx'])){
            $param['need_wx'] = '';
        }
        if(empty($param['need_other'])){
            $param['need_other'] = '';
        }
        $need_data = [
            'user_id'=>$uid,
            'name'=>$param["need_name"],
            'need_category'=>$param["need_category"],
            'need_budget_down'=>$param["need_budget_down"],
            'need_budget_up'=>$param["need_budget_up"],
            'phone'=>$param["need_phone"],
            'need_desc'=>$param["need_desc"],
            'qq'=>$param['need_qq'],
            'wx'=>$param['need_wx'],
            'other'=>$param['need_other'],

        ];
        if ($param) {
            $need=new Need();
            $re=$need->update($need_data);
            return $re ?  returnJson(1,'操作成功') : returnJson(0,'操作失败');
        } else {
            returnJson(0, '获取参数失败');
        }
    }

    /**
     * fyk
     * 获取定制需求内容
     * id
     * status
     */
    public function need_order_detail()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            //获取详情
            $need_detail= (new Need())->need_detail($postData['id']);
            return $need_detail ?  returnJson(1,'操作成功',$need_detail) : returnJson(0,'操作失败');
        }else{
            returnJson(0, '获取参数失败');
        }
    }


    /**
     * @author fyk
     * 评价
     * @throws \think\exception\DbException
     */
    public function need_comment()
    {
        $request = Request::instance();
        $param = $request->param();

        $validate = new Validate([
            ['order_id', 'require|unique:NeedScore', '订单号不能为空|该订单已评价'],
            ['satisfied', 'require|number', '满意度不能为空'],
            ['satisfy', 'require|number', '功能满足不能为空'],
            ['reliable', 'require|number', '可靠性不能为空'],
            ['easy', 'require|number', '易用性不能为空'],
            ['beautiful', 'require|number', '美观性不能为空'],
            ['serve', 'require|number', '总体服务不能为空'],
            ['knowledge', 'require|number', '知识水平不能为空'],
            ['response', 'require|number', '响应速度不能为空'],
            ['complaint', 'require|number', '投诉处理不能为空'],
            ['sale', 'require|number', '售后服务不能为空'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());exit();
        }
        $order = Need::get(['need_order'=>$param['order_id']]);
        if(!$order)returnJson(0,'订单有误');

        $param['user_id'] = $order['user_id'];
        unset($param['id']);
        $need = new NeedScore($param);
        $res = $need->allowField(true)->save();

        return $res  ? returnJson(1,'提交成功') : returnJson(0,'提交失败');

    }

    /**
     * 签订合同异步回调-支付宝
     */
    public function qd_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {

            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            $res = Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    'need_status'=>4,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);

                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res2 = (new AllOrder())->allorder_add($budget_type,$data,$no['money'],$income);

                return $res1 && $res2   ? true : false;
            });

            return $res    ?   returnJson(1,'支付成功') : returnJson(0,'支付失败');

        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 微信支付回调
     * @author fyk
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function qd_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);
            $data =  Order::get(['no'=>$rstArr['out_trade_no']]);

            if (empty($data)) {
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($data['payment'] == 2) {
                return true;  // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                Db::transaction(function()use ( $data){
                    $res1 =  Order::where('id',$data['id'])->update([
                        'need_status'=>4,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);

                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res2 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2   ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

    /**
     * 原型确认异步回调-支付宝
     * @param Request $request
     */
    public function yx_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            $res = Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    'need_status'=>5,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);

                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res2 = (new AllOrder())->allorder_add($budget_type,$data,$no['money'],$income);

                return $res1 && $res2   ? true : false;
            });

            return $res    ?   returnJson(1,'支付成功') : returnJson(0,'支付失败');

        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 微信支付回调
     * @author fyk
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function yx_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);
            $data =  Order::get(['no'=>$rstArr['out_trade_no']]);

            if (empty($data)) {
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($data['payment'] == 2) {
                return true;  // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                Db::transaction(function()use ( $data){
                    $res1 =  Order::where('id',$data['id'])->update([
                        'need_status'=>5,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);

                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res2 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2   ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

    /**
     * 项目上线异步回调-支付宝
     * @param Request $request
     */
    public function sx_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            $res = Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    'need_status'=>6,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);

                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res2 = (new AllOrder())->allorder_add($budget_type,$data,$no['money'],$income);

                return $res1 && $res2   ? true : false;
            });

            return $res    ?   returnJson(1,'支付成功') : returnJson(0,'支付失败');

        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 微信支付回调
     * @author fyk
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function sx_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);
            $data =  Order::get(['no'=>$rstArr['out_trade_no']]);

            if (empty($data)) {
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($data['payment'] == 2) {
                return true;  // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                Db::transaction(function()use ( $data){
                    $res1 =  Order::where('id',$data['id'])->update([
                        'need_status'=>6,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);

                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res2 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2   ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

    /**
     * 项目验收异步回调-支付宝
     * @param Request $request
     */
    public function ys_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {

            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            $res = Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    'need_status'=>7,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);

                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res2 = (new AllOrder())->allorder_add($budget_type,$data,$no['money'],$income);

                return $res1 && $res2   ? true : false;
            });

            return $res    ?   returnJson(1,'支付成功') : returnJson(0,'支付失败');

        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 微信支付回调
     * @author fyk
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function ys_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);
            $data =  Order::get(['no'=>$rstArr['out_trade_no']]);

            if (empty($data)) {
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            if ($data['payment'] == 2) {
                return true;  // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                Db::transaction(function()use ( $data){
                    $res1 =  Order::where('id',$data['id'])->update([
                        'need_status'=>7,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);

                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res2 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2   ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

}
