<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Admin edit Certification
## *****************************************************************
?>



<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create(null ,array('controller'=>'certificationorganizations', 'action'=>'editcertification', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Certification.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Certification</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certification')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
		
		<div class="rowElem noborder"><label>Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Certification.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Certification Organization<span style="color:red;">*</span>:</label><div class="formRight">
                    
<?php  echo $this->Form->select('Certification.certi_orgaid',$certificationorganizations,array('empty'=>'-- Select Certification Organization --','class'=>'topAction','style'=>'width:50%')); ?>

				<?php echo $this->Form->error('Certification.certi_orgaid', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Certification<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Certification.course', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

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
