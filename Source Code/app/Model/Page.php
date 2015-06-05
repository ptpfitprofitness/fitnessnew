<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		Model, for mapping database tables to the objects
## *****************************************************************
class Page extends AppModel{
	public $name = 'Page';
	
	public $validate = array(
		'page_title' => array(
			 'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter page title'),
		),
		'page_slug' => array(
			 'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter page title'),
			 'slug' => array('rule' => array('alphaNumericDashUnderscore'), 'last'=>true, 'message' => 'Slug can only be letters, numbers, dash and underscore'),
			 'unique'=>array('rule'=>array('isUnique','on'=>'create'),'last'=>true, 'message' => 'Slug should be unique. '),
		),
		'page_content' => array(
			'required' => array('rule' => array('notEmpty'), 'last'=>true, 'message' => 'Please enter page content'),
		),
	);
	public function alphaNumericDashUnderscore($check) {
        $value = array_values($check);
        $value = $value[0];
        return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
    }
}
?>
