<?php
/*
 * 用于按照类别获取文章列表
 */
namespace Home\Model;
use Think\Model\ViewModel;
class ArticleViewModel extends ViewModel{
	protected  $viewFields = array(
		'ArticleArticle' => array('id','title','content','cover','_type'=>'LEFT'),
		'ArticleBase' => array('cid','create_time','_on'=>'ArticleArticle.id = ArticleBase.id','_type'=>'LEFT'),
                'AdminUpload' => array('path', '_on' => 'ArticleArticle.cover = AdminUpload.id')
	);
	
	//获取文章列表  CID=cid（分类ID）
	public function get_article($cid, $limits){
		$map['cid'] = $cid;
		$map['ArticleBase.status'] = array('neq', '-1');
		$list = D('ArticleView')->where($map)->order('ArticleBase.sort desc,ArticleArticle.id desc')->limit($limits)->select();
		return $list;
	}
}