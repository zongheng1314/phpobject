<?php
// +----------------------------------------------------------------------
// | CoreThink [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.corethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com> <http://www.corethink.cn>
// +----------------------------------------------------------------------
namespace Article\Model;
use Think\Model;
/**
 * 文档类型
 * @author jry <598821125@qq.com>
 */
class SliderModel extends Model {
    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'article_slider';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,80', '类型标题长度为1-80个字符', self::EXISTS_VALIDATE, 'length'),
        array('title', '', '类型标题已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('slider_type', 'require', '请选择广告位置', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('cover', 'require', '请上传广告图片', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', 'require', '跳转链接不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('sort', 'require', '排序不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 获取幻灯列表
     * @author jry <598821125@qq.com>
     */
    public function getList($limit = 10, $order = null, $map = null) {
        $con["status"] = array("eq", '1');
        if ($map) {
            $map = array_merge($con, $map);
        }
        if (!$order) {
            $order = 'sort desc, id desc';
        }
        if(!$map){
            $map['status'] = array("eq",1);
        }
        $slider_list = $this->page(!empty($_GET["p"]) ? $_GET["p"] : 1, $limit)
                            ->order($order)
                            ->where($map)
                            ->select();
        return $slider_list;
    }
    
    //获取指定类型的广告内容
    public function get_data($limit = 4, $type = 51, $order = 'auc_article_slider.sort desc,auc_article_slider.id desc', $map = null){
   		$con['auc_article_slider.status'] = array('eq', '1');
   		$con['auc_article_slider.slider_type'] = $type;
        if ($map) {
            $map = array_merge($con, $map);
        } else {
        	$map = $con;
        }
    	$data_list = $this->field('auc_article_slider.title, auc_article_slider.url, UPLOAD.path')
    				 ->join('auc_admin_upload UPLOAD on auc_article_slider.cover = UPLOAD.id')
    				 ->where($map)->order($order)->limit($limit)->select();
    	return $data_list;
    }
}
