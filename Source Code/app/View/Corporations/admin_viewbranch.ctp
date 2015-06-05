<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view CorporationBranch info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'corporations','action'=>'branch'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Branchs',array('controller'=>'corporations','action'=>'branch'), array('title'=>'Branches','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Branches</h5><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'branch')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Associated With(Corporation)<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['Corporation']['company_name']; ?>
			</div><div class="fix"></div></div>
			
			
			
			
			<div class="rowElem noborder"><label>Username<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['CorporationBranch']['username']; ?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Branch Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['CorporationBranch']['branch_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['CorporationBranch']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $clubInfo['CorporationBranch']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['CorporationBranch']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['CorporationBranch']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['CorporationBranch']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['CorporationBranch']['zip']) )
							echo $clubInfo['CorporationBranch']['zip']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['CorporationBranch']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Date Enrolled:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $clubInfo['CorporationBranch']['date_enrolled']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="rowElem noborder">
				<label>Notification Status:</label>
				<div class="formRight" style="margin:0px;">
				<?php  if(!empty($clubInfo['CorporationBranch']['notification_status'])&&($clubInfo['CorporationBranch']['notification_status'])===1) echo "Yes"; else echo "No"; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
		<?php /* ?>	<div class="rowElem noborder">
				<label>No. Of Trainer<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($clubInfo['CorporationBranch']['no_trainer']))
							echo $clubInfo['CorporationBranch']['no_trainer']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<?php */?>
			<div class="fix"></div>
			
		
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
