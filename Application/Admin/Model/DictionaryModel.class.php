<?php
namespace Admin\Model;
use Think\Model;
/**
 * 2015/12/28  数据字典 MODEL
 * @author 周书森
 *
 */
class DictionaryModel extends Model{
	/**
     * 自动验证规则 
     */
    protected $_validate = array(
        array('value', 'require', '键值不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('tag', 'require', '标签不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('type', 'require', '类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('describe', 'require', '描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('sort', 'require', '排序不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );
    
    //获取指定类别并转为适合BULIDER的数组
    public function get_select($type){
    	$map['type'] = $type;
    	$list =  M('Dictionary')->where($map)->field('id,value')->select();
    	if($list == false)return false;
    	$data = "";
    	foreach($list as $k => $v){
    		$data[$v['id']] = $v['value'];
    	}
    	return $data;
    }
}