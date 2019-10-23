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
use app\model\Goods as Good;
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
        if (!empty($goods_recommend_staus)) {
            $where['goods_recommend_staus'] = $goods_recommend_staus;
        }
        if ($goods_name) {
            $where['goods_name'] = ['like', "%{$goods_name}%"];
        }
        $list=Good::getGoodsList($where);
        foreach($list as $k =>$v){
            //获取当前id对应的规格
            $list[$k]['special']=$listObj2=Special::getSpecialInfo($v['id']);
        }
        $listInfo = $list;
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
        halt($postData);
        //判断商品的名字是否重复
        $is_use=Good::get(['goods_name'=>$postData['goods_name']]);
        if($is_use){
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        $res = Good::create($postData['data']);
        if ($res === false) {
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');
        } else {
           //获取新增的goods_id($res->id)
            foreach($postData['special'] as $k2 =>$v2){
                $postData['special']['goods_id']=$res->id;
                Special::create($postData['special'][$k2]);
            }
            return $this->buildSuccess([]);
        }
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品编辑
     */
    public function edit(){
        $groups = '';
        $postData = $this->request->post();  //获取传参
        //判断商品的名字是否重复
        $is_use=Good::all(['goods_name'=>$postData['goods_name']]);
        if(count($is_use) > 2){
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        //获取参数id-商品id
        $goods_info=Good::update($postData);
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