<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Validate;

class Treaty extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $con_a = Db::table('about')->where(['type'=>2])->find();
        if(empty($con_a)){
            $con_a = new \ArrayObject();
        }

        $con_b = Db::table('about')->where(['type'=>3])->find();
        if(empty($con_b)){
            $con_b = new \ArrayObject();
        }

        $con_c = Db::table('about')->where(['type'=>4])->find();
        if(empty($con_b)){
            $con_b = new \ArrayObject();
        }
        return $this->buildSuccess([
            'con_a'=>$con_a,
            'con_b'=>$con_b,
            'con_c'=>$con_c,
        ]);
    }


    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function upd()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'con_a'=>'require|regex:/^[1-9]\d*$/',
            'con_b'=>'require|regex:/^[1-9]\d*$/',
        ];
        $message = [
            'con_a.require'=>'请填写签到积分',
            'con_a.regex'=>'签到积分应为正整数',
            'con_b.require'=>'请填写商品积分',
            'con_b.regex'=>'商品积分应为正整数',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        // 签到积分
        $param['type'] = 2;
        $info = Db::table('info')->where(['type'=>2])->find();
        if(empty($info)){
            $insert = Db::table('info')->insert(array('con'=>$param['con_a'],'type'=>$param['type']));
            if(!$insert){
                return $this->buildFailed(0,'操作失败');
            }
        }else{
            $param['id'] = $info['id'];
            $update = Db::table('info')->update(array('id'=>$param['id'],'con'=>$param['con_a'],'type'=>$param['type']));
            if($update === false){
                return $this->buildFailed(0,'操作失败');
            }
        }

        // 商品积分
        $param['type'] = 5;
        $info = Db::table('info')->where(['type'=>5])->find();
        if(empty($info)){
            $insert = Db::table('info')->insert(array('con'=>$param['con_b'],'type'=>$param['type']));
            if(!$insert){
                return $this->buildFailed(0,'操作失败');
            }
        }else{
            $param['id'] = $info['id'];
            $update = Db::table('info')->update(array('id'=>$param['id'],'con'=>$param['con_b'],'type'=>$param['type']));
            if($update === false){
                return $this->buildFailed(0,'操作失败');
            }
        }

        return $this->buildSuccess([]);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
