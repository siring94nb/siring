<?php

namespace app\data\model;
use think\Config;
use think\Model;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
class WechatPay extends Model
{
    /**
     * @param $title
     * @param $detail
     * @param $no
     * @param $cost
     * @param $url
     * @param $openid
     * @return array|string|\think\response\Json
     */
    public function pay($title,$no,$cost,$url)
    {
        //支付相关参数
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP
            'body'             => $title,//标题
            'detail'           => 'Siring支付订单',//详情
            'out_trade_no'     => $no,//订单号
            'total_fee'        => $cost, // 单位：分
            'notify_url'       => $url, // 支付结果通知网址，如果不设置则会使用配置里的默认地址
//            'openid'           => $openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        //初始化SDK相关配置
        $options = config('wechat');

        $app = new Application($options);

        $payment = $app->payment;
        //生成订单
        $order = new Order($attributes);

        $result = $payment->prepare($order); // 这里的order是上面一步得来的。 这个prepare()帮你计算了校验码，帮你获取了prepareId.省心。
        $prepayId = null;
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id; // 这个很重要。有了这个才能调用支付。
            $codeUrl = $result->code_url;//生成二维码支付
            //生成二维码
            //生成二维码
            $imgData = 'http://qr.topscan.com/api.php?text='. $codeUrl;
//            $Qr = new QrCode($codeUrl);
//            $Qr->setSize(300)
//                ->setWriterByName('png')
//                ->setMargin(10)
//                ->setEncoding('utf-8')
//                ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
//                ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0])
//                ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
////                ->setLogoPath(ROOT_PATH . 'template/common/images/wxpay.png')
////                ->setLogoWidth(65)
//                ->setValidateResult(false);
//            $Qr->writeFile(ROOT_PATH . "uploads/qrcode.png");
//            $imgData= imgToBase64(ROOT_PATH . "uploads/qrcode.png");
            return json(['code'=>1,'msg'=>'发起支付成功','imgData'=>$imgData]);exit();
        } else {
            return json(array('code'=>0,'msg'=>"发起支付失败"));exit();
        }

    }


    /**
     * 微信消息推送
     * @param $first
     * @param $openId
     * @param $keyword1
     * @param $keyword2
     * @param $keyword3
     * @return bool
     */
    public static function push_message($first,$openId,$keyword1,$keyword2,$keyword3){

        //初始化SDK相关配置
        $options = config('wechat');

        $app = new Application($options);
        $notice = $app->notice;

        $templateId = '45AVtOWclAImNCa4FD3FKFFii0PLlTe9WUj6YgljwJY';
        $url = 'https://www.siring.com.cn/#/afterLoggin'; // 点击到达的页面url
        $data = array(
            "first"  => $first,
            "keyword1"   => $keyword1,
            "消息内容"  => $keyword2,
            "keyword3"  => $keyword3,
            "keyword4"  => date("Y-m-d H:i:s", time()),
            "remark" => "具体内容请前往PC端查看！感谢你的使用！",
        );

        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($openId)->send();
        $result_arr = json_decode($result);

        if(!empty($result_arr) && $result_arr->errmsg == "ok"){
            return true;
        }else{
            return false;
        }
    }
}
