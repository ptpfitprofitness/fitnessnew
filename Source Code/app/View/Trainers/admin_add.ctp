<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Trainer' ,array('controller'=>'trainers', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Trainer</h5><a href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			<div class="rowElem noborder"><label>Trainer Type:</label><div class="formRight">
               <?php
               $trainertypeArr=array('I'=>'Individual','C'=>'Associated with Club');
               ?>       
				<?php  echo $this->Form->select('Trainer.trainer_type',$trainertypeArr,array('empty'=>false,'class'=>'topAction','onchange'=>'getTrainerType()','style'=>'width:50%','empty'=>'-- Trainer Type --')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Club:</label><div class="formRight">
               <?php
               //$trainertypeArr=array('C'=>'Associated with Club','I'=>'Individual');
               ?>       
				<?php  echo $this->Form->select('Trainer.club_id',$clubs,array('empty'=>'-- Select Club --','class'=>'topAction','style'=>'width:50%')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Certification Organization:</label><div class="formRight">
                    
				<?php  echo $this->Form->select('Trainer.certification_org_id',$cert_org,array('empty'=>'-- Select Certification Organization--','class'=>'topAction','style'=>'width:50%')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Certification:</label><div class="formRight">
                    
				<?php  echo $this->Form->select('Trainer.certification_id',$certifications,array('empty'=>'-- Select Certification --','class'=>'topAction','style'=>'width:50%')); ?>

			</div><div class="fix"></div></div>
				<div class="rowElem noborder"><label>Certification No:</label><div class="formRight">
                    	<?php echo $this->Form->text('Trainer.certification_no', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('Trainer.certification_no', null, array('class' => 'error')); ?>

				

			</div><div class="fix"></div></div>
			
			<!--<div class="rowElem noborder"><label>Degree:</label><div class="formRight">
                    
				<?php  //echo $this->Form->select('Trainer.degree_id',$degrees,array('empty'=>'-- Select Degree --','class'=>'topAction','style'=>'width:50%')); ?>

			</div><div class="fix"></div></div> -->

		<!--<div class="rowElem noborder"><label>Username:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainer.username', array('maxlength'=>255,'id'=>'Username', 'class'=>'validate[required] ')); ?>

				<?php //echo $this->Form->error('Trainer.username', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			
			<div class="rowElem noborder"><label>Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php echo $this->Form->error('Trainer.email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
            <div class="rowElem noborder"><label>Password<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->password('Trainer.password', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainer.password', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>First Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.first_name', array('maxlength'=>255,'id'=>'FirstName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainer.first_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Last Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.last_name', array('maxlength'=>255,'id'=>'LastName','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Trainer.last_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>


			<div class="rowElem noborder"><label>Address:</label><div class="formRight">	
				
				<?php echo $this->Form->text('Trainer.address', array('maxlength'=>255,'id'=>'Address')); ?>

				<?php echo $this->Form->error('Trainer.address', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>City:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.city', array('maxlength'=>255, 'id'=>'city')); ?>
				
				<?php echo $this->Form->error('Trainer.city', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>State:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.state', array('maxlength'=>255, 'id'=>'state')); ?>
				
				<?php echo $this->Form->error('Trainer.state', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			

			<div class="rowElem noborder"><label>Country:</label><div class="formRight">

				<?php echo $this->Form->select('Trainer.country', $countries, array('style'=>'','empty'=>'-- Select Country --','default'=>226));?>
				
				<?php echo $this->Form->error('Trainer.country', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>			

			<div class="rowElem noborder"><label>Zip:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.zip', array('maxlength'=>255, 'id'=>'zip')); ?>
				
				<?php echo $this->Form->error('Trainer.zip', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Phone:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.phone', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainer.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
		<div class="rowElem noborder"><label>Mobile:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.mobile', array('maxlength'=>255,'id'=>'Phone')); ?>

				<?php echo $this->Form->error('Trainer.mobile', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Certifications:</label><div class="formRight">

				<?php echo $this->Form->textarea('Trainer.certifications', array('maxlength'=>500, 'id'=>'certifications')); ?>
				
				<?php echo $this->Form->error('Trainer.certifications', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<!--<div class="rowElem noborder"><label>Experience(Years)<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainer.year_exp', array('maxlength'=>25, 'id'=>'year_exp','class'=>'validate[required] ')); ?>
				
				<?php //echo $this->Form->error('Trainer.year_exp', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			<!--<div class="rowElem noborder"><label>Session Price<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainer.session_price', array('maxlength'=>25, 'id'=>'session_price','class'=>'validate[required] ')); ?>
				
				<?php //echo $this->Form->error('Trainer.session_price', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
          <!-- <div class="rowElem noborder"><label>PayPal Email<span style="color:red;">*</span>:</label><div class="formRight">

				<?php //echo $this->Form->text('Trainer.paypal_email', array('maxlength'=>255,'id'=>'EmailAddress', 'class'=>'validate[required,custom[email],ajax[agantEmailValidate]] ')); ?>

				<?php //echo $this->Form->error('Trainer.paypal_email', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>-->
			
			
			
			<div class="rowElem noborder"><label>Bio:</label><div class="formRight">

				<?php echo $this->Form->textarea('Trainer.Bio', array('maxlength'=>500, 'id'=>'Bio')); ?>
				
				<?php echo $this->Form->error('Trainer.Bio', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Notification Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('Trainer.notification_status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('Trainer.notification_status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
						<div class="rowElem noborder"><label>Date Enrolled:</label><div class="formRight">

				<?php echo $this->Form->text('Trainer.date_enrolled', array('maxlength'=>255,'id'=>'datepicker')); ?>

				<?php echo $this->Form->error('Trainer.date_enrolled', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Profile Picture:</label><div class="formRight">

				<?php echo $this->Form->file('Trainer.logo');?>
				
				<?php echo $this->Form->error('Trainer.logo', null, array('class' => 'error')); ?>		

			</div><div class="fix"></div></div>	

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'trainers', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


