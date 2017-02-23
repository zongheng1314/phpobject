<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{
	protected $_validate = array(
		array('attr_name', 'require', '请填写属性类别'),
		array('attr_sort', 'require', '请填写分类排序'),
	);
}