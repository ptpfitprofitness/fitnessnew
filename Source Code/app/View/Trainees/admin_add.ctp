<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer
## *****************************************************************
/*echo "<pre>";
print_r($trainers);
echo "</pre>";*/
//die();
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Trainee' ,array('controller'=>'trainees', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Client</h5><a href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			

			
			<div class="rowElem noborder"><label>Club<span style="color:red;">*</span>:</label><div class="formRight">
               <?php
               //$trainertypeArr=array('C'=>'Associated with Club','I'=>'Individual');
               ?>       
				<?php  //echo $this->Form->select('Trainee.club_id',$clubs,array('class'=>'topAction','multiple'=>'multiple','style'=>'width:62%;height:80px;','size'=>'5','class'=>'','name'=>'TraineeClub_Id','onchange'=>'getTrainerList()')); ?>
				
				<?php echo $this->Form->select('Trainee.club_id', $clubs, array('style'=>'','empty'=>'-- Select Club --'));?>
				
				<?php echo $this->Form->error('Trainee.club_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<!--<div class="rowElem noborder"><label>Trainers:</label><div class="formRight" id="trainersID">                  
				<?php  //echo $this->Form->select('Trainee.trainers',$trainers,array('class'=>'topAction','multiple'=>'multiple','style'=>'width:62%;height:80px;','size'=>'5','class'=>'','name'=>'TraineeTrainers')); ?>
			</div><div class="fix"></div></div>-->
			
			<div class="rowElem noborder"><label>Trainer:</label><div class="formRight">

				<?php echo $this->Form->select('Trainee.trainer_id', $trainers, array('style'=>'','empty'=>'-- Select Trainer --'));?>
				
				<?php echo $this->Form->error('Trainee.trainer_id', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>

			<!--<div class="rowElem noborder"><label>Username:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainee.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('Trainee.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Trainee.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
            <div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Trainee.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainee.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Trainee.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Trainee.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Trainee.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Trainee.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Trainee.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Trainee.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Trainee.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainee.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.mobile', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainee.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Trainee.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Trainee.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Trainee.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('Trainee.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			
			<div class="rowElem noborder"><label>Profile Picture:</label><div class="formRight">

				<?php echo $this->Form->file('Trainee.photo');?>
				
				<?php echo $this->Form->error('Trainee.photo', null, array('class' => 'error')); ?>		

			</div><div class="fix"></div></div>	

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'trainees', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


