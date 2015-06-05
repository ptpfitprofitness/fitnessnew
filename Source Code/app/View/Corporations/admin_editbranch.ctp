<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin edit CorporationBranch
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create(null ,array('controller'=>'corporations', 'action'=>'editbranch', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('CorporationBranch.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Branch</h5><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'branch')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
		
		
			<div class="rowElem noborder"><label>Corporation:</label><div class="formRight">
               <?php
               //$trainertypeArr=array('C'=>'Associated with Club','I'=>'Individual');
               ?>       
				<?php  echo $this->Form->select('CorporationBranch.corporation_id',$corporation,array('empty'=>'-- Select Corporation --','class'=>'topAction','style'=>'width:50%')); ?>

				<?php echo $this->Form->error('CorporationBranch.corporation_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<!--<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('CorporationBranch.username', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('CorporationBranch.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('CorporationBranch.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('CorporationBranch.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CorporationBranch.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			<div class="rowElem noborder"><label>Branch Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.branch_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CorporationBranch.branch_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CorporationBranch.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.last_name', array('maxlength'=>255,'id'=>'LastName')); ?>

				<?php echo $this->Form->error('CorporationBranch.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('CorporationBranch.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('CorporationBranch.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('CorporationBranch.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('CorporationBranch.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('CorporationBranch.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('CorporationBranch.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			
			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('CorporationBranch.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	

				<div class="rowElem noborder"><label>No. Of Trainer:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.no_trainer', array('maxlength'=>255, 'id'=>'no_trainer')); ?>
				
				<?php echo $this->Form->error('CorporationBranch.no_trainer', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>		
			
			
					
					<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('CorporationBranch.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
					
					<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('CorporationBranch.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('CorporationBranch.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
					
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationBranch.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('CorporationBranch.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
					
						
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'branch')); ?>">CANCEL</a>
			<div class="fix"></div>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
<div class="fix"></div>
</div>
</div>
<style>
.divFormCon .divRow .divColm2 {
    float: left;
    width: 490px;
}
.checkBoxList {
    width: 330px;
}
.whiteBoxWrap {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DBDBDB;
    padding: 22px 30px;
}
.checkBoxList .checkListCon {
    float: left;
    width: 350px;
}

.checkBoxList .checkListCon li {
    float: left;
    width: 30%;
}
.checkListCon ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.checkListCon li {
    color: #818181;
    display: block;
    font-size: 12px;
    list-style-type: none;
    margin: 0 0 5px;
    padding: 0;
	float:left;
	width:40%;
}
.checkListCon li input {
    margin-right: 5px;
    vertical-align: middle;
}
</style>

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
