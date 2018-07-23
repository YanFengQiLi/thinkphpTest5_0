<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User as UserModel;

class User extends Controller{

    public function index(){
        /*$user  = UserModel::get(1);
        dump($user->toArray());*/
        //$user = UserModel::select();

        $user = new UserModel();
        /*$user->email = '41111156@qq.com';
        $res = $user->save();*/

        /*$res = $user->save([
            'password' => md5('123')
        ],['id' => 25]);*/

        /*$res = $user->where([
            'id' => 25
        ])->update([
            'username' => 'myname'
        ]);*/

        $res = $user->all();
        dump($res);
    }


    /**
     * @author zhenHong
     * 一、插入单条数据三种方法：最终调用save方法，该放法返回插入的记录数
     *  1、通过实例化模型，利用对象调用属性进行赋值
     *  2、通过data()方法进行数据的批量赋值
     *  3、在实例化时，传入数据
     *
     *  二、批量插入数据：saveAll()    该方法返回带有模型包含新增模型（带自增ID）的数据集（数组）
     *  saveAll() ：
     *      1、可以自动判断时更新还是插入操作，若带主键则进行更新操作，否则则进行插入
     *      2、若想实现带主键的批量新增：
     *          $user->saveAll($list, false);
     *
     *  三、使用静态方法create，返回当前模型对象的实例
     *      User::create($data);
     */
    public function addUser(){
        //方法1
        /*$user = new UserModel();
        $user->username = '张三';
        $user->password = md5('123456');
        $user->email = '123@qq.com';
        $user->create_time = time();
        $user->update_time = time();
        $res = $user->save();*/

        //方法2：
        /*$user  = new UserModel();
        $user->data([
            'username' => '李四',
            'password' => md5('123456'),
            'email' => '123@qq.com',
            'create_time' => time(),
            'update_time' => time()
        ]);
        $res = $user->save();*/

        //方法3：
        /*$user = new UserModel([
            'username' => '李3',
            'password' => md5('123456'),
            'email' => '123@qq.com',
            'create_time' => time(),
            'update_time' => time()
        ]);
        $res = $user->save();*/

        //静态调用
        /*$res = UserModel::create([
            'username' => '哈哈',
            'password' => md5('123456'),
            'email' => '123@qq.com',
            'mobile' => 13620154879,
            'create_time' => time(),
            'update_time' => time()
        ]);*/

    }

    /**
     * @author zhenHong
     * @date testShow
     * 一、更新单挑数据的三种方法：
     *      1、查找并更新 :在取出数据后，更改字段内容后更新数据     返回影响记录条数，若当前数据无变动则返回0
     *      2、直接更新：在save方法的第二个参数传入主键    返回影响记录条数，若当前数据无变动则返回0
     *      3、通过数据库操作类井进行更新 ：update()   返回当前模型对象实例
     *          (1)、若不传主键则要写where条件
     *          (2)、若存在主键则不需要，where条件
     *      4、使用静态方法更新      返回影响记录条数，若当前数据无变动则返回0
     *
     * 二、批量更新：批量更新仅能根据主键值进行更新，其它情况请使用foreach遍历更新
     *      saveAll()方法 传入主键数据
     */
    public function updateUser(){
        //法1：get()方法返回当前模型的实例对象
        /*$user = UserModel::get(1);
        $user->email = '123@qq.com';
        $res = $user->save();*/

        //法2：
        /*$user = new UserModel();
        $res = $user->save([
            'username' => '大天'
        ],['id'=>1]);*/


        //法3：
        /*$user = new UserModel();
        $res = $user->where('id','=','1')
            ->update([
                'mobile' => 13620457899
            ]);*/


        /*$user = new UserModel();
        $res = $user->update([
            'id' => 1,
            'username' => '李军啊'
        ]);*/


        /*$res = UserModel::where('id','=','2')
                ->update([
                    'username' => '张三啊11'
                ]);*/
        //dump($res);
    }


    /**
     * @author zhenHong
     * @date testShow
     * 删除数据的四种方法：返回影响行数
     *      1、通过实例化后模型后删除
     *      2、调用静态方法destroy()方法删除
     *      3、闭包删除
     *      4、数据库操作类删除
     *
     */
    public function userDelete(){
        /*$user = UserModel::get(23);
        $res = $user->delete();*/


        //$res = UserModel::destroy(22);

        /*$res = UserModel::destroy(function ($query){
            $query->where('id','=','21');
        });*/

        /*$res = UserModel::where('id','=','20')
            ->delete();*/
        //dump($res);
    }
}