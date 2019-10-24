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
use think\Validate;


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
        // foreach($list as $k =>$v){
        //     //获取当前id对应的规格
        //     $list[$k]['special']=$listObj2=Special::getSpecialInfo($v['id']);
        // }
        $listInfo = $list;
        return $this->buildSuccess([
            'list'  => $listInfo,
        ]);
    }
    /** 
     * lilu
     * 商品管理-商品/软件开发定制--商品添加
     */
    public function add(){
        $groups = '';
        $postData = $this->request->post();
        //判断商品的名字是否重复
        $is_use=Good::get(['goods_name'=>$postData['data']['goods_name']]);
        if($is_use){
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        unset($postData['data']['id']);
        $postData['data']['create_time']=time();
        $res = Good::create($postData['data'])->toArray();
        if ($res) {
                //获取新增的goods_id($res->id)
                foreach($postData['special'] as $k2 =>$v2){
                    unset($postData['special'][$k2]['id']);
                    $postData['special'][$k2]['goods_id']=$res['id'];
                    Special::create($postData['special'][$k2]);
                }
                return $this->buildSuccess([]);
            } else {
                return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');
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
        $is_use=Good::all(['goods_name'=>$postData['data']['goods_name']]);
        if(count($is_use) >= 2){
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        //获取参数id-商品id
        $postData['data']['update_time']=time();
        $goods_info=Good::update($postData['data']);
        foreach($postData['special'] as $k =>$v){
            $goods_info2=Special::update($postData['special'][$k]);
        }
        // $goods_info['special']=Special::getSpecialInfo($id);
        
        if($goods_info !==false){
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
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品分类列表
     */
    public function category_index(){
        $request = Request::instance();
        $list = Db::table('category')->select();
        return $this->buildSuccess([
            'list'=>$list,
        ]);
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品分类添加
     */
    public function category_add(){
        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'category_name'=>'require',
        ];
        $message = [
            'category_name.require'=>'分类名称不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $result = Db::table('category')->insert($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品分类编辑
     */
    public function category_edit(){
        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'id'=>'require',
            'category_name'=>'require',
        ];
        $message = [
            'id.require'=>'缺少必要参数',
            'category_name.require'=>'分类名称不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $result = Db::table('category')->update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品分类删除
     */
    public function category_del(){
        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'id'=>'require',
        ];
        $message =[
            'id.require'=>'缺少必要参数',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $info = Db::table('banner')->find($param['id']);
        if(empty($info)){
            return $this->buildFailed(0,'数据不存在');
        }
        $result = Db::table('banner')->where('id',$param['id'])->delete();
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }
    /**
     * lilu
     * 获取商品的信息
     * id
     * get
     */
    public function get_goods(){
        $request=Request::instance();
        //获取商品id
        $goods_id=$request->get('id');
        $goods_info=Good::get($goods_id)->toArray();
        //获取商品对应的规格信息
        $special=Special::all(['goods_id'=>$goods_info['id']])->toArray();
        if($goods_info){
            return $this->buildSuccess([
                'data'=>$goods_info,
                'special'=>$special,
            ]);
        }else{
            return $this->buildFailed(0,'获取失败');
        }
    }

    /**
     * lilu
     * 商品管理-软件定制商品-定制商品
     */
    public function made(){
        $where['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $where['page'] = $this->request->get('page', 1);
        $goods_name = $this->request->get('goods_name', '');
        $goods_recommend_staus = $this->request->get('goods_recommend_staus', '');
        if (!empty($goods_recommend_staus)) {
            $where['goods_recommend_staus'] = $goods_recommend_staus;
        }
        if ($goods_name) {
            $where['goods_name'] = ['like', "%{$goods_name}%"];
        }
        $list=Good::getGoodsList($where);
        // foreach($list as $k =>$v){
        //     //获取当前id对应的规格
        //     $list[$k]['special']=$listObj2=Special::getSpecialInfo($v['id']);
        // }
        $listInfo = $list;
        return $this->buildSuccess([
            'list'  => $listInfo,
        ]);
    }



}