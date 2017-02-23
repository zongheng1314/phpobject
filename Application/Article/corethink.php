<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
// 模块信息配置
return array(
    // 模块信息
    'info' => array(
        'name'        => 'Article',
        'title'       => 'CMS门户',
        'icon'        => 'fa fa-newspaper-o',
        'icon_color'  => '#9933FF',
        'description' => '后台管理系统',
        'developer'   => '山东新海软件股份有限公司',
        'website'     => 'http://www.neocean.top',
        'version'     => '1.1.0',
        'beta'        => 'false',
        'dependences' => array(
            'Admin'   => '1.1.0',
        )
    ),

    // 模块配置
    'config' => array(
        'need_check' => array(
            'title'   => '前台发布审核',
            'type'    => 'radio',
            'options' => array(
                '1'   => '需要',
                '0'   => '不需要',
            ),
            'value'   => '0',
        ),
        'toggle_comment' => array(
            'title'  => '是否允许评论文档',
            'type'   =>'radio',
            'options' => array(
                '1'   => '允许',
                '0'   => '不允许',
            ),
            'value'  => '1',
        ),
        'slider_over' => array(
            'title'  => '两侧广告',
            'type'   =>'radio',
            'options' => array(
                '1'   => '开启',
                '0'   => '关闭',
            ),
            'value'  => '1',
        ),
        'group_list' => array(
            'title'  => '栏目分组',
            'type'   =>'array',
            'value'  => '1:默认',
        ),
        'cate' => array(
            'title'  => '首页栏目自定义',
            'type'   =>'array',
            'value'  => 'a:1',
        ),
        'taglib' => array(
            'title'  => '加载标签库',
            'type'   =>'checkbox',
            'options'=> array(
                'Article' => 'Article',
            ),
            'value'  => array(
                '0'  => 'Article',
            ),
        ),
    ),

    // 后台菜单及权限节点配置
    'admin_menu' => array(
        '1' => array(
            'id'    => '1',
            'pid'   => '0',
            'title' => '内容',
            'icon'  => 'fa fa-newspaper-o',
        ),
        '2' => array(
            'pid'   => '1',
            'title' => '内容管理',
            'icon'  => 'fa fa-folder-open-o',
        ),
        '3' => array(
            'pid'   => '2',
            'title' => '文章配置',
            'icon'  => 'fa fa-wrench',
            'url'   => 'Article/Admin/Default/module_config',
        ),
        '4' => array(
            'pid'   => '2',
            'title' => '文档模型',
            'icon'  => 'fa fa-cubes',
            'url'   => 'Article/Admin/Type/index',
        ),
        '5' => array(
            'pid'   => '4',
            'title' => '新增',
            'url'   => 'Article/Admin/Type/add',
        ),
        '6' => array(
            'pid'   => '4',
            'title' => '编辑',
            'url'   => 'Article/Admin/Type/edit',
        ),
        '7' => array(
            'pid'   => '4',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Type/setStatus',
        ),
        '8' => array(
            'pid'   => '4',
            'title' => '字段管理',
            'icon'  => 'fa fa-database',
            'url'   => 'Article/Admin/Attribute/index',
        ),
        '9' => array(
            'pid'   => '8',
            'title' => '新增',
            'url'   => 'Article/Admin/Attribute/add',
        ),
        '10' => array(
            'pid'   => '8',
            'title' => '编辑',
            'url'   => 'Article/Admin/Attribute/edit',
        ),
        '11' => array(
            'pid'   => '8',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Attribute/setStatus',
        ),
        '12' => array(
            'pid'   => '2',
            'title' => '栏目分类',
            'icon'  => 'fa fa-navicon',
            'url'   => 'Article/Admin/Category/index',
        ),
        '13' => array(
            'pid'   => '12',
            'title' => '新增',
            'url'   => 'Article/Admin/Category/add',
        ),
        '14' => array(
            'pid'   => '12',
            'title' => '编辑',
            'url'   => 'Article/Admin/Category/edit',
        ),
        '15' => array(
            'pid'   => '12',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Category/setStatus',
        ),
        '16' => array(
            'pid'   => '2',
            'title' => '文章管理',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/index',
        ),
        '17' => array(
            'pid'   => '2',
            'title' => '广告管理',
            'icon'  => 'fa fa-image',
            'url'   => 'Article/Admin/Slider/index',
        ),
        '18' => array(
            'pid'   => '17',
            'title' => '新增',
            'url'   => 'Article/Admin/Slider/add',
        ),
        '19' => array(
            'pid'   => '17',
            'title' => '编辑',
            'url'   => 'Article/Admin/Slider/edit',
        ),
        '20' => array(
            'pid'   => '17',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Slider/setStatus',
        ),
//        '21' => array(
//            'pid'   => '2',
//            'title' => '通知公告',
//            'icon'  => 'fa fa-bullhorn',
//            'url'   => 'Article/Admin/Notice/index',
//        ),
        '22' => array(
            'pid'   => '21',
            'title' => '新增',
            'url'   => 'Article/Admin/Notice/add',
        ),
        '23' => array(
            'pid'   => '21',
            'title' => '编辑',
            'url'   => 'Article/Admin/Notice/edit',
        ),
        '24' => array(
            'pid'   => '21',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Notice/setStatus',
        ),
//        '25' => array(
//            'pid'   => '2',
//            'title' => '底部导航',
//            'icon'  => 'fa fa-map-signs',
//            'url'   => 'Article/Admin/Footnav/index',
//        ),
        '26' => array(
            'pid'   => '25',
            'title' => '新增',
            'url'   => 'Article/Admin/Footnav/add',
        ),
        '27' => array(
            'pid'   => '25',
            'title' => '编辑',
            'url'   => 'Article/Admin/Footnav/edit',
        ),
        '28' => array(
            'pid'   => '25',
            'title' => '设置状态',
            'url'   => 'Article/Admin/Footnav/setStatus',
        ),
        '29' => array(
            'pid'   => '2',
            'title' => '友情链接',
            'icon'  => 'fa fa-link',
            'url'   => 'Article/Admin/FriendlyLink/index',
        ),
        '30' => array(
            'pid'   => '29',
            'title' => '新增',
            'url'   => 'Article/Admin/FriendlyLink/add',
        ),
        '31' => array(
            'pid'   => '29',
            'title' => '编辑',
            'url'   => 'Article/Admin/FriendlyLink/edit',
        ),
        '32' => array(
            'pid'   => '29',
            'title' => '设置状态',
            'url'   => 'Article/Admin/FriendlyLink/setStatus',
        ),
        '33' => array(
            'pid'   => '2',
            'title' => '回收站',
            'icon'  => 'fa fa-recycle',
            'url'   => 'Article/Admin/Article/recycle',
        ),
        '34' => array(
            'pid'   => '33',
            'title' => '删除OR还原',
            'url'   => 'Article/Admin/Article/delete',
        ),
        '35' => array(
            'pid'   => '12',
            'title' => '编辑分类',
            'url'   => 'Article/Admin/Category/edit_with_tree',
        ),
        '36' => array(
            'pid'   => '16',
            'title' => '新增文章',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/add',
        ),
        '37' => array(
            'pid'   => '16',
            'title' => '编辑文章',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/edit',
        ),
        '38' => array(
            'pid'   => '16',
            'title' => '移动文章',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/move',
        ),
        '39' => array(
            'pid'   => '16',
            'title' => '回收站',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/recycle',
        ),
        '40' => array(
            'pid'   => '16',
            'title' => '删除OR还原',
            'icon'  => 'fa fa-edit',
            'url'   => 'Article/Admin/Article/delete',
        ),
    )
);
