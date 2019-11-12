<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;
class Good extends Model
{
    use SoftDelete;
    protected $deleteTime = 'del_time';
    protected $table = "good";
    protected $resultSetType = 'collection';
    protected $createTime    = 'create_time';
    protected $updateTime    = 'update_time';

    /**
     * 无用户id商品列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function good_list($param)
    {

        $where = array();
        if(!empty($param['type'])){
            $type = ($param['type']);
            switch($type) {
                case 1://全部排序

                    $order = 'id desc';

                    break;
                case 2://按价格最高

                    $order = 'original_price desc';

                    break; //按价格最低
                case 3:

                    $order = 'original_price asc';

                    break;
                case 4://按销量最高

                    $order = 'sales_volume desc';

                    break;
                case 5://按销量最低

                    $order = 'sales_volume asc';

                    break;
            }
        }
        if(!empty($param['category_id'])){
            $where['category_id'] = $param['category_id'];
        }

        if(!empty($param['title'])){
            $where['goods_name'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 16;
        }
        $field = 'id,goods_name,original_price,category_id,goods_images,sales_volume,period,sign';

        $list = Good::with('category') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();
       //pp($list);die;
        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['category_title'] = $val['category']['category_name'];
            //取一张图
            $att=explode(',',$val["goods_images"]);
            $list['data'][$key]['img'] = $att[0];
            unset( $list['data'][$key]['goods_images']);
            unset($list['data'][$key]['category']);
        }

        return $list;
    }

    /**
     * 无用户id商品列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function user_good_list($param,$uid)
    {

        $res = new Collection();
        $where = array();
        if(!empty($param['type'])){
            $type = ($param['type']);
            switch($type) {
                case 1://全部排序

                    $order = 'id desc';

                    break;
                case 2://按价格最高

                    $order = 'original_price desc';

                    break; //按价格最低
                case 3:

                    $order = 'original_price asc';

                    break;
                case 4://按销量最高

                    $order = 'sales_volume desc';

                    break;
                case 5://按销量最低

                    $order = 'sales_volume asc';

                    break;
            }
        }
        if(!empty($param['category_id'])){
            $where['category_id'] = $param['category_id'];
        }

        if(!empty($param['title'])){
            $where['goods_name'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 16;
        }
        $field = 'id,goods_name,original_price,category_id,goods_images,sales_volume,period,sign';

        $list = Good::with('category') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();
        //pp($list);die;
        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['category_title'] = $val['category']['category_name'];
            $list['data'][$key]['follow'] = $res->user_pro($val['id'], $uid);
            //取一张图
            $att=explode(',',$val["goods_images"]);
            $list['data'][$key]['img'] = $att[0];
            unset( $list['data'][$key]['goods_images']);
            unset($list['data'][$key]['category']);
        }

        return $list;
    }

    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id');
    }

    /**
     * 商品详情
     * @param $goods_id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function good_detail($goods_id)
    {
        $field = 'id,goods_name,goods_number,category_id,goods_images,period,goods_des';

        $res = Good::with('category')->where('id',$goods_id)->field($field)->find();
        $res['category_title'] = $res['category']['category_name'];
        $res['reviews_num'] =  Reviews::num($res['id']);//商品评论总数量
        $res['special'] = Special::spec_pro($res['id']);//规格
        //取一张图
        $att=explode(',',$res["goods_images"]);
        $res['img'] = $att[0];
        unset( $res['goods_images']);
        unset($res['category']);

        return $res;
    }

    /**
     * 商品评论（查询）
     * @param $goods_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function good_review($goods_id)
    {
        $res = Reviews::where(['goods_id'=>$goods_id,'cid'=>0,'delect_at'=>null])->select()->toArray();
        foreach ($res as $k=>$v){
            //个人信息
            $user = new User();
            $user_all = $user->user_detail($v['user_id']);
            $res[$k]['phone'] = $user_all['phone'];
            $res[$k]['img'] = $user_all['img'];
            //pp($res);die;
            //会员等级信息
            $join_role = JoinRole::member_details($user_all['grade']);
            $res[$k]['ico'] = $join_role['img'];
            $res[$k]['grade_name'] = $join_role['title'];
            //二级评论
            $res[$k]['grade'] = $user_all['grade'];
            $res[$k]['relpay'] = Reviews::two_level($v['id']);
        }
        return $res;

    }
//    public function good_review($goods_id){
//        $Member=new Reviews();
//        $data=$Member->with(['user'])->where(['goods_id'=>$goods_id,'cid'=>0,'delect_at'=>null])->select();
//        return $data;
//
//    }
//
//    public function user(){
//        //hasOne()方法中第一个为关联的模型名称，第二个为关联的外键，
//        //所以这里分别是Profile模型和profile_id外键
//        return $this->hasOne('User','id','user_id');
//    }
//
//
//    /**
//     * @return \think\model\relation\HasMany
//     * 这里是关联的一对多的情况，方法名同样为表明，记住了
//     */
//
//    public function reviews(){
//
//        return $this->hasOne('Reviews','id','cid');
//
//    }

    /**
     * 商品评论（删除）
     * @param $id   评论ID
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function good_review_del($id)
    {
        $res = Reviews::where('id',$id)->update(['delect_at'=>time()]);
        $re = Reviews::where('cid',$id)->update(['delect_at'=>time()]);
        return true;
    }







}
