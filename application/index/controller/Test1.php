<?php
namespace app\index\controller;

use app\index\model\UserComment;
use app\index\model\Users as User;
use think\Controller;
use think\Db;

class Test1 extends Controller{

    //  软删除 与 真实删除
    public function testSoftDelete(){
        // 软删除
        $res = User::destroy(1);
        dump($res);
        // 真实删除
        /*User::destroy(1,true);



        $user = User::get(1);
        // 软删除
        $user->delete();
        // 真实删除
        $user->delete(true);*/
    }

    //  软删除 数据查询
    public function testSelectSoftDelete(){
        header('Content-type:text/html;charset=UTF-8');
        //  带有软删除 数据的查询
        //$res = User::withTrashed()->find(1);

        //User::withTrashed()->select();

        //  只查询 软删除的数据
        //$res = User::onlyTrashed()->find();

        $res = User::onlyTrashed()->select();
        dump($res);die;
    }

    //  hasOne查询一条数据
    public function testUserInfoOne(){
        $data = User::get(function ($query) {
            $query->where('id', 2);
        }, ['userInfo']);
        return json($data);
    }

    /**
     *  hasOne 查询多条记录的三种写法
     *  查询当前模型
     */
    public function testUserInfoMoreWith(){

        $data = User::with('userInfo')->select([2, 3]);

        $data = User::with('userInfo')->select(function ($query) {
            $query->where('id', 'in', [2, 3]);
        });

        $data = User::with(['userInfo' => function ($query) {
            $query->where('user_content', '嘿嘿');
        }])->where('username','test3')->select();

        return json($data);

    }

    //  关联模型 与 bind()
    public function testUserInfoBind(){
        $data = User::get(2, 'userInfo2');

        return json($data);
    }

    //  一对多关联
    public function testUserComments(){
        //  用户id = 2 的评论
        $user = User::get(2);
        $info = $user->userComments()->select();

        //$info = $user->userComments()->whereTime('create_time','>','2018-07-16')->select();
        return json($info);
    }

    //  关联模型 与 has()
    public function testUserCommentsHas(){
        $list = User::has('userComments','>=',3)->select();
       return json($list);
    }

    //  关联模型 与 hasWhere()
    public function testUserCommentsHasWhere(){
        $info = User::hasWhere('userInfo',['user_content' => '嘿嘿'])->find();

        /*$info = User::hasWhere('userComments',function($query){
            $query->where('UserComment.id','gt','3');
        },['username','email','id'])->select();*/

        return json($info);
    }






}
