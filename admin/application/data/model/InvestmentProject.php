<?php

namespace app\data\model;

use think\Model;

/**
 * @author fyk
 * Class InvestmentProject
 * @package app\data\model
 */
class InvestmentProject extends Model
{
    protected $table = "investment_project";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    /**
     * 新增
     * @param $param
     * @return InvestmentProject|bool
     */
    public function investment_add($param)
    {
        //pp($param);die;
        $data = new InvestmentProject;
        $data->save([
            'title' => $param['title'],
            'uid' => $param['uid'],
            'cid' => $param['cid'],
            'no' => $this->get_sn(),
            'reward' => $param['reward'],
            'location' =>$param['location'],
            'bright' => $param['bright'],
            'revenue' => $param['revenue'],
            'user_data' => $param['user_data'],
            'valuation' => $param['valuation'],
            'background' =>$param['background'],
            'advantage' => $param['advantage'],
            'bp_url' => $param['bp_url'],

        ]);

        return $data  ? $data : false;
    }


    /**
     * @return string
     */
    function get_sn() {
        return 'TR'.date('YmdHi').rand(100000, 999999);
    }

    /**
     * 无用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function investment_list($param)
    {

        $where = array();
        if(!empty($param['type'])){
            $type = ($param['type']);
            switch($type) {
                case 1://全部排序

                    $order = 'id desc';

                    break;
                case 2://按打赏数量最高

                    $order = 'rew_num desc';

                    break;
                case 3://按打赏数量最低

                    $order = 'rew_num asc';

                    break;

            }
        }
        if(!empty($param['cid'])){
            $where['cid'] = $param['cid'];
        }

        if(!empty($param['title'])){
            $where['title'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = 'id,title,cid,bright';

        $list = InvestmentProject::with('InvestmentClass') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['industry_field'] = $val['investment_class']['title'];
            unset($list['data'][$key]['investment_class']);
        }

        return $list;
    }

    /**
     * 用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function user_investment_list($param,$uid)
    {

        $where = array();
        if(!empty($param['type'])){
            $type = ($param['type']);
            switch($type) {
                case 1://全部排序

                    $order = 'id desc';

                    break;
                case 2://按打赏数量最高

                    $order = 'rew_num desc';

                    break;
                case 3://按打赏数量最低

                    $order = 'rew_num asc';

                    break;

            }
        }
        if(!empty($param['cid'])){
            $where['cid'] = $param['cid'];
        }

        if(!empty($param['title'])){
            $where['title'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 12;
        }
        $field = 'id,title,cid,bright';

        $list = InvestmentProject::with('InvestmentClass') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['industry_field'] = $val['investment_class']['title'];
            //用户是否关注
            $type =2;
            $list['data'][$key]['follow'] = Collection::user_pro($type,$val['id'], $uid);
            unset($list['data'][$key]['investment_class']);
        }
        //pp($list);die;

        return $list;
    }


    /**
     * 项目详情
     * @param $param
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function details($param)
    {
        $data = InvestmentProject::with('InvestmentClass') ->where('id',$param['id'])
            -> field('id,title,cid,reward,location,bright,revenue,user_data,valuation,background,advantage,bp_url')
            -> find()->toArray();

        $data['industry_field'] = $data['investment_class']['title'];
        unset($data['investment_class']);

        return $data;
    }


    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function InvestmentClass()
    {
        return $this->belongsTo('InvestmentClass', 'cid', 'id');
    }

    /**
     * 用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function investment_project_list($param,$uid)
    {

        $where = array();
        $where['uid'] = $uid;
        if(!empty($param['process'])){
            $where['process'] = $param['process'];

        }
        if(!empty($param['title'])){
            $where['title|no'] = ['like','%'.$param['title'].'%'];
        }

        if(!empty($param['type'])){
            $where['type'] = $param['type'];
        }

        if(!empty($param['start_time'])){
            $where['created_at'] = ['gt',$param['start_time']];
        }

        if(!empty($param['end_time'])){
            $where['created_at'] = ['lt',$param['end_time']];
        }

        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 6;
        }

        $field = 'id,no,title,cid,bright,reward,created_at';
        $order = 'id desc';

        $list = InvestmentProject::with('InvestmentClass') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['industry_field'] = $val['investment_class']['title'];

            unset($list['data'][$key]['investment_class']);
        }

        return $list;
    }

}
