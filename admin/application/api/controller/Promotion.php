<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/2
 * Time: 11:10
 */
namespace app\api\controller;

use app\data\model\PromotionOrder;
use think\Controller;
use think\Request;
use think\Session;

/**
 * 控制台-AI推广运营
 * Class Promotion
 * @package app\api\controller
 */
class Promotion extends Controller
{

    /**
     * AI推广列表
     * @throws \think\exception\DbException
     */
    public function manuscript_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new PromotionOrder();

        $uid = Session::get("uid");

        if($uid){

            $uid = Session::get("uid");
            $data = $good->promotion_list($param,$uid);


            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }

            return  returnJson(0,'请登录');
    }


}
