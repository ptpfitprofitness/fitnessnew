<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		12/06/2014
##  Description :		IM session.
##	Copyright   :       SynapseIndia
## *****************************************************************

//$unms='Anilgodawat_Trainer';
$unms=$from;

?>
<link rel="stylesheet" type="text/css" href="<?php echo $config['url'];?>css/css_chat/chat.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['url'];?>css/css_chat/screen.css" />
<script type="text/javascript" src="<?php echo $config['url'];?>js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo $config['url'];?>js/chat_js/chatjs.php?uname=<?php echo $unms;?>"></script>             
    
<script>
chatWith('<?php echo $to;?>');
</script>
<a onclick="javascript:chatWith('<?php echo $to;?>')" href="javascript:void(0);"><img src="<?php echo $config['url'];?>images/widget_online_icon.gif"> <?php echo $to;?></a>