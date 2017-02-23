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
 * 分类模型
 * @author jry <598821125@qq.com>
 */
class CategoryModel extends Model {
    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'article_category';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title', 'require', '名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('title', '1,32', '名称长度为1-32个字符', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
        array('title', 'checkTitle', '名称已经存在', self::MUST_VALIDATE, 'callback', self::MODEL_INSERT),
        array('group', 'require', '分组不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('doc_type', 'require', '内容模型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('url', '0,255', '链接长度为0-25个字符', self::EXISTS_VALIDATE, 'length',self::MODEL_BOTH),
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
     * 前台用户投稿权限(不影响后台)
     * @author jry <598821125@qq.com>
     */
    public function post_auth($id) {
        $list[0] = '禁止投稿';
        $list[1] = '允许投稿';
        return $id ? $list[$id] : $list;
    }

    /**
     * 栏目分组
     * @author jry <598821125@qq.com>
     */
    public function group_list() {
        return parse_attr(C('article_config.group_list'));
    }

    /**
     * 检查同一分组下是否有相同的字段
     * @author jry <598821125@qq.com>
     */
    protected function checkTitle() {
        $map['title'] = array('eq', I('post.title'));
        $map['group'] = array('eq', I('post.group'));
        $result = $this->where($map)->find();
        return empty($result);
    }

    /**
     * 获取参数的所有父级分类
     * @param int $cid 分类id
     * @return array 参数分类和父类的信息集合
     * @author jry <598821125@qq.com>
     */
    public function getParentCategory($cid, $group = 1) {
        if (empty($cid)) {
            return false;
        }
        $con['status'] = 1;
        $con['group']  = $group;
        $category_list = $this->where($con)->field('id,pid,group,title,url')->select();
        $current_category = $this->field('id,pid,group,title,url,doc_type,content,update_time')->find($cid); //获取当前分类的信息
        $result[] = $current_category;
        $pid = $current_category['pid'];
        while (true) {
            foreach ($category_list as $key => $val) {
                if ($val['id'] == $pid) {
                    $pid = $val['pid'];
                    array_unshift($result, $val); //将父分类插入到数组第一个元素前
                }
            }
            if ($pid == 0 || count($result) == 1) { //已找到顶级分类或者没有任何父分类
                break;
            }
        }
        return $result;
    }

    /**
     * 获取分类树，指定分类则返回指定分类的子分类树，不指定则返回所有分类树，指定分类若无子分类则返回同级分类
     * @param  integer $id    分类ID
     * @param  boolean $field 查询字段
     * @return array          分类树
     * @author jry <598821125@qq.com>
     */
    public function getCategoryTree($id = 0, $limit = null, $group = 1, $field = true) {
        //获取当前分类信息
        if ((int)$id > 0) {
            $info = $this->find($id);
            $id   = $info['id'];
        }
        //获取所有分类
        $map['status'] = array('eq', 1);
        $map['group']  = array('eq', $id ? $info['group'] : $group);
        $tree = new \Common\Util\Tree();
        $list = $this->field($field)->where($map)->order('sort asc, id asc')->select();
        $list = $tree->list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = (int)$id); //返回当前分类的子分类树
        if ($limit) {
            $list = array_slice($list, 0, $limit);
        }
       
        if (!$list) {
            return $this->getSameLevelCategoryTree($id);
        }
        return $list;
    }

    /**
     * 获取同级分类树
     * @param  integer $id    分类ID
     * @return array          分类树
     * @author jry <598821125@qq.com>
     */
    public function getSameLevelCategoryTree($id = 0) {
        //获取当前分类信息
        if ((int)$id > 0) {
            $info = $this->find($id);
            $parent_info = $this->find($info['pid']);
            $id   = $info['id'];
        }
        //获取所有分类
        $map['status'] = array('eq', 1);
        $map['pid']    = array('eq', $info['pid']);
        $map['group']  = array('eq', $info['group']);
        $tree = new \Common\Util\Tree();
        $list = $this->field($field)->where($map)->order('sort asc')->select();
        return $list;
    }
}