<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 17:36
 */

namespace app\admin\controller;

use think\Db;
use think\Request;
use app\model\AdminAuthGroupAccess;
use app\util\ReturnCode;
use app\util\Tools;

class Goods extends Base{

    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品列表
     */
    public function index(){
        
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品添加
     */
    public function add(){
        $groups = '';
        $postData = $this->request->post();
        $postData['regIp'] = request()->ip(1);
        $postData['regTime'] = time();
        $postData['password'] = Tools::userMd5($postData['password']);
        if ($postData['groupId']) {
            $groups = trim(implode(',', $postData['groupId']), ',');
        }
        unset($postData['groupId']);

        //判断用户名唯一性
        $model = new AdminUser();
        $res = $model->where(array('username'=>$postData['username']))->field('id')->find();
        if($res){
            return $this->buildFailed(0, '该用户名已存在');
        }

        $res = AdminUser::create($postData);
        if ($res === false) {
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');
        } else {
            AdminAuthGroupAccess::create([
                'uid'     => $res->id,
                'groupId' => $groups
            ]);

            return $this->buildSuccess([]);
        }
    }
}