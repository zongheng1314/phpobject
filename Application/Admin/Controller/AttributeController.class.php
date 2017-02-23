<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
use Common\Util\Think\Page;
/**
 * 属性管理 2015/12/28
 * @author 周书森
 *
 */
class AttributeController extends AdminController{
	//首页 第一级 属性
	public function index(){
		$model = D('AttrType');
		
		if(!empty($_REQUEST['keyword']))$map['type_name'] = array('like', '%'.$_REQUEST['keyword'].'%');
		
		$p = !empty($_GET['p']) ? $_GET['p'] : 1;
		$list = $model->where($map)->page($p, C('ADMIN_PAGE_ROWS'))->order('id desc')->select();
		$page = new Page($model->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		
		$this->assign('meta_title', '数据管理-顶级');
		$this->assign('list', $list);
		$this->assign('page', $page->show());
        $this->display();
	}
	
	//一级属性新增
	public function index_add(){
		if(IS_POST){
			$model = D('AttrType');
			$data = $model->create();
			if($data){
				if($model->add($data)){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败,请刷新后重试');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data['type_sort'] = 0;
			//快速生成页
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('新增属性')
					->setPostUrl(U('index_add'))
					->addFormItem('type_name', 'text', '属性类别', '属性类别')
					->addFormItem('type_sort', 'text', '分类排序', '用于排序')
					->addFormItem('remark', 'textarea', '属性描述','属性描述')
					->setFormData($data)
					->display();
		}
	}
	
	//一级属性编辑
	public function index_edit(){
		if(IS_POST){
			$model = D('AttrType');
			$data = $model->create();
			if($data){
				if($model->add($data)){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败,请刷新后重试');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data = M('AttrType')->find($_GET['id']);
			//快速生成页
			$builder = new \Common\Builder\FormBuilder();
			$builder->setMetaTitle('新增属性')
					->setPostUrl(U('index_add'))
					->addFormItem('id', 'hidden')
					->addFormItem('type_name', 'text', '属性类别', '属性类别')
					->addFormItem('type_sort', 'text', '分类排序', '用于排序')
					->addformItem('remark', 'textarea', '属性描述','属性描述')
					->setFormData($data)
					->display();
		}
	}
	
	//内页 第二级 属性
	public function attribute(){
		$model = D('Attribute');
		
		$map['type_id'] = $_REQUEST['id'];
		if(!empty($_REQUEST['keyword']))$map['attr_value'] = array('like', '%'.$_REQUEST['keyword'].'%');
		
		$p = !empty($_GET['p']) ? $_GET['p'] : 1;
		$list = $model->where($map)->page($p, C('ADMIN_PAGE_ROWS'))->order('id desc')->select();
		$page = new Page($model->where($map)->count(), C('ADMIN_PAGE_ROWS'));
		
		$this->assign('type_id', $_GET['id']);
		$this->assign('meta_title', '数据管理-二级');
		$this->assign('list', $list);
		$this->assign('page', $page->show());
        $this->display();
	}
	
//二级属性新增
	public function attribute_add(){
		if(IS_POST){
			$model = D('Attribute');
			$data = $model->create();
			if($data){
				if(empty($_POST['value'][0]))$this->error('请最少添加一个属性值');
				$data['attr_value'] = implode(',', $_POST['value']);
				$id = $model->add($data);
				if($id){
					$value = $_POST['value'];
					$sort = $_POST['sort'];
					
					$v_model = M('AttributeValue');
					
					foreach ($value as $k => $v){
						$v_data['type_id'] = $_POST['type_id'];
						$v_data['attr_id'] = $id;
						$v_data['attr_value_sort'] = $sort[$k];
						$v_data['attr_value_name'] = $v;
						$v_model->add($v_data);
					}
					
					$this->success('新增成功', U('attribute',array('id'=>$_POST['type_id'])));
				} else {
					$this->error('新增失败,请刷新后重试');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data['type_id'] = $_GET['type_id'];
			$this->display();
			die();
		}
	}
	
	//二级属性编辑
	public function attribute_edit(){
		if(IS_POST){
			$model = D('Attribute');
			$data = $model->create();
			if($data){
				if(empty($_POST['value'][0]))$this->error('请最少添加一个属性值');
				$data['attr_value'] = implode(',', $_POST['value']);
				$id = $model->save($data);
				if($id){
					$value = $_POST['value'];
					$sort = $_POST['sort'];
					
					$v_model = M('AttributeValue');
					
					$v_model->where('attr_id = '.$_POST['id'])->delete();
					
					foreach ($value as $k => $v){
						$v_data['type_id'] = $_POST['type_id'];
						$v_data['attr_id'] = $_POST['id'];
						$v_data['attr_value_sort'] = $sort[$k];
						$v_data['attr_value_name'] = $v;
						$v_model->add($v_data);
					}
					$this->success('更新成功', U('attribute',array('id'=>$_POST['type_id'])));
				} else {
					$this->error('更新失败,请刷新后重试');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data = M('Attribute')->find($_GET['id']);
			$this->assign('vo', $data);
			
			//子分类
			$list = M('AttributeValue')->where('attr_id = '.$data['id'])->select();
			$this->assign('list', $list);
			$this->display();
		}
	}
	
	/**
	 * 删除  带层数删除
	 * @author 周书森
	 * 
	 */
	public function delete(){
		if(is_array($_REQUEST['ids'])){
			$ids = $_REQUEST['ids'];
		} else {
			$ids[0] = $_REQUEST['ids'];
		}
		
		if($_GET['deep'] == 1){		//三层深时
			$where['id'] = array('in', $ids);
			$if = M('AttrType')->where($where)->delete();
			if($if == false)$this->error('删除失败，请刷新重试');
			$where_2['type_id'] = array('in', $ids);
			M('Attribute')->where($where_2)->delete();
			M('AttributeValue')->where($where_2)->delete();
			$this->success('删除成功', U('index'));
		} else {
			$where['id'] = array('in', $ids);
			$if = M('Attribute')->where($where)->delete();
			if($if == false)$this->error('删除失败，请刷新重试');
			$where_2['attr_id'] = array('in', $ids);
			M('AttributeValue')->where($where_2)->delete();
			$this->success('删除成功', U('index',array('id'=>$_GET['type_id'])));
		}
	}
	
}
