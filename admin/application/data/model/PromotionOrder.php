<?php

namespace app\data\model;

use think\Model;
use think\Validate;

class PromotionOrder extends Model
{
    protected $table = "order";
    protected $resultSetType = 'collection';


    public function order_add($role_type,$uid,$title,$object,$num,$yid,$tid,$ask,$money,$grade,$con,$resume,$url)
    {

        $data = new PromotionOrder;
        $data->save([
            'type'=> 5,
            'role_type' => $role_type,
            'user_id' => $uid,
            'name' => $title,
            'resume' => $object,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'model_id' => $tid,
            'need_status'=>$ask,
            'yid' => $yid,
            'grade' => $grade,
            'con' => $con,
            'resume' => $resume,
            'url'=>$url,
            'status' =>1,
            'order_status'=>1,
            'created_at'=>time(),

        ]);

        return $data !== false ? $data : false;
    }

    /**
     * 生成单号
     * @return string
     */
    function get_sn() {
        return 'TG'.date('YmdHis').rand(100000, 999999);
    }

    /**
     * 用户id列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function promotion_list($param,$uid)
    {
        $where['type'] = 5;
        $where['user_id'] = $uid;
        if(!empty($param['process'])){
            $where['order_status'] = $param['process'];

        }
        if(!empty($param['title'])){
            $where['title|no'] = ['like','%'.$param['title'].'%'];
        }

        if(!empty($param['role_type'])){
            $where['role_type'] = $param['role_type'];
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

        $field = 'id,no,name,role_type,model_id,money,order_status,created_at';
        $order = 'id desc';

        $list = PromotionOrder::with('Extension') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $key => $val){
            $list['data'][$key]['package_fee'] = $val['extension']['name'].'￥'.$val['extension']['money'];

            unset($list['data'][$key]['extension']);
        }

        return $list;
    }

    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function Extension()
    {
        return $this->belongsTo('Extension', 'model_id', 'id');
    }

    /**
     * @param $id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function details($id)
    {
        return self::where('id',$id)->field('id,name,resume,url,grade,num,need_status')->find()->toArray();
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
        return self::save(['order_status'=>$process],['id'=>$id]);
    }

}
