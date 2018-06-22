<?php
//return array(
    //'配置项'=>'配置值'
//);
return array(
    'MODULE_ALLOW_LIST' => array('Admin','Api'),
    'DEFAULT_MODULE'     => 'Admin',                    //默认模块
    'URL_MODEL'          => '2',                        //URL模式
    'SESSION_AUTO_START' => true,                       //是否开启session
    //更多配置参数
    //'URL_HTML_SUFFIX' => 'html|shtml|xml',            // 多个伪静态后缀设置 用|分割
    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',                 // 数据库类型
    'DB_HOST'               => '192.168.1.141',             // 服务器地址
    'DB_NAME'               => 'ersanli',               // 数据库名
    'DB_USER'               => 'ersanli',               // 用户名
    'DB_PWD'                => '2dd3r6pWls1oGv7DpJs',   // 密码
    'DB_PORT'               => '3306',                  // 端口
    'DB_PREFIX'             => 'app_',                  // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    => false,                   // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => false,                   // 启用字段缓存
    'DB_CHARSET'            => 'utf8',                  // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0,                       // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,                   // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         => 1,                       // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           => '',                      // 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    => false,                   // 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    => 'file',                  // SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   => 20000,                   // SQL缓存的队列长度
    'DB_SQL_LOG'            => false,                   // SQL执行日志记录
    /* 数据库设置 */
    "over_time"             => 120,                     // 验证码过期时间
    "PASS_KEY"              => 'unohachahangzhou',      
    #redis配置项#
    /* 'DATA_CACHE_TYPE'       => 'Redis',                 //采用rdis 缓存
    'DATA_CACHE_PREFIX'     => 'Ersanli_',              //缓存前缀
    //'REDIS_AUTH_PASSWORD'   => 'Cyonger',               //redis auth认证密码
    'REDIS_HOST'            => '127.0.0.1',
    'REDIS_PORT'            => '6379',
    'DATA_CACHE_TIMEOUT'    => 60*60, */
    
);