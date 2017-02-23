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
 * 后台默认控制器
 * @author jry <598821125@qq.com>
 */
class IndexController extends AdminController {
    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index(){
        // 获取所有模块信息及后台菜单
        $con['status'] = 1;
        $system_module_list = D('Module')->where($con)->order('sort asc, id asc')->select();
        $tree = new tree();
        $menu_list = array();
        
        //获取用户组信息及其权限菜单
        $user_group = D('Admin/Access')->getFieldByUid(session('user_auth.uid'), 'group');
        $group_info = D('Admin/Group')->find($user_group);
        $group_auth = json_decode($group_info['menu_auth'], true);
        
        //遍历所有菜单并过滤该用户权限菜单
        foreach ($system_module_list as $key => &$module) {
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
            $menu_list[$module['name']]['id']   = $module['id'];
            $menu_list[$module['name']]['name'] = $module['name'];
            
        }
        
        
        
        // 如果模块顶级菜单配置了top字段则移动菜单至top所指的模块下边
        foreach ($menu_list as $key => &$value) {
            if ($value['top']) {
                if ($menu_list[$value['top']]) {
                    $menu_list[$value['top']]['_child'] = array_merge(
                        $menu_list[$value['top']]['_child'],
                        $value['_child']
                    );
                    unset($menu_list[$key]);
                }
            }
        }

       
        
        // 获取快捷链接
        $con = array();
        $con['status'] = 1;
        $link_list = D('Link')->where($con)->order('sort asc, id asc')->select();
        foreach ($link_list as $key => &$value) {
            if (!stristr($value['url'], 'http://') && !stristr($value['url'], 'https://')) {
                $value['url'] = U($value['url']);
            }
            //无权限取消显示的快捷菜单	zss
            if($group_info['id']!=1 and !in_array($value['id'], $group_auth['Admin']))unset($link_list[$key]);
        }
        
        $repass['url'] = '/index.php?s=/admin/Index/repass.html';
        $repass['id'] = 0;
        $repass['pid'] = 1;
        $repass['title'] = '修改密码';
        $repass['icon'] = 'fa-wrench';
        $link_list[] = $repass;
        
        $link_list = $tree->list_to_tree($link_list);

        // 模板变量赋值
     //   $this->assign('_link_list', $link_list);  // 后台快捷链接
        $this->assign('_menu_list', $menu_list);  // 后台左侧菜单
        $this->assign('meta_title', "首页");
        $this->display();
    }

    /**
     * 删除缓存
     * @author jry <598821125@qq.com>
     */
    public function removeRuntime() {
        $file = new \Common\Util\File();
        $result = $file->del_dir(RUNTIME_PATH);
        $this->success("缓存清理成功");
        die();
        if ($result) {
            $this->success("缓存清理成功");
        } else {
            $this->error("缓存清理失败");
        }
    }
    
    
    //修改密码	zss 2016/04/20
    public function repass(){
    	if(IS_POST){
    		if(empty($_POST['password']) or empty($_POST['new_password']) or empty($_POST['re_newpassword']))$this->error('请输入完整信息');
    		if($_POST['new_password'] != $_POST['re_newpassword'])$this->error('两次新密码不一致');
    		
    		$model = D('User/User');
    		$map['id'] = session('user_auth.uid');
    		$user_password = $model->field('password')->where($map)->find();
    		$post_password = user_md5($_POST['password']);
    		if(user_md5($_POST['new_password']) == $user_password['password'])$this->error('新旧密码不能相同');
    		if($post_password == $user_password['password']){
    			$save['password'] = user_md5($_POST['new_password']);
    			$check_password = $model->check_password($save['password']);
    			if($check_password){
    				$yesno = $model->where($map)->save($save);
    				if($yesno == false)$this->error('修改失败，请重试');
    				$this->success('修改成功！');
    			} else {
    				$this->error($model->getError());
    			}
    		} else {
    			$this->error('原密码错误');
    		}
    	} else {
    		 //使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增配置')  //设置页面标题
                    ->setPostUrl(U('repass')) //设置表单提交地址
                    ->addFormItem('password', 'password', '原密码', '请输入原用户密码')
                    ->addFormItem('new_password', 'password', '新密码', '请输入新密码')
                    ->addFormItem('re_newpassword', 'password', '确认新密码', '请再次输入新密码')
                    ->display();
    	}
    }
}
