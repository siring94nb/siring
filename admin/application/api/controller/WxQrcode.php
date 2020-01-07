<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/7
 * Time: 14:48
 */
namespace app\api\controller;
use app\data\model\Message;
use think\Request;
use think\Session;
use EasyWeChat\Foundation\Application;
/**
 * 生成带参数二维码
 * Class WxQrcode
 * @package app\api\controller
 */
class WxQrcode extends Base
{
    /**
     * 生成扫描码
     */
    public function code_add()
    {
        $uid = Session::get("uid");

        if($uid){

            $options = config('wechat');

            $app = new Application($options);

            $qrcode = $app->qrcode;

            $result = $qrcode->temporary($uid, 60);

            $url = $result->url;

            $imgData = 'http://qr.topscan.com/api.php?text='. $url;

            echo "<img src='".$imgData."'>";
        }else{
            return  returnJson(3,'请登录');
        }

    }

    /**
     * 服务
     * @throws \EasyWeChat\Core\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Server\BadRequestException
     */
    public function serve(){

        $options = config('wechat');

        $app = new Application($options);
        $server = $app->server;
        $user   = $app->user;
        $server->setMessageHandler(function ($message) use ($user) {
            $openid =     $message->FromUserName;

            $msg = $message->EventKey;
            $user = new \app\data\model\User();
            $user->upd($openid,$msg);

            $userInfo = $user->get($message->FromUserName);

            return "您好".$userInfo->nickname."！欢迎关注我!";
            
        });

        $response = $app->server->serve();

        // 对于需要直接输出响应的框架，或者原生 PHP 环境下
        $response->send();

    }
}
