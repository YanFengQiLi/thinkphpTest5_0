<?php
return [
    'app_debug'              => true,
    'show_error_msg'         => true,
    /*
     *  普通模式(默认)
     *      url_route_on：false
     *  混合模式
     *      url_route_on：true
     *      url_route_must:false
     *  强制模式
     *      url_route_on：true
     *      url_route_must:true
     * */
    'url_route_on'           => true,
    'url_route_must'=>  false,
    //加载路由文件数组  可以添加多个路由文件，默认是route.php
    'route_config_file' => [
        'route',
        'route_my'
    ],
    //'default_return_type'    => 'json',
    //数据库配置
    'database'               => [
        // 数据库类型
        'type'            => 'mysql',
        // 数据库连接DSN配置
        'dsn'             => '',
        // 服务器地址
        'hostname'        => '127.0.0.1',
        // 数据库名
        'database'        => 'thinkphp5_0',
        // 数据库用户名
        'username'        => 'root',
        // 数据库密码
        'password'        => 'root',
        // 数据库连接端口
        'hostport'        => '3306',
        // 数据库连接参数
        'params'          => [],
        // 数据库编码默认采用utf8
        'charset'         => 'utf8',
        // 数据库表前缀
        'prefix'          => 'think_',
        // 数据库调试模式
        'debug'           => false,
        // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
        'deploy'          => 0,
        // 数据库读写是否分离 主从式有效
        'rw_separate'     => false,
        // 读写分离后 主服务器数量
        'master_num'      => 1,
        // 指定从服务器序号
        'slave_no'        => '',
        // 是否严格检查字段是否存在
        'fields_strict'   => true,
        // 数据集返回类型
        'resultset_type'  => 'array',
        // 自动写入时间戳字段
        'auto_timestamp'  => false,
        // 时间字段取出后的默认时间格式
        'datetime_format' => 'Y-m-d H:i:s',
        // 是否需要进行SQL性能分析
        'sql_explain'     => false,
    ],
    'myRedis' => [
        'host' => '127.0.0.1',
        //  redis 默认的端口号
        'port' => 6379,
        //  redis 密码
        'password' => '',
        //  选择数据库 默认为0  命令用于切换到指定的数据库，数据库索引号 index 用数字值指定，以 0 作为起始索引值
        'select' => 0,
        //  设置 链接超时时间 以秒为单位
        'timeout' => 0,
        //  设置过期时间 以毫秒为单位
        'expire' => 0,
        //  定义是否为持久链接
        'persistent' => false,
        //  用作存储会话的Redis密钥的前缀
        'prefix' => ''
    ]
];