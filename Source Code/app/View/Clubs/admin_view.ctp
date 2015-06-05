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
		<h5><?php echo $this->Html->link('Home',array('controller'=>'clubs','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Clubs',array('controller'=>'clubs','action'=>'index'), array('title'=>'Clubs','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Club</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Club Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['club_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Username<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['username']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Phone<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['phone']; ?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['Club']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['Club']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['Club']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['Club']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['Club']['zip']) )
							echo $clubInfo['Club']['zip']; 
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
					if(!empty($clubInfo['Club']['notification_status']) && ($clubInfo['Club']['notification_status'])==1)
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
					<?php echo $clubInfo['Club']['date_enrolled']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>No. Of Trainer<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['Club']['no_trainer']))
							echo $clubInfo['Club']['no_trainer']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Logo<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['Club']['logo'])) {
							if(!empty($clubInfo["Club"]["logo"])) {?>								
									<img src="<?php echo $config['url']?>uploads/<?php echo $clubInfo["Club"]["logo"];?>" width="50" height="50"/>
							
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
