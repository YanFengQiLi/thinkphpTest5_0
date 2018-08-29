<?php

namespace app\index\model;

use think\Model;

class UserComment extends Model
{
    protected $table = 'think_user_comments';


    public function user(){
        return $this->belongsTo('user');
    }
}