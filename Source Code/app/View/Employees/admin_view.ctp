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
		<h5><?php echo $this->Html->link('Home',array('controller'=>'employees','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Employees',array('controller'=>'employees','action'=>'index'), array('title'=>'Employees','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Employee</h5><a href="<?php echo $this->Html->url(array('controller'=>'employees', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			
			<div class="rowElem noborder"><label>Associated With(Corporation):<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php //echo $traineeInfo['Employee']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $traineeInfo['Employee']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $traineeInfo['Employee']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($traineeInfo['Employee']['zip']) )
							echo $traineeInfo['Employee']['zip']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Phone:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['phone']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<div class="rowElem noborder">
				<label>Mobile:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $traineeInfo['Employee']['mobile']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Notification status<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($traineeInfo['Employee']['notification_status']) && ($traineeInfo['Employee ']['notification_status'])==1)
							echo "Yes"; 
						else
							echo "No"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			
			<div class="rowElem noborder">
				<label>Is Trainee<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($traineeInfo['Employee']['trainee_flag']) && ($traineeInfo['Employee ']['trainee_flag'])==1)
							echo "Yes"; 
						else
							echo "No"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			
			
			<div class="rowElem noborder">
				<label>Photo<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($traineeInfo['Employee']['photo'])) {
							if(!empty($traineeInfo['Employee']["photo"])) {?>								
									<img src="<?php echo $config['url']?>uploads/<?php echo $traineeInfo['Employee']["photo"];?>" width="50" height="50"/>
							
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
