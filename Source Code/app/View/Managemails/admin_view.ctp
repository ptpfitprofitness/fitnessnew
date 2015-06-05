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
		<h5><?php echo $this->Html->link('Home',array('controller'=>'Managemails','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Mails',array('controller'=>'Managemails','action'=>'index'), array('title'=>'Manage Mail','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Mails</h5><a href="<?php echo $this->Html->url(array('controller'=>'Managemails', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Mails Type<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $ManagemailInfo['Managemail']['mails_type']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Subject<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $ManagemailInfo['Managemail']['subject']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Content<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $ManagemailInfo['Managemail']['content']; ?>
			</div><div class="fix"></div></div>			

			
			</div>
			
			
			<div class="fix"></div>
			
			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
