<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/8
 * Time: 16:08
 */
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class About extends Base {
    /**
     * @function 关于我们
     */
    public function profitInfo(){
        $info = Db::table('about')->where('type',1)->find();
        if(empty($info)){
            $info = new \ArrayObject();
        }

        return $this->buildSuccess([
            'info'=>$info,
        ]);
    }

    /**
     * @function 关于我们更新
     */
    public function profitUpd(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'con'=>'require',
        ];
        $message = [
            'con.require'=>'请填写内容',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        $info = Db::table('about')->where('type',1)->find();
        if(empty($info)){
            $insert = Db::table('about')->where('type',1)->insert($param);
            if($insert){
                return $this->buildSuccess([]);
            }else{
                return $this->buildFailed(0,'操作失败');
            }
        }else{
            $param['id'] = $info['id'];
            $update = Db::table('about')->where('type',1)->update($param);
            if($update !== false){
                return $this->buildSuccess([]);
            }else{
                return $this->buildFailed(0,'操作失败');
            }
        }
    }
}