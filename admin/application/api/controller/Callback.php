<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/26
 * Time: 18:39
 */
namespace app\api\controller;
use app\data\model\AllOrder;
use app\data\model\Order;
use app\data\model\UserCard;
use app\data\model\Invoice;
use app\data\model\Recharge;
use app\data\model\UserFund;
use app\data\model\UserGrade;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;
use Yansongda\Pay\Pay;
use EasyWeChat\Foundation\Application;
/**
 * 支付回调
 * @author fyk
 * Class Callback
 * @package app\api\controller
 */
class Callback extends Base
{
    protected $config = [
        'alipay' => [
            'app_id' => '2018082861128764',
            'ali_public_key'        => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmKw/C4jHlGLUhpATv2yesGaZOSI9MmOuw5AMcB6odktNj19CSNDAmS5gDCKM4bJyVFOCFb3BNgvADvhoXHMPngGUkqHkJuRotGpvbr3A5UCyWLsF442cFnO7KZC5blKY59DmB/zZ7E9gRT5BhmQebJkkMls2PcVkvEUNTdQiorcNunhxOfsyUuYqsZP0yPoptR8YarmiWZVXwNxJ7Ha3zVzc7kVPqNYyDkCYtSfvVjOeutUh2dGsz1irsYUZpQP4Kra2YyhPlXpNS/KR3TSl1eLXxAQH6g1YWIsQ7/AZRi+Qv1mczwB9miYjQyPkEtjyYQkHVaItxeGW3fvsSvXy9QIDAQAB',
            'private_key'     => 'MIIEowIBAAKCAQEAydhpt8EHQWE6lv1ExOuWo9dOZ09v4i4zW2r0/ftC6lUVwkLwiXberMQl4GZd7CDnYL9Te5nhce1jJ2VerIhFn0pZmFZwjcRUBVGtZC39m4ziGrrTrdwrCVXvLzje2QXGfU2kf80NsWht3QEXBXs4yeAjJdscC+IXo8bopR9Gav7Byxt38thDErUGvX4Mw5e3eag4UGwDffp2q9SyWZaCZdOS3SuE2HM5baPyoyp6bjcMSi3p4pqr5YePc3BXAZ/AVKYblmhOe1oM+TjCinh+NdHhWvDOki9/Hb69dBKCxWMgjvikRw3b2QtOPLFIgU9GMdTRdnaV53wbPreLuJMNjQIDAQABAoIBABpfd3i19O+693/Q+dJNAfLIaAshmvnPlZBFSluBH/4kPeKTAoDDkla6jkRiu7Tlm7XNaegFdCqBnOoB2bvrVkV43noEGVK8q0nCoUgspi1T3Bsn/A6EbO8cVlMyOBPdKFEo+uxj630ZqvksckiaEBJ4gb8pgOGgmfwhOjaQ/o9uHGaS2ay58EXrG3gWC5ldA5N7Kd1EVf7x4H1Z+ymvjsyCcg1n3d0h7dNPHt/kXhlupbsQsuRu0QXOXc7ZP1YshQgMx1tVTFexzLEnnkU/qVnG6SM40/mksfTLGRJnOvKjJlkVOOqQlZfaXIq4aGiPDdm8Cyq7JEuirgSFFx4Np9UCgYEA9jU5McmfpiLXvMSePufbLLjj3MmQqJMvbPUcnuWakD/G714tp6jHgBCcM0qJaTkvX+JBuU7D/q2B56AKWvr/DpkIC2Y5PdgJz90XuLyQjO7ldORE+mrnbZ2uAn2v5W7VXGsN8z9gb6qVFhaAYWRNspT6p3ck+OSarsqGCuwpZk8CgYEA0d+CqLYLDSvLbe5s1VH1BHmXn2hqq0T2pLAoYU/3vvbtBY9B7eXsY/kehdNnsmmnlSfIYCNg17ZhkU6/dTZBpgbIJQ1lKBtINwrXAL/yVBIHkmXPlBobcgzI1ZW44leY41CfzUnDPfL4ULD//S13Dk/+GiEXlZLkAUzoHn71c2MCgYAGkwlB8RZYQ1nranynRV2u5gj/nkpElhmQGUN4Yr0r2OghACzL60/YdZkWLYlZy/Md5lbG8fl91XhAjR95qnYhF6kFVOd2ZUxtxoOZpT9e5Aowgt/sp+oiHTHGU0DdKYZ8/0bSFgEnOjDc9CDdeOYyPJQs4JuWIdSXkkTeCcxZNQKBgEHTE3zs09yGruBE1pe1g96qcFbL/iDHmYAfzBpxZWfctIx42RnPcmwMt3kLzEtV/fy3JI6aqgYeKs3TYBNYOBDlsaKFaAPDQswYt0SB73RUz1EoY4m1AoSr49WxhvJevRIWuHg/uV/Vs/JDAZcbymqPxkfVtzrvflm2EFt4QG23AoGBAJMUb4qxT4cIiQ5beUHD99mogeQzuLdd03jZy/udPRG0Q9fnIu4xR2V3UtedPF4h5jQGzy/HXjteBl+F3PRyBog3/EjlZ6fpxiaYtRTAPHFYpkk/CckHn4uzhx4snM1s69YSdn/ypisdqFO0AH3qTm12GeoAcWX/iO0VnEok6H7U',
        ],
    ];

    /**
     * 支付宝同步回调
     */
    public function software_return()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if($pay->driver('alipay')->gateway()->verify($request->param())){
            $url = 'https://manage.siring.com.cn/#/afterLoggin';

            header('Location:'.$url);
        };
    }


    /**
     * 支付宝异步回调
     */
    public function software_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                  //  'need_status'=>4,
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
    public function app_notice(){

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
                        //  'need_status'=>4,
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
     * 合伙人支付回调
     */
    public function partner_return()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if($pay->driver('alipay')->gateway()->verify($request->param())){
            $url = 'https://manage.siring.com.cn/#/afterLoggin';

            header('Location:'.$url);
        };
    }

    /**
     *合伙人支付宝异步回调
     */
    public function partner_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    //  'need_status'=>4,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);
                //用户表
                $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update([
                    'type'=>2,
                    'is_city'=>1,
                    'agent_city'=>$data['city_id']
                ]);
                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res3 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                return $res1 && $res2 && $res3  ? true : false;
            });


        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 合伙人微信支付回调
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function partner_notice()
    {
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
                        //  'need_status'=>4,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);

                    //用户表
                    $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update([
                        'type'=>2,
                        'is_city'=>1,
                        'agent_city'=>$data['city_id']
                    ]);
                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res3 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2 && $res3  ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

    /**
     * 分包商支付宝回调
     */
    public function sub_return()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if($pay->driver('alipay')->gateway()->verify($request->param())){
            $url = 'https://manage.siring.com.cn/#/afterLoggin';

            header('Location:'.$url);
        };
    }

    /**
     *分包商支付宝异步回调
     */
    public function sub_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    //  'need_status'=>4,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);

                //用户表
                $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update([
                    'type'=>2,
                    'is_subpackage'=>1,
                    'sub_id'=>$data['id']
                ]);
                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res3 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                return $res1 && $res2 && $res3  ? true : false;
            });


        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 分包商微信支付回调
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function sub_notice()
    {
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
                        //  'need_status'=>4,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);
                    //用户表
                    $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update([
                        'type'=>2,
                        'is_subpackage'=>1,
                        'sub_id'=>$data['id']
                    ]);
                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res3 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2 && $res3  ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }

    /**
     * 等级会员支付宝回调
     */
    public function grade_return()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if($pay->driver('alipay')->gateway()->verify($request->param())){
            $url = 'https://manage.siring.com.cn/#/afterLoggin';

            header('Location:'.$url);
        };
    }

    /**
     * 等级会员异步回调
     */
    public function grade_notify()
    {
        $request = Request::instance();
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->param())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents('notify.txt', "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单号：' . $request->param('out_trade_no') . "\r\n", FILE_APPEND);
            file_put_contents('notify.txt', '订单金额：' . $request->param('total_amount') . "\r\n\r\n", FILE_APPEND);

            $no['order_no'] = $request->param('out_trade_no');
            $no['money'] = $request->param('total_amount');
            //事务
            Db::transaction( function() use ( $no ){
                //查询订单
                $data =  Order::get(['no'=>$no['order_no']]);
                $res1 =  Order::where('id',$data['id'])->update([
                    //  'need_status'=>4,
                    'payment'=>2,
                    'pay_type'=>1,
                    'pay_time'=>time(),
                ]);
                //用户表
                $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update(['type'=>2, 'grade'=>1]);
                //用户等级表
                $res3 = (new UserGrade())->where('user_id',$data['user_id'])->update(['grade'=>1]);
                //订单统计表添加
                $budget_type = 1;
                $income = '';//收入金额
                $res4 = (new AllOrder())->allorder_add($budget_type,$data,$no['money'],$income);

                return $res1 && $res2 && $res3 && $res4 ? true : false;
            });


        } else {
            file_put_contents('notify.txt', "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }

    /**
     * 等级会员微信支付回调
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function grade_notice()
    {
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
                        //  'need_status'=>4,
                        'payment'=>2,
                        'pay_type'=>2,
                        'pay_time'=>time(),
                    ]);
                    //用户表
                    $res2 = (new \app\data\model\User())->where('id',$data['user_id'])->update(['type'=>2, 'grade'=>1]);
                    //用户等级表
                    $res3 = (new UserGrade())->where('user_id',$data['user_id'])->update(['grade'=>1]);
                    //订单统计表添加
                    $budget_type = 1;
                    $income = '';//收入金额
                    $res4 = (new AllOrder())->allorder_add($budget_type,$data,$data['money'],$income);

                    return $res1 && $res2 && $res3 && $res4 ? true : false;

                });
            }
            return true;

        });
        // 将响应输出
        return $response;
    }
}
