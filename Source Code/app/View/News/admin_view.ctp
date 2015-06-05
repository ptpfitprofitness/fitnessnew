<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view club info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'news','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage News',array('controller'=>'news','action'=>'index'), array('title'=>'News','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View News</h5><a href="<?php echo $this->Html->url(array('controller'=>'news', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			
			
			<div class="rowElem noborder"><label>Heading<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $newInfo['New']['heading']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Description<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $newInfo['New']['description']; ?>
			</div><div class="fix"></div></div>					

			
			
			<div class="rowElem noborder">
				<label>Photo<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($newInfo['New']['logo'])) {
							if(!empty($newInfo['New']["logo"])) {?>								
									<img src="<?php echo $config['url']?>uploads/<?php echo $newInfo['New']["logo"];?>" width="50" height="50"/>
							
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
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
