<?php
namespace  app\controller;

use app\data\model\UserCard as Card;
use think\Request;
use think\Session;
use think\Db;

/**
 * lilu
 * 用户银行控制器
 */
class  UserCard extends  Base{

    /**
     * lilu
     * 添加/编辑用户信用卡
     */
    public function user_card_add()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            if($postData['default_status']==1){    //银行是默认使用
                $re=UserCard::update(['user_id'=>$postData['user_id'],'default_status'=>0]);
            }
            if($postData['id']==0){
                $res=UserCard::create($postData)->toArray();
            }else{
                $res=UserCard::update($postData)->toArray();
            }
            return   json(['1','操作成功','data'=>$res]);
        }else{
            return   json(['0','获取数据失败']);
        }
    }

    /**
     * lilu
     * 获取用户的银行卡列表
     * param  user_id
     */
    public function user_card_list()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
                $res=UserCard::all(['user_id'=>$postData,'del_time'=>null])->toArray();
            return   json(['1','操作成功','data'=>$res]);
        }else{
            return   json(['0','获取参数失败']);
        }

    }

    

}