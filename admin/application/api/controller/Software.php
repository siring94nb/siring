<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/10/28
 * Time: 10:33
 */
namespace app\api\controller;
use app\data\model\Category;
use app\data\model\Good;
use think\Request;
use think\Db;
use think\Session;

class Software extends Base
{
    /**
     * 软件定制分类
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function soft_type()
    {
        $data = (new Category()) ->select()->toArray();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 软件定制商品列表
     * @throws \think\exception\DbException
     */
    public function soft_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new Good();

        $uid = Session::get("uid");

        if($uid){

            $uid = Session::get("uid");
            $data = $good->user_good_list($param,$uid);

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }
            $data = $good->good_list($param);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 商品详情
     * @param $goods_id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function soft_detail($goods_id)
    {
        $good = new Good();
        $data = $good->good_detail($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 商品评论
     * @param $goods_id
     */
    public function soft_reviews($goods_id)
    {
        $good = new Good();
        $data = $good->good_review($goods_id);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 推荐商品
     * @return $data
     */
    public function soft_push()
    {
        $data = db('good')->orderRaw('rand()')->where(['del_time'=>null])
            ->field('id,goods_name,goods_images,period')->limit(6)->select();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

}
