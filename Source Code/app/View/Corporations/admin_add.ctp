<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Add New Club
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Corporation' ,array('controller'=>'corporations', 'action'=>'add',  'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Corporation</h5><a href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				
<h1 style="padding:10px 0px 0px 5px;">Headquarters</h1>
<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Corporation.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		<!--	<div class="rowElem noborder"><label>Username<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Corporation.username', array('maxlength'=>255, 'class'=>'validate[required]')); ?>

				<?php //echo $this->Form->error('Corporation.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->

			<div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Corporation.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Corporation.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		<div class="rowElem noborder"><label>Company Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.company_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Corporation.company_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Corporation.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Corporation.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Corporation.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Corporation.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Corporation.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Corporation.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Corporation.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Corporation.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Corporation.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('Corporation.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Corporation.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Corporation.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

	


			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'corporations', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


