<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title><?php echo ($meta_title); ?>｜<?php echo C('WEB_SITE_TITLE');?>后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="author" content="XinHaiThink">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="generator" content="CoreThink">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="XinHaiThink">
    <meta name="format-detection" content="telephone=no,email=no">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="apple-touch-icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/Public/libs/cui/css/cui.min.css">
    <link rel="stylesheet" type="text/css" href="/./Application/Admin/View/Public/css/admin.css?v=<?php echo C('STATIC_VERSION');?>">
    <link rel="stylesheet" type="text/css" href="/./Application/Admin/View/Public/css/theme/<?php echo C('ADMIN_THEME');?>.css">
    
    <!--[if lt IE 9]>
        <script src="/Public/cdn_js/html5.min.js"></script>
        <script src="/Public/cdn_js/respond.min.js"></script>
    <![endif]-->
    <!-- 如果配置里CDN静态资源列表则使用CDN否则使用静态资源 -->
            <script type="text/javascript" src="/Public/libs/jquery/1.x/jquery.min.js"></script>
    </head>

<body>
    <div class="clearfix full-header">
        
    </div>

    <div class="clearfix full-container">
        
    <style type="text/css">
    .builder {
        background: #fff;
    }
    .builder .builder-tabs,
    .builder .builder-toolbar,
    .builder .builder-container {
        margin-bottom: 20px;
    }
    .builder .builder-container .builder-data-empty {
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    .builder .builder-container .builder-data-empty .empty-info {
        padding: 130px 0;
        color: #555;
    }
    .builder .builder-container .builder-table .panel {
        margin-bottom: 0px;
    }
    .builder .builder-container .builder-table .panel .table td {
        max-width: 600px;
        vertical-align: middle;
    }
    .builder .builder-container .builder-table .panel .table td img.picture {
        max-width: 200px;
        max-height: 40px;
    }
    .builder .builder-container .pagination {
        margin-bottom: 0px;
    }
    @media (max-width: 768px) {
        .builder-list-toolbar .button-list .btn {
            margin-bottom: 15px;
        }
    }
</style>

<div class="builder builder-list-box panel-body">

    <!-- Tab导航 -->
    
    <!-- 顶部工具栏按钮 -->
    <div class="builder-toolbar builder-list-toolbar">
            <div class="row">
                <!-- 工具栏按钮 -->
                <div class="col-xs-12 col-sm-9 button-list" style="width:25%;">
                        <a title="新增" class="btn btn-primary" href="<?php echo U('add');?>">新增</a>&nbsp;
<!--                        <a title="启用" target-form="ids" class="btn btn-success ajax-post confirm" model="dictionary" href="/index.php?s=/admin/dictionary/setstatus/status/resume/model/dictionary.html">启用</a>&nbsp;-->
<!--                        <a title="禁用" target-form="ids" class="btn btn-warning ajax-post confirm" model="dictionary" href="/index.php?s=/admin/dictionary/setstatus/status/forbid/model/dictionary.html">禁用</a>&nbsp;-->
                        <a title="删除" target-form="ids" class="btn btn-danger ajax-post confirm" model="dictionary" href="<?php echo U('delete');?>">删除</a>&nbsp;
                 </div>
                <!-- 搜索框 -->
                <div class="col-xs-12 col-sm-3" style="width:75%; height:35px;">
                        <div class="input-group search-form" style="float:right;">
                        <form action="<?php echo U('index');?>" method="post" style="height:35px; width:600px;">
                        	<select name="type" class="search-input form-control" style="width:250px;">
                        		<option value="">选择类型</option>
                        		<?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($tp["type"]); ?>" <?php if($_REQUEST['type'] == $tp['type']): ?>selected<?php endif; ?>><?php echo ($tp["type"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        	</select>
                            <input type="text" name="keyword" style="width:250px;" class="search-input form-control" value="<?php echo ($_REQUEST['keyword']); ?>" placeholder="请输入描述">
                            <span class="input-group-btn"><a class="btn btn-default" href="javascript:;" id="search" url="<?php echo U('index');?>"><i class="fa fa-search"></i></a></span>
                        </form>
                        </div>
                    </div>
            </div>
        </div>

    <!-- 数据列表 -->
    <div class="builder-container builder-list-container">
        <div class="row">
            <div class="col-xs-12">

                <div class="builder-table">
                    <div class="panel panel-default">
                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input class="check-all" type="checkbox"></th>
                                    <th>ID</th>
                                    <th>键值</th>
                                    <th>标签</th>
                                    <th>类型</th>
                                    <th>描述</th> 
                                    <th>排序</th> 
                                    <th>操作</th>                                 
                                </tr>
                            </thead>
                            <tbody>
                            	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td><input class="ids" type="checkbox" value="<?php echo ($vo["id"]); ?>" name="ids[]"></td>
                                    <td><?php echo ($vo["id"]); ?></td>
                                    <td><?php echo ($vo["value"]); ?></td>
                                    <td><?php echo ($vo["tag"]); ?></td>
                                    <td><?php echo ($vo["type"]); ?></td>
                                    <td><?php echo ($vo["describe"]); ?></td>
                                    <td><?php echo ($vo["sort"]); ?></td>
                                    <td>
                                    <a title="编辑" class="label label-primary" href="<?php echo U('edit', array('id' => $vo['id']));?>">编辑</a>&nbsp;&nbsp;
                                    <a title="删除" class="label label-danger ajax-get confirm" model="dictionary" href="<?php echo U('delete', array('ids' => $vo['id']));?>">删除</a>&nbsp;&nbsp;
                                    <a title="添加键值" class="label label-primary" href="<?php echo U('add_value', array('id' => $vo['id']));?>">添加键值</a>&nbsp;&nbsp;
                                    </td>                                    
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                             </tbody>
                        </table>
                    </div>

                    <ul class="pagination">
	                    <?php echo ($page); ?>
                    </ul> 
                  </div>

            </div>
        </div>
    </div>


    <!-- 额外功能代码 -->
    </div>

<script type="text/javascript">
    $(function() {
        if (!$('.builder')) {
            return false;
        }

        //全选/反选/单选的实现
        $(".builder .check-all").click(function() {
            $(".ids").prop("checked", this.checked);
        });

        $(".builder .ids").click(function() {
            var option = $(".ids");
            option.each(function() {
                if (!this.checked) {
                    $(".check-all").prop("checked", false);
                    return false;
                } else {
                    $(".check-all").prop("checked", true);
                }
            });
        });

        //搜索功能
        $('body').on('click', '.builder #search', function() {
            var url = $(this).attr('url');
            var query = $('.builder .search-form').find('form').serialize();
            query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g, '');
            query = query.replace(/(^&)|(\+)/g, '');
            if (url.indexOf('?') > 0) {
                url += '&' + query;
            } else {
                url += '?' + query;
            }
            window.location.href = url;
        });

         //回车搜索
        $(".builder .search-input").keyup(function(e) {
            if (e.keyCode === 13) {
                $("#search").click();
                return false;
            }
        });
    });
</script>


    </div>

    <div class="clearfix full-footer">
        
    </div>

    <div class="clearfix full-script">
        <div class="container-fluid">
            <input type="hidden" id="corethink_home_img" value="/./Application/Home/View/Public/img">
            <script type="text/javascript" src="/Public/libs/cui/js/cui.min.js"></script>
            <script type="text/javascript" src="/./Application/Admin/View/Public/js/admin.js?v=20150903"></script>
            
        </div>
    </div>
</body>
</html>