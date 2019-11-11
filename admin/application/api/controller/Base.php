<?php
/**
 * 工程基类
 * @since   2017/02/28 创建
 * @author  zhaoxiang <zhaoxiang051405@gmail.com>
 */

namespace app\api\controller;


use app\util\ApiLog;
use app\util\ReturnCode;
use think\Controller;
use think\Session;

class Base extends Controller {

    /**
     * lilu
     * 前置操作
     */
    protected $beforeActionList = [
        'is_login'  =>  ['only'=>'meal_order_add'],
    ];


    /**
     * lilu
     * 判断用户是否登录
     */
    protected function is_login()
    {
        if(Session::get('uid')){
            return   true;
        }else{
            return json(['code' => 0,'msg' =>'用户暂未登录']);
        }
    }

    public function __construct(){
        parent::__construct();
        //允许跨站提交
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
        header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

    }

    private $debug = [];
    protected $userInfo = [];

    public function _initialize() {
        $this->userInfo = ApiLog::getUserInfo();
    }

    public function buildSuccess($data, $msg = '操作成功', $code = ReturnCode::SUCCESS) {
        $return = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ];
        if ($this->debug) {
            $return['debug'] = $this->debug;
        }

        return json($return);
    }

    public function buildFailed($code, $msg, $data = []) {
        $return = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data
        ];
        if ($this->debug) {
            $return['debug'] = $this->debug;
        }

        return json($return);
    }

    protected function debug($data) {
        if ($data) {
            $this->debug[] = $data;
        }
    }

}
