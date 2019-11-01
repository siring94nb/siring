<?php
namespace app\admin\controller;

use think\Db;
use think\Request;
use app\util\ReturnCode;
use app\model\Templete ;
use app\data\model\Good as GoodModel;
use app\data\model\Reviews;
use app\model\Special;

/**
 * lilu
 * 小程序saas管理
 */
class AppletManage extends Base{

    /**
     * lilu
     * 行业模板-模板列表
     */
    public function index()
    {
        $size = $this->request->post('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $page = $this->request->post('page', 1);
        $model_name = $this->request->post('model_name', '');
        $where['del_time']=NULL;
        if ($model_name) {
            $where['model_name'] = ['like', "%{$model_name}%"];
        }
        $templete= new Templete();
        $list=$templete->where($where)->order('id desc')->paginate($size, false, ['page' => $page])->toArray();
        $listcount=$templete->count();
        if($list){
            return $this->buildSuccess([
                'data'=>$list,
                'listCount'=>$listcount,
            ]);
        }else{
            return $this->buildFailed('0','获取数据失败');
        }
    }
    /**
     * lilu
     * 行业模板-模板添加
     */
    public function add()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            unset($postData['id']);
            $res=Templete::create($postData)->toArray();
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','获取参数失败');
        }
    }
    /**
     * lilu
     * 行业模板-模板编辑
     */
    public function edit()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=Templete::update($postData)->toArray();
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','获取参数失败');
        }
    }
    /**
     * lilu
     * 行业模板-模板删除
     */
    public function del()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=Templete::update(['id'=>$postData['id'],'del_time'=>time()])->toArray();
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','获取参数失败');
        }
    }
    /**
     * lilu
     * 行业模板-切换模板的现实状态
     * param     id     模板的id
     * param     model_status     模板的状态
     */
    public function change_model_status()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=Templete::update($postData);
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed('0','缺少必要的参数');
        }

    }
    
    /**
     * lilu
     * 行业模板-模板套餐
     */
    public function model_meal()
    {

    }







}
