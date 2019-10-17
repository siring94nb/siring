<?php

namespace app\api\controller;
use think\Db;
class Live extends Base {
    public function index() {
        $where = [];

        $list = Db::table('user') -> where($where) ->limit(1) -> select();
        
        if($list){
            return json(['code' => 1,'msg' => "请求成功",'data' => $list]);exit;
        }else{
            return json(['code' => 0,'msg' => "请求错误"]);exit;
        }
             

    }

    public function add() {

        return $this->buildSuccess([
            '新增' =>"这是一个新增"
        ]);
    }

    public function upd() {

        return $this->buildSuccess([
            '修改' =>"这是一个修改"
        ]);
    }
}