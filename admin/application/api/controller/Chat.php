<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/6
 * Time: 10:14
 */
namespace app\api\controller;
use app\data\model\Message;
use app\data\model\WechatPay;
use app\data\model\User;
use think\Request;

/**
 * 消息留言
 * Class Chat
 * @package app\api\controller
 */
class Chat extends Base
{

    /**
     * 消息留言
     */
    public function add_message()
    {
        $request = Request::instance();
        $param = $request->param();

        $data = (new Message())->add($param);
        if($data){
            $user = (new User())->user_detail($param['rid']);

            $msg = WechatPay::push_message('Siring消息推送',$user['open_id'],'123456','123','待确认');
        }

        return $data ? returnJson(1,'留言成功'): returnJson(0,'提交失败');

    }

    /**
     * 用户留言列表
     * @param $pid
     * @param $uid
     * @throws \think\exception\DbException
     */
    public function msg_list($pid,$uid)
    {

        $data = Message::get_list($pid,$uid);

        return $data ? returnJson(1,'获取成功',$data): returnJson(0,'获取失败',$data);

    }

    /**
     * 读取消息
     * @param $xid
     */
    public function msg_read($xid)
    {
        $data = Message::where('id',$xid)->update(['type'=>1]);

        return $data ? returnJson(1,'读取成功',$data): returnJson(0,'读取失败',$data);
    }
}
