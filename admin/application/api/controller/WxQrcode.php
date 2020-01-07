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

        $options = config('wechat');

        $app = new Application($options);

        $qrcode = $app->qrcode;

        $result = $qrcode->forever(56);// 或者 $qrcode->forever("foo");

        $url = $result->url;

        $imgData = 'http://qr.topscan.com/api.php?text='. $url;
        pp($imgData);die;
        $content = file_get_contents($url); // 得到二进制图片内容

        file_put_contents(__DIR__ . '/code.jpg', $content); // 写入文件
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
            $openid =     $message->FromUserName; // 用户的 openid
            $userInfo = $user->get($message->FromUserName);
            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息'.$openid;
                    break;
                case 'text':
                    return '收到文字消息'.$openid;
                    break;
                case 'image':
                    return '收到图片消息'.$userInfo->nickname;
                    break;
                case 'voice':
                    return '收到语音消息'.$userInfo->nickname;
                    break;
                case 'video':
                    return '收到视频消息'.$userInfo->nickname;
                    break;
                case 'location':
                    return '收到坐标消息'.$userInfo->nickname;
                    break;
                case 'link':
                    return '收到链接消息'.$userInfo->nickname;
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息'.$userInfo->nickname;
                    break;
            }

            // ...
        });

        $response = $app->server->serve();

        // $response 为 `Symfony\Component\HttpFoundation\Response` 实例
        // 对于需要直接输出响应的框架，或者原生 PHP 环境下
        $response->send();

    }
}
