<?php

namespace app\data\model;

use think\Model;
use Yansongda\Pay\Pay;
use think\Request;
/**
 * @author fyk
 * 支付宝支付
 * Class Alipay
 * @package app\data\model
 */
class Alipay extends Model
{

    /**
     * 扫码支付接口
     * @param $no
     * @param $money
     * @param $title
     * @return mixed
     */
    public function get_alipay($notify_url,$return_url,$no,$money,$title)
    {

        $config = [
            'alipay' => [
                'app_id' => config('alipay.app_id'),
                'notify_url' => $notify_url,
                'return_url' => $return_url,
                'ali_public_key'        => config('alipay.ali_public_key'),
                'private_key'     => config('alipay.private_key'),
            ],
        ];

        $config_biz = [
            'out_trade_no' => $no,
            'total_amount' => $money,
            'subject'      => $title,
        ];

        $pay = new Pay($config);

        $data = $pay->driver('alipay')->gateway('scan')->pay($config_biz);


        //生成支付码
        $imgData = 'http://qr.topscan.com/api.php?text='. $data;

        return json(['code'=>1,'msg'=>'发起支付成功','imgData'=>$imgData]);exit();
    }

}
