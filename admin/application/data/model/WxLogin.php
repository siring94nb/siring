<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/8
 * Time: 10:34
 */
namespace app\data\model;
use think\Request;
use think\Model;
class WxLogin extends Model
{
    //微信公众平台信息（appid/secret）
    protected $sj_appid = 'wxf0c67b5684405d44';
    protected $sj_secret = 'efbf672f147c397407b2267cf3d4253a';

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
        //微信公众平台信息
        $appid = $this->sj_appid;
        $secret = $this->sj_secret;

        //获取token
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$param['code'].'&grant_type=authorization_code';
        $data = $this->curlGet($url);

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

        return $res;

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
