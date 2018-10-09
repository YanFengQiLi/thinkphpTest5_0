<?php
namespace app\index\model;

use think\Model;

class UserRole extends Model{
    protected $table = 'user_role';

    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';

    protected $updateTime = 'update_time';
}