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
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $config['base_title']; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1 ">
<meta name="description" content="Free Web tutorials" />
<meta name="keywords" content="">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="PRAGMA" content="NO-CACHE">
<meta http-equiv="EXPIRES" content="Mon, 22 Jul 2002 11:12:01 GMT">
<!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<?php 
    echo $this->Html->css('css_web/style');	
     echo $this->Html->css('css_web/polyglot-language-switcher');	
	echo $this->Html->css('css_web/font');
	echo $this->Html->css('css_web/media');
	echo $this->Html->css('css_web/skin');
	echo $this->Html->css('css_web/jquery.notifyBar');
	//echo $this->Html->css('ui-lightness/jquery-ui-1.8.16.custom.css');
	
	echo $this->Html->script('js_web/jquery.min');
	//echo $this->Html->script('js_web/jquery-ui-1.8.16.custom.min.js');
	echo $this->Html->script('js_web/html5');
	echo $this->Html->script('js_web/selectmain');
	echo $this->Html->script('js_web/jquery.jcarousel.min');
	echo $this->Html->script('js_web/jquery.notifyBar');	
	echo $this->Html->script('js_web/functions');
	echo $this->Html->script('js_web/script');	
	echo $this->Html->script('js_web/jquery-ui-1.10.0.custom.min');	
	echo $this->Html->script('js_web/jquery-rating');	
	
	//echo $this->fetch('css');
	//echo $this->fetch('script');
?>

<link rel="stylesheet" type="text/css" href="css/skin.css" />
<script> 
$(document).ready(function(){
  $("#pane").click(function(){
    $("#slide").slideToggle("slow");
  });
});
</script>
<?php echo $this->Html->script('js_web/jquery.custom_radio_checkbox'); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
$(".radio").dgStyle();
$(".checkbox").dgStyle();
$(".checkbox1").dgStyle();
});
</script>
<script>
function galleryPopOpen(str){
//alert('#'+str);
$('.galleryCont').css('display','none');
$('#'+str).fadeIn('slow');
}
// Popoup Script	
function popupOpen(str){
//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
$('#'+str).css('display','block');
$('.layer').css('display','block');

$('#'+str).animate({"opacity":"1"}, 300);
$('#'+str).css('z-index','9999');
$('#container').css({"opacity": "0.4"});	
}
function popupClose(str){
$('#'+str).stop().animate({"opacity":"0"}, 300);
$('.layer').css('display','none');

$('#'+str).css({"display": "none"});			
$('#container').stop().animate({ "opacity": "1"}, 300);
$('#'+str).css({"display": "none"});
}

// Popoup Script for Invite Specialist	
function popupOpen2(str,str2){
//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
$('#'+str).css('display','block');
$('#InvitationReceiverId').val(str2);
$('.layer').css('display','block');

$('#'+str).animate({"opacity":"1"}, 300);
$('#'+str).css('z-index','9999');
$('#container').css({"opacity": "0.4"});	
}

// Popoup Script for Email Session Reply	
function popupOpen3(str,str2,str3,str4,str5){
//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
popupClose('pop15');
$('#'+str).css('display','block');
$('#MessageParentIds').val(str2);
$('#MessageSenderIds').val(str3);
$('#MessageReceiverIds').val(str4);
$('#MessageSenderBys').val(str5);
$('.layer').css('display','block');

$('#'+str).animate({"opacity":"1"}, 300);
$('#'+str).css('z-index','9999');
$('#container').css({"opacity": "0.4"});	
}


// Popoup Script for Buy Session	
function popupOpen9(str,str2){
//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
$('#'+str).css('display','block');
/*$('#InvitationReceiverId').val(str2);*/
$('.layer').css('display','block');

$('#'+str).animate({"opacity":"1"}, 300);
$('#'+str).css('z-index','9999');
$('#container').css({"opacity": "0.4"});	
$('#bysessd').html('<img src="<?php echo $this->Html->url('/images');?>/loading-serv.gif" />');
 
	if(str2!='')
	{
	$.ajax({
	            type: "POST",
	            url: "<?php echo $config["url"]?>specialist/servicepr/"+str2,
	            data:str2,
	            success: function(res) {
	            	//alert(res);
	            	$('#bysessd').html(res);
	                //console.log(res);
	            }
	            
	        });
}

}

</script>
</head>
<body>
<?php if($this->Session->check('Message.flash')) {  
	 echo "<script>$(function() { $.notifyBar({ cls: 'success', html: '".$this->Session->flash()."' }) });</script>";
 }?>
<div class="layer"></div>

<?php if(!$this->Session->read('USER_ID')) { ?>
<?php echo $this->element('popups'); ?>
<? } ?>

<!-- Start Wrapper -->
<section id="wrapper">

<!-- Start Header -->
<?php echo $this->element('header'); ?>
<!-- End Header -->

<?php echo $content_for_layout;?>

<!-- Start add-bar --> 
<?php echo $this->element('addbar'); ?>
<!-- End add-bar -->	         


<!-- Start Footer-bar --> 
<?php echo $this->element('footer');?>
<!-- End Footer-bar --> 

<?php echo $this->element('copyfooter');?>

</section>
<!-- End Wrapper -->


</body>
</html>
<? echo $this->element('sql_dump'); ?>