<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> View Video </title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body id="home">
<table width="100%" cellpadding="0" cellspacing="0" class="forPass1">
<tr>
<td width="100%" align="left">
<div class="forGotInner">
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td width="100%" class="width1 pleft1 subTxt">
		<form name="videoFrm" action="" method="POST"  onsubmit="">
		<table width="100%" cellspacing="0" cellpadding="6">
		<!-- playVideo START -->
		<tr>
			<td>
<div id="container">
						<a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.
					</div>
					<script type="text/javascript" src="<?php echo $config['url'];?>js/swfobject.js"></script>
					<script type="text/javascript">
						var s1 = new SWFObject("<?php echo $config['url'];?>movie_player.swf","mediaplayer","550","300","7");
						s1.addParam("allowFullScreen","true");
						s1.addParam("allowScriptAccess","sameDomain");
						//s1.addParam("scale","noscale");
						s1.addParam("salign","lt");
						//s1.addParam("wmode","transparent");
						s1.addParam("bgcolor","#000000");
						s1.addVariable("fileName","<?php echo $config['url'];?>plupload/<?php echo $videoname;?>");
						s1.addVariable("autoStart","false");
						s1.addVariable("image","");
						s1.addVariable("autoReSize","false");						
						s1.addVariable("winWidth","550");
						s1.addVariable("winHeight","300");
						s1.write("container");
					</script>
					
					
			</td>
		</tr>
		<tr><td><b><?php echo $setVideoArr['ExerciseLibrary']['doc_name'];?></b></td>
		</tr>
		<tr><td><p><?php echo $setVideoArr['ExerciseLibrary']['description'];?></p></td>
		</tr>
		<!-- playVideo END -->
		<tr>		
		<td colspan="2" align="center">
			<img src="<?php echo $config['url'];?>images/close.jpg" alt="Close" title="Close" onclick="javascript:window.close();" /> 
		</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
		</form>
	</div>
	</td>
	</tr>
	</table>
</td>
</div>
</tr>
<tr>
	<td width="100%" align="center">&nbsp;</td>
</tr>
</table>
</body>
</html>