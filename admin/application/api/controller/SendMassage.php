<?php

namespace app\api\controller;
use think\Controller;
use think\Request;
use think\Validate;


class SendMassage extends Controller
{

    /**
     * 短信中转API
     * @param $data
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sendMassage(Request $request)
    {
        if($request->isPost()){
            $data = Request::instance()->param();
            $validate  = new Validate([
                ['MsgId', 'require', '消息编号不能为空'],
                ['Channel', 'require', '发送通道不能为空'],
                ['MobileNo', 'require', '手机号不能为空'],
                ['Zone', 'require', '手机区号不能为空'],
                ['Content','require','消息内容不能为空'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($data)) {
                $this->error = $validate->getError();
                $return_data = [
                    'Status'=> false,
                    'StatusCode'=> 201, //参数错误
                    'Msg' => $this->error,
                    'GatewayId' => " ",
                ];
                return json_encode($return_data);
            }
            //手机格式
            if(!$this->isMobile($data['MobileNo'])) {
                $return_data = [
                    'Status'=> false,
                    'StatusCode'=> 202, //手机格式错误
                    'Msg' => '手机格式错误',
                    'GatewayId' => " ",
                ];
                return json_encode($return_data);
            }

            $restul = $this->send($data['Content'],$data['MobileNo']);
            return json_encode($restul);
        }


    }


    /**
     * @param string $content  短信内容
     * @param string $mobile   手机号
     * @return 成功时返回，其他抛异常
     */

    public function send($content,$mobile)
    {
        $massageSign = '【智慧茶仓】';
        // $content = '【智慧茶仓】短信内容';//带签名的短息内容
        // $mobile = '18309224319';//手机号
        $url = "http://117.48.217.182:8860/sendSms";//请求URL
        $api_code = "240001";//对接协议中的API代码
        $api_secret = "4SFE6PW1GL";//对接协议中的API密码
        $content = $massageSign.$content;
        $sign = md5($content.$api_secret);//md加密后短信内容+API密码 获得签名
        $bodys = [
            'cust_code'=>$api_code,
            'content' => $content,
            'destMobiles' => $mobile,
            'sign' => $sign,
        ];
        $data_string = json_encode($bodys);
        if (!function_exists('curl_init'))
        {
            return '';
        }
        //设置url
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/html'));// 文本提交方式，必须声明请求头
        $data = curl_exec($ch);
        if($data === false){
            var_dump(curl_error($ch));
        }else{
            curl_close($ch);
        }
        return $data;
    }

    /**
     * 
     * 验证手机号
     */
    public function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8|9)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
