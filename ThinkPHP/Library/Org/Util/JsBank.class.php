<?php
/**
 * 建设银行端口类
 * @author zss 
 * 20160719 14:04
 * 参数后缀带 Y 的为必须。	N为非必须
 */

use Think\Crypt\Driver\Base64;
class JsBank {
	/*交易类型
	 * 	1 MD5 方式
	 *  2 秘钥接口
	 *  3 防钓鱼接口
	 *  默认为普通MD5方式
	 */
	public $INTERFACE = 1;
	
	//银行网址	Y
	public $BANKURL = 'https://ibsbjstar.ccb.com.cn/app/ccbMain';
	
	//商户代码	CHAR(15)	Y
	public $MERCHANTID = '';
	
	//柜台代码	CHAR(9)	Y
	public $POSID = '';
	
	//分行代码	CHAR(9)	Y
	public $BRANCHID = '';
	
	//定单号	CHAR(30)	Y
	public $ORDERID = '';
	
	//付款金额	NUMBER(16,2)	Y	
	public $PAYMENT = '';
	
	//币种  默认：01   01 = 人民币	CHAR(2)	Y
	public $CURCODE = '01';
	
	//交易码	由建行统一分配为520100	CHAR(6)	Y
	public $TXCODE = '520100';
	
	/*
	//备注1	CHAR(30)	N
	public $REMARK1 = '';
	
	//备注2	CHAR(30)	N
	public $REMARK2 = '';
	*/
	
	//校验码 采用标准MD5按顺序排列加密所有所需参数(除MAC外)		Y
	public $MAC = '';

	//公钥后三十位	CHAR(30)	防钓鱼接口Y
	public $PUB = '';
	
	//密钥	CHAR(30) 	密钥型接口Y	复用商户公钥前30位，只在MD5摘要时使用，不作为参数传递。
	public $PUB32 = '';
	
	//网关类型    详细请查看手册->GATEWAY设置说明部分。	VARCHAR(100)	N
	public $GATEWAY = '';
	
	//客户端IP	CHAR(40)	N
	public $CLIENTIP = '';
	
	//客户在商户系统中注册的信息，中文需使用escape编码	CHAR(256)	N
	public $REGINFO = '';
	
	//所购商品信息	CHAR(256)	N
	public $PROINFO = '';	
	
	//商户URL	CHAR(100)	N	商户送空值即可，银行从后台读取商户设置的一级域名，如www.ccb.com则设为： “ccb.com”，最多允许设置三个不同的域名，格式为：****.com| ****.com.cn|****.net）
	public $REFERER = '';
	
	/*分期期数	CHAR(2)	N	
	 * 信用卡支付分期期数，一般为3、6、12等，必须为大于1的整数，
	 * 当分期期数为空或无该字段上送时，则视为普通的网上支付当分期期数为空或无该字段上送时，
	 * 该字段不参与MAC校验，否则参与MAC校验。
	*/
	public $INSTALLNUM = '';
	
	/*	客户端标识		CHAR(40)	N
	 * 商户客户端的intent-filter/schema，格式如下：
		comccbpay+商户代码(即MERCHANTID字段值)+商户自定义的标示app的字符串
		商户自定义的标示app的字符串，只能为字母或数字。
		示例：
		comccbpay105320148140002alipay
		当该字段有值时参与MAC校验，否则不参与MAC校验。
	 */
	public $THIRDAPPINFO = '';
	
	//必须参数的数组	TYPE为 1 (防钓鱼接口) 时，还需要 PUB(公钥后三十位)的必须验证
	private $mustArray = array('MERCHANTID', 'POSID', 'BRANCHID', 'ORDERID', 'PAYMENT', 'CURCODE', 'TXCODE', 'MAC', 'TYPE');
	
	/*
	 * 验证必须信息
	 * 通过返回1
	 */
	public function CheckMust(){
		foreach ($this->mustArray as $k => $v){
			if(empty($this->$v))return $v.'不能为空'; 
		}
		if($this->TYPE == 1){
			if(empty($this->PUB))return 'PUB不能为空';
		}
		return 1;
	}
	
	//生成URL
	public function AddUrl(){
		//默认	MD5方式
		
		$REQUEST_RI = '
			MERCHANTID='.$this->MERCHANTID.'
			&POSID='.$this->POSID.'
			&BRANCHID='.$this->BRANCHID.'
			&ORDERID='.$this->ORDERID.'
			&PAYMENT='.$this->PAYMENT.'
			&CURCODE='.$this->CURCODE.'
			&TXCODE='.$this->TXCODE.'
			&REMARK1=&REMARK2=';
		
		$MD5_REQUEST_RI = $REQUEST_RI;
		//秘钥加密类型 
		if($this->INTERFACE == 2){
			
			$INTERFACE_2 = '&PUB32='.$this->PUB32;	//复用商户公钥前30位，只在MD5摘要时使用，不作为参数传递。
			
			$MD5_REQUEST_RI = $REQUEST_RI.$INTERFACE_2;
		}
		
		//防钓鱼类型
		if($this->INTERFACE == 3){
			
			/*
			 * &REGINFO='.$this->js_escape($this->REGINFO).'
			   &PROINFO='.$this->js_escape($this->PROINFO).'
			 * */
			
			$INTERFACE_3 = '
				&TYPE=1
				&PUB='.$this->PUB.'
				&GATEWAY='.$this->GATEWAY.'
				&CLIENTIP='.$this->CLIENTIP.'
				&REGINFO='.$this->js_escape($this->REGINFO).'
			    &PROINFO='.$this->js_escape($this->PROINFO).'
				&REFERER='.$this->REFERER;
			
			$MD5_REQUEST_RI = $REQUEST_RI.$INTERFACE_3;
			
			$REQUEST_RI .= '
				&TYPE=1
				&GATEWAY='.$this->GATEWAY.'
				&CLIENTIP='.$this->CLIENTIP.'
				&REGINFO='.$this->js_escape($this->REGINFO).'
			    &PROINFO='.$this->js_escape($this->PROINFO).'
				&REFERER='.$this->REFERER;
		}
		
		$REQUEST_RI = $this->trimall($REQUEST_RI);
		$MD5_REQUEST_RI = $this->trimall($MD5_REQUEST_RI);
		
		$url = $this->BANKURL.'?'.$REQUEST_RI.'&MAC='.md5($MD5_REQUEST_RI);
		return $url;
	}
	
	
	/**
	 * 生成XML查询链接
	 * 20160725
	 * @version $pos_id 柜台号
	 * @version $order_data 订单时间YYYYMMDD
	 * @version $begin_time 开始时间 ,格式00:00:00
	 * @version $end_time 结束时间,格式23:59:59
	 * @version $begin_orderid 开始订单号
	 * @version $end_orderid 结束订单号
	 * @version $qupwd 查询密码
	 * @version $sel_type 返回方式,默认XML返回
	 */
	public function XmlSelect_OrderInfo($pos_id, $order_date, $begin_time = '00:00:00', $end_time = '23:59:59', $begin_orderid, $end_orderid, $qupwd, $sel_type = 3){
		$data['MERCHANTID'] = $this->MERCHANTID;
		$data['BRANCHID'] = $this->BRANCHID;
		$data['POSID'] = $pos_id;
		$data['ORDERDATE'] = $order_date;
		$data['BEGORDERTIME'] = $begin_time;
		$data['ENDORDERTIME'] = $end_time;
		$data['BEGORDERID'] = $begin_orderid;
		$data['ENDORDERID'] = $end_orderid;
		$data['QUPWD'] = '';
		$data['TXCODE'] = 410400;
		$data['SEL_TYPE'] = $sel_type;
		$data['OPERATOR'] = '';
		
		$url_data = urldecode(http_build_query($data));
		$mac = md5($url_data);
		$data['MAC'] = $mac;
		$data['QUPWD'] = $qupwd;
		
		$info = $this->send_post($this->BANKURL, $data);
		return $info;
	}
	
	/** 
	 * 发送post请求 
	 * @param string $url 请求地址 
	 * @param array $post_data post键值对数据 
	 * @return string 
	 */  
	public function send_post($url, $post_data) {  
	  $postdata = http_build_query($post_data);  
	  $options = array(  
	    'http' => array(  
	      'method' => 'POST',  
	      'header' => 'Content-type:application/x-www-form-urlencoded',  
	      'content' => $postdata,  
	      'timeout' => 15 * 60 // 超时时间（单位:s）  
	    )  
	  );  
	  $context = stream_context_create($options);  
	  $result = file_get_contents($url, false, $context);  
	  return $this->characet($result);  
	}  
	
	    /**
	     * 转为UTF-8
	     * */
	public function characet($data){
		  if( !empty($data) ){
		    $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
		    if( $fileType != 'UTF-8'){
		      $data = mb_convert_encoding($data ,'utf-8' , $fileType);
		    }
		  }
		  return $data;
		}
			
	
	//escape 加密
	public function js_escape($string = '', $encoding = 'UTF-8'){
		$return = '';
			    for ($x = 0; $x < mb_strlen($string, $encoding); $x ++) {
			    $str = mb_substr($string, $x, 1, $encoding);
			    if (strlen($str) > 1) { // 多字节字符
			    $return .= '%u' . strtoupper(bin2hex(mb_convert_encoding($str, 'UCS-2', $encoding)));
			    } else {
			    $return .= '%' . strtoupper(bin2hex($str));
			    }
		    }
	    return $return;
	}
	
	//删掉所有空格
	function trimall($str)//删除空格
	{
	    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
	    return str_replace($qian,$hou,$str);    
	}
	
	//中文转为字节用MD5加密
	function bin2hex_md5($str){
		if (preg_match("/[\x7f-\xff]/", $str)) 
		 {
		    return bin2hex($str); 
		    
		 }
		 else
		 {
		     return $str;
		 }
		
	}
	
}


	