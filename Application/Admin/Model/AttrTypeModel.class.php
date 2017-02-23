<?php
namespace Admin\Model;
use Think\Model;
class AttrTypeModel extends Model{
	protected $_validate = array(
		array('type_name', 'require', '请填写属性类别'),
		array('type_sort', 'require', '请填写分类排序'),
		array('remark', 'require', '请填写属性描述'),
	);
}