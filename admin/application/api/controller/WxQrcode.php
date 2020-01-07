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
    //微信公众平台信息（appid/secret）
    protected $sj_appid = 'wx7a8782e472a6c34a';
    protected $sj_secret = 'ae3dce2528dc43edd49e571cb95b9c25';
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

            $userInfo = $user->get($message->FromUserName);
            $msg = $message->EventKey;
            $user = new \app\data\model\User();
            $user->upd($openid,$msg);

            return "您好".$userInfo->nickname."！欢迎关注我!";

        });

        $response = $app->server->serve();

        // 对于需要直接输出响应的框架，或者原生 PHP 环境下
        $response->send();

    }

    public function wx_accredit(){
        $redirect_uri = 'http://manage.siring.com.cn/api/WxQrcode/wx_code';
        $redirect_uri = urlencode($redirect_uri);
        //微信公众平台appid
        $appid = $this->sj_appid;

        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';

        header('Location:'.$url);
    }
    /**
     * @function 获取openid
     */
    public function wx_code(){
        $request = Request::instance();
        $param = $request->param();
        if(empty($param['code'])){
            return returnJson(0,'code参数为空');exit;
        }
        //print_r($param['code']);die;
        //微信公众平台信息
        $appid = Config::get('wx_appid');
        $secret = Config::get('wx_secret');

        //获取token
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$param['code'].'&grant_type=authorization_code';
        $data = $this->curlGet($url);
        //print_r($data);die;
        if(empty($data['access_token'])){
            return returnJson(0,'access_token错误');exit;
        }
        if(empty($data['openid'])){
            return returnJson(0,'openid错误');exit;
        }
        //拿取头像相关信息
        $token = $data['access_token'];
        $openid = $data['openid'];
        $Allurl = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';

        $res = $this->curlGet($Allurl);
        print_r($res);die;
        $openid_name = db('user')->where(array('openid'=> $openid))->field('id,phone_number')->find();
        // print_r($openid_name);die;
        if($openid_name){
            //更新用户信息
            db('user')->where(array('openid'=> $openid))->update(['img'=>$res['headimgurl'],]);
            //跳转首页
            $url = Config::get('web_url').$this->app_index.'?user_id='.$openid_name['id'];
            header('Location:'.$url);
        }else{
            //跳转绑定账号页面
            $url = Config::get('web_url').$this->app_wx.'?openid='.$data['openid'];
            header('Location:'.$url);
        }
    }

    /**
     * @function curl以get方式连接
     */
    public function curlGet($url){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($curl);
        curl_close($curl);
        return json_decode($data,true);
    }
}
