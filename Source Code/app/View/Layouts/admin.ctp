<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		layout, contains theme and its details
## *****************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Panel</title>
    
    <!-- Include CSS -->
	<?php echo $this->Html->css('reset'); ?>
	<?php echo $this->Html->css('main'); ?>
	<?php echo $this->Html->css('wysiwyg'); ?>
	<?php echo $this->Html->css('dataTable'); ?>
	<?php echo $this->Html->css('fullcalendar'); ?>
	<?php echo $this->Html->css('elfinder'); ?>
	<?php echo $this->Html->css('colorpicker'); ?>
	<?php echo $this->Html->css('icons'); 
	echo $this->Html->css('ui-lightness/jquery-ui-1.8.16.custom.css');
	echo $this->Html->css('jquery.autocomplete');
	?>
	
	<script type="text/javascript">
	var site_url = '<?php echo $config['url']; ?>';
	var site_img_url = '<?php echo $config['url']; ?>app/webroot/img/';
	</script>
	
    <!-- Inculude JS -->
	<?php
		
		echo $this->Html->script('platform/jquery-1.6.1.min');
		echo $this->Html->script('platform/jquery.stylish-select');
	?>
	
	<?php echo $this->Html->script('spinner/jquery.mousewheel'); ?>
	<?php echo $this->Html->script('spinner/ui.spinner'); ?>
	
	<?php echo $this->Html->script('forms/forms'); ?> 
	<?php echo $this->Html->script('forms/autogrowtextarea'); ?> 
	<?php echo $this->Html->script('forms/autotab'); ?> 
	<?php echo $this->Html->script('forms/jquery.validationEngine-en'); ?> 
	<?php echo $this->Html->script('forms/jquery.validationEngine'); ?> 
	
	<?php echo $this->Html->script('ui/progress'); ?>
	<?php echo $this->Html->script('ui/jquery.jgrowl'); ?>
	<?php echo $this->Html->script('ui/jquery.tipsy'); ?>
	<?php echo $this->Html->script('ui/jquery.alerts'); ?>
	
	<?php echo $this->Html->script('custom'); ?> 
	<?php echo $this->Html->script('admin_custom'); ?> 
	<?php echo $this->Html->script('platform/myfunction'); 
	echo $this->Html->script('js_web/jquery-ui-1.8.16.custom.min.js');
	?> 
	
	<?php
		/* Including files for the datepicker process*/
			echo $this->Html->script('calendar/jquery.ui.core');
			echo $this->Html->script('calendar/jquery.ui.widget');
			echo $this->Html->script('calendar/jquery.ui.datepicker');
			echo $this->Html->css('calendar/jquery-ui');
			echo $this->Html->css('calendar/demos');
			echo $this->Html->css('calendar/mdp'); 
			echo $this->Html->script('calendar/jquery-ui.multidatespicker'); 
		/* Including files for the datepicker process*/
		
			echo $this->Html->script('jquery.autocomplete');
		
	?>	
	<?php

		echo $this->Html->css('admin_menu');		
	?>
	<?php echo $this->fetch('css'); ?>
	<?php echo $this->fetch('script'); ?> 

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

</head>
<body>

<!-- Top navigation bar -->
<div id="topNav">
    <div class="fixed">
        <div class="wrapper" style="width:1000px;">
            <div class="welcome"><img alt="" src="http://www.ptpfitpro.com/images/logo.png">
            	<?php //echo $this->Html->image('platform/logo.png');?>
            </div>
            <div class="userNav">
            	<?php echo "Logged in as ".ucfirst($this->Session->read('Admin.Admin.name')); ?></span>&nbsp;|&nbsp;<?php echo date('l, F j, Y');?>&nbsp;|&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'updateprofile')); ?>" title="Update Profile"><span>Update Profile</span></a>&nbsp;|&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'changepassword')); ?>" title="Change Password"><span>Change Password</span></a>&nbsp;|&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'logout')); ?>" title="Logout"><span>Log Out</span></a>
               
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>
<div id="header" class="wrapper" >
 <?php /* ?>  <ul class="menuTemplate1 decor1_1" license="mylicense"> 
		<li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_index') {  ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'index')); ?>">Dashboard</a></li> 
		<li class="separator"></li> 
		<li <?php if($this->params['controller'] == 'clubs'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'index')); ?>">Manage Clubs</a></li>		
		<li class="separator"></li>
		<li <?php if($this->params['controller'] == 'corporations'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'index')); ?>">Manage Corporations</a></li>		
		<li class="separator"></li>  
		
			<li <?php if($this->params['controller'] == 'trainers'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'index')); ?>">Manage Trainers</a></li>		
		<li class="separator"></li>  
		
		<li <?php if($this->params['controller'] == 'trainees'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>">Manage Trainees</a></li>		
		<li class="separator"></li>  
		
		<li <?php if($this->params['controller'] == 'pages'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'pages', 'action'=>'index')); ?>">Manage Pages Content</a></li>		
		<li class="separator"></li> 
		<li <?php if($this->params['controller'] == 'faqs'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'faqs', 'action'=>'index')); ?>">Manage FAQ</a></li>		
		<li class="separator"></li> 
		
		
		
	</ul>
	<?php */?>
</div> 

<!-- Content wrapper -->
<div class="wrapper">
	<div class="leftSidebar">
	<?php
	//pr($this->params);
	?>
		<ul class=""> 
		<li <?php if($this->params['controller'] == 'users' && $this->params['action'] == 'admin_index') {  ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'index')); ?>">Dashboard</a></li> 
		
		<li <?php if($this->params['controller'] == 'clubs' && ($this->params['action'] == 'admin_index'|| $this->params['action'] == 'admin_add'|| $this->params['action'] == 'admin_edit' ||$this->params['action'] == 'admin_view')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'index')); ?>">Manage Clubs</a></li>
		<li <?php if($this->params['controller'] == 'clubs' && ($this->params['action'] == 'admin_branch'|| $this->params['action'] == 'admin_addbranch'|| $this->params['action'] == 'admin_editbranch' ||$this->params['action'] == 'admin_viewbranch')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'branch')); ?>">Manage Club Branches</a></li>	
		<li <?php if($this->params['controller'] == 'clubs' &&  ($this->params['action'] == 'admin_contact'|| $this->params['action'] == 'admin_addcontact'|| $this->params['action'] == 'admin_editcontact' ||$this->params['action'] == 'admin_viewcontact')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'admin_contact')); ?>">Manage Club Contacts</a></li>	
		
		<?php if($corporationshow==1){?>
		
		<li <?php if($this->params['controller'] == 'corporations'&& ($this->params['action'] == 'admin_index'|| $this->params['action'] == 'admin_add'|| $this->params['action'] == 'admin_edit' ||$this->params['action'] == 'admin_view')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'index')); ?>">Manage Corporations</a></li>
		
		<li <?php if($this->params['controller'] == 'corporations' &&  ($this->params['action'] == 'admin_branch'|| $this->params['action'] == 'admin_addbranch'|| $this->params['action'] == 'admin_editbranch' ||$this->params['action'] == 'admin_viewbranch')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'admin_branch')); ?>">Manage Corporation Branches</a></li>		
		 
		
		<li <?php if($this->params['controller'] == 'corporations' &&  ($this->params['action'] == 'admin_contact'|| $this->params['action'] == 'admin_addcontact'|| $this->params['action'] == 'admin_editcontact' ||$this->params['action'] == 'admin_viewcontact')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'admin_contact')); ?>">Manage Corporation Contacts</a></li>
		
		
		
			<li <?php if($this->params['controller'] == 'employees'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'employees', 'action'=>'index')); ?>">Manage Employees</a></li>	
			<?php }?>
			<li <?php if($this->params['controller'] == 'certificationorganizations' &&  ($this->params['action'] == 'admin_index'|| $this->params['action'] == 'admin_add'|| $this->params['action'] == 'admin_edit' ||$this->params['action'] == 'admin_view')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'admin_index')); ?>">Manage Certification Organization</a></li>
			
			<li <?php if($this->params['controller'] == 'certificationorganizations' &&  ($this->params['action'] == 'admin_certification'|| $this->params['action'] == 'admin_addcertification'|| $this->params['action'] == 'admin_editcertification' ||$this->params['action'] == 'admin_viewcertification')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'admin_certification')); ?>">Manage Certification</a></li>
			
			<li <?php if($this->params['controller'] == 'certificationorganizations' &&  ($this->params['action'] == 'admin_degree'|| $this->params['action'] == 'admin_adddegree'|| $this->params['action'] == 'admin_editdegree' ||$this->params['action'] == 'admin_viewdegree')){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'admin_degree')); ?>">Manage Degrees</a></li>
			
			<li <?php if($this->params['controller'] == 'trainers'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'index')); ?>">Manage Trainers</a></li>		
			
				<li <?php if($this->params['controller'] == 'packages'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'packages', 'action'=>'index')); ?>">Manage Trainers Session Packages</a></li>		
	
	
		
		<li <?php if($this->params['controller'] == 'trainees'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>">Manage Clients</a></li>		
		  
		
		<li <?php if($this->params['controller'] == 'pages'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'pages', 'action'=>'index')); ?>">Manage Pages Content</a></li>		
		
		<li <?php if($this->params['controller'] == 'faqs'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'faqs', 'action'=>'index')); ?>">Manage FAQs</a></li>
		<li <?php if($this->params['controller'] == 'Managemails'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'Managemails', 'action'=>'index')); ?>">Manage Mails</a></li>
		<li <?php if($this->params['controller'] == 'news'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'news', 'action'=>'index')); ?>">Manage News</a></li>		
		
		<li <?php if($this->params['controller'] == 'nutritionals'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'nutritionals', 'action'=>'index')); ?>">Manage Nutritionals Guide</a></li>	
		
		<li <?php if($this->params['controller'] == 'foods'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'foods', 'action'=>'food')); ?>">Manage Food Log</a></li>
		
		<li <?php if($this->params['controller'] == 'librarys'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'librarys', 'action'=>'exerciselibrary')); ?>">Manage Exercise Library</a></li>
		
		<li <?php if($this->params['controller'] == 'helpguides'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'helpguides', 'action'=>'helpguide')); ?>">Manage Help Guide</a></li>
		
		<li <?php if($this->params['controller'] == 'subscriptions'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions', 'action'=>'index')); ?>">Manage Subscriptions</a></li>	
		<li <?php if($this->params['controller'] == 'subscriptions'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'Forms', 'action'=>'index')); ?>">Manage Forms</a></li>	
		<li <?php if($this->params['controller'] == 'index'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'index', 'action'=>'contactrequest')); ?>">Manage Contact Query</a></li>
		<li <?php if($this->params['controller'] == 'coupons'){ ?> class="selected" <?php } ?> ><a href="<?php echo $this->Html->url(array('controller'=>'coupons', 'action'=>'index')); ?>">Manage Coupons</a></li>
		
		</ul>
	</div>
	<div class="rightSidebar">
	<?php echo $this->fetch('content'); ?>
	</div>
	<div style="clear:both;"></div>
	<div class="fix"></div>
</div>
	<div class="fix"></div>
	<!-- Footer -->
	<div id="footer">
		<div class="wrapper">
			<span>&copy; Copyright <?php echo date("Y");?>. All rights reserved. Powered by <a href="#" title="">SynapseIndia</a></span>
		</div>
	</div>
<style>
.swfupload{margin-left:-121px;}
.ui_tpicker_minute_label{margin-top:60px!important;}
</style>
</body>
</html>
<?php if(Configure::read('debug')>0) echo $this->element('sql_dump'); ?>