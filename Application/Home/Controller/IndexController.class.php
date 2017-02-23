<?php
namespace Home\Controller;
use Think\Controller;
use Common\Util\Think\Page;
class IndexController extends Controller {
    public function index(){
      
         $copyright = C('WEB_SITE_COPYRIGHT');
//         p($copyright);
         $this->assign('copyright',$copyright);
        // 页面文章
        $article_model = D('ArticleView');	
        $new = $article_model->get_article(1,6);
        $content = $new[0]['content'];
        $subject = strip_tags($content);//去除html标签
        $pattern = '/\s/';//去除空白
        $content = preg_replace($pattern, '', $subject);   
        $new[0]['content'] =  $content;
        
        if($new[0]['cover'] > 0 ){
         
            $this->assign('cover', $new[0]);            
        }
        else {
//               p($new[0]);
                $this->assign('cover', $new[0]);       
//            $cover_where['cover'] = array('gt', 0); //排除等于0的cover
//            $cover_where['cid'] = 1;
//            $cover_where['ArticleBase.status'] = array('neq', '-1');
//            $cover = $article_model->where($cover_where)->order('id desc')->find();//find取一条  select是取全部；
////            p($cover);
//            if($cover)$this->assign('cover', $cover);
       }
        
//        p($new[0]);
/*
         $where = $new[0]['cover'];
         $data_p = M('admin_upload')->where('id = '.$where)->find();
         
         if($data_p['path'] == ''){
             foreach ($new as $key => $value) {
                  if($value['cover'] != 0){
                    $photo_cover = $value['cover'];
                    $where = $photo_cover;
                    $data_p = M('admin_upload')->where('id = '.$where)->find();
                    $this->assign('data_p',$data_p);
                  }
             }     
         }
 
 */
//         p($data_p);
         $this->assign('data_p',$data_p);
         
	 $this->assign('news',$new);

        $notice = $article_model->get_article(2,9);
//        p($notice);
        $this->assign('notice',$notice);
        
        $youhui = $article_model->get_article(7,7);
        $this->assign('youhui',$youhui);
        
        $rencai = $article_model->get_article(8,7);
        $this->assign('rencai',$rencai);
        
        $keyan = $article_model->get_article(9,7);
        $this->assign('keyan',$keyan);
        
        $ruzhu = $article_model->get_article(10,8);
        $this->assign('ruzhu',$ruzhu);
        
        $article_detail = D('Article/Article');
        
    $category_model = D('Article/Category');
    $group_list = $category_model->getParentCategory(15);  
     
 
//    p($group_list);
    $this->assign('article_detail',$group_list[count($group_list)-1]);
        
        //首页广告
        $silder_model = D('Article/Slider');
        $pic = $silder_model->getList(3);
//        p($pic);
        foreach ($pic as $k => $value) {
            $where = $value['cover'];
            $data = M('admin_upload')->where('id = '.$where)->find();
            $pic[$k]['path'] = $data['path'];
//            p($data); 
//            $this->assign('data',$data);
        }
        $this->assign('pic',$pic);
        
        
 //园区概览
       $park = $article_model->get_article(5,6);
//       p($park);
       /*
         foreach ($park as $k => $value) {
            $where = $value['cover'];
            $data = M('admin_upload')->where('id = '.$where)->find();
            $park[$k]['path'] = $data['path'];
      //      p($data); 
//            $this->assign('data',$data);
        }
        * 
        */
       $this->assign('park',$park);
     /*
      * 友情链接
     */
     $friendly_link = D('article_friendly_link');
     $whe['status'] = array('eq', '1');
     $link_list = $friendly_link->where($whe)->order('sort desc, id desc')->select();
//     p($link_list);
      foreach ($link_list as $k => $value) {
            $map['id'] = $value['logo'];
//            $map['status'] = array('eq', '1');
//            p($map);
            $link_p = M('admin_upload')->where($map)->find();
            $link_list[$k]['path'] = $link_p['path'];
        }
     $this->assign('link_list',$link_list);
        $this->display();
    }
/*
 * 园区概览
 */    
public function volist(){
    
//    var_dump($_GET['pid']);
    $category_model = D('Article/Category');
    $group_list = $category_model->getParentCategory($_GET['pid']);
//     p($group_list);
    $this->assign('group_list',$group_list);
    $park_child = $category_model->getCategoryTree($_GET['pid']);
//       p($park_child);
    if($park_child && $park_child[0]['pid'] > 0){
        
        $this->assign('park_child',$park_child);
    }
/*   独立查询文章
    //点击子分类获取文章列表
 // $pid = $group_list[0]['id'];
    $article_model = D('ArticleView');	
    $article_list = $article_model->get_article($_GET['pid'],12);
    $this->assign('article_list',$article_list);
  */  
  
    //获取最新文章列表
        $article_model = D('Article/Article');
        $new_article_list = $article_model->getNewList();
    //    p($new_article_list);
       $this->assign('new_article_list',$new_article_list);

     if($group_list[count($group_list)-1]['doc_type'] == 3){
        //分页
        $limits = 12;
        $p = empty($_GET['p']) ? 1 : $_GET['p'];
        $map['cid'] = $_GET['pid'];
        $map['ArticleBase.status'] = array('neq', '-1');//查询文章状态=1
//        p($map);
        $atticle_model = D('ArticleView');
        $list = $atticle_model
            ->where($map)
            ->order('ArticleBase.sort desc,ArticleArticle.id desc')
            ->page($p, $limits)
            ->select();
    //    p($list);
        $page = new Page($atticle_model->where($map)->count(), $limits);
        $page->setConfig('next','下一页');
        $this->assign('artic_list',$list);
        $this->assign('page', $page->show());



    /*  
        //获取文章详情  
        foreach ($new_article_list as $key => $value) {
           $id = $value['id'];
    //       p($id);
           $article_detail = $article_model->detail($id);
    //       p($article_detail['previous']['href']);
    //       p($article_detail);
    //       p($article_detail['previous']);
           $new_article_list[$key]['href'] = $article_detail['previous']['href'];  
        }
   */     
        //获取分类
        $this->assign('article_detail',$group_list[count($group_list)-1]);
          $copyright = C('WEB_SITE_COPYRIGHT');
//         p($copyright);
           $this->assign('copyright',$copyright);
 
  
        $this->display('parkview');
    
    } else {
        
          $copyright = C('WEB_SITE_COPYRIGHT');
//         p($copyright);
           $this->assign('copyright',$copyright);
         $this->assign('article_detail',$group_list[count($group_list)-1]);
         $this->display('detail');
         
 
    }
}   

public function detail(){

          $copyright = C('WEB_SITE_COPYRIGHT');
//         p($copyright);
           $this->assign('copyright',$copyright);
    $article_model = D('Article/Article');
    $article_detail = $article_model->detail($_GET['id']);
//    p($article_detail);
   
    $cid = $article_detail['cid'];//拿到cid用于返回上级目录链接
    $up_title = $article_detail['category']['title'];
//    p($up_title);
    $this->assign('up_title',$up_title);
    
 //获取最新文章列表
    $new_article_list = $article_model->getNewList();
//    p($new_article_list);
    $this->assign('new_article_list',$new_article_list);
 //获取父目录
   $category_model = D('Article/Category');
    $group_list = $category_model->getParentCategory($cid);
//   p($group_list);
    $this->assign('group_list',$group_list);
    $pid = $group_list[0]['id']; //拿到pid用于查询子目录显示
//获取子目录
    $park_child = $category_model->getCategoryTree($pid);
    

//    if($article_detail['cid'] = $park_child['id']){
//       $on = TRUE;
//       $this->assign('is_on',$on);
//    }
    
//       p($park_child);
  if($park_child && $park_child[0]['pid'] > 0) $this->assign('park_child',$park_child);   
    
    $this->assign('article_detail',$article_detail);
          
    $this->display();
}

}