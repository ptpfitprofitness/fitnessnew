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
		<h5><?php echo $this->Html->link('Home',array('controller'=>'trainers','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Trainers',array('controller'=>'trainers','action'=>'index'), array('title'=>'Trainers','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Trainer</h5><a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Trainer Type<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php if($trainerInfo['Trainer']['trainer_type']=='I'){echo 'Individual';} else{ echo 'Associated With Club';} ?>
			</div><div class="fix"></div></div>
			<?php if($trainerInfo['Trainer']['trainer_type']=='C'){?>
			<div class="rowElem noborder"><label>Club Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php 
				$clbid=$trainerInfo['Trainer']['club_id'];
				echo $clubs[$clbid];
				
				//echo $clubs['Club']['club_name']; ?>
			</div><div class="fix"></div></div>
			<?php }?>
			
			<div class="rowElem noborder"><label>First Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $trainerInfo['Trainer']['first_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $trainerInfo['Trainer']['last_name']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Email:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['email']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			
			<div class="rowElem noborder">
				<label>Phone:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['phone']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder">
				<label>Mobile:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['mobile']; ?>
				</div>
				<div class="fix"></div>
			</div>

			<div class="rowElem noborder">
				<label>Certifications:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['certifications']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>Address:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['address']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>City:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['city']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
				<div class="rowElem noborder">
				<label>State:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $trainerInfo['Trainer']['state']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Zip <span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($trainerInfo['Trainer']['zip']) )
							echo $trainerInfo['Trainer']['zip']; 
						else
							echo "-"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			<!--<div class="rowElem noborder">
				<label>Exp. (Years)<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						/*if(!empty($trainerInfo['Trainer']['year_exp']))
							echo $trainerInfo['Trainer']['year_exp']; 
						else
							echo "-"; */
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>-->
			
			<!--	<div class="rowElem noborder">
				<label>Session Price<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						/*if(!empty($trainerInfo['Trainer']['session_price']))
							echo $trainerInfo['Trainer']['session_price']; 
						else
							echo "-"; */
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>-->
			
				<!--<div class="rowElem noborder">
				<label>PayPal Email<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						/*if(!empty($trainerInfo['Trainer']['paypal_email']))
							echo $trainerInfo['Trainer']['paypal_email']; 
						else
							echo "-"; */
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>-->
			
			<div class="rowElem noborder">
				<label>Notification status<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($trainerInfo['Trainer']['notification_status']) && ($trainerInfo['Trainer']['notification_status'])==1)
							echo "Yes"; 
						else
							echo "No"; 
					?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Logo<span style="color:red;">&nbsp;</span>:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
						if(!empty($trainerInfo['Trainer']['logo'])) {
							if(!empty($trainerInfo['Trainer']["logo"])) {?>								
									<img src="<?php echo $config['url']?>uploads/<?php echo $trainerInfo['Trainer']["logo"];?>" width="50" height="50"/>
							
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
