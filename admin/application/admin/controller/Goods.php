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
use app\util\ReturnCode;
use app\util\Tools;
use app\model\Goods as Goods2;
use app\model\Special;

class Goods extends Base{

    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品列表
     */
    public function index(){
        $where['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $where['page'] = $this->request->get('page', 1);
        $goods_name = $this->request->get('goods_name', '');
        $category_id = $this->request->get('category_id', '');
        $goods_recommend_staus = $this->request->get('goods_recommend_staus', '');
        $where = [];
        if (!empty($goods_recommend_staus)) {
            $where['goods_recommend_staus'] = $goods_recommend_staus;
        }
        if ($goods_name) {
            $where['goods_name'] = ['like', "%{$goods_name}%"];
        }
        halt($where);
        $listObj=(new Goods2())->getGoodsList($where);
        $listInfo = $listObj['data'];
        return $this->buildSuccess([
            'list'  => $listInfo,
            'count' => $listObj['total']
        ]);
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
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品编辑
     */
    public function edit(){
        //获取参数id-商品id
        $id = $this->request->get('id', '');
        $goods_info=Goods2::get($id);
        $goods_info['special']=Special::getSpecialInfo($id);
        if($goods_info){
            return $this->buildSuccess([
                'data'=>$goods_info
            ]);
        }else{
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '操作失败');
        }
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品删除
     */
    public function delete(){

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品复制
     */
    public function copy(){

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--添加评论
     */
    public function evaluate(){

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--检索
     */
    public function search(){

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--检索
     */
    public function business_meal(){

    }



}