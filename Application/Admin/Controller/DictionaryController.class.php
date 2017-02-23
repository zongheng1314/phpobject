<?php
/**
 * 2015/12/28 
 * @author 周书森
 */
namespace Admin\Controller;

use Common\Util\Think\Page;

class DictionaryController extends AdminController{
	
	//首页
	public function index(){
		$model = D('Dictionary');
		if(!empty($_REQUEST['keyword'])){
			$map['describe'] = array('like', '%'.$_REQUEST['keyword'].'%');
			$maps['describe'] = $_REQUEST['keyword'];
		}
		if(!empty($_REQUEST['type'])){
			$map['type'] = $_REQUEST['type'];
			$maps['type'] = $_REQUEST['type'];
		}
		
		//获取所有类型
		$types = $model->field('type')->group('type')->select();
		$this->assign('types', $types);
		
		$p = !empty($_GET["p"]) ? $_GET['p'] : 1;
		$list = $model->where($map)->page($p, C('ADMIN_PAGE_ROWS'))->order('id desc')->select();
		$page = new Page(
			$model->where($map)->count(), C('ADMIN_PAGE_ROWS')
		);
		
		$this->assign('meta_title', '字典列表');
		$this->assign('list', $list);
		$this->assign('page', $page->show());
        $this->display();
	}
	
	//新增页
	public function add(){
		if(IS_POST){
			$model = D('Dictionary');
			$data = $model->create();
			if($data){
				if($model->add($data)){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data['sort'] = 0;
			 // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增字典') //设置页面标题
                    ->setPostUrl(U('add'))    //设置表单提交地址
                    ->addFormItem('value', 'text', '键值', '键值')
                    ->addFormItem('tag', 'text', '标签', '标签')
                    ->addFormItem('type', 'text', '类型', '类型')
                    ->addFormItem('describe', 'text', '描述', '描述')
                    ->addFormItem('sort', 'text', '排序', '排序')
                    ->setFormData($data)
                    ->display();
		}
	}
	
	//添加键值
	public function add_value(){
		if(IS_POST){
			$model = D('Dictionary');
			$data = $model->create();
			if($data){
				if($model->add($data)){
					$this->success('新增成功', U('index'));
				} else {
					$this->error('新增失败');
				}
			} else {
				$this->error($model->getError());
			}
		} else {
			$data = M('Dictionary')->field('tag,type,describe')->find($_GET['id']);
			$data['sort'] = 0;
			 // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增字典') //设置页面标题
                    ->setPostUrl(U('add'))    //设置表单提交地址
                    ->addFormItem('value', 'text', '键值', '键值')
                    ->addFormItem('tag', 'text', '标签', '标签')
                    ->addFormItem('type', 'text', '类型', '类型')
                    ->addFormItem('describe', 'text', '描述', '描述')
                    ->addFormItem('sort', 'text', '排序', '排序')
                    ->setFormData($data)
                    ->display();
		}
	}
	
	//修改页
	public function edit(){
		if(IS_POST){
				$model = D('Dictionary');
				$data = $model->create();
				if($data){
					if($model->save($data)){
						$this->success('修改成功', U('index'));
					} else {
						$this->error('修改失败');
					}
				} else {
					$this->error($model->getError());
				}
			} else {
				$model = D('Dictionary');
				$data = $model->find($_GET['id']);
				// 使用FormBuilder快速建立表单页面。
	            $builder = new \Common\Builder\FormBuilder();
	            $builder->setMetaTitle('修改字典') //设置页面标题
	                    ->setPostUrl(U('edit'))    //设置表单提交地址
	                    ->addFormItem('id', 'hidden')
	                    ->addFormItem('value', 'text', '键值', '键值')
	                    ->addFormItem('tag', 'text', '标签', '标签')
	                    ->addFormItem('type', 'text', '类型', '类型')
	                    ->addFormItem('describe', 'text', '描述', '描述')
	                    ->addFormItem('sort', 'text', '排序', '排序')
	                    ->setFormData($data)
	                    ->display();
			}
	}
	
	
	//删除
	public function delete(){
		$ids = $_REQUEST['ids'];
		if(empty($ids))$this->error('请选择信息');
		if(is_array($ids)){
			$map['id'] = array('in', $ids);
		} else {
			$map['id'] = $ids;
		}
		
		M('Dictionary')->where($map)->delete();
		$this->success('操作完成');
	}
	
}