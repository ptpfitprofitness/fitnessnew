<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Member' ,array('controller'=>'members', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Customer</h5><a href="<?php echo $this->Html->url(array('controller'=>'members', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Member.username', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Member.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Member.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Member.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Member.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Member.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>First Name:</label><div class="formRight">

				<?php echo $this->Form->text('Member.first_name', array('maxlength'=>255,'id'=>'FirstName')); ?>

				<?php echo $this->Form->error('Member.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name:</label><div class="formRight">

				<?php echo $this->Form->text('Member.last_name', array('maxlength'=>255,'id'=>'LastName')); ?>

				<?php echo $this->Form->error('Member.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Gender:</label><div class="formRight">	
				
				<?php echo $this->Form->radio("Member.gender",array("Male"=>"Male","Female"=>"Female","NULL"=>"N/A"),array("type"=>"radio","label"=>"","legend"=>"","default" => 'NULL', 'style' => 'margin-left:20px;'));?>
				<?php echo $this->Form->error('Member.gender', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Member.city', array('maxlength'=>128, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Member.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Member.country_id', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Member.country_id', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Age:</label><div class="formRight">

				<?php // echo $this->Form->text('Member.age', array('maxlength'=>3)); ?>
				<?php echo $this->Form->text('Member.age', array('maxlength'=>11,'id'=>'datepicker', 'readonly'=>'true ')); ?>
				
				<?php echo $this->Form->error('Member.age', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Profile Picture:<br>(Your profile picture will only be viewable to specialists that you personally contact)</label><div class="formRight">

				<?php echo $this->Form->file('Member.picture');?>
				
				<?php echo $this->Form->error('Member.picture', null, array('class' => 'error')); ?>		

			</div><div class="fix"></div></div>	
			
			
			<div class="rowElem noborder"><label>Default Avatars:<br>(If no profile picture is uploaded, Please select the Default Avatars to be used)</label><div class="formRight">	
				
				<?php 
				
				echo $this->Form->radio("Member.avatar",array("1"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/1.jpg'/>","2"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/2.jpg'/>","3"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/3.jpg'/>","4"=>"<img border='1'  width='50px' src='".$config['imgurl']."img/4.jpg'/>"),array("type"=>"radio","label"=>"","legend"=>"","default" => '1', 'style' => 'margin-left:10px;'));?>
				<?php echo $this->Form->error('Member.avatar', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'members', 'action'=>'index')); ?>">CANCEL</a>
			
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

