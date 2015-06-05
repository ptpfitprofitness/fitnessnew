<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view Clubcontact info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'clubs','action'=>'contact'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Contact',array('controller'=>'clubs','action'=>'contact'), array('title'=>'contacts','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
<?php //pr($clubInfo); ?>
		<div class="widget first">
			<div class="head"><h5 class="iList">View contacts</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'contact')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>	
			
			<div class="rowElem noborder"><label>Associated With(Club)<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['club_name']; ?>
			</div><div class="fix"></div></div>
					
			<div class="rowElem noborder"><label>Title<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['ClubContact']['title']; ?>
			</div><div class="fix"></div></div>
			
		
			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubContact']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Mobile:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubContact']['mobile']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			
			
			<div class="rowElem noborder">
				<label>Phone:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubContact']['phone']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>Date Enrolled:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubContact']['date_enrolled']; ?>
				</div>
				<div class="fix"></div>
			</div>
						
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
