<?php
namespace Org\Util;
class Message {
	
	//api地址接口  参数?uid=ID&pwd=md5(密码)&mobile=手机号&msg=短信内容&dtime=时间
	private $apiurl = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/get_send_md5/";
	//获取余额接口url
	private $userinfourl = "http://www.smsadmin.cn/smsmarketing/wwwroot/api/user_info/";
	
	//用户账号
	public $uid = "sdxhrj";
	
	//用户密码
	public $password = "xinhaikejiju";
	
	//手机号码,多个发送用;隔开
	public $mobile = "";
	
	//短信内容不能超过70字
	public $msg = "";
	
	//发送时间
	public $dtime = "";
	
	//返回信息
	public $back = array (0 => "发送成功!", 1 => "用户名或密码错误!", 2 => "余额不足!", 3 => "超过发送最大量", 4 => "此用户不允许发送!", 5 => "手机号或发送信息不能为空!", 6 => "含有敏感字,请修改后发送!", 7 => "超过70个字,请修改后发送!" );
	
	//错误码
	public $errorcode = "";
	
	//验证参数
	public function init() {
		if ($this->uid == "") {
			return "用户名账号为空";
		//	exit ();
		} elseif ($this->password == "") {
			return "用户密码不能为空";
		//	exit ();
		} elseif ($this->mobile == "") {
			return ("手机号不能为空");
		//	exit ();
		} elseif ($this->msg == "") {
			return ("短信内容不能为空");
		//	exit ();
		}
	}
	
	//采用post方式发送短信
	public function send() {
		//简单参数验证	
		$this->init ();
		//生成发送url
		$sendurl = $this->apiurl . "?uid=" . $this->uid . "&pwd=" . md5 ( $this->password ) . "&mobile=" . rawurldecode($this->mobile) . "&msg=" . rawurldecode(iconv("utf-8", "gb2312", trim($this->msg))) . "&dtime=" . $this->dtime;
		
		//选项
		$opts = array ('http' => array ('method' => "POST" ) );
		//生成句柄
		$context=stream_context_create($opts);
		//获取信息
		$info = file_get_contents ( $sendurl,false,$context);
		//转码后重新赋值
		$info = iconv ( "gb2312", "UTF-8", $info );
		//设置返回码
		$this->errorcode = substr ( $info, 0, 1 );
	}
	
	
	//获取余额信息
	public function getuserinfo() {
		//生成发送url
		$sendurl = $this->userinfourl . "?uid=" . $this->uid . "&pwd=" . $this->password;
		//获取信息
		$info = file_get_contents ( $sendurl );
		//转码后重新赋值
		$info = iconv ( "gb2312", "UTF-8", $info );
		list ( , , $yue ) = split ( "=", $info );
		return $yue;
	}
	
	//获取消息码
	
	public function geterrorcode(){
		return $this->errorcode;
	}
	
	//获取错误信息
	public function geterror() {
		return $this->back [$this->errorcode];
	}

}

?>