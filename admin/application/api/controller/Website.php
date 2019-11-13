<?php

namespace app\api\controller;

use app\data\model\About;
use app\data\model\Contact;
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
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
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
