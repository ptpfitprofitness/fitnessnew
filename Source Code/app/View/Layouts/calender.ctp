<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		layout, contains theme and its details
## *****************************************************************
header('Cache-Control: no-store, private, no-cache, must-revalidate');                  // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);    // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');                                       // Date in the past  
header('Expires: 0', false); 
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');
?>

<?php 
   /*echo $this->Html->css('css_web/style');	
	echo $this->Html->css('css_web/font');
	echo $this->Html->css('css_web/media');
	echo $this->Html->css('css_web/skin');
	echo $this->Html->css('css_web/jquery.notifyBar');*/
	echo $this->Html->css('css_web/fullcalendar');
	
?>


<?php echo $content_for_layout;?>

<? echo $this->element('sql_dump'); ?>