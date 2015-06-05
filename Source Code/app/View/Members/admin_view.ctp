<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'members','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Members',array('controller'=>'members','action'=>'index'), array('title'=>'Members','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Member</h5><a href="<?php echo $this->Html->url(array('controller'=>'members', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $memberInfo['Member']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $memberInfo['Member']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Preferred Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $memberInfo['Member']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Helpler's Email<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['helplers_email']))
							echo $memberInfo['Member']['helplers_email']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Zip code<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['zip_code']) )
							echo $memberInfo['Member']['zip_code']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>School<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['school_name']))
							echo $memberInfo['Member']['school_name']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Class<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['school_class'])) 
							echo $memberInfo['Member']['school_class']; 
						else
							echo "-"; 							
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Image<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['logo'])) {
							if(!empty($memberInfo["Member"]["logo"])) {
								if(preg_match("/fbcdn-profile/",$memberInfo["Member"]["logo"])) { ?>
									<img src="<?php echo $memberInfo["Member"]["logo"];?>" width="50" height="50"/>
							<?php 	}else{ ?>	
									<img src="<?php echo $config['url']?>users/<?php echo $memberInfo["Member"]["logo"];?>" width="50" height="50"/>
							<?php 	} ?>
						<?php 	}else{ ?>
									<img src="<?php echo $config['url']?>img/marketplace/placeholder-large.gif" width="50" height="50" alt="" />
						<?php 	}
						}else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Video<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['video'])){ ?>
							<a href="<?php echo $memberInfo["Member"]["video"];?>" id="players" class="player"></a>
				<?php	}else{
							echo "-"; 
						}
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Skills<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['skills']))
							echo implode(" <br/> ",unserialize($memberInfo['Member']['skills']));
						else
							echo "-";
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Travel<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['travel'])){
							echo implode(" <br/> ",unserialize($memberInfo['Member']['travel']));						
						}						
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>About me<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($memberInfo['Member']['about_me']))
							echo $memberInfo['Member']['about_me']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
<script>
	var videopath = "<?php echo $config["url"];?>users/videos";
	var swfplayer = "<?php echo $config["url"];?>webroot/flowplayer/videos/flowplayer-3.1.1.swf";
	
	playVideo();
	
	function playVideo(){
		$(".player").each(function(){
			$f( $(this).attr("id"),"http://releases.flowplayer.org/swf/flowplayer-3.2.15.swf", {
				clip: {
						// use baseUrl so we can play with shorter file names
						baseUrl: '<?php echo $config["url"];?>users/videos/',
						// use first frame of the clip as a splash screen
						autoPlay: false,
						autoBuffering: true
					}
			});	
		});	
	}
</script>
<style>.player{width:393px;height:263px;}</style>