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
<?php echo $this->Form->create(null,array('controller'=>'clubs', 'action'=>'addbranch', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Branch</h5><a href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'branch')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
			
			<div class="rowElem noborder"><label>Club:</label>
			<div class="formRight">
                   
				<?php  echo $this->Form->select('ClubBranch.club_id',$clubs,array('empty'=>'-- Select Club --','class'=>'topAction','style'=>'width:50%')); ?>

			</div><div class="fix"></div>
			</div>	
		
		
			<!--<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('ClubBranch.username', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('ClubBranch.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('ClubBranch.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('ClubBranch.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('ClubBranch.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			<div class="rowElem noborder"><label>Branch Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.branch_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('ClubBranch.branch_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('ClubBranch.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.last_name', array('maxlength'=>255,'id'=>'LastName')); ?>

				<?php echo $this->Form->error('ClubBranch.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			

			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('ClubBranch.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('ClubBranch.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('ClubBranch.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('ClubBranch.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('ClubBranch.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('ClubBranch.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('ClubBranch.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>No. Of Trainer:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.no_trainer', array('maxlength'=>255, 'id'=>'no_trainer')); ?>
				
				<?php echo $this->Form->error('ClubBranch.no_trainer', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('ClubBranch.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('ClubBranch.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('ClubBranch.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('ClubBranch.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('ClubBranch.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			
			
			
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'clubs', 'action'=>'branch')); ?>">CANCEL</a>
			
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

