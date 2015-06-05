<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view ClubBranch info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'clubs','action'=>'branch'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Branchs',array('controller'=>'clubs','action'=>'branch'), array('title'=>'Branches','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
<?php //pr($clubInfo); ?>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Branches</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'branch')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>	
			
			<div class="rowElem noborder"><label>Associated With(Club)<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Club']['club_name']; ?>
			</div><div class="fix"></div></div>
					
			<div class="rowElem noborder"><label>Username<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['ClubBranch']['username']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Branch Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['ClubBranch']['branch_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['ClubBranch']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['ClubBranch']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubBranch']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubBranch']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>Phone:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubBranch']['phone']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>Notification Status:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
					if(!empty($clubInfo['ClubBranch']['notification_status']) && ($clubInfo['ClubBranch']['notification_status'])==1)
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
					<?php echo $clubInfo['ClubBranch']['date_enrolled']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubBranch']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['ClubBranch']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['ClubBranch']['zip']) )
							echo $clubInfo['ClubBranch']['zip']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>No. Of Trainer<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['ClubBranch']['no_trainer']))
							echo $clubInfo['ClubBranch']['no_trainer']; 
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
