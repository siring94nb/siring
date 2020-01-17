<?php

namespace app\api\controller;

use app\data\model\About;
use app\data\model\Contact;
use app\data\model\Course;
use app\data\model\Seo;
use think\Request;

/**
 * Class Website
 * @package app\api\controller
 * @time 2019/10/17
 */
class Website extends Base
{
    /**
     * 关于我们/网站协议
     * @author fyk
     * @return \think\Response
     */
    public function website_list()
    {
        $request = Request::instance();
        $param = $request->param();

        $type = $param['type'] ;
        if(!$type)returnJson(0,'类型有误');

        $about = new About();
        $res =  $about->about_index($type);
        $data['con'] = $res;

        return $res ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 联系我们
     * @author fyk
     * @return \think\Response
     */
    public function contact()
    {
        $data = (new Contact())->find();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * SEO优化
     * @author fyk
     * @return \think\Response
     */
    public function seo()
    {
        $data = (new Seo())->find();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 定制案例
     * @param $id
     */
    public function custom_case()
    {
        $data = db('good')->orderRaw('rand()')
            ->where(['del_time'=>null])
            ->field('id,goods_name,goods_images')
            ->limit(6)->select();

        foreach ($data as $k=>$v){
            //图片
            $att=explode(',',$v["goods_images"]);
            $data[$k]['img'] = $att[0];
            unset($data[$k]['goods_images']);
        }
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 核心成员
     * @throws \think\exception\DbException
     */
    public function member()
    {
        $data = (new \app\data\model\Member())->all();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 荣誉证书
     * @throws \think\exception\DbException
     */
    public function honor()
    {
        $banner = new \app\data\model\Banner();
        $type = 2;
        $data = $banner->banner_list($type);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 发展历程
     * @throws \think\exception\DbException
     */
    public function course()
    {
        $data = ( new Course())->all();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

}
