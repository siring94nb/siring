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
    protected $table = "order";
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
            'type' => 6,
            'name' => $param['title'],
            'user_id' => $param['uid'],
            'sid' => $param['cid'],
            'no' => $this->get_sn(),
            'surplus' => $param['reward'],
            'con' =>$param['location'],
            'resume' => $param['bright'],
            'other' => $param['revenue'],
            'proposal' => $param['user_data'],
            'examine_opinion' => $param['valuation'],
            'user_clause' =>$param['background'],
            'advantage' => $param['advantage'],
            'url' => $param['bp_url'],

        ]);

        return $data  ? $data : false;
    }


    /**
     * @return string
     */
    function get_sn() {
        return 'TR'.date('YmdHis').rand(100000, 999999);
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
        if(!empty($param['sid'])){
            $where['sid'] = $param['sid'];
        }

        if(!empty($param['title'])){
            $where['name'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = 'id,name,sid,resume';

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
        if(!empty($param['sid'])){
            $where['sid'] = $param['sid'];
        }

        if(!empty($param['title'])){
            $where['name'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 12;
        }
        $field = 'id,name,sid,resume';

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
    public function details($id)
    {

        $data = InvestmentProject::with('InvestmentClass') ->where('id',$id)
            -> field('id,name,sid,surplus,con,resume,other,proposal,examine_opinion,user_clause,advantage,url')
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
        return $this->belongsTo('InvestmentClass', 'sid', 'id');
    }

    /**
     * 用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function investment_project_list($param,$uid)
    {

        $where['type'] = 6;
        $where['user_id'] = $uid;
        if(!empty($param['process'])){
            $where['need_status'] = $param['process'];

        }
        if(!empty($param['title'])){
            $where['name|no'] = ['like','%'.$param['title'].'%'];
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

        $field = 'id,model_type,name,user_id,sid,resume,surplus,created_at,need_status';
        $order = 'id desc';

        $list = InvestmentProject::with('InvestmentClass') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['industry_field'] = $val['investment_class']['title'];

            unset($list['data'][$key]['investment_class']);
        }

        return $list;
    }

    /**
     * 修改
     * @param $param
     * @return false|int
     */
    public function upd($param)
    {
        //必填字段验证
        $validate = new Validate([
            ['id', 'require', '订单id不能为空'],
            ['name', 'require', '标题不能为空'],
            ['resume', 'require', '推广对象不能为空'],
            ['grade', 'require', '高手等级不能不好空'],
            ['url', 'require', '参考不能不好空'],
            ['need_status', 'require', '内容类型必须'],
            ['num', 'require', '字数必须'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());exit();
        }

        return $this->allowField(true)->save($param,['id'=>$param['id']]);

    }

    /**
     * 1：为需求确认，2：为代写中, 3:为确认稿件，4：为智推中，5为：智推完成
     * @param $id
     * @param $process
     * @return false|int
     */
    public function status($id,$process)
    {
        return self::save(['need_status'=>$process],['id'=>$id]);
    }

}
