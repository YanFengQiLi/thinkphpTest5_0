<?php
namespace app\index\controller;

use think\cache\driver\Redis;
use think\Controller;
use think\Request;

class Myredis extends Controller {

    protected $redis;

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

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->redis = new Redis($this->option);
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
}