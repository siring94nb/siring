<?php
/**
 *
 * @since   2019-02-20
 * @author  fyk 企业付款到余额
 */

namespace app\util;
class Wxpay {

    function transfer($data){
    	//支付信息
    	$wxchat['appid'] = WxPayConfig::$appid;
    	$wxchat['mchid'] = WxPayConfig::$mchid;
    	$webdata = array(
    			'mch_appid' => $wxchat['appid'],//商户账号appid
                'mchid'     => $wxchat['mchid'],//商户号
    			'nonce_str' => md5(time()),//随机字符串
                'partner_trade_no'=> date('YmdHis'), //商户订单号，需要唯一
    			'openid' => $data['openid'],//转账用户的openid
    			'check_name'=> 'NO_CHECK', //OPTION_CHECK不强制校验真实姓名, FORCE_CHECK：强制 NO_CHECK：
    			'amount' => $data['money']*100, //付款金额单位为分
    			'desc'   => '微信企业付款到零钱',//企业付款描述信息
    			'spbill_create_ip' => request()->ip(),//获取IP
    	);
    	foreach ($webdata as $k => $v) {
    		$tarr[] =$k.'='.$v;
    	}
    	sort($tarr);
    	$sign = implode($tarr, '&');
    	$sign .= '&key='.WxPayConfig::$key;
    	$webdata['sign']=strtoupper(md5($sign));
    	$wget = $this->ArrToXml($webdata);//数组转XML
    	$pay_url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';//api地址
    	$res = $this->postData($pay_url,$wget);//发送数据
    	if(!$res){
    		return array('status'=>1, 'msg'=>"Can't connect the server" );
    	}
    	$content = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
    	if(strval($content->return_code) == 'FAIL'){
    		return array('status'=>1, 'msg'=>strval($content->return_msg));
    	}
    	if(strval($content->result_code) == 'FAIL'){
    		return array('status'=>1, 'msg'=>strval($content->err_code),':'.strval($content->err_code_des));
    	}
    	$rdata = array(
    			'mch_appid'        => strval($content->mch_appid),
    			'mchid'            => strval($content->mchid),
    			'device_info'      => strval($content->device_info),
    			'nonce_str'        => strval($content->nonce_str),
    			'result_code'      => strval($content->result_code),
    			'partner_trade_no' => strval($content->partner_trade_no),
    			'payment_no'       => strval($content->payment_no),
    			'payment_time'     => strval($content->payment_time),
    	);
    	return $rdata;
    }

    //数组转XML
    function ArrToXml($arr)
    {
        if(!is_array($arr) || count($arr) == 0) return '';
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    //发送数据
    function postData($url,$postfields){
        $ch = curl_init();
        $params[CURLOPT_URL] = $url;    //请求url地址
        $params[CURLOPT_HEADER] = false; //是否返回响应头信息
        $params[CURLOPT_RETURNTRANSFER] = true; //是否将结果返回
        $params[CURLOPT_FOLLOWLOCATION] = true; //是否重定向
        $params[CURLOPT_POST] = true;
        $params[CURLOPT_POSTFIELDS] = $postfields;
        $params[CURLOPT_SSL_VERIFYPEER] = false;
        $params[CURLOPT_SSL_VERIFYHOST] = false;
        //以下是证书相关代码
        $params[CURLOPT_SSLCERTTYPE] = 'PEM';
        $params[CURLOPT_SSLCERT] = getcwd().'/plugins/payment/weixin/cert/apiclient_cert.pem';//绝对路径
        $params[CURLOPT_SSLKEYTYPE] = 'PEM';
        $params[CURLOPT_SSLKEY] = getcwd().'/plugins/payment/weixin/cert/apiclient_key.pem';//绝对路径
        curl_setopt_array($ch, $params); //传入curl参数
        $content = curl_exec($ch); //执行
        curl_close($ch); //关闭连接
        return $content;
    }


}