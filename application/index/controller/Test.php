<?php

namespace app\index\controller;

use app\index\model\UserComment;
use app\index\model\UserMessage;
use think\Controller;
use app\index\model\User;
use think\Db;
use app\index\model\UserInfo;

class Test extends Controller
{

    //展示获取器
    public function index()
    {
        $user = new User();
        $data = $user->select();
        $arr = [];
        foreach ($data as $key => $user) {
            $arr[$key]['createTime'] = $user->create_time;
            $arr[$key]['updateTime'] = $user->create_time;
        }
        dump($arr);
    }

    //展示修改器 与  新增时间和修改时间的自动写入   save插入
    public function index1()
    {
        $user = new User();
        $user->username = '哈哈';
        $user->password = '123456';
        $user->email = '123456';
        $user->mobile = '1234567';
        $res = $user->save();
        dump($res);
    }

    // save 展示数据更新操作
    public function index2()
    {
        $user = new User();
        $arr = ['username' => '程序员', 'email' => '456@qq.com'];
        $res = $user->save($arr, ['id' => 1]);
        dump($res);
    }

    //链表查询  不是数据表字段也可以使用获取器
    public function index3()
    {
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
        $join = [['__USER_MESSAGE__ M', 'M.user_id = U.id']];
        $user = new User();
        $data = $user->alias('U')->field('U.*,M.message,M.status')->join($join)->select();
        $arr = [];
        foreach ($data as $key => $user) {
            $arr[$key][] = $user->id;
            $arr[$key][] = $user->status;
        }
        dump($arr);
    }

    //查询单条记录    查询某个字段  更新某个字段
    public function index4()
    {
        //查询单条记录
        /*$user = User::get(1);
        dump($user['username']);*/

        //查询某个字段
        $user = User::where('id', 1)->value('username');

        //更新某个字段
        $user = User::where('id', 1)->setField('username', '李梅');
        dump($user);
    }

    //$resultSetType 属性应用
    public function index5()
    {
        $info = User::alias('U')->field('U.*,M.message')->join('__USER_MESSAGE__ M', 'M.u_id = U.id', 'left')->select();
        $info = $info->toArray();
        dump($info);
    }

/**************************************  软删除  *************************************************/

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


/**************************************  关联模型  *************************************************/


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function indexRelationSelect()
    {
        /**
         * 使用hasOne 关联模型 查询1条数据
         */
        $data1 = User::get(function ($query) {
            $query->where('id', 1);
        }, ['userInfo']);


        /**
         *  使用 hasOne关联模型 查询多条数据，使用 with() 方法
         *  1、当 with 传递的是 string 类型，即 关联模型名称 ,只支持查询主键
         *  2、当 with 传递的是 array 类型
         *        (1)、关联多个模型 [模型1,模型2,模型3...]
         *        (2)、还可以，以 key=>value 形式传递 闭包查询  '关联模型名称' => 闭包查询
         */
        $data2 = User::with('userInfo')->select([1, 2]);
        $data2 = User::with('userInfo')->select(function ($query) {
            $query->where('id', 'in', [1, 2]);
        });
        $data2 = User::with(['userInfo' => function ($query) {
            $query->where('user_content', '哈哈');
        }])->select(function ($query) {
            $query->where('sex', 0);
        });


        /**
         *  根据关联表的查询条件 查询当前模型的数据
         *  注意：
         *      1、使用 hasWhere() 进行查询
         *      2、hasWhere 参数：
         *          参数1：关联模型名称  参数2：查询条件(数组或闭包) 参数3 当前显示的模型的字段（不传则显示全部）
         *      3、指定属性查询
         */
        $data3 = User::hasWhere('userInfo', function ($query) {
            $query->where('user_content', '哈哈');
        }, ['username', 'email'])->find();

        $data3 = User::field('username,sex,email')->with(['userInfo' => function ($query) {
            $query->field('user_content')->where('user_id', 1);
        }])->select(function ($sel) {
            $sel->where('username', '哈哈1');
        });
        return json($data3);
    }


    /**
     * @throws \think\exception\DbException
     * @author zhenHong
     * 关联新增
     */
    public function indexRelationInsert()
    {
        $user = User::get(1);
        $num = $user->userInfo()->save(['user_content' => '的孙菲菲']);
        dump($num);
    }

    /**
     * @throws \think\exception\DbException
     * @author zhenHong
     * 关联更新
     */
    public function indexRelationUpdate()
    {
        $user = User::get(1);
        $num = $user->userInfo->save(['user_content' => '拉拉']);
        dump($num);
    }


    /**
     * @throws \think\exception\DbException
     * @author zhenHong
     * 相对关联
     */
    public function indexBelongsToUser()
    {
        $infoObj = UserInfo::get(2);
        //  获取全部 user 表的所有字段
        $infoObj->user;
        //  获取 user 表指定的字段
        //$infoObj->user->email;
        return json($infoObj);
    }


    /**
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * @author zhenHong
     * 使用 绑定属性到父模型
     */
    public function indexHasOneBind()
    {
        $user = User::get(function ($query) {
            $query->where('id', 1)->field('id,username');
        }, 'userInfo');
        return json($user);
    }


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author zhenhong~
     * 一对多关联 hasMany 查询
     */
    public function indexHasMany()
    {
        /**
         *  查询 当前用户下的评论 注意这里 where 条件是 user_comments的条件
         *  获取关联数据
         */
        /*$user = User::get(1);
        $info = $user->userComments()->where('id',1)->select();
        return json($info);*/

        /**
         *  根据关联模型条件查询当前模型数据
         *   1、has()
         *  参数1：关联模型名
         *  参数2：比较操作符 或 查询数组
         *  参数3：个数
         *  参数4：关联表统计字段，默认 count(*)
         *  打印 sql 我们发现 这个 has 方法实现就是 分组统计后在按条件查找：发表超过1个的用户
         *
         *  2、hasWhere()
         *  参数1：关联模型名
         *  参数2：查询条件（数组或者闭包）
         *  参数3：指定返回的当前模型表字段
         */
        /*$list = User::has('userComments','>=',1)->select(false);
        return json($list);*/


        /*$list = User::hasWhere('userComments',function($query){
            $query->where('click','egt',0);
        },['username','email','id'])->select();
        return json($list);*/


        /**
         *  定义相对关联
         *  查询当前模型的数据
         */
        /*$list = UserComment::hasWhere('user',function ($query){
            $query->where('username','哈哈1');
        })->select();
        return json($list);*/
    }

    /**
     * @throws \think\exception\DbException
     * @auhtor  zhenhong~
     * 注意：
     *      1、$user->userComments() 返回关联模型对象
     *      2、$user->userComments   返回关联模型数组对象
     */
    public function indexAddOrUpdateHasMany()
    {
        //  关联新增
        /*$user = User::find(1);
        $user->userComments()->save(['comment'=>'我更新了评论']);*/

        //  批量新增
        /*$user = User::find(1);
        $user->userComments()->saveAll([
            ['comment' => '评论1'],
            ['comment' => '评论2'],
        ]);*/

        //  关联更新
        $user = User::get(1);
        $data = [];
        foreach($user->userComments as $key => $val){
            $data[$key] = $val->toArray();
        }
    }


    /**
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * 获取 该用户的所有角色
     */
    public function findManyToMany(){
        $user = User::get(1);
        return json($user->role);
    }

    /**
     * @throws \think\exception\DbException
     * 多对多新增1条数据：
     *      1、save 中的数组是 role 的字段
     *      2、这样会将 向 role 表插入一条新数据
     *      3、并且向中间表，插入二者的关联数据
     *
     *  注意：
     *      1、多对多插入时，这个 save() 方法是 belongsToMany 类的 内置方法，并不是 Model 类的 save() 方法
     *      所以即使你创建了，中间表的模型，开启了时间戳的自动写入，也不会生效。
     *      2、但是查看源码得知： belongsToMany 类的 save() 方法，有第二个参数，传入插入中间表的其他参数
     *
     */
    public function addManyToMany(){
        $user = User::get(1);
        $num = $user->role()->save([
            'role_name' => '宿管'
        ],[
            'create_time' => time(),
            'update_time' => time()
        ]);
        dump($num);
    }

    /**
     * @return string
     * @throws \think\exception\DbException
     * 多对多关联   批量新增（关联表 与 中间表同时新增）
     */
    public function UserRoleInsertMany(){
        $user = User::get(3);

        $user->role()->saveAll([
            ['role_name' => '语文老师'],
            ['role_name' => '体育老师'],
        ],[
            'create_time' => time(),
            'update_time' => time()
        ],true);

        return '添加成功';
    }

    /**
     * @return string
     * @throws \think\exception\DbException
     * 多对多关联   只新增中间表数据
     * 插入 user_id = 2 且 role_id = 21 到中间表
     */
    public function UserRoleInsertMid(){
        $user = User::get(2);

        $user->role()->save(21);

        return '添加成功';
    }
}

