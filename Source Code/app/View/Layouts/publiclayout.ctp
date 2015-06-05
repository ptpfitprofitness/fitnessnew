<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		03/03/2014
##  Description :		layout, contains theme and its details
## *****************************************************************
header('Cache-Control: no-store, private, no-cache, must-revalidate');                  // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);    // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');                                       // Date in the past  
header('Expires: 0', false); 
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
header('Pragma: no-cache');

$kob=$this->params;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $config['base_title']; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 ">
<meta name="description" content="Free Web tutorials" />
<meta name="keywords" content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta http-equiv="EXPIRES" content="Mon, 03 March 2014 11:12:01 GMT">
<!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->

<?php 
	echo $this->Html->script('jquery-1.8.2.min.js');	
	
	echo $this->Html->script('front/js/jquery.slides.min');
	echo $this->Html->script('front/js/custom');
	echo $this->Html->script('front/js/functions');
	echo $this->Html->script('intlTelInput');
	//echo $this->Html->script('front/js/jquery.colorbox');
	echo $this->Html->script('front/js/jquery.colorbox-min');
	
	
	
	
	
?>

<!--<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
		<script type="text/javascript" src="js/daterangepicker.jQuery.js"></script>
		<link rel="stylesheet" href="css/ui.daterangepicker.css" type="text/css" />
		<link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />-->

<?php
    echo $this->Html->script('jquery.validationEngine-en.js');
	echo $this->Html->script('jquery.validationEngine.js'); 

?>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<?php 
    echo $this->Html->css('front/fonts');	
    echo $this->Html->css('front/font-awesome');	
    echo $this->Html->css('intlTelInput');	
    echo $this->Html->css('demo');	
   // echo $this->Html->css('front/jquery.h5-lightbox');	
    if($kob['action']=='scheduling_calendar')
    {
    	echo $this->Html->css('front/media_cal');
    }else {
    	echo $this->Html->css('front/media');
    }
    
    	
    echo $this->Html->css('front/slider');	
    echo $this->Html->css('front/style');	
    echo $this->Html->css('validationEngine.jquery.css');	
    echo $this->Html->css('colorbox.css');	

   
	
  
?>
 


</head>
<body>

<!--<div class="layer"></div>-->

<?php //echo $this->element('popups'); ?>

<!-- Start Wrapper -->
<div class="wrapper">

<!-- Start Header -->
<?php echo $this->element('headerpublic'); ?>
<!-- End Header -->

<?php echo $this->Session->flash(); ?>

<?php echo $content_for_layout;?>


       


<!-- Start Footer-bar --> 
<?php echo $this->element('publicfooter');?>
<!-- End Footer-bar --> 




<!-- End Wrapper -->


</body>
</html>
<?php echo $this->element('sql_dump'); ?>