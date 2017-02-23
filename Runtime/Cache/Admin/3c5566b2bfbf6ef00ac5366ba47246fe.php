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
    
    <style type="text/css">
        .background {
            position: absolute;
            right: 0px;
            top: 0px;
            bottom: 0px;
            left: 0px;
            background: #1685d0;
            overflow: hidden;
        }
        .brand {
            width: 100%;
            height: 85px;
            padding: 0 20px;
            text-align: center;
        }
        .panel-lite {
            margin: 5% auto;
            max-width: 400px;
            background: #fff;
            padding: 45px 30px;
            border-radius: 4px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .panel-lite h4 {
            font-weight: 400;
            font-size: 24px;
            text-align: center;
            color: #1685d0;
            margin: 15px auto;
        }
        .panel-lite a.link {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: #1685d0;
            font-size: 14px;
        }
        .form-group {
            position: relative;
            font-size: 15px;
            color: #666;
        }
        .form-group + .form-group {
            margin-top: 30px;
        }
        .form-group .form-label {
            position: absolute;
            z-index: 1;
            left: 0;
            top: 5px;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }
        .form-group .form-control {
            width: 100%;
            position: relative;
            z-index: 3;
            height: 35px;
            background: none;
            border: none;
            padding: 5px 0;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            border-bottom: 1px solid #777;
            box-shadow: none;
            border-radius: 0;
        }
        .form-group .form-control:invalid {
            outline: none;
        }
        .form-group .form-control:focus, .form-group .form-control:valid {
            outline: none;
            color: #1685d0;
            box-shadow: 0 1px #1685d0;
            border-color: #1685d0;
        }
        .form-group .form-control:focus + .form-label,
        .form-group .form-control:valid + .form-label {
            font-size: 12px;
            -ms-transform: translateY(-15px);
            -webkit-transform: translateY(-15px);
            transform: translateY(-15px);
        }
        .floating-btn {
            background: #1685d0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: #fff;
            font-size: 32px;
            border: none;
            position: absolute;
            margin: auto;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            box-shadow: 1px 0px 0px rgba(0, 0, 0, 0.3) inset;
            margin: auto;
            right: -30px;
            bottom: 90px;
            cursor: pointer;
        }
        .floating-btn:hover {
            box-shadow: 0 0 0 rgba(0, 0, 0, 0.3) inset, 0 3px 6px rgba(0, 0, 0, 0.16), 0 5px 11px rgba(0, 0, 0, 0.23);
        }
        .floating-btn:hover .icon-arrow {
            -ms-transform: rotate(45deg) scale(1.2);
            -webkit-transform: rotate(45deg) scale(1.2);
            transform: rotate(45deg) scale(1.2);
        }
        .floating-btn:focus, .floating-btn:active {
            outline: none;
        }
        .icon-arrow {
            position: relative;
            width: 13px;
            height: 13px;
            border-right: 3px solid #fff;
            border-top: 3px solid #fff;
            display: block;
            -ms-transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            margin: auto;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }
        .icon-arrow:after {
            content: '';
            position: absolute;
            width: 18px;
            height: 3px;
            background: #fff;
            left: -5px;
            top: 5px;
            -ms-transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }
        .verifyimg-box {
            padding: 0;
            border: 0;
        }
        .verifyimg-box .verifyimg {
            cursor: pointer;
            width: 130px;
            height: 41px;
            margin-top: -6px;
            border-bottom: 1px solid #777;
        }
        @media (max-width: 768px) {
            .background {
                display: none;
            }
            .panel-lite {
                box-shadow: none;
                border-color: #fff;
            }
        }
    </style>

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
        
    </div>

    <div class="clearfix full-container">
        
    <!-- 背景 -->
    <div id="particles-js" class="background"></div>

    <!-- 登陆框 -->
    <div class="panel-lite">
        <div class="brand">
            <?php if(C('WEB_SITE_LOGO')): ?>
                <a href="<?php echo C('HOME_PAGE');?>"><img alt="logo" style="width:383px; height:83px;" class="logo img-responsive" src="<?php echo (get_cover(C("WEB_SITE_LOGO"))); ?>"></a>
            <?php else: ?>
                <a href="<?php echo C('HOME_PAGE');?>"><img alt="logo" style="width:383px; height:83px;" class="logo img-responsive" src="/wangzhan/./Application/Home/View/Public/img/logo/logo_with_title_dark.png"></a>
            <?php endif; ?>
        </div>
        <h4>后台登录</h4>
        <form class="login-form" action="<?php echo U('');?>" method="post">
            <div class="form-group">
                <input type="text" required="required" class="form-control" name="username" autocomplete="off">
                <label class="form-label">账　号</label>
            </div>
            <div class="form-group">
                <input type="password" required="required" class="form-control" name="password">
                <label class="form-label">密　码</label>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" required="required" class="form-control" name="verify">
                    <label class="form-label">验证码</label>
                    <span class="input-group-addon verifyimg-box">
                        <img id="admin_verify" class="verifyimg reload-verify" alt="CoreThink验证码" src="<?php echo U('verify');?>" title="点击刷新">
                    </span>
                </div>
            </div>
            <div class="form-group">
                <a type="submit" class="visible-xs btn btn-primary-outline btn-block btn-pill btn-lg ajax-post" target-form="login-form">登录</a>
            </div>
<!--            <a class="link" target="_blank" href="<?php echo C('HOME_PAGE');?>">忘记密码 ? </a>-->
            <button type="submit" class="floating-btn ajax-post hidden-xs" target-form="login-form">
                <i class="icon-arrow"></i>
            </button>
        </form>
    </div>

    </div>

    <div class="clearfix full-footer">
        
    </div>

    <div class="clearfix full-script">
        <div class="container-fluid">
            <input type="hidden" id="corethink_home_img" value="/wangzhan/./Application/Home/View/Public/img">
            <script type="text/javascript" src="/wangzhan/Public/libs/cui/js/cui.min.js"></script>
            <script type="text/javascript" src="/wangzhan/./Application/Admin/View/Public/js/admin.js?v=<?php echo C('STATIC_VERSION');?>"></script>
            
    <script src="/wangzhan/Public/libs/particles/particles.min.js"></script>
    <script type="text/javascript">
        $(function(){
            // 刷新验证码
            $("#admin_verify").on('click', function() {
                var verifyimg = $("#admin_verify").attr("src");
                if (verifyimg.indexOf('?') > 0) {
                    $("#admin_verify").attr("src", verifyimg + '&random=' + Math.random());
                } else {
                    $("#admin_verify").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
                }
            });

            //背景粒子效果
            particlesJS('particles-js', {
                particles: {
                    color: '#46BCF3',
                    shape: 'circle', // "circle", "edge" or "triangle"
                    opacity: 1,
                    size: 2,
                    size_random: true,
                    nb: 200,
                    line_linked: {
                        enable_auto: true,
                        distance: 100,
                        color: '#46BCF3',
                        opacity: .8,
                        width: 1,
                        condensed_mode: {
                            enable: false,
                            rotateX: 600,
                            rotateY: 600
                        }
                    },
                    anim: {
                        enable: true,
                        speed: 1
                    }
                },
                interactivity: {
                    enable: true,
                    mouse: {
                        distance: 250
                    },
                    detect_on: 'canvas', // "canvas" or "window"
                    mode: 'grab',
                    line_linked: {
                        opacity: .5
                    },
                    events: {
                        onclick: {
                            enable: true,
                            mode: 'push', // "push" or "remove" (particles)
                            nb: 4
                        }
                    }
                },
                retina_detect: true
            });
        });
    </script>

        </div>
    </div>
</body>
</html>