<?php
/**
 * 2015/12/29 
 * 测试的一个MODEL
 * @author 周书森
 *
 */
namespace Admin\Model;
use Think\Model\ViewModel;

class AuctionAttsViewModel extends ViewModel{
	protected  $viewFields = array(
     'AttrType'=>array('id','_type'=>'LEFT'),
     'Attribute'=>array('id'=>'attr_id', '_on'=>'Attribute.type_id=AttrType.id','_type'=>'LEFT'),
     'AttributeValue'=>array('id'=>'val_id', '_on'=>'AttributeValue.attr_id=Attribute.id'),
   );
	
}