<?php
namespace app\index\controller;

use app\index\model\Users;
use think\Controller;
use think\Db;

class Test1 extends Controller{
    public function index(){
        $user = new Users();
        $arr = [
            'username' => '哈哈11',
            'password' => md5('123'),
            'email' => '123@qq.com',
            'mobile' => 466,
        ];
        $res = $user->save($arr);
        dump($res);
    }

    //获取器
    public function index2(){
        $user = new Users();
        $info = $user->find(1);
        return json($info);
    }

    //修改器
    public function index3(){
        $user = new Users();
        $arr = [
            'username' => '哈哈11',
            'email' => '123@qq.com',
            'password' => '123456',
            'mobile' => 466,
        ];
        $res = $user->save($arr);
        dump($res);
    }

    //1532425343
    public function index4(){
        /*$res = Db::name('User')
            ->where('id',30)
            ->update([
                'username' => '222'
            ]);*/

        $user = new Users();
        $res = $user->save(['username'=>'666'],['id' => 30]);
        dump($res);
    }

    public function index5(){
        $info  = Db::name('user')
            ->alias('a')
            ->field('a.username,w.message,a.id')
            ->join('__USER_MESSAGE__ w','a.id = w.user_id')
            ->select();
        dump($info);
    }

    public function index6(){
        //$user = Users::get(1);

        //$user = Db::name('User')->find(1);

        //$user = Db::name('User')->where('id',1)->value('username');

        $user = Db::name('User') ->where('id',1)
            ->setField('username','张三');

        dump($user);
    }
}
