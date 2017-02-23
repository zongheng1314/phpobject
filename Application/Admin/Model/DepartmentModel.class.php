<?php
namespace Admin\Model;
use Think\Model;
/**
 * 2015/12/28  数据字典 MODEL
 * @author 周书森
 *
 */
class DepartmentModel extends Model{
	/**
     * 自动验证规则 
     */
    protected $_validate = array(
        array('name', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('remark', 'require', '备注不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
       // array('area', 'area_check', '请最少选择一级管辖范围', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

}