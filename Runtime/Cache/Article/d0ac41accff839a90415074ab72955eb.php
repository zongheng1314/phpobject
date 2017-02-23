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
        
    </div>

    <div class="clearfix full-container">
        
    <div class="col-xs-2">
        <link rel="stylesheet" type="text/css" href="/wangzhan/Public/libs/ztree/css/metroStyle/metroStyle.css">
<div class="panel-body">
    <div class="ztree ztree-manual" id="cate-list"></div>
</div>
<?php
 $map['status'] = array('egt', '0'); $map['group'] = array('eq', 1); $data_list = D('Category')->field('id,pid,group,doc_type,title,url,create_time,sort,status') ->where($map)->order('sort asc,id asc')->select(); foreach ($data_list as &$item) { $document_type = D('Type')->find($item['doc_type']); if ($document_type['name'] === 'page') { $item['url'] = U('Article/Admin/Category/edit_with_tree', array('id' => $item['id'])); $item['target'] = "_self"; } else if ($document_type['name'] === 'link') { if (!stristr($item['url'], 'http://') && !stristr($item['url'], 'https://')) { $item['url'] = U($item['url']); } } else if ($document_type['system'] === '0') { $item['url'] = U('Article/Admin/Article/index', array('cid' => $item['id'])); $item['target'] = "_self"; } } $data_list = json_encode($data_list); ?>
<script type="text/javascript" src="/wangzhan/Public/libs/ztree/js/jquery.ztree.all-3.5.min.js" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        //ztree设置
        var setting = {
            data:{
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "pid",
                    rootPId: 0
                },
                key:{
                    name:'title'
                }
            }
        };
        zTreeNodes = <?php echo ($data_list); ?>;
        zTreeObj = $.fn.zTree.init($("#cate-list"), setting, zTreeNodes);
        zTreeObj.expandAll(true);
    });
</script>

    </div>
    <div class="col-xs-10">
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
    <?php if(!empty($tab_nav)): ?><div class="builder-tabs builder-list-tabs">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <?php if(is_array($tab_nav["tab_list"])): $i = 0; $__LIST__ = $tab_nav["tab_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tab): $mod = ($i % 2 );++$i;?><li class="<?php if($tab_nav['current_tab'] == $key) echo 'active'; ?>"><a href="<?php echo ($tab["href"]); ?>"><?php echo ($tab["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div><?php endif; ?>

    <!-- 顶部工具栏按钮 -->
    <?php if(!empty($top_button_list)): ?><div class="builder-toolbar builder-list-toolbar">
            <div class="row">
                <!-- 工具栏按钮 -->
                <?php if(!empty($top_button_list)): ?><div class="col-xs-12 col-sm-9 button-list">
                        <?php if(is_array($top_button_list)): $i = 0; $__LIST__ = $top_button_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$button): $mod = ($i % 2 );++$i;?><a <?php echo ($button["attribute"]); ?>><?php echo ($button["title"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                    </div><?php endif; ?>

                <!-- 搜索框 -->
                <?php if(!empty($search)): ?><div class="col-xs-12 col-sm-3">
                        <div class="input-group search-form">
                            <input type="text" name="keyword" class="search-input form-control" value="<?php echo ($_GET["keyword"]); ?>" placeholder="<?php echo ($search["title"]); ?>">
                            <span class="input-group-btn"><a class="btn btn-default" href="javascript:;" id="search" url="<?php echo ($search["url"]); ?>"><i class="fa fa-search"></i></a></span>
                        </div>
                    </div><?php endif; ?>
            </div>
        </div><?php endif; ?>


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
                                    <?php if(is_array($table_column_list)): $i = 0; $__LIST__ = $table_column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$column): $mod = ($i % 2 );++$i;?><th><?php echo (htmlspecialchars($column["title"])); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($table_data_list)): $i = 0; $__LIST__ = $table_data_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                        <td><input class="ids" type="checkbox" value="<?php echo ($data[$table_data_list_key]); ?>" name="ids[]"></td>
                                        <?php if(is_array($table_column_list)): $i = 0; $__LIST__ = $table_column_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$column): $mod = ($i % 2 );++$i;?><td><?php echo ($data[$column['name']]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                                <?php if(empty($table_data_list)): ?><tr class="builder-data-empty">
                                        <?php $tdcolspan = count($table_column_list)+1 ?>
                                        <td class="text-center empty-info" colspan="<?php echo ($tdcolspan); ?>">
                                            <i class="fa fa-database"></i> 暂时没有数据<br>
                                        </td>
                                    </tr><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(!empty($table_data_page)): ?><ul class="pagination"><?php echo ($table_data_page); ?></ul><?php endif; ?>
                </div>

            </div>
        </div>
    </div>


    <!-- 额外功能代码 -->
    <?php echo ($extra_html); ?>
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
            var query = $('.builder .search-form').find('input').serialize();
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