<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Admin Add New Certification Organization
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Certificationorganization' ,array('controller'=>'certificationorganizations', 'action'=>'add',  'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Certification Organization</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

		<div class="rowElem noborder"><label>Acronym<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.acronym', array('maxlength'=>255, 'class'=>'')); ?>

				<?php echo $this->Form->error('Certification.acronym', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
		<div class="rowElem noborder"><label>Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Phone Number<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.phone', array('maxlength'=>255, 'class'=>'')); ?>

				<?php echo $this->Form->error('Certification.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Web address<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.webaddress', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('Certification.webaddress', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Contact name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.contact_name', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('Certification.contact_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Verification link<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.verification_link', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('Certification.verification_link', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			

	


			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


