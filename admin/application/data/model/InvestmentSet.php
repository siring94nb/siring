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
}
