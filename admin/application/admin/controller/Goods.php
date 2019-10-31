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
use app\data\model\Good as GoodModel;
use app\data\model\Reviews;
use app\data\model\Evaluate;
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
        // if ($category_id !== '-1') {
        //     $where['category_id'] = $category_id;
        // }
        if ($goods_recommend_staus !== '-1') {
            $where['goods_recommend_staus'] = $goods_recommend_staus;
        }
        if ($goods_name) {
            $where['goods_name'] = ['like', "%{$goods_name}%"];
        }
        $list=Good::getGoodsList($where);
        foreach($list as $k =>$v){
            //获取当前id对应的规格
            $list[$k]['special']=Special::get($v['id']);
        }
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
        $postData['data']['period']=$postData['special'][0]['cycle_time'];  
        $postData['data']['original_price']=$postData['special'][0]['price'];  
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
        $postData = $this->request->param();  //获取传参
        //判断商品的名字是否重复
        $is_use=Good::all(['goods_name'=>$postData['data']['goods_name']]);
        if(count($is_use) >= 2){
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        //获取参数id-商品id
        $postData['data']['update_time']=time();
        $postData['data']['create_time']=strtotime($postData['data']['create_time']);
        $postData['data']['period']=$postData['special'][0]['cycle_time'];  
        $postData['data']['original_price']=$postData['special'][0]['price']; 
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
    public function del(){
        //获取删除的id
        $request=Request::instance();
        $goods_id=$request->post('id');
        $res=Good::destroy($goods_id);
        if($res !== false){
            //删除商品对应的规格
            $special = Special::all(['goods_id'=>$goods_id])->toArray();
            foreach($special as $k =>$v){
                Special::destroy($v['id']);
            }
           return $this->buildSuccess([]);
        }else{
           return $this->buildFailed(['0','删除失败，请重新删除']);
        }

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--商品复制
     */
    public function copy(){
        //复制当前的商品信息新生成一天记录
        $request=Request::instance();
        $id=$request->param();
        if($id){
            //获取商品的信息
            $data['data']=Goods::get($id['id']);
            $data['special']=Special::all(['goods_id'=>$id['id']])->toArray();
            unset($data['data']['id']);
            $data['data']['create_time']=time();
            $data['data']['update_time']=null;
            $res=Good::create($data['data'])->toArray();
            foreach($special as $k =>$v){
                //获取新增的goods_id($res->id)
                foreach($data['special'] as $k2 =>$v2){
                    unset($data['special'][$k2]['id']);
                    $data['special'][$k2]['goods_id']=$res['id'];
                    Special::create($data['special'][$k2]);
                }
            }
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','缺少必要参数');
        }

    }
    /**
     * lilu
     * 商品管理-商品/软件开发定制--添加评论
     */
    public function evaluate(){
        $evaluate=new Evaluate();
        $list=Evaluate::all()->toArray();
        $listcount=Evaluate::count();
        if($list){
            foreach($list as $k =>$v ){
                $list[$k]['plate_name']=Evaluate::getStatusAttr($v['plate_form']);
            }
            return $this->buildSuccess([
                'data'=>$list,
                'listCount'=>$listcount
            ]);
        }else{
            return $this->buildFailed('0','获取失败');
        }


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
        $goods_id=$request->post('id');
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
     * 商品管理-软件定制商品-定制案例
     */
    public function made(){
        $size = $this->request->post('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $page = $this->request->post('page', 1);
        $project_name = $this->request->post('project_name', '');
        $where['del_time']=NULL;
        if ($project_name) {
            $where['project_name'] = ['like', "%{$project_name}%"];
        }
        $list=Db::table('made_good')->where($where)->order('id desc')->paginate($size, false, ['page' => $page])->toArray();
        foreach($list['data'] as $k =>$v){
            $list['data'][$k]['develop']=json_decode($v['develop'],true);
        }
        $listcount=Db::table('made_good')->where($where)->count();
        return $this->buildSuccess([
            'list'  => $list,
            'listCount'=>$listcount,
        ]);
    }

    /** 
     * lilu
     * 商品管理-定制案例--商品添加
     */
    public function made_add(){
        $groups = '';
        $postData = $this->request->param();
        //判断商品的名字是否重复
        $is_use=Db::table('made_good')->where('project_name',$postData['project_name'])->find();
        if($is_use){
            return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '定制案例已存在');
        }
        unset($postData['data']['id']);
        $postData['create_time']=time();
        $postData['develop']=json_encode($postData['develop']);
        $res = Db::table('made_good')->insert($postData);
        if ($res) {
                return $this->buildSuccess([]);
            } else {
                return $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');
        }
    }
    /**
     * lilu
     * 商品管理-定制案例--商品编辑
     */
    public function made_edit(){
        $groups = '';
        $postData = $this->request->param();  //获取传参
        //判断商品的名字是否重复
        $is_use=Db::table('made_good')->where('project_name',$postData['project_name'])->count();
        if($is_use >= 2){
            return $this->buildField(ReturnCode::DB_SAVE_ERROR, '商品名称已存在');
        }
        //获取参数id-商品id
        $postData['update_time']=time();
        $postData['develop']=json_encode($postData['develop']);
        $goods_info=Db::table('made_good')->update($postData);
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
     * 商品管理-定制商品--商品删除
     * param   id   商品id
     */
    public function made_del(){
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=Db::table('made_good')->update(['id'=>$postData['id'],'del_time'=>time()]);
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','缺少必要参数');
        }

    }

    /**
     * lilu
     * 获取马甲会员
     */
    public function get_horse_member(){
        $limit = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $start = $this->request->get('page', 1);
        $where['status']='1';
        $where['vest']='2';
        $member_list=Db::table('user')->where($where)->order('id asc')->field('id,realname')->select();
        if($member_list){
            return $this->buildSuccess([
                $member_list
            ]);
        }else{
            return $this->buildFailed('0','获取数据失败');
        }

    } 
    
    /**
     * lilu
     * 添加评论
     */
    public function add_comment(){
        $request=Request::instance();
        $datapost=$request->param();
        $res=Reviews::create($datapost['data'])->toArray();
        if($res){
            //增加官方回复
            $datapost['special']['cid']=$res['id'];
            $re=Reviews::create($datapost['special'])->toArray();
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','操作失败');
        }
    }

    /**
     * lilu
     * 历史评论
     * param   id  (商品ID)
     */
    public function comment_list()
    {
        $request=Request::instance();
        $dataPost=$request->param();
        if($dataPost['id'])
        {
            //获取商品的评论
            $goods_model=new GoodModel();
            $comment_list=$goods_model->good_review($dataPost['id'])->toArray();
            if($comment_list){
                return $this->buildSuccess([
                    'data'=>$comment_list,
                ]);
            }else{
                return $this->buildFailed('0','获取失败');
            }
        }else{
            return $this->buildFailed('0','缺少必须参数');
        }
    }
    
    /**
     * lilu
     * 历史评论删除
     * param   id  (商品ID)
     */
    public function comment_del()
    {
        $request=Request::instance();
        $dataPost=$request->param();
        if($dataPost['id'])
        {
            //删除商品的评论
            $goods_model=new GoodModel();
            $comment_list=$goods_model->good_review_del($dataPost['id']);
            if($comment_list){
                return $this->buildSuccess([]);
            }else{
                return $this->buildFailed('0','获取失败');
            }
        }else{
            return $this->buildFailed('0','缺少必须参数');
        }
    }

    /**
     * lilu
     * 切换软件开发商品的推荐状态
     * param   id    商品ID
     * param   goods_recommend_status    1  推荐    0   不推荐
     */
    public function change_goods_status()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=Good::update($postData);
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','缺少必要的参数');
        }
    }




}