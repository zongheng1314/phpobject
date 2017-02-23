<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>潍坊高新技术产业开发区滨海产业园</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/wangzhan/./Application/Home/View/Public/css/index.css" rel="stylesheet">
    <script src="/wangzhan/./Application/Home/View/Public/js/jquery-1.8.3.min.js"></script>
    <script src="/wangzhan/./Application/Home/View/Public/js/koala.min.1.5.js"></script>
    <script src="/wangzhan/./Application/Home/View/Public/js/lrtk.js"></script>
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
    <div class="main-box">
        <!-- 代码 开始 -->
        <div id="fsD1" class="focus">
            <div id="D1pic1" class="fPic">
             
                <?php if(is_array($pic)): $i = 0; $__LIST__ = $pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="fcon" style="display: none;">
                    <a target="_blank" href="<?php echo ($data["url"]); ?>"><img src="./<?php echo ($data['path']); ?>"></a>
                    <!--如果不要标题可以删除下面一行代码-->
                  
                    <span class="shadow"><a href="#"><?php echo ($data['title']); ?></a></span>
                 
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="fbg">
                <div class="D1fBt" id="D1fBt">
                    <a href="javascript:void(0)" hidefocus="true"><i>1</i></a>
                    <a href="javascript:void(0)" hidefocus="true"><i>2</i></a>
                    <a href="javascript:void(0)" hidefocus="true"><i>3</i></a>
                </div>
            </div>
        </div>
        <!-- 代码 结束 -->
        <div class="clear10"></div>
        <div class="box-1">
            <div class="title-1">
                <b>新闻中心</b>
                <a href="<?php echo U('Index/volist',array('pid' => 1));?>">更多>></a>
            </div>
            
            <div class="news-img">
                <?php if(!empty($cover["cover"])): ?><a title="<?php echo ($cover["title"]); ?>" href="<?php echo U('Index/detail',array('id'=>$cover['id']));?>"><img alt="<?php echo ($cover["title"]); ?>" src="./<?php echo ($cover['path']); ?>" width="490" height="295"></a><?php endif; ?>
                <?php if(empty($cover["cover"])): ?><a title="<?php echo ($cover["title"]); ?>" href="<?php echo U('Index/detail',array('id'=>$cover['id']));?>"><img src="/wangzhan/./Application/Home/View/Public/img/moren.jpg" width="490" height="295"></a><?php endif; ?>
            </div>
            
            <div class="news"> 
                <div class="headline">
                    <a><?php echo strcut($news[0]['title'],20);?></a>
                    <p><?php echo strcut($news[0]['content'],75);?><a href="<?php echo U('Index/detail',array('id'=>$news[0]['id']));?>">查看更多</a></p>
                </div>
                <ul class="news-ul">
                   <?php if(is_array($news)): $i = 0; $__LIST__ = array_slice($news,1,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                        <span>[<?php echo (date("Y-m-d",$vo['create_time'])); ?>]</span>
                        <a href="<?php echo U('Index/detail',array('id'=>$vo['id']));?>"><?php echo strcut($vo['title'],20);?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="clear10"></div>
        </div>
        <div class="box-2">
            <div class="notice">
                <div class="title-1">
                    <b>通知公告</b>
                    <a href="<?php echo U('Index/volist',array('pid' => 2));?>">更多>></a>
                </div>
                <ul class="notice-ul">
                  <?php if(is_array($notice)): $i = 0; $__LIST__ = array_slice($notice,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><li>
                        <span>[<?php echo (date("Y-m-d",$vo1['create_time'])); ?>]</span>
                        <a href="<?php echo U('Index/detail',array('id'=>$vo1['id']));?>"><?php echo strcut($vo1['title'],12);?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="dang">
                <div class="title-1">
                    <b>机关党建</b>
                    <a href="<?php echo U('Index/volist',array('pid' => 3));?>">更多>></a>
                </div>
                <div class="menu1box">
                    <ul id="menu1">
                        <li class="hover" onclick="setTab(1,0)"><a>优惠政策</a></li>
                        <li onclick="setTab(1,1)"><a>园区人才</a></li>
                        <li style ='width: 111px' onclick="setTab(1,2)"><a>园区科研</a></li>
                    </ul>
                </div>
                <div class="main1box">
                    <div class="main1" id="main1">
                        <ul class="block">
                            <?php if(is_array($youhui)): $i = 0; $__LIST__ = array_slice($youhui,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?><li>
                                <span>[<?php echo (date("Y-m-d",$vo2['create_time'])); ?>]</span>
                                <a href="<?php echo U('Index/detail',array('id'=>$vo2['id']));?>"><?php echo strcut($vo2['title'],12);?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <ul>
                            <?php if(is_array($rencai)): $i = 0; $__LIST__ = array_slice($rencai,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($i % 2 );++$i;?><li>
                                <span>[<?php echo (date("Y-m-d",$vo3['create_time'])); ?>]</span>
                                <a href="<?php echo U('Index/detail',array('id'=>$vo3['id']));?>"><?php echo strcut($vo3['title'],12);?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <ul>
                        <?php if(is_array($keyan)): $i = 0; $__LIST__ = array_slice($keyan,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo4): $mod = ($i % 2 );++$i;?><li>
                                <span>[<?php echo (date("Y-m-d",$vo4['create_time'])); ?>]</span>
                                <a href="<?php echo U('Index/detail',array('id'=>$vo4['id']));?>"><?php echo strcut($vo4['title'],12);?></a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="shang">
                <div class="title-1">
                    <b>招商引资</b>
                    <a href="<?php echo U('Index/volist',array('pid' => 4));?>">更多>></a>
                </div>
                <ul class="shang-ul">
                    <li>
                        <a href="<?php echo U('Index/volist', array('pid' =>24 ));?>">
                            <img src="/wangzhan/./Application/Home/View/Public/img/tab-1.png" width="56" border="0">
                            <p>投资导向</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Index/volist', array('pid' =>25));?>">
                            <img src="/wangzhan/./Application/Home/View/Public/img/tab-2.png" width="56" border="0">
                            <p>入园条件</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Index/volist', array('pid' =>26 ));?>">
                            <img src="/wangzhan/./Application/Home/View/Public/img/tab-3.png" width="56" border="0">
                            <p>建设流程</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Index/volist', array('pid' =>27));?>">
                            <img src="/wangzhan/./Application/Home/View/Public/img/tab-4.png" width="56" border="0">
                            <p>优惠政策</p>
                        </a>
                    </li>
                </ul>
                <div class="title-2">
                    <b>入驻企业</b>
                </div>
                <div class="shang-qy">
                    <?php if(is_array($ruzhu)): $i = 0; $__LIST__ = array_slice($ruzhu,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo5): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/detail',array('id'=>$vo5['id']));?>"><?php echo strcut($vo5['title'],15);?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="box-3">
            <div class="title-1">
                <b>园区概览</b>
                <a href="<?php echo U('Index/volist',array('pid' => 5));?>">更多>></a>
            </div>
            <!-- 代码开始 -->
            <div class="box-img">
                <div class="picbox">
                    <ul class="piclist mainlist">
                        <?php if(is_array($park)): $i = 0; $__LIST__ = $park;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$park): $mod = ($i % 2 );++$i; if(!empty($park["cover"])): ?><li><a href="<?php echo U('Index/detail',array('id'=>$park['id']));?>"><img src="./<?php echo ($park['path']); ?>" /></a></li><?php endif; ?>
                            <?php if(empty($park["cover"])): ?><li><a href="<?php echo U('Index/detail',array('id'=>$park['id']));?>"><img src="/wangzhan/./Application/Home/View/Public/img/moren.jpg" /></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <ul class="piclist swaplist"></ul>
                </div>
                <div class="og_prev"></div>
                <div class="og_next"></div>
            </div>
            <!-- 代码结束 -->
            <div class="brief-text">
                <div class="brief-t">
                    <a href="<?php echo U('Index/volist', array('pid' =>15 ));?>">园区简介</a>
                    <a href="<?php echo U('Index/volist', array('pid' =>16 ));?>">产业规划</a>
                    <a href="<?php echo U('Index/volist', array('pid' =>17 ));?>">交通物流</a>
                    <a href="<?php echo U('Index/volist', array('pid' =>18 ));?>">配套设施</a>
                    <a href="<?php echo U('Index/volist', array('pid' =>19 ));?>">园区发展公司</a>
                </div>
                <p><?php echo strcut($article_detail['content'],112);?><a style ="color: #c50a14" href="<?php echo U('Index/volist',array('pid'=>15));?>">查看更多</a></p>
            </div>
            <div class="clear10"></div>
        </div>
        <div class="box-4">
            <div class="serv">
                <div class="title-1">
                    <b>园区服务</b>
                    <a href="<?php echo U('Index/volist',array('pid' => 6));?>">更多>></a>
                </div>
                <div class="serv-box">
                    <div class="serv-item">
                        <a class="serv-1" href="<?php echo U('Index/volist',array('pid'=>11));?>">园区机构</a>
                        <a class="serv-2" href="<?php echo U('Index/volist',array('pid'=>12));?>">政策法规</a>
                        <a class="serv-3" href="<?php echo U('Index/volist',array('pid'=>14));?>">服务理念</a>
                        <a class="serv-4" href="<?php echo U('Index/volist',array('pid'=>29));?>">联系我们</a>
                    </div>
                    <p class="ser-text">
                        单位名称: 潍坊高新技术产业开发区滨海产业园<br>
                        座&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机: 0536-2097170<br>
                        邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱: wfgxbhcyy@126.com<br>
                        邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编: 261205<br>
                        通讯地址: 潍坊高新区健康东街6699号创新大厦
                    </p>
                </div>
            </div>
            <div class="video">
                <div class="title-3">
                    宣传视频 <span>Video</span>
                </div>
                <div class="video-box">
                <!--<embed src="/wangzhan/./Application/Home/View/Public/img/shipin.f4v" widht=273 height=200 autostart=true loop=true/false></embed>-->
         <video src="/wangzhan/./Application/Home/View/Public/img/shipin.f4v" width="273" height="200" autoplay="autoplay" controls="controls"></video>
                </div>
            </div>
            <div class="clear10"></div>
        </div>
        <div class="box-5">
            <div class="title-5">
                友情链接
            </div>
            <div class="link">
                <?php if(is_array($link_list)): $i = 0; $__LIST__ = $link_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?><a target="_blank" href="<?php echo ($link['url']); ?>"><img src="./<?php echo ($link['path']); ?>"></a><?php endforeach; endif; else: echo "" ;endif; ?>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div class="foot">
    版权所有：<?php echo ($copyright); ?>
</div>

<script type="text/javascript">
    Qfast.add('widgets', { path: "/wangzhan/./Application/Home/View/Public/js/terminator2.2.min.js", type: "js", requires: ['fx'] });
    Qfast(false, 'widgets', function () {
        K.tabs({
            id: 'fsD1',   //焦点图包裹id
            conId: "D1pic1",  //** 大图域包裹id
            tabId:"D1fBt",
            tabTn:"a",
            conCn: '.fcon', //** 大图域配置class
            auto: 1,   //自动播放 1或0
            effect: 'fade',   //效果配置
            eType: 'click', //** 鼠标事件
            pageBt:true,//是否有按钮切换页码
            bns: ['.prev', '.next'],//** 前后按钮配置class
            interval: 3000  //** 停顿时间
        })
    })
</script>
<script>
    function setTab(m,n){
        var tli=document.getElementById("menu"+m).getElementsByTagName("li");
        var mli=document.getElementById("main"+m).getElementsByTagName("ul");
        for(i=0;i<tli.length;i++){
            tli[i].className=i==n?"hover":"";
            mli[i].style.display=i==n?"block":"none";
        }
    }
</script>
</body>
</html>