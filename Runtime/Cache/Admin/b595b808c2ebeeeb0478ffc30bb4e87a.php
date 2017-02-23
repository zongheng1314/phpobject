<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE');?>后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="author" content="<?php echo C('WEB_SITE_TITLE');?>">
    <meta name="keywords" content="<?php echo ($meta_keywords); ?>">
    <meta name="description" content="<?php echo ($meta_description); ?>">
    <meta name="generator" content="CoreThink">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php echo C('WEB_SITE_TITLE');?>">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="apple-touch-icon" type="image/x-icon" href="/wangzhan/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/wangzhan/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/wangzhan/Public/libs/cui/css/cui.min.css">
    <link rel="stylesheet" type="text/css" href="/wangzhan/./Application/Admin/View/Public/css/admin.css?v=<?php echo C('STATIC_VERSION');?>">
    <link rel="stylesheet" type="text/css" href="/wangzhan/./Application/Admin/View/Public/css/theme/<?php echo C('ADMIN_THEME');?>.css">
    
    <!--[if lt IE 9]>
        <script src="/Public/cdn_js/html5.min.js"></script>
        <script src="/Public/cdn_js/respond.min.js"></script>
    <![endif]-->
    <!-- 如果配置里CDN静态资源列表则使用CDN否则使用静态资源 -->
    <?php if(C('CDN_RESOURCE_LIST')): ?>
        <?php echo C('CDN_RESOURCE_LIST');?>
    <?php else: ?>
        <script type="text/javascript" src="/wangzhan/Public/libs/jquery/1.x/jquery.min.js"></script>
    <?php endif; ?>
</head>

<body>
    <div class="clearfix full-header">
        
    <!-- 顶部导航 -->
    <div class="main-nav navbar navbar-inverse navbar-fixed-top main-nav" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-top">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php if(C('WEB_SITE_LOGO')): ?>
                <a class="navbar-brand" target="_blank" href="/wangzhan/">
                   <img class="logo img-responsive" style="width:148px; height:32px;" src="<?php echo (get_cover(C("WEB_SITE_LOGO"))); ?>">
                </a>
            <?php else: ?>
                <a class="navbar-brand" target="_blank" href="/wangzhan/">
                    <img class="logo img-responsive" style="width:148px; height:32px;" src="/wangzhan/./Application/Home/View/Public/img/logo/logo_with_title.png">
                </a>
            <?php endif; ?>
        </div>
        <div class="collapse navbar-collapse navbar-collapse-top">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#admin-index" role="tab" data-toggle="tab">
                        <i class="fa fa-home"></i>
                        <span>首页</span>
                    </a>
                </li>
                <!-- 主导航 -->
                <?php if(is_array($_menu_list)): $i = 0; $__LIST__ = $_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <a href="#module<?php echo ($vo["id"]); ?>" role="tab" data-toggle="tab">
                            <i class="fa <?php echo ($vo["icon"]); ?>"></i>
                            <span><?php echo ($vo["title"]); ?></span>
                        </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo U('Admin/Index/removeRuntime');?>" class="ajax-get no-refresh"><i class="fa fa-trash"></i> 清空缓存</a></li>
                <li><a target="_blank" href="/wangzhan/"><i class="fa fa-external-link-square"></i> 打开前台</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> <?php echo ($_user_auth["username"]); ?> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('Admin/Public/logout');?>" class="ajax-get"><i class="fa fa-sign-out"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    </div>

    <div class="clearfix full-container">
        
    <div class="container-fluid with-top-navbar">
        <div class="row">
            <!-- 后台左侧导航 -->
            <div id="sidebar" class="col-xs-12 col-sm-2 sidebar tab-content">
                <!-- 快捷链接 -->
                <div role="tabpanel" class="tab-pane fade in active" id="admin-index">
                    <nav class="navside navside-default" role="navigation">
                        <ul class="nav navside-nav navside-first">
                            <?php if(is_array($_link_list)): $fkey = 0; $__LIST__ = $_link_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lk): $mod = ($fkey % 2 );++$fkey;?><li>
                                    <a data-toggle="collapse" href="#navside-collapse-lk-<?php echo ($lk["id"]); ?>-<?php echo ($fkey); ?>">
                                        <i class="fa <?php echo ($lk["icon"]); ?>"></i>
                                        <span class="nav-label"><?php echo ($lk["title"]); ?></span>
                                        <span class="fa arrow"></span>
                                    </a>
                                    <?php if(!empty($lk["_child"])): ?><ul class="nav navside-nav navside-second collapse in" id="navside-collapse--lk-<?php echo ($lk["id"]); ?>-<?php echo ($fkey); ?>">
                                            <?php if(is_array($lk["_child"])): $skey = 0; $__LIST__ = $lk["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns_second): $mod = ($skey % 2 );++$skey;?><li>
                                                    <a href="<?php echo ($_ns_second['url']); ?>" class="open-tab" tab-name="navside-collapse-<?php echo ($_ns["id"]); ?>-<?php echo ($fkey); ?>-<?php echo ($skey); ?>">
                                                        <i class="fa <?php echo ($_ns_second["icon"]); ?>"></i>
                                                        <span class="nav-label"><?php echo ($_ns_second["title"]); ?></span>
                                                    </a>
                                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul><?php endif; ?>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </nav>
                </div>

                <!-- 模块菜单 -->
                <?php if(is_array($_menu_list)): $i = 0; $__LIST__ = $_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns): $mod = ($i % 2 );++$i; if($_ns['_child']): ?>
                        <div role="tabpanel" class="tab-pane fade" id="module<?php echo ($_ns["id"]); ?>">
                            <nav class="navside navside-default" role="navigation">
                                <ul class="nav navside-nav navside-first">
                                    <?php if(!empty($_ns["_child"])): if(is_array($_ns["_child"])): $fkey = 0; $__LIST__ = $_ns["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns_first): $mod = ($fkey % 2 );++$fkey;?><li>
                                                <a data-toggle="collapse" href="#navside-collapse-<?php echo ($_ns["id"]); ?>-<?php echo ($fkey); ?>">
                                                    <i class="<?php echo ($_ns_first["icon"]); ?>"></i>
                                                    <span class="nav-label"><?php echo ($_ns_first["title"]); ?></span>
                                                    <span class="fa arrow"></span>
                                                </a>
                                                <?php if(!empty($_ns_first["_child"])): ?><ul class="nav navside-nav navside-second collapse in" id="navside-collapse-<?php echo ($_ns["id"]); ?>-<?php echo ($fkey); ?>">
                                                        <?php if(is_array($_ns_first["_child"])): $skey = 0; $__LIST__ = $_ns_first["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_ns_second): $mod = ($skey % 2 );++$skey;?><li>
                                                                <a href="<?php echo U($_ns_second['url']);?>" class="open-tab" tab-name="navside-collapse-<?php echo ($_ns["id"]); ?>-<?php echo ($fkey); ?>-<?php echo ($skey); ?>">
                                                                    <i class="<?php echo ($_ns_second["icon"]); ?>"></i>
                                                                    <span class="nav-label"><?php echo ($_ns_second["title"]); ?></span>
                                                                </a>
                                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                                    </ul><?php endif; ?>
                                            </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <!-- 右侧内容 -->
            <div id="main" class="col-xs-12 col-sm-10 main">
                <!-- 多标签后台 -->
                <nav class="navbar navbar-default ct-tab-nav" role="navigation">
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-left">
                            <li><a href="#" id="tab-left"><i class="fa fa-caret-left"></i></a></li>
                        </ul>
                        <div class="ct-tab-wrap clearfix">
                            <ul class="nav navbar-nav nav-close ct-tab">
                                <li href="#home" role="tab" data-toggle="tab">
                                    <a href="#"><i class="fa fa-dashboard"></i> <span>首页</span></a>
                                </li>
                            </ul>
                        </div>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" id="tab-right"><i class="fa fa-caret-right"></i></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">关闭操作 <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="close-all">关闭所有</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- 多标签后台内容部分 -->
                <div class="tab-content ct-tab-content">
                    <!-- 首页 -->
                    <div role="tabpanel" class="fade in active" id="home">
                        <div class="dashboard clearfix">
                            <div class="col-xs-12 col-sm-6 col-lg-4 ct-update">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="update pull-right"></div>
                                        <i class="fa fa-cog"></i> 系统信息
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-condensed text-overflow">
                                            <tbody>
<!--                                                <tr>-->
<!--                                                    <td>CoreThink版本</td>-->
<!--                                                    <td>-->
<!--                                                        <span class="version">-->
<!--                                                            v<?php echo C('CURRENT_VERSION');?>-->
<!--                                                            <?php echo C('BETA_VERSION') ? 'Beta'.C('BETA_VERSION') : '';?>-->
<!--                                                        </span>-->
<!--                                                    </td>-->
<!--                                                </tr>-->
<!--                                                <tr>-->
<!--                                                    <td>CoreThink正版认证</td>-->
<!--                                                    <td class="sn_info">-->
<!--                                                        <a href="<?php echo C('WEBSITE_DOMAIN');?>" target="_blank" class="btn-danger" style="padding:2px 5px;"><i class="fa fa-lock"></i> 未授权！</a>-->
<!--                                                    </td>-->
<!--                                                </tr>-->
<!--                                                <tr>-->
<!--                                                    <td>产品型号</td>-->
<!--                                                    <td><?php echo C('PRODUCT_TITLE');?>（ <?php echo C('PRODUCT_MODEL');?> ）</td>-->
<!--                                                </tr>-->
                                                <tr>
                                                    <td>ThinkPHP版本</td>
                                                    <td><?php echo (THINK_VERSION); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>服务器操作系统</td>
                                                    <td><?php echo (PHP_OS); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>运行环境</td>
                                                    <td>
                                                        <?php
 $server_software = explode(' ', $_SERVER['SERVER_SOFTWARE']); echo $server_software[0]; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>PHP版本</td>
                                                    <td><?php echo PHP_VERSION; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>MYSQL版本</td>
                                                    <td><?php $system_info_mysql = M()->query("select version() as v;"); echo ($system_info_mysql["0"]["v"]); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>上传限制</td>
                                                    <td><?php echo ini_get('upload_max_filesize');?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                             

                            <!-- 后台首页小工具 -->
                            <?php echo hook('AdminIndex');?>
                        </div>
                    </div>
                </div>

                <div class="clearfix footer">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <div class="navbar-header">
                            </div>
                            <div class="collapse navbar-collapse navbar-collapse-bottom">
                                <ul class="nav navbar-nav">
                                </ul>
                                <ul class="nav navbar-nav navbar-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <div class="clearfix full-footer">
        
    </div>

    <div class="clearfix full-script">
        <div class="container-fluid">
            <input type="hidden" id="corethink_home_img" value="/wangzhan/./Application/Home/View/Public/img">
            <script type="text/javascript" src="/wangzhan/Public/libs/cui/js/cui.min.js"></script>
            <script type="text/javascript" src="/wangzhan/./Application/Admin/View/Public/js/admin.js?v=<?php echo C('STATIC_VERSION');?>"></script>
            
        </div>
    </div>
</body>
</html>