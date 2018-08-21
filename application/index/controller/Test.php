<?php
namespace app\index\controller;

use app\index\model\UserMessage;
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

    //$resultSetType 属性应用
    public function index5(){
        $info = User::alias('U')
            ->field('U.*,M.message')
            ->join('__USER_MESSAGE__ M','M.u_id = U.id','left')
            ->select();
        $info = $info->toArray();
        dump($info);
    }


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function indexRelationSelect(){
        /**
            使用hasOne 关联模型 查询1条数据
         */
        $data1 = User::get(function($query){
            $query->where('id',1);
        },['userInfo']);


        /**
         *  使用 hasOne关联模型 查询多条数据，使用 with() 方法
         *  1、当 with 传递的是 string 类型，即 关联模型名称 ,只支持查询主键
         *  2、当 with 传递的是 array 类型
         *        (1)、关联多个模型 [模型1,模型2,模型3...]
         *        (2)、还可以，以 key=>value 形式传递 闭包查询  '关联模型名称' => 闭包查询
         */
        $data2 = User::with('userInfo')->select([1,2]);
        $data2 = User::with('userInfo')->select(function($query){
            $query->where('id','in',[1,2]);
        });
        $data2 = User::with(['userInfo' => function($query){
            $query->where('user_content','哈哈');
        }])->select(function($query){
            $query->where('sex',0);
        });


        /**
         *  根据关联表的查询条件 查询当前模型的数据
         *  注意：
         *      1、使用 hasWhere() 进行查询
         *      2、hasWhere 参数：
         *          参数1：关联模型名称  参数2：查询条件(数组或闭包) 参数3 当前显示的模型的字段（不传则显示全部）
         *      3、指定属性查询
         */
        $data3 = User::hasWhere('userInfo',function($query){
            $query->where('user_content','哈哈');
        },['username','email'])->find();

        $data3 = User::field('username,sex,email')
                ->with(['userInfo' => function($query){
                    $query->field('user_content')
                        ->where('user_id1',1);;
                }])->select(function($sel){
                    $sel->where('username','哈哈1');
                });
        return json($data3);
    }
    
}

