<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Util\Think\Page;
use Common\Util\Tree;
/**
 * 用户控制器
 * @author jry <598821125@qq.com>
 */
class UserController extends AdminController {
    /**
     * 用户列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        // 搜索
        $keyword   = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['auc_admin_user.id|auc_admin_user.username'] = array($condition, $condition, '_multi'=>true);
		$map['auc_admin_user.reg_type'] = 'admin';
        // 获取所有用户
        $map['auc_admin_user.status'] = array('egt', '0'); // 禁用和正常状态
        $p = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $user_object = D('User');
        $data_list = $user_object
        		 //  ->join('auc_admin_access A on auc_admin_user.id = A.uid')
        	//	   ->field('auc_admin_user.*,A.group')
                   ->page($p , C('ADMIN_PAGE_ROWS'))
                   ->where($map)
                   ->order('id desc')
                   ->select();
        $page = new Page(
            $user_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );
		
       			 //分配部门按钮参数数组  周书森
        		$my_attribute['title'] = '分配部门';
                $my_attribute['class'] = 'label label-primary';
                $my_attribute['href']  = U(
                    MODULE_NAME.'/'.CONTROLLER_NAME.'/user_department/',
                    array('id' => '__data_id__')
                );
                
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('用户列表') // 设置页面标题
                ->addTopButton('addnew')  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete', array('href'=>U(MODULE_NAME.'/'.CONTROLLER_NAME.'/delete')))  // 添加删除按钮
                ->setSearch('请输入ID/用户名', U('index'))
                ->addTableColumn('id', 'UID')
//                ->addTableColumn('avatar', '头像', 'picture')
                ->addTableColumn('nickname', '昵称')
                ->addTableColumn('username', '用户名')
//                ->addTableColumn('email', '邮箱')
                ->addTableColumn('mobile', '手机号')
                ->addTableColumn('create_time', '添加时间', 'time')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)    // 数据列表
                ->setTableDataPage($page->show()) // 数据列表分页
                ->addRightButton('edit')          // 添加编辑按钮
                ->addRightButton('forbid')        // 添加禁用/启用按钮
                ->addRightButton('delete', array('href'=>U(
                    MODULE_NAME.'/'.CONTROLLER_NAME.'/delete',
                    array(
                        'ids' => '__data_id__',
                    ))))        // 添加删除按钮
//                ->addRightButton('self',$my_attribute)        // 添加分配部门按钮
                ->display();
    }

    /**
     * 新增用户
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
            $user_object = D('User');
            $data = $user_object->create();
            if ($data) {
            	if(empty($_POST['group']))$this->error('请选择用户组');
            	$data['nickname'] = $_POST['username'];
                $id = $user_object->add($data);
                if ($id) {
                	//写入分组
                	$group_data['group'] = $_POST['group'];
                	$group_data['uid'] = $id;
                	$group_data['status'] = 1;
                	D('Access')->add($group_data);
                	//写入
                	$add_data['uid'] = $id;
                	$add_data['user_type'] = $_POST['user_type'];
                	M('UserPerson')->add($add_data);
                    
                //单位ID
                $model = M('user_department');
				$model->where('user_id = '.$id)->delete();
				$data['user_id'] = $id;
				$data['department_id'] = $_POST['dep_id'];
				$model->add($data);							

				$this->success('新增成功', U('index'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {
        	$data['reg_type'] = 'admin';
        	$data['user_type'] = 3;
        	$data['email'] = 'qq@qq.com';
        	
        	$map['status'] = array('egt', 0);
        	
        	//$deps = $this->select_list_as_tree('Department', $map, '顶级部门' , 'id', 'name');
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增用户') //设置页面标题
                    ->setPostUrl(U('add'))    //设置表单提交地址
                    ->addFormItem('reg_type', 'hidden', '注册方式', '注册方式')
                    ->addFormItem('user_type', 'hidden', '账号类别', '账号类别')
                    ->addFormItem('username', 'text', '用户名', '用户名')
                    ->addFormItem('password', 'password', '密码', '密码')
                    ->addFormItem('email', 'hidden', '邮箱', '邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '手机号')
                    ->addFormItem('group', 'select', '用户组', '不同用户组对应相应的权限', select_list_as_tree('Group'))
                    ->addFormItem('dep_id', 'select', '所属学校', '用户所属学校', select_list_as_tree('Department','','','id', 'name'))
                    ->setFormData($data)
                    ->display();
                    /*	原字段
                    ->setPostUrl(U('add'))    //设置表单提交地址
                    ->addFormItem('reg_type', 'hidden', '注册方式', '注册方式')
                    ->addFormItem('nickname', 'text', '昵称', '昵称')
                    ->addFormItem('user_type', 'radio', '账号类别', '账号类别', D('Admin/User')->user_type())
                    ->addFormItem('username', 'text', '用户名', '用户名')
                    ->addFormItem('password', 'password', '密码', '密码')
                    ->addFormItem('email', 'text', '邮箱', '邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '手机号')
                    ->addFormItem('avatar', 'picture', '头像', '头像')
                    ->setFormData(array('reg_type' => 'admin','user_type'=>1))
                    ->display();
                    */
        }
    }

    /**
     * 编辑用户
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            // 密码为空表示不修改密码
            if ($_POST['password'] === '') {
                unset($_POST['password']);
            }
        	if (empty($_POST['password'])) {
                unset($_POST['password']);
            }

            // 提交数据
            $user_object = D('User');
            $data = $user_object->create();
        	
            if ($data) {
           		if (empty($_POST['password'])) {
               	 	unset($data['password']);
            	} else {
            		$data['password'] = user_md5($data['password']);
            	}
                $result = $user_object
                        ->field('id,nickname,username,email,mobile,gender,avatar,update_time,password')
                        ->save($data);

                $re = D('Access')->where('uid = "'.$_POST['id'].'"')->find();
                $group_data['group'] = $_POST['group'];
	            $group_data['uid'] = $_POST['id'];
                if($re){
	                //更新分组
	                $result_2 = D('Access')->where('uid = '.$_POST['id'])->save($group_data);
                } else {
                	 //写入分组
	                $result_2 = D('Access')->add($group_data);
                }  

                //单位ID
                $model = M('user_department');
				$model->where('user_id = '.$id)->delete();
				$data['user_id'] = $id;
				$data['department_id'] = $_POST['dep_id'];
				$model->add($data);						
                    
                
                if ($result or $result_2) {
                	M('UserPerson')->where('uid = '.$id)->save(array('user_type'=>$_POST['user_type']));
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败', $user_object->getError());
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {
            // 获取账号信息
            $info = D('User')->find($id);
            $person = M('UserPerson')->where('uid = '.$id)->find();
            $group = M('AdminAccess')->where('uid = '.$id)->find();
            $dep_id = M('user_department')->where('user_id = '.$id)->find();
            $info['dep_id'] = $dep_id['department_id'];
            $info['user_type'] = $person['user_type'];
            $info['group'] = $group['group'];
            unset($info['password']);
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑用户')  // 设置页面标题
                    ->setPostUrl(U('edit'))    // 设置表单提交地址
                    ->addFormItem('id', 'hidden', 'ID', 'ID')
                    ->addFormItem('nickname', 'text', '昵称', '昵称')
//                    ->addFormItem('user_type', 'radio', '账号类别', '账号类别', D('Admin/User')->user_type())
                    ->addFormItem('username', 'text', '用户名', '用户名')
                    ->addFormItem('password', 'password', '密码', '密码')
                    ->addFormItem('email', 'hidden', '邮箱', '邮箱')
                    ->addFormItem('mobile', 'text', '手机号', '手机号')
                    ->addFormItem('group', 'select', '用户组', '不同用户组对应相应的权限', select_list_as_tree('Group'))
					->addFormItem('dep_id', 'select', '所属学校', '用户所属学校', select_list_as_tree('Department','','','id', 'name'))
                    //                    ->addFormItem('avatar', 'picture', '头像', '头像')
                    ->setFormData($info)
                    ->display();
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
                $this->error('超级管理员不允许操作');
            }
        } else {
            if($ids === '1') {
                $this->error('超级管理员不允许操作');
            }
        }
        parent::setStatus($model);
    }
    
    /**
     * 给用户分配部门
     * @author 周书森 2015/12/25
     */
    public function user_department(){
    	if(IS_POST){
    		$user_ids = $_POST['id'];
    		$dep_ids = array_filter(explode(',', $_POST['dep_ids']));
    		
    		if(count($dep_ids) > 1){
    			$this->error('只能选择一条信息');
    			die();	
    		}
    		
			if(empty($_POST['dep_ids']))$this->error('无数据，请选择数据后重试');
			
			$model = M('user_department');
			
			$model->where('user_id = '.$user_ids)->delete();
			
			foreach ($dep_ids as $k => $v){
				$data['user_id'] = $user_ids;
				$data['department_id'] = $v;
				$model->add($data);						
			}
			$this->success('分配成功', U('index'));
    	} else {
    		//第一层地区
	    	$model = M('Department');
	    	$departments = $model->where('pid = 0')->select();
	    	
	    	//查找用户已经分配到的部门
	    	$user_deps = M('UserDepartment')->where('user_id = '.$_GET['id'])->select();
	    	foreach ($user_deps as $k=>$v){
	    		$user_deps[$k] = $v['department_id'];
	    	}
	    	$this->assign('user_deps', $user_deps);
	    	$content = $model->select();
	    	$tree = new Tree();
	    	$contents = $tree->list_to_tree($content, 'id', 'pid');
	    	
	    	$this->assign('departments', $content);
	    	$this->display();
    	}
    }
	/**
	 * 获取部门
	 * @author 周书森  2015/15/26
	 */
	function get_department(){
		header("Content-Type: text/html;charset=utf-8");
		
		$model = M('Department');
		$ini = explode('_', $_GET['id']);
		$map['pid'] = $ini[0];
		$list = $model->where($map)->select();	
		$count = count($list);
		$i = 0;
		$con = "";
		foreach ($list as $k=>$v){
			$con .= '{id: "'.$v['id'].'", name:"'.$v['name'].'", isParent:true}';
			if($i < $count)$con .= ',';
		}
		$cons = "[$con]";
		echo $cons;
	}
    
    
	/**
	 * 获取下级城市
	 * @author  周书森  2015/12/25
	 */	
	function get_area(){
	header("Content-Type: text/html;charset=utf-8");
	
	$model = M('Area');
	$ini = explode('_', $_REQUEST['id']);
	$map['area_parent_id'] = $ini[0];
	$content = $model->where($map)->order('area_sort')->select();
	
	$pCount = count($content);
	$max = (int)$pCount;
	
	if($content == false){
		return false;
	} else {
		$con ="";
		$i = 0;
		if($content[0]['area_deep'] == 3){
			foreach ($content as $k=>$v){
				$con .=  "{ id:'".$v['area_id']."',	name:'".$v['area_name']."',}";
				$i++;
				if($i < $max){
					$con .= ',';
				}
			}
		} else {
			foreach ($content as $k=>$v){
				$con .=  "{ id:'".$v['area_id']."',	name:'".$v['area_name']."', isParent:true}";
				$i++;
				if($i < $max){
					$con .= ',';
				}
			}
		}
		
		$cons = '['.$con.']';
		echo $cons;
	}
}	
	
	//删除 2016-03-24 zss
	public function delete(){
		$ids = $_REQUEST['ids'];
		if(empty($ids))$this->error('请选择信息');
		if(is_array($ids)){
			$map['id'] = array('in', $ids);
			$map_2['uid'] = array('in', $ids);
		} else {
			$map['id'] = $ids;
			$map_2['uid'] = $ids;
		}
		M('AdminUser')->where($map)->delete();
		M('UserPerson')->where($map_2)->delete();
		M('AdminAccess')->where($map_2)->delete();
		$this->success('删除成功');
	}
	

}
