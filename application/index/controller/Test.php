<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use think\Db;
class Test extends Controller{

    //展示获取器
    public function index(){
        $user = new User();
        $data = $user->select();
        $arr = [];
        foreach ($data as $key => $user){
            $arr[$key]['createTime'] = $user->create_time;
            $arr[$key]['updateTime'] = $user->create_time;
        }
        dump($arr);
    }

    //展示修改器 与  新增时间和修改时间的自动写入   save插入
    public function index1(){
        $user = new User();
        $user->username = '哈哈';
        $user->password = '123456';
        $user->email = '123456';
        $user->mobile = '1234567';
        $res = $user->save();
        dump($res);
    }

    // save 展示数据更新操作
    public function index2(){
        $user = new User();
        $arr = [
            'username' => '程序员',
            'email' => '456@qq.com'
        ];
        $res = $user->save($arr,['id' => 1]);
        dump($res);
    }

    //链表查询  不是数据表字段也可以使用获取器
    public function index3(){
        //方法1
        /*$data = Db::table('think_user')
            ->alias('U')
            ->field('U.*,M.message')
            ->join('think_user_message M','M.user_id = U.id')
            ->select();*/

        //方法2
        /*$data = Db::name('User')
                ->field('U.*,M.message')
                ->alias('U')
                ->join('__USER_MESSAGE__ M','M.user_id = U.id')
                ->select();*/

        //方法3
        $join = [
            ['__USER_MESSAGE__ M','M.user_id = U.id']
        ];
        $user = new User();
        $data = $user
            ->alias('U')
            ->field('U.*,M.message,M.status')
            ->join($join)
            ->select();
        $arr = [];
        foreach ($data as $key => $user){
            $arr[$key][] = $user->id;
            $arr[$key][] = $user->status;
        }
        dump($arr);
    }

    //查询单条记录    查询某个字段  更新某个字段
    public function index4(){
        //查询单条记录
        /*$user = User::get(1);
        dump($user['username']);*/

        //查询某个字段
        $user = User::where('id',1)
            ->value('username');

        //更新某个字段
        $user = User::where('id',1)
            ->setField('username','李梅');
        dump($user);
    }




}

