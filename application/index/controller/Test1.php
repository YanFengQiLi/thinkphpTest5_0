<?php

namespace app\index\controller;

use app\index\model\UserComment;
use app\index\model\Users as User;
use think\Controller;
use think\Db;

class Test1 extends Controller
{

    //  软删除 与 真实删除
    public function testSoftDelete()
    {
        // 软删除
        $res = User::destroy(10);

        // 真实删除
        //$res = User::destroy(7,true);



        $user = User::get(9);
        // 软删除
        //$user->delete();

        // 真实删除
        //$user->delete(true);
    }

    //  软删除 数据查询
    public function testSelectSoftDelete()
    {
        //  带有软删除 数据的查询
        $res = User::withTrashed()->find(1);

        $res = User::withTrashed()->select();

        //  只查询 软删除的数据
        //$res = User::onlyTrashed()->find();

        $res = User::onlyTrashed()->select();

        return json($res);
    }

    //  hasOne查询一条数据
    public function testUserInfoOne()
    {
        $data = User::get(function ($query) {
            $query->where('id', 2);
        }, ['userInfo']);
        return json($data);
    }

    /**
     *  hasOne 查询多条记录的四种写法
     *  根据条件查寻当前模型
     */
    public function testUserInfoMoreWith()
    {

        $data = User::with('userInfo')->select([2, 3]);


        $data = User::with('userInfo')->select(function ($query) {
            $query->where('id', 'in', [2, 3]);
        });

        $data = User::with('userInfo,userMessage')->select([2, 3]);

        $data = User::with(['userInfo' => function ($query) {
            $query->where('id', 'in', [2, 3]);
        }])->select();

        return json($data);

    }

    //  关联模型 与 bind()
    public function testUserInfoBind()
    {
        $data = User::get(2, 'userInfo2');

        return json($data);
    }

    //  一对多关联
    public function testUserComments()
    {
        //  用户id = 2 的评论
        $user = User::get(2);
        //$info = $user->userComments()->select();

        $info = $user->userComments()->whereTime('create_time','>','2018-07-16')->select();
        return json($info);
    }

    //  关联模型 与 has() 看sql
    public function testUserCommentsHas()
    {
        $list = User::has('userComments', '>', 3)->select();
        //echo User::getLastSql();die;
        return json($list);
    }

    //  关联模型 与 hasWhere() 看sql
    public function testUserCommentsHasWhere()
    {
        $info = User::hasWhere('userInfo', ['user_content' => '嘿嘿'],['id','username'])->find();
        echo User::getLastSql();die;
        /*$info = User::hasWhere('userComments',function($query){
            $query->where('UserComment.id','gt','3');
        },['username','email','id'])->select();*/

        return json($info);
    }

    /** ******************************* 第三次 *************************************** */

    //  关联新增    情况1：主表 与 关联表同时插入
    public function testUserInfoInsert1(){
        $userData = [
            'username' => '李梅',
            'password' => '123',
            'mobile' => '123',
            'email' => '123@qq.com'
        ];
        $user = new User();
        $res1 = $user->save($userData);
        $res2 = $user->userInfo()->save([
            'user_content' => '啦啦'
        ]);
        if($res1 && $res2){
            return json('新增成功');
        }else{
            return json('新增失败');
        }
    }

    //  关联新增    情况2：已知主表，插入关联表
    public function testUserInfoInsert2(){
        $user = User::get(3);
        $res = $user->userInfo()->save([
            'user_content' => '我是第3条数据'
        ]);
        if(!empty($res)){
            return json('新增成功');
        }
    }

    //  关联修改
    public function testUserInfoSave(){
        //  写法1、
        /*$user = User::get(1);
        $user->userInfo->user_content = '我修改了';
        $num = $user->userInfo->save();*/



        //  写法2、
        $user = User::get(1);
        $num = $user->userInfo->save([
            'user_content' => '修改111'
        ]);


        if(!empty($num)){
            return json('修改成功');
        }
    }

    //  关联删除    注意:5.0.5版本
    public function testUserInfoDel(){
        $user = User::get(6);
        $num = $user->together('userInfo')->delete();
        if(!empty($num)){
            return json('删除成功');
        }
    }


}
