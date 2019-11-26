<?php

namespace app\data\model;

use think\Model;

/**
 * @author fyk
 * Class InvestmentSet
 * @package app\data\model
 */
class InvestmentSet extends Model
{
    protected $table = "investment_set";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    /**
     * 分类费用
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function industry_index()
    {
        $field = 'id,cost,reward,cid';

        $list = InvestmentSet::with('InvestmentClass') -> field( $field ) ->select()->toArray();

            foreach($list as $key=>$value){
                $list[$key]['title'] = $value['investment_class']['title'];
                unset($list[$key]['investment_class']);
            }

        return $list;
    }


    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function InvestmentClass()
    {
        return $this->belongsTo('InvestmentClass', 'cid', 'id');
    }

}
