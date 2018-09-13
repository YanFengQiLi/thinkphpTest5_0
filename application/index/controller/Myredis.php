<?php
namespace app\index\controller;

use think\cache\driver\Redis;
use think\Controller;

class Myredis extends Controller {

    protected $redis;

    protected $originRedis;

    protected $option = [
        'host'       => '127.0.0.1',
        //  redis 默认的端口号
        'port'       => 6379,
        //  redis 密码
        'password'   => '',
        //  选择数据库 默认为0  命令用于切换到指定的数据库，数据库索引号 index 用数字值指定，以 0 作为起始索引值
        'select'     => 0,
        //  设置 链接超时时间 以秒为单位
        'timeout'    => 0,
        //  设置过期时间 以毫秒为单位
        'expire'     => 0,
        //  定义是否为持久链接
        'persistent' => false,
        //  用作存储会话的Redis密钥的前缀
        'prefix'     => '',
    ];

    public function __construct()
    {
        $this->redis = new Redis($this->option);

        $this->originRedis = new \Redis();

        $this->originRedis->connect($this->option['host'],$this->option['port'],$this->option['timeout']);
    }

    /**
     *  设置有效期为 60 秒的 string 类型的 key
     */
    public function setStringExpireValue(){
        $this->redis->set('age',10,10);
        return 'true';
    }

    /**
     *  读取 有效期为 60 秒的 string 类型的 key
     */
    public function getStringExpireValue(){
        return $this->redis->get('age');

    }

    /**
     *  设置 有效期为 时间戳 的 string 类型的 key
     */
    public function setStringExpireTimeValue(){
        $dateStart = '2018-09-07';
        $dateEnd = date('Y-m-d',strtotime("{$dateStart} +7 days"));
        $this->redis->set('nickname','偷桃的',strtotime($dateEnd));
        return 'true';
    }

    /**
     *  读取 有效期为 时间戳 的 string 类型的 key
     */
    public function getStringExpireTimeValue(){
        return $this->redis->get('nickname');
    }

    /**
     * @return bool
     * 设置 无有效期 的 string 类型的 key
     */
    public function setStringNotExpireValue(){
        $this->redis->set('username','孙悟空');
        return 'true';
    }


    /**
     * @return mixed
     * 读取 无有效期的 string 类型的 key
     */
    public function getStringNotExpireValue(){
        return $this->redis->get('username');
    }

    /**
     * @return bool
     * 设置 自增缓存 步长为1
     * 可以作为 新闻访问量，每当访问我这个页面时，click 字段就 +1
     */
    public function setClickInc(){
        $this->redis->inc('click',1);
        return 'true';
    }

    /**
     * @return string
     * 设置 自减缓存 步长为1
     */
    public function setClickDec(){
        $this->redis->dec('click',1);
        return 'true';
    }

    /**
     * @return string
     * 删除缓存，只需提供要清除的 key
     */
    public function deleteRedisCache(){
        $this->redis->rm('nickname');
        return 'true';
    }


    /**
     * @return string
     *
     * setex('key',time,'value') 设置键值对，并设置该键的缓存时间
     */
    public function setStringSetEx(){
        $redis = new Myredis();
        $redis->originRedis->setex('myTest',60,'张三哈哈');
        return 'true';
    }

    public function getStringGetEx(){
        $redis = new Myredis();
        return $redis->originRedis->get('myTest');
    }

/*********************************************** String类型的拓展   ******************************************************************************/
    public function setStringSetNx(){
        $redis = new Myredis();
        $num = $redis->originRedis->setnx('name','电费');
        if($num){
            return dataResponse(200,'','设置成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }


    /**
     * @return string
     * mset() 批量设置键值对
     * 用法： 需要传递一个 一维的关联型数组
     * 优点： 节省网络开销
     */
    public function setStringMset(){
        $redis = new Myredis();
        $arr = [
            'name' => '李梅',
            'age'  => 16,
            'parent' => '李梅父母'
        ];
        $redis->originRedis->mset($arr);
        return 'true';
    }

    /**
     * @return \think\response\Json
     * mget()  批量获取键值对
     * 优点： 节省网络开销
     *
     */
    public function getStringMget(){
        $redis = new Myredis();
        $data = $redis->originRedis->mget([
            'name','age','parent'
        ]);
        return dataResponse(200,$data,'');
    }


    /**
     *  msetex()
     * 用于所有给定 key 都不存在时，同时设置一个或多个 key-value 对
     * 如果设置的 key 中，redis 中存在，则返回 0
     *
     * 函数返回值：
     *     类型 int， 0 - 设置失败  1 - 设置成功
     *
     * 与 mset() 的异同点：
     * 相同点：
     *      都是批量设置 键值对
     * 异同点：
     *      mset() 批量设置 key-value 时，遇到相同的 key 会自动进行合并，并覆盖其 value
     *
     *      msetex() 批量设置时 key-value 时，会逐个检测 key ，只要有一个 key 存在 就会报错
     *
     *
     *
     */
    public function setManyStringNotKey(){
        $redis = new Myredis();
        $num = $redis->originRedis->msetex([
            'name' => '利达',
            'dance' => '芭蕾舞'
        ]);
        if($num){
            return dataResponse(200,'','设置成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }

    /**
     * @return \think\response\Json
     * append('已经存在的key','要追加的内容') 向已经存在的 key=value，追加内容
     */
    public function getStringAppend(){
        $redis = new Myredis();
        $num = $redis->originRedis->append('name','这是我追加的内容');
        if($num){
            return dataResponse(200,'','设置成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }


    /*************************************************************************************************
                                    list 的类型
     *  1、常用来做 异步队列使用

     *****************************************************************************************************/


    /**
     * @return \think\response\Json
     * lPush('key','val_1',...'val_N');
     *
     * 用途：
     * 将一个或多个值插入到列表头部。
     * 如果 key 不存在，一个空列表会被创建并执行 lPush 操作。
     * 当 key 存在:
     *      (1)、不是列表类型时，返回一个错误
     *      (2)、是列表类型时，会继续的将值 push 到列表头部
     *
     * 返回值： 列表长度
     */
    public function list_lPush(){
        $redis = new  Myredis();
        $num = $redis->originRedis->lPush('myGoodList','shoes','shirt','pants');
        if($num){
            return dataResponse(200,'','设置成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }

    /**
     *  lPop('key')
     *
     *  作用：
     *      移出并获取列表的第一个元素,队头的元素
     *
     *  返回值：
     *       若 key 存在，返回队头第一个元素
     *       若 key 不存在， 返回 nil 框架 内部返回 false
     */
    public function list_lPOP(){
        $redis = new Myredis();
        $first = $redis->originRedis->lPop('myGoodList');
        if($first){
            return dataResponse(200,$first,'获取成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }

    /**
     *  lLen('key')
     *
     * @return \think\response\Json
     *
     *  获取指定 key 的列表长度
     *
     *  返回值：
     *      (1)、key 不存在 返回 0
     *      (2)、key 不是 list 类型 返回nil
     *
     */
    public function list_lLen(){
        $redis = new Myredis();
        $length = $redis->originRedis->lLen('myGoodList');
        if($length){
            return dataResponse(200,$length,'获取成功');
        }else{
            return dataResponse(201,'','设置失败');
        }
    }

}