<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Util\Tree;
/**
 * 部门控制器
 * @author jry <598821125@qq.com>
 */
class GroupController extends AdminController {
    /**
     * 部门列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        // 搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array(
            $condition,
            $condition,
            '_multi' => true
        );

        // 获取所有部门
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $data_list = D('Group')
                   ->where($map)
                   ->order('sort asc, id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户组列表')  // 设置页面标题
                ->addTopButton('addnew')   // 添加新增按钮
                ->addTopButton('resume')   // 添加启用按钮
                ->addTopButton('forbid')   // 添加禁用按钮
                ->addTopButton('delete')   // 添加删除按钮
                ->setSearch('请输入ID/用户组名称', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title_show', '用户组名称')
//                ->addTableColumn('icon', '图标', 'icon')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)  // 数据列表
                ->addRightButton('edit')        // 添加编辑按钮
                ->addRightButton('forbid')      // 添加禁用/启用按钮
                ->addRightButton('delete')      // 添加删除按钮
                ->alterTableData(  // 修改列表数据
                    array('key' => 'id', 'value' => '1'),
                    array('right_button' => '<a class="label label-warning">超级管理员无需操作</a>')
                )
                ->display();
    }

    /**
     * 新增部门
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $group_object = D('Group');
            $_POST['menu_auth']= json_encode(I('post.menu_auth'));
            $data = $group_object->create();
            if ($data) {
                $id = $group_object->add($data);
                if ($id) {
                    $this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($group_object->getError());
            }
        } else {
            // 获取现有部门
            $map['status'] = array('egt', 0);
            $all_group = select_list_as_tree('Group', $map, '顶级分组');

            // 获取功能模块的后台菜单列表	2016/05/06 全部输出  原来的 zss
            /*
            $tree = new Tree();
            $moule_list = D('Module')
                        ->where(array('status' => 1))
                        ->select();  // 获取所有安装并启用的功能模块
            $all_module_menu_list = array();
            foreach ($moule_list as $key => $val) {
                $temp = json_decode($val['admin_menu'], true);
                $menu_list_item = $tree->list_to_tree($temp);
                $all_module_menu_list[$val['name']] = $menu_list_item[0];
            }
			 $this->assign('all_module_menu_list', $all_module_menu_list);
            */
                        
             //2016-05-06 控制权限输出	开始   
            // 获取所有安装并启用的功能模块
            $moule_list = D('Module')
                        ->where(array('status' => 1))
                        ->select();
			$tree = new tree();
	        $menu_list = array();
	        //获取用户组信息及其权限菜单
	        $user_group = D('Admin/Access')->getFieldByUid(session('user_auth.uid'), 'group');
	        $group_info = D('Admin/Group')->find($user_group);
	        $group_auth = json_decode($group_info['menu_auth'], true);
	        
	        //遍历所有菜单并过滤该用户权限菜单
	        foreach ($moule_list as $key => &$module) {
	        	if($group_info['id']!=1){//非超管需过滤
	        		//判断该module是否在用户权限菜单中如没有跳出循环
		        	if(count($group_auth[$module['name']])<=0) continue;
		        	//获取所有菜单
		        	$all_menu=json_decode($module['admin_menu'], true);
		        	//循环过滤用户权限菜单
		        	foreach($all_menu as $kk=>$vv){
		        		if(!in_array($vv['id'], $group_auth[$module['name']])){
		        			unset($all_menu[$kk]);
		        		}
		        	}
	        	}else{
	        		$all_menu=json_decode($module['admin_menu'], true);
	        	}
	        	
	            $temp = $tree->list_to_tree($all_menu);
	            $menu_list[$module['name']] = $temp[0];
	            //  $menu_list[$module['name']]['id']   = $module['id'];	//未知错误。应该为1
	            $menu_list[$module['name']]['id']   = 1;
	            $menu_list[$module['name']]['name'] = $module['name'];
	        }
	        $this->assign('all_module_menu_list', $menu_list);
             //2016-05-06 控制权限输出	结束
            
           
            $this->assign('all_group', $all_group);
            $this->assign('meta_title', '新增用户组');
            $this->display('add_edit');
        }
    }

    /**
     * 编辑部门
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            $group_object = D('Group');
            $_POST['menu_auth']= json_encode(I('post.menu_auth'));
            $data = $group_object->create();
            if ($data) {
                if ($group_object->save($data)!== false) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($group_object->getError());
            }
        } else {
            // 获取部门信息
            $info = D('Group')->find($id);
            $info['menu_auth'] = json_decode($info['menu_auth'], true);

            // 获取现有部门
            $map['status'] = array('egt', 0);
            $all_group = select_list_as_tree('Group', $map, '顶级分组');

            // 获取所有安装并启用的功能模块
            $moule_list = D('Module')
                        ->where(array('status' => 1))
                        ->select();

            // 获取功能模块的后台菜单列表 2016/05/06 控制权限菜单输出	原来的
            /*
            $tree = new Tree();
            $all_module_menu_list = array();
            foreach ($moule_list as $key => $val) {
                $temp = json_decode($val['admin_menu'], true);
                $menu_list_item = $tree->list_to_tree($temp);
                $all_module_menu_list[$val['name']] = $menu_list_item[0];
            }
            
            $this->assign('all_module_menu_list', $all_module_menu_list);
			*/
                        
             //2016-05-06 控制权限输出	开始   
			$tree = new tree();
	        $menu_list = array();
	        //获取用户组信息及其权限菜单
	        $user_group = D('Admin/Access')->getFieldByUid(session('user_auth.uid'), 'group');
	        $group_info = D('Admin/Group')->find($user_group);
	        $group_auth = json_decode($group_info['menu_auth'], true);
	        //遍历所有菜单并过滤该用户权限菜单
	        foreach ($moule_list as $key => &$module) {
	        	if($group_info['id']!=1){//非超管需过滤
	        		//判断该module是否在用户权限菜单中如没有跳出循环
		        	if(count($group_auth[$module['name']])<=0) continue;
		        	//获取所有菜单
		        	$all_menu=json_decode($module['admin_menu'], true);
		        	//循环过滤用户权限菜单
		        	foreach($all_menu as $kk=>$vv){
		        		if(!in_array($vv['id'], $group_auth[$module['name']])){
		        			unset($all_menu[$kk]);
		        		}
		        	}
	        	}else{
	        		$all_menu=json_decode($module['admin_menu'], true);
	        	}
	        	
	            $temp = $tree->list_to_tree($all_menu);
	            $menu_list[$module['name']] = $temp[0];
	          //  $menu_list[$module['name']]['id']   = $module['id'];	//未知错误。应该为1
	            $menu_list[$module['name']]['id']   = 1;
	            $menu_list[$module['name']]['name'] = $module['name'];
	        }
	        $this->assign('all_module_menu_list', $menu_list);
             //2016-05-06 控制权限输出	结束   
            $this->assign('info', $info);
            $this->assign('all_group', $all_group);
            $this->assign('meta_title', '编辑用户组');
            $this->display('add_edit');
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author jry <598821125@qq.com>
     */
    public function setStatus($model = CONTROLLER_NAME){
        $ids = I('request.ids');
        if (is_array($ids)) {
            if(in_array('1', $ids)) {
                $this->error('超级管理员组不允许操作');
            }
        } else {
            if($ids === '1') {
                $this->error('超级管理员组不允许操作');
            }
        }
        parent::setStatus($model);
    }
}
