<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Add New Corporation
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create(null,array('controller'=>'corporations', 'action'=>'addcontact', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Contact</h5><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'contact')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
			
			<div class="rowElem noborder"><label>Corporation:</label>
			<div class="formRight">
                   
				<?php  echo $this->Form->select('CorporationContact.corporation_id',$corporations,array('empty'=>'-- Select Corporation --','class'=>'topAction','id'=>'BranchCorporationId','style'=>'width:50%','onchange'=>'getCorporationBranchList()')); ?>

			</div><div class="fix"></div>
			</div>	
			
			<div class="rowElem noborder"><label>Branch:</label>
			<div id="branchesID" class="formRight">
                   
				<?php  echo $this->Form->select('CorporationContact.branch_id',$branches,array('empty'=>'-- Select Corporation --','class'=>'topAction','id'=>'branchesID','style'=>'width:50%')); ?>

			</div><div class="fix"></div>
			</div>	
		
		
			<div class="rowElem noborder"><label>Title<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationContact.title', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CorporationContact.title', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
		
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationContact.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('CorporationContact.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			
			
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationContact.phone', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('CorporationContact.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationContact.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('CorporationContact.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('CorporationContact.mobile', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('CorporationContact.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			
			
			
			
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'contact')); ?>">CANCEL</a>
			
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

