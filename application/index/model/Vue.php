<?php
namespace app\index\model;
use think\Model;

class Vue extends Model{
	protected $table = 'think_vue';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y-m-d H:i:s';
}