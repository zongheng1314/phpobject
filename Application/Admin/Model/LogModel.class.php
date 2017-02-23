<?php
/**
 *日志模块
 *zss 20160716 11:00 
 */
namespace Admin\Model;
use Think\Model;

class LogModel extends Model{
	protected  $tableName = 'admin_log';
	
	
	/**
	 * 新增日志
	 */
	public function add_log(){
		$menu_info = D('Admin/Module')->getCurrentMenu(); // 当前菜单
		if(empty($menu_info))return false;
		$data['menu_url'] = $menu_info['url'];
		$data['menu_name'] = $menu_info['title'];
		$data['uid'] =  session('user_auth.uid');
		$data['username'] = session('user_auth.username');
		$data['add_time'] = time();
		$data['key'] = $_SERVER['REQUEST_URI'];
		$this->add($data);
	}
}