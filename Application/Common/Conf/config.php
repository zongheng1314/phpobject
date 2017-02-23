<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------

/**
 * CoreThink全局配置文件
 */
$_config = array(
    /**
     * 产品配置
     * 系统升级需要此配置
     * 根据CoreThink用户协议：
     * 免费版您可以免费用于项目开发
     * 但不允许更改本产品后台的版权信息，请您尊重我们的劳动成果及知识产权，违者追究法律责任。
     * 为了您更加方便使用本系统，后台特别设置了当前项目开发团队名称：DEVELOP_TEAM允许您自由更改来展示您的信息
     * 商业授权版可更改所有的产品名称及公司名称，授权联系：admin@corethink.cn
     */
    // 系统主页地址配置
    'HOME_PAGE'       => (is_ssl()?'https://':'http://').$_SERVER['HTTP_HOST'].__ROOT__,

    // 控制器分级情况下默认分级
    'DEFAULT_CONTROLLER_LEVEL' => 'Home',

    // URL模式
    'URL_MODEL' => '3',

    // 全局过滤配置
    'DEFAULT_FILTER' => '', //TP默认为htmlspecialchars

    // 预先加载的标签库
    'TAGLIB_PRE_LOAD' => 'Home\\TagLib\\Corethink',

    // URL配置
    'URL_CASE_INSENSITIVE' => true,  // 不区分大小写

    // 应用配置
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common'),
    'MODULE_ALLOW_LIST'  => array('Home','Admin','Install'),

    // 模板相关配置
    'TMPL_PARSE_STRING'  => array(
        '__PUBLIC__'     => __ROOT__.'/Public',
        '__CUI__'        => __ROOT__.'/Public/libs/cui',
        '__ADMIN_IMG__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/img',
        '__ADMIN_CSS__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/css',
        '__ADMIN_JS__'   => __ROOT__.'/'.APP_PATH.'Admin/View/Public/js',
        '__ADMIN_LIBS__' => __ROOT__.'/'.APP_PATH.'Admin/View/Public/libs',
        '__HOME_IMG__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/img',
        '__HOME_CSS__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/css',
        '__HOME_JS__'    => __ROOT__.'/'.APP_PATH.'Home/View/Public/js',
        '__HOME_LIBS__'  => __ROOT__.'/'.APP_PATH.'Home/View/Public/libs',
    ),

    // 文件上传默认驱动
    'UPLOAD_DRIVER' => 'Local',

    // 文件上传相关配置
    'UPLOAD_CONFIG' => array(
        'mimes'    => '',                        // 允许上传的文件MiMe类型
        'maxSize'  => 2*1024*1024,               // 上传的文件大小限制 (0-不做限制，默认为2M，后台配置会覆盖此值)
        'autoSub'  => true,                      // 自动子目录保存文件
        'subName'  => array('date', 'Y-m-d'),    // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
        'rootPath' => './Uploads/',              // 保存根路径
        'savePath' => '',                        // 保存路径
        'saveName' => array('uniqid', ''),       // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
        'saveExt'  => '',                        // 文件保存后缀，空则使用原后缀
        'replace'  => false,                     // 存在同名是否覆盖
        'hash'     => true,                      // 是否生成hash编码
        'callback' => false,                     // 检测文件是否存在回调函数，如果存在返回文件信息数组
    ),
   
);

// 获取数据库配置信息，手动修改数据库配置请修改./Data/db.php，这里无需改动
if (is_file('./Data/db.php')) {
    $db_config = include './Data/db.php';  // 包含数据库连接配置
} else {
    // 开启开发部署模式
    if (@$_SERVER[ENV_PRE.'DEV_MODE'] === 'true') {
        // 数据库配置
        $db_config = array(
            'DB_TYPE'   => $_SERVER[ENV_PRE.'DB_TYPE'] ? : 'mysql',           // 数据库类型
            'DB_HOST'   => $_SERVER[ENV_PRE.'DB_HOST'] ? : '127.0.0.1',       // 服务器地址
            'DB_NAME'   => $_SERVER[ENV_PRE.'DB_NAME'] ? : 'corethink',       // 数据库名
            'DB_USER'   => $_SERVER[ENV_PRE.'DB_USER'] ? : 'root',            // 用户名
            'DB_PWD'    => $_SERVER[ENV_PRE.'DB_PWD']  ? : '',                // 密码
            'DB_PORT'   => $_SERVER[ENV_PRE.'DB_PORT'] ? : '3306',            // 端口
            'DB_PREFIX' => $_SERVER[ENV_PRE.'DB_PREFIX'] ? : 'ct_',           // 数据库表前缀
        );
    } else {
        // 数据库配置
        $db_config = array(
            'DB_TYPE'   => 'mysql',           // 数据库类型
            'DB_HOST'   => '127.0.0.1',       // 服务器地址
            'DB_NAME'   => 'corethink',       // 数据库名
            'DB_USER'   => 'root',            // 用户名
            'DB_PWD'    => '',                // 密码
            'DB_PORT'   => '3306',            // 端口
            'DB_PREFIX' => 'ct_',             // 数据库表前缀
        );
    }
}

// 如果数据表字段名采用大小写混合需配置此项
$db_config['DB_PARAMS'] = array(\PDO::ATTR_CASE => \PDO::CASE_NATURAL);

// 返回合并的配置
return array_merge(
    $_config,                                      // 系统全局默认配置
    $db_config,                                    // 数据库配置数组
    include APP_PATH.'/Common/Builder/config.php'  // 包含Builder配置
);
