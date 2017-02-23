<?php if (!defined('THINK_PATH')) exit();?>    <!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>潍坊高新技术产业开发区滨海产业园</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/wangzhan/./Application/Home/View/Public/css/index.css" rel="stylesheet">
    <link href="/wangzhan/./Application/Home/View/Public/css/inner.css" rel="stylesheet">
    <link href='/wangzhan/./Application/Home/View/Public/css/page.css' rel="stylesheet">
</head>
<body>

    <div class="top-wrap">
    <div class="top">
        <div class="logo">
            <a href="#"><img src="/wangzhan/./Application/Home/View/Public/img/logo.png" width="720" border="0"></a>
        </div>
    </div>
</div>
<div class="nav-wrap">
    <ul class="nav">
        <li <?php if($_GET['pid'] == '' && $article_detail['category']['pid'] == '' ): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/index');?>">首&nbsp;页</a></li>
        <li <?php if($_GET['pid'] == 5 || $group_list[0]['id'] == 5 || $article_detail['category']['pid'] == 5 || $article_detail['category']['id'] == 5): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist', array('pid' => 5));?>">园区概览</a></li>
        <li <?php if($_GET['pid'] == 1 || $article_detail['pid'] == 1 || $article_detail['category']['pid'] == 1 || $article_detail['category']['id'] == 1): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 1));?>">新闻中心</a></li>
        <li <?php if($_GET['pid'] == 4 || $article_detail['pid'] == 4 || $article_detail['category']['pid'] == 4 || $article_detail['category']['id'] == 4): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 4));?>">招商引资</a></li>
        <li <?php if($_GET['pid'] == 20 || $article_detail['pid'] == 20 || $article_detail['category']['pid'] == 20 || $article_detail['category']['id'] == 20): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 20));?>">创新资源</a></li>
        <li <?php if($_GET['pid'] == 6 || $article_detail['pid'] == 6 || $article_detail['category']['pid'] == 6 || $article_detail['category']['id'] == 6): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 6));?>">园区服务</a></li>
        <li <?php if($_GET['pid'] == 3 || $article_detail['pid'] == 3 || $article_detail['category']['pid'] == 3 || $article_detail['category']['id'] == 3): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 3));?>">机关党建</a></li>
        <li <?php if($_GET['pid'] == 29 || $article_detail['pid'] == 29 || $article_detail['category']['pid'] == 29 || $article_detail['category']['id'] == 29): ?>class="nav-on"<?php endif; ?>><a href="<?php echo U('Index/volist',array('pid' => 29));?>">联系我们</a></li>
    </ul>
</div>
    
<div class="main-wrap">
    <div class="clear10"></div>
    <table class="main-table" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="300" class="inner-left">
               
                <?php if(!empty($park_child)): ?><div class="left-t">资讯分类</div>
                <ul class="news-class">
                    <?php if(is_array($park_child)): $i = 0; $__LIST__ = $park_child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$park): $mod = ($i % 2 );++$i;?><li <?php if($_GET['pid'] == $park['id']): ?>class="on"<?php endif; ?> ><a href="<?php echo U('Index/volist', array('pid' => $park['id']));?>"><?php echo ($park['title']); ?></a></li>
                      <!--<li class="on"><a href="#"><?php echo ($park['title']); ?></a></li>--><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul><?php endif; ?>
                <div class="left-t">最新文章</div>
                <ul class="news-hot">
                    <?php if(is_array($new_article_list)): $i = 0; $__LIST__ = array_slice($new_article_list,0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$newarticle): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/detail',array('id'=>$newarticle['id']));?>"><?php echo strcut($newarticle['title'],15);?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <div class="left-t">联系方式</div>
                <table class="cont-box" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <th>单位名称:</th>
                        <td>潍坊高新技术产业开发区滨海产业园</td>
                    </tr>
                    <tr>
                        <th>座&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机:</th>
                        <td>0536-2097170</td>
                    </tr>
                    <tr>
                        <th>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:</th>
                        <td>wfgxbhcyy@126.com</td>
                    </tr>
                    <tr>
                        <th>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编:</th>
                        <td>261205</td>
                    </tr>
                    <tr>
                        <th>通讯地址:</th>
                        <td>潍坊高新区健康东街6699号创新大厦</td>
                    </tr>
                </table>
            </td>
            <td width="15"></td>
            <td width="685" class="inner-right">
                <div class="position">
                    <a href="<?php echo U('Index/index');?>">首页</a>><a href="<?php echo U('Index/volist',array('pid' =>$group_list[0]['id']));?>"><?php echo ($group_list[0]['title']); ?></a>  <?php if(!empty($group_list["1"])): ?>> <a ><?php echo strcut($group_list[1]['title'],15);?></a><?php endif; ?>
                </div>
                <ul class="right-list">
                    
                    <!--文章列表-->
                    <?php if(is_array($artic_list)): $i = 0; $__LIST__ = $artic_list;if( count($__LIST__)==0 ) : echo "暂无相关内容" ;else: foreach($__LIST__ as $key=>$alist): $mod = ($i % 2 );++$i;?><li><span><?php echo ($alist['creat_time']); ?></span><a href="<?php echo U('Index/detail',array('id'=>$alist['id']));?>"><?php echo strcut($alist['title'],25);?></a></li><?php endforeach; endif; else: echo "暂无相关内容" ;endif; ?>
                </ul>
                   <div class="sabrosus"><?php echo ($page); ?></div>
            </td>
        </tr>
        
    </table>
    
</div>
<div class="foot">
    版权所有：<?php echo ($copyright); ?>
</div>
</body>
</html>