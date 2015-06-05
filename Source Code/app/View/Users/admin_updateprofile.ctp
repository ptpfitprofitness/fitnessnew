<?php
##******************************************************************
##  Project		:		Platform Project
##  Done by		:		313
##	Create Date	:		10/08/2013
##  Description :		view, page settings and its details
## *****************************************************************
?>

<div class="content">

    

<div class="content" id="container">

<?php if(isset($errorMessage)){ ?>

	<div>

		<div class="nNote nFailure hideit">

			<p><strong>Error: </strong>

				<?php echo $errorMessage; ?>

			</p>

		</div>

	</div>

	<?php } ?>



<?php 

if (($this->Session->check('Message.flash'))) {

	echo $this->Session->flash('flash', array('element' => 'flash'));

}

?>

<?php echo $this->Form->create('' ,array('controller'=>'users', 'action'=>'updateprofile', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<?php echo $this->Form->hidden('Admin.id'); ?>

<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Update Profile</h5></div>

		

			<div class="rowElem noborder"><label>Full Name:</label><div class="formRight">

				<?php echo $this->Form->text('Admin.name', array('maxlength'=>255,'id'=>'FullName', 'class'=>'validate[required]')); ?>

				<?php echo $this->Form->error('Admin.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

		

			<div class="rowElem noborder"><label>Email address:</label><div class="formRight">

				<?php echo $this->Form->text('Admin.email', array('maxlength'=>128,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email]]')); ?>

				<?php echo $this->Form->error('Admin.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Corporation Section On/Off:</label><div class="formRight">
<?php //echo $this->Form->radio('Admin.on_off', array('0'=>'Off','1'=>'On'),array('class'=>'inputType', 'legend'=>false));?>

				<input type="radio" name="data[Admin][on_off]" value="1" id="Admintype1" <?php if($corporationshow==1){ echo 'checked="checked"';}?>/> On
				&nbsp;
				<input type="radio" name="data[Admin][on_off]" value="0" id="Admintype2" <?php if($corporationshow==0){ echo 'checked="checked"';}?> /> Off

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>30 Day Trial On/Off:</label><div class="formRight">
<?php $notify=array(1=>'Off',0=>'On');
 ?>
				<?php // echo $this->Form->select('Admin.thirtydaytrial', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->select('Admin.thirtydaytrial', $notify, array('style'=>'','empty'=>'-- Select Status --'));?>
				
				<?php echo $this->Form->error('Admin.thirtydaytrial', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			<div class="rowElem noborder"><label>RSS URL:</label><div class="formRight">

				<?php echo $this->Form->text('Admin.rssurl', array('maxlength'=>255,'id'=>'RssUrl')); ?>

				<?php echo $this->Form->error('Admin.rssurl', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			

			

			<input type="reset" value="Reset" class="greyishBtn submitForm" />

			<input type="submit" value="Save" class="greyishBtn submitForm" />

			<input type="button" value="Cancel" class="greyishBtn submitForm" onclick="location.href='<?php echo $this->Html->url('/admin/users/index/');?>'" />

			

			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>

</div>

    

<div class="fix"></div>

</div>



</div>

