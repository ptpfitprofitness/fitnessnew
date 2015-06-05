<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view Corporation info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'corporations','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Corporations',array('controller'=>'corporations','action'=>'index'), array('title'=>'Corporations','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Corporation</h5><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Company Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $corporationInfo['Corporation']['company_name']; ?>
			</div><div class="fix"></div></div>
			
						

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $corporationInfo['Corporation']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			
			<div class="rowElem noborder"><label>Username<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $corporationInfo['Corporation']['username']; ?>
			</div><div class="fix"></div></div>
		
			
			<div class="rowElem noborder"><label>Phone<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $corporationInfo['Corporation']['phone']; ?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $corporationInfo['Corporation']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $corporationInfo['Corporation']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $corporationInfo['Corporation']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($corporationInfo['Corporation']['zip']) )
							echo $corporationInfo['Corporation']['zip']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Notification Status:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
					if(!empty($corporationInfo['Corporation']['notification_status']) && ($corporationInfo['Corporation']['notification_status'])==1)
					{
						echo "Yes";
					} 
					else {
						echo "No";
					}
					
					
					?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			
			<div class="rowElem noborder">
				<label>Date Enrolled:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $corporationInfo['Corporation']['date_enrolled']; ?>
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
