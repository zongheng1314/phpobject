<?php
namespace Admin\Controller;
use Common\Util\Tree;
use Common\Util\Think\Page;

class DepartmentController extends AdminController{
	
	//首页
	public function index(){
		if(isset($_REQUEST['keyword'])){
			$map['name']= array('like', '%'.$_REQUEST['keyword'].'%');
		}
		$department_object = M('Department');

		$p = !empty($_GET["p"]) ? $_GET['p'] : 1;
		$data = $department_object->where($map)->page($p, C('ADMIN_PAGE_ROWS'))->order('id desc')->select();
		$page = new Page(
            $department_object->where($map)->count(),
            C('ADMIN_PAGE_ROWS')
        );
        $this->assign('meta_title', '部门管理');
		$this->assign('list', $data);
		$this->assign('page', $page->show());
        $this->display();
        die();
        /*
		// 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('部门列表')  // 设置页面标题
                ->addTopButton('addnew')   // 添加新增按钮
                ->addTopButton('resume')   // 添加启用按钮
                ->addTopButton('forbid')   // 添加禁用按钮
                ->addTopButton('delete')   // 添加删除按钮
                ->setSearch('请输入部门名称', U('index'))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('department_name', '部门名称')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data)  // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')        // 添加编辑按钮
                ->addRightButton('delete')      // 添加删除按钮
                ->display();
                */
	}
	
	//新增页
	public function add(){
		
		if(IS_POST){
			if(empty($_POST['area'][1]))$this->error('请选择所在地址');
			$model = D('Department');
			$data = $model->create();
			
			if($data){
				//获取 部门地址 和  pid  PID带过两个参数，上级部门的ID和地址。如：2,0_1  区分判断后写入
				$pid = explode(',', $_POST['pid']);
				if($pid == 0){
					$data['pid'] = $pid;
					$data['depurl'] = $pid;
				} else {
					if(isset($pid[1])){
						$data['pid'] = $pid[0];
						$data['depurl'] = $pid[1].'_'.$pid[0];
					} else {
						$data['pid'] = $pid[0];
						$data['depurl'] = $pid[0];
					}
				}
				
				$data['areaurl'] = '0_'.implode('_', array_filter($_POST['area']));
				
				if($model->add($data)){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
				
			} else {
				$this->error($model->getError());	
			}
		} else {
			 // 获取现有部门
			$map['status'] = array('egt', 0);
            $all_group = $this->select_list_as_tree('Department', $map, '顶级部门' , 'id', 'name');
			$this->assign('all_group', $all_group);
			
			//获取地区(顶级)
			$area_model = M('Area');
			$all_area = $area_model->where('area_deep = 1')->order('area_sort')->select();
			$this->assign('all_area', $all_area);
			
			$this->display();
			die();
			/*
			 // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增部门') //设置页面标题
                    ->setPostUrl(U('add'))    //设置表单提交地址
                    ->addFormItem('department_name', 'text', '部门名称', '部门名称')
                    ->addFormItem('department_name', 'text', '部门名称', '部门名称')
                    ->addFormItem('department_name', 'text', '部门名称', '部门名称')
                    ->display();
                    */
		}
	}
	
	//编辑页
	public function edit(){
		if(IS_POST){
			if(empty($_POST['area'][1]))$this->error('请选择所在地址');
			$model = D('Department');
			$data = $model->create();
			
			if($data){
				//获取 部门地址 和  pid  PID带过两个参数，上级部门的ID和地址。如：2,0_1  区分判断后写入
				$pid = explode(',', $_POST['pid']);
				if($pid == 0){
					$data['pid'] = $pid;
					$data['depurl'] = $pid;
				} else {
					if(isset($pid[1])){
						$data['pid'] = $pid[0];
						$data['depurl'] = $pid[1].'_'.$pid[0];
					} else {
						$data['pid'] = $pid[0];
						$data['depurl'] = $pid[0];
					}
				}
				
				$data['areaurl'] = '0_'.implode('_', array_filter($_POST['area']));
				
				$model->save($data);
				M('Student')->where('school_id = '.I('id'))->save(array('dep_url'=>$data['depurl'].'_'.$data['id']));
				$this->success('修改成功', U('index'));
				
			} else {
				$this->error($model->getError());	
			}
		} else {
			//获取部门信息
			$data = M('Department')->find($_GET['id']);
			if($data == false)$this->error('未找到相应信息，请刷新后重试',U('index'));
			
			 // 获取现有部门
			$map['status'] = array('egt', 0);
			$map['id'] = array('neq', $data['id']);
            $all_group =  $this->select_list_as_tree('Department', $map, '顶级部门' , 'id', 'name');
			$this->assign('all_group', $all_group);
			
			//获取地区(顶级)
			$area_model = M('Area');
			$all_area = $area_model->where('area_deep = 1')->order('area_sort')->select();
			
			//获取地区并处理。部门的三级区域地址
			$area_ids =  explode('_', $data['areaurl']);
			$where['area_id'] = array('in', $area_ids);
			$department_area = $area_model->where($where)->order('area_sort')->select();
			foreach ($department_area as $k=>$v){
				$areas[$v['area_deep']] = $v;
				$area_id[$v['area_deep']] = $v['area_id'];
			}
			$this->assign('all_area', $all_area);
			$this->assign('areas', $areas);
			
			//二级区域
			if(!empty($area_ids[1])){
				$all_area_2 = $area_model->where('area_parent_id = '.$area_ids[1])->order('area_sort')->select();
				$this->assign('all_area_2', $all_area_2);
			}
			//三级区域
			if(!empty($area_ids[2])){
				$all_area_3 = $area_model->where('area_parent_id = '.$area_ids[2])->order('area_sort')->select();
				$this->assign('all_area_3', $all_area_3);
			}
			
			
			$this->assign('vo', $data);
			$this->display();
			die();
			/*
			$builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('修改部门信息') //设置页面标题
            		->setPostUrl(U('edit'))	//提交地址
            		->addFormItem('id', 'hidden')
            		->addFormItem('department_name', 'text', '部门名称', '部门名称')
            		->setFormData($data)
            		->display();
            		*/
		}
	}
	
	//给部门分配人员 周书森
	public function user_department(){
		if(IS_POST){
			$user_ids = $_POST['menu_auth'];
			if(empty($user_ids))$this->error('无数据，请选择数据后重试');
			$model = M('user_department');
			
			$departments_id = $_POST['id'];
			
			$model->where('department_id = '.$departments_id)->delete();
			
			foreach ($user_ids as $k => $v){
				$data['user_id'] = $v;
				$data['department_id'] = $departments_id;
				$model->add($data);						
			}
			$this->success('分配成功', U('index'));
		} else {
			$users = D('User')->where('status = 1 and id != 1')->select();
			$departments = M('user_department')->field('user_id as id')->where('department_id = '.$_GET['id'])->select();
			foreach ($departments as $k=>$v){
				$departments[$k] = $v['id'];
			}
			$this->assign('departments', $departments);
			$this->assign('all_user', $users);
			$this->display();
		}
		
	}
	
	
	//删除
	public function delete(){
		$ids = $_REQUEST['ids'];
		if(empty($ids))$this->error('请选择信息');
		if(is_array($ids)){
			$map['id'] = array('in', $ids);
			$dep_map['dep_id'] = array('in', $ids);
		} else {
			$map['id'] = $ids;
			$dep_map['dep_id'] = $ids;
		}
		
		M('Department')->where($map)->delete();
		M('SchoolConfig')->where($dep_map)->delete();
		$this->success('操作完成');
	}
	
	
/**
 * 获取下级城市
 * @author  周书森  2015/12/25
 */	
function get_area(){
	$model = M('Area');
	$map['area_parent_id'] = $_POST['id'];
	$map['area_deep'] = $_POST['area_deep'];
	$content = $model->where($map)->order('area_sort')->select();
	$this->ajaxReturn($content);
}	
	
/**
 * 获取所有数据并转换成一维数组
 * @author  周书森微改，便于获取部门地址
 */
function select_list_as_tree($model, $map = null, $extra = null, $key = 'id' , $title = 'title') {
    //获取列表
    $con['status'] = array('eq', 1);
    if ($map) {
        $con = array_merge($con, $map);
    }
    $model_object = D($model);
    if (in_array('sort', $model_object->getDbFields())) {
        $list = $model_object->where($con)->order('sort asc, id asc')->select();
    } else {
        $list = $model_object->where($con)->order('id asc')->select();
    }

    //转换成树状列表(非严格模式)
    $tree = new \Common\Util\Tree();
    $list = $tree->toFormatTree($list, $title, 'id', 'pid', 0, false);

    if ($extra) {
        $result[0]['val'] = $extra;
    }

    //转换成一维数组
    foreach ($list as $val) {
        $result[$val[$key].','.$val["depurl"]]['val'] = $val['title_show'];
        $result[$val[$key].','.$val["depurl"]]['url'] = $val['depurl'].'_'.$val['id'];
    }
    return $result;
}
}