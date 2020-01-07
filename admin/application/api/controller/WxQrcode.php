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
    public function code_add()
    {

        $options = config('wechat');

        $app = new Application($options);

        $qrcode = $app->qrcode;

        $result = $qrcode->forever(56);// 或者 $qrcode->forever("foo");

        $ticket = $result->ticket; // 或者 $result['ticket']

        $url = $result->url;

        pp($url);die;
        $url = $qrcode->url($ticket);

        $content = file_get_contents($url); // 得到二进制图片内容

        file_put_contents(__DIR__ . '/code.jpg', $content); // 写入文件
    }
}
