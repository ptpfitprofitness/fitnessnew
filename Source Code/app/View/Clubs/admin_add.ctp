<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Add New Club
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Club' ,array('controller'=>'clubs', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Club</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				
			<!--<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Club.username', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('Club.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Club.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Club.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Club.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Club.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			<div class="rowElem noborder"><label>Club Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Club.club_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Club.club_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Club.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Club.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name:</label><div class="formRight">

				<?php echo $this->Form->text('Club.last_name', array('maxlength'=>255,'id'=>'LastName')); ?>

				<?php echo $this->Form->error('Club.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			

			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Club.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Club.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Club.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Club.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Club.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Club.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Club.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Club.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Club.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Club.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>No. Of Trainer:</label><div class="formRight">

				<?php echo $this->Form->text('Club.no_trainer', array('maxlength'=>255, 'id'=>'no_trainer')); ?>
				
				<?php echo $this->Form->error('Club.no_trainer', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Club.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Club.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Club.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('Club.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Club.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Club.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Club Logo:<br>(Your Club Logo will only be viewable to Webstie that you personally contact)</label><div class="formRight">

				<?php echo $this->Form->file('Club.logo');?>
				
				<?php echo $this->Form->error('Club.logo', null, array('class' => 'error')); ?>		

			</div><div class="fix"></div></div>	
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>
<script>
	$(document).ready(function(){			
		$('#datepicker').datepicker({
			inline: true,
			changeMonth: true,
            changeYear: true,
            maxDate: '-1',
            dateFormat: 'mm-dd-yy',
            yearRange:'-100:+0'
		});	
		
		
	});
	
</script>

