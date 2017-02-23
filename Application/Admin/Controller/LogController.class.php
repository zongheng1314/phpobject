<?php
/**
 * 日志模块
 * zss 20160716 11:23
 */
namespace Admin\Controller;
use Admin\Controller\AdminController;
use Common\Util\Think\Page;

class LogController extends AdminController{
	
	public function index(){
		
		$p = $_GET['p'] ? $_GET['p'] : 1;
		
		if(!in_array(1, session('user_group'))){
			$map['uid'] = is_login();
		}
		
		$model = D('Log');
		$rows = C('ADMIN_PAGE_ROWS');
		$data_list = $model->where($map)->page($p,$rows)->order('id desc')->select();
		$page = new Page($model->where($map)->count(), $rows);
		
		// 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('管理员列表')  // 设置页面标题
                ->addTopButton('delete')   // 添加删除按钮
                ->setSearch('请输入用户名', U('index'))
//                ->addTableColumn('id', 'ID')
                ->addTableColumn('uid', '用户ID')
                ->addTableColumn('username', '用户名')
                ->addTableColumn('menu_name', '操作')
                ->addTableColumn('key', 'URL')
                ->addTableColumn('add_time', '时间', 'time')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('delete')         // 添加删除按钮
                ->display();
	}
}