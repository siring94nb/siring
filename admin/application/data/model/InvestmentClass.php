<?php

namespace app\data\model;

use think\Model;

/**
 * @author fyk
 * Class InvestmentClass
 * @package app\data\model
 */
class InvestmentClass extends Model
{
    protected $table = "investment_class";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
}
