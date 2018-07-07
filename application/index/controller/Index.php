<?php
namespace app\index\controller;

use think\Controller;
use think\Loader;
use think\Request;
use think\Validate;

class Index extends Controller
{
    //注册页面
    public function index()
    {
        return $this->fetch('index');
    }

    /**
     * @param Request $request
     *  使用validate验证方法总结：
     *      1、独立的使用Validate类验证:
     *         需要use think\Validate;
     *         实例化该类，设置需要验证的字段规则，调用message方法传入对应字段的提示信息,验证规则推荐传入数组
     *      2、使用验证器验证：
     *         需要在对应的模块下创建validate文件夹,并在该文件夹下创建对应的类文件，此类必须继承think\validate类
     *         实例化验证器
     *         (1)、可以使用Loader::validate('验证器名称')
     *         (2)、
     */
    public function registerUser(Request $request){
        header('Content-type:text/html;charset=UTF-8');
        //1、使用Validate类验证--独立验证
        /*$validate = new Validate([
            'username' => ['require','regex'=>'/^[a-zA-Z0-9]{6,10}$/'],
            'email' => ['require','email'],
            'mobile' => ['regex' => '0?(13|14|15|17|18|19)[0-9]{9}'],
            'password' => ['require','regex'=>'/^[a-zA-Z0-9]{6,10}$/']
        ]);
        $validate->message([
            'username' => '用户名由字母和数字组成,长度在5~15位',
            'email' => '邮箱不合法',
            'mobile' => '手机号不合法',
            'password' => '密码由字母和数字组成,长度在6~20位'
        ]);*/



        /*
         *  2、使用验证器验证
         *      --2、1使用loader类实例化验证器
         *      --2、2使用助手函数实例化验证器
         * */
        $validate = Loader::validate('User');
        //$validate = validate('User');
        $data = $request->post();
        if(!$validate->check($data)){
            dump($validate->getError());
        }
    }

    /**
     * @param Request $request
     * 单独实例化验证类：
     *      1、支持动态验证规则的添加
     *      2、字段的批量赋值
     */
    public function registerUserTest(){
        header('Content-type:text/html;charset=UTF-8');
        //测试数据
        $data = [
            'name' => 'la',
            'age'  => '12',
            'email' => '123@qq.com'
        ];
        $rule = [
            'name' => ['require','min' => 3],
        ];
        //批量设置字段信息  如果不穿
        $field = [
            'name' => '姓名',
            'age'  => '年龄',
            'email'=> '邮箱'
        ];
        /*$msg = [
            'name' => '用户名由字母和数字组成,长度在5~15位',
        ];*/
        $validate = new Validate($rule,[],$field);

        //动态添加验证规则
        $validate->rule('age',['max'=>3]);

        if(!$validate->check($data)){
            dump($validate->getError());
        }
    }
}
