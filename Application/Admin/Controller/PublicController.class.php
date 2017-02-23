<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\CommonController;
use Think\Verify;
/**
 * 后台唯一不需要权限验证的控制器
 * @author jry <598821125@qq.com>
 */
class PublicController extends CommonController {
    /**
     * 后台登陆
     * @author jry <598821125@qq.com>
     */
    public function login() {
    	
        if (IS_POST) {
            $username = I('username');
            $password = I('password');

            // 图片验证码校验
            if (!$this->check_verify(I('post.verify')) && $_SERVER['SERVER_NAME'] !== 'localhost') {
                $this->error('验证码输入错误！');
            }

            // 验证用户名密码是否正确
            $user_object = D('Admin/User');
            $user_info = $user_object->login($username, $password);
            if (!$user_info) {
                $this->error($user_object->getError());
            }

            // 验证管理员表里是否有该用户
            $account_object = D('Admin/Access');
            $where['uid'] = $user_info['id'];
            $account_info = $account_object->where($where)->getField('group',true);
            if (!$account_info) {
                $this->error('该用户没有管理员权限'.$account_object->getError());
            }

            // 设置登录状态
            $uid = $user_object->auto_login($user_info);
          		//赋值所属部门 不是管理员的   周书森  2015/12/31
          		if(!in_array(1, $account_info)){
	           		$dep_id = M('UserDepartment')
	           					->join('auc_department D on auc_user_department.department_id = D.id')
	           					->where('user_id ='.$uid)->find();
	           		
	           		session('dep_id', $dep_id['department_id']); //学校ID
	           		session('dep_url', $dep_id['depurl']);
          		} 
          	//赋值用户组
          	session('user_group', $account_info);
          	
            // 跳转
       //     if (0 < $account_info['uid'] && $account_info['uid'] === $uid) {
            if (!empty($account_info)) {
                $this->success('登录成功！', U('Admin/Index/index'));
            } else {
                $this->logout();
            }
        } else {
            $this->assign('meta_title', '管理员登录');
            $this->display();
        }
    }

    /**
     * 注销
     * @author jry <598821125@qq.com>
     */
    public function logout() {
        session('user_auth', null);
        session('user_auth_sign', null);
        $this->success('退出成功！', U('login'));
    }

    /**
     * 图片验证码生成，用于登录和注册
     * @author jry <598821125@qq.com>
     */
    public function verify($vid = 1) {
        $verify = new Verify();
        $verify->length = 4;
        $verify->entry($vid);
    }

    /**
     * 检测验证码
     * @param  integer $id 验证码ID
     * @return boolean 检测结果
     */
    function check_verify($code, $vid = 1) {
        $verify = new Verify();
        return $verify->check($code, $vid);
    }
}
