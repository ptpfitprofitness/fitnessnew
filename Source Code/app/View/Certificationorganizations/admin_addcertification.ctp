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
<?php echo $this->Form->create(null,array('controller'=>'certificationorganizations', 'action'=>'addcertification', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Certification</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certification')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
		
		
		<div class="rowElem noborder"><label>Certification Organization<span style="color:red;">*</span>:</label>
			<div class="formRight">
       <?php  echo $this->Form->select('Certification.certi_orgaid',$certificationorganizations,array('empty'=>'-- Select Certification Organization --','class'=>'topAction validate[required]','style'=>'width:50%')); ?>

			</div><div class="fix"></div>
			</div>	
		
		<div class="rowElem noborder"><label>Certification Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Certification.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
		
		
			<div class="rowElem noborder"><label>Certification Category<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.course', array('maxlength'=>255)); ?>

				<?php echo $this->Form->error('Certification.course', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

						<div class="rowElem noborder"><label>Expiration Date Required<span style="color:red;">*</span>:</label><div class="formRight">
<?php $exp_option = array(1=>'Yes',0 =>'No'); ?>
			 <?php  echo $this->Form->select('Certification.expiration_date_required',$exp_option,array('empty'=>'-- Expiration Date Required --','class'=>'topAction validate[required]','style'=>'width:50%')); ?>
        

				<?php echo $this->Form->error('Certification.expiration_date_required', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Certification Number Required<span style="color:red;">*</span>:</label><div class="formRight">
<?php $cxp_option = array(1=>'Yes',0 =>'No'); ?>
			 <?php  echo $this->Form->select('Certification.certification_number_required',$cxp_option,array('empty'=>'-- Certification Date Required --','class'=>'topAction validate[required]','style'=>'width:50%')); ?>
        

				<?php echo $this->Form->error('Certification.certification_number_required', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certification')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


