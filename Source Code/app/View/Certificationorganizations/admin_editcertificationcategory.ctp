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
<?php echo $this->Form->create(null,array('controller'=>'certificationorganizations', 'action'=>'editcertificationcategory', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->
<?php echo $this->Form->hidden('CertificationCat.id'); ?>

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Certification Category</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certificationcategory')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
		
		
			
		<div class="rowElem noborder"><label>Certification Category<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationCat.category_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CertificationCat.category_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
		
		
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certificationcategory')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


