<?php
namespace  app\api\controller;


use app\data\model\Category;
use app\data\model\Good;
use app\data\model\NeedOorder as Need;
use app\data\model\Special;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;


class  NeedOrder  extends  Base{
    /**
     * 需求定制订单
     * @author 李禄
     * @return \think\Response
     */
    public function need_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
                ['need_name', 'require', '需求名称不能为空'],
                ['need_category','require','分类不能为空'],
                ['need_budget_down','require','低价预算不能不好空'],
                ['need_budget_up','require','高价预算不能不好空'],
                ['need_phone','require','手机必须'],
                ['need_desc','require','需求描述必须'],
                // ['need_file','require','附件必须'],
        ]);
                if(!$validate->check($param)){
                    returnJson (0,$validate->getError());exit();
                }
                $user_id = Session::get("uid");
                halt($user_id);
                if($user_id){
                    $user_id = Session::get("uid");
                }else{
                    $user_id = $param["user_id"];
                }
                //开启事务
                Db::startTrans();
                try{
                    $data=Need::create($param)->toArray();
                    $order_id = $data['id'];
                    Db::commit();
                    return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);

                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return false;
                }

    }


}
