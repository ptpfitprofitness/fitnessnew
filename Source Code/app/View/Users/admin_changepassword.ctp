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

<?php echo $this->Form->create('' ,array('controller'=>'users', 'action'=>'changepassword', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Change Password</h5></div>

		

			<div class="rowElem noborder"><label>Current Password:</label><div class="formRight">

				<?php echo $this->Form->password('Admin.old_password', array('maxlength'=>255,'id'=>'OldPassword', 'class'=>'validate[required,minSize[6]]')); ?>

				<?php echo $this->Form->error('Admin.old_password',null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

		

			<div class="rowElem noborder"><label>New Password:</label><div class="formRight">

				<?php echo $this->Form->password('Admin.new_password', array('maxlength'=>128,'id'=>'NewPassword', 'class'=>'validate[required,minSize[6]]')); ?>

				<?php echo $this->Form->error('Admin.new_password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			

			<div class="rowElem noborder"><label>Confirm Password:</label><div class="formRight">

				<?php echo $this->Form->password('Admin.confirm_password', array('maxlength'=>128,'id'=>'ConfirmPassword', 'class'=>'validate[required,equals[NewPassword]]')); ?>

				<?php echo $this->Form->error('Admin.confirm_password',null, array('class' => 'error')); ?>

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

