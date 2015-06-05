<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		15/07/2014
##  Description :		Admin Edit Trainer Session Package
## *****************************************************************
?>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Form' ,array('controller'=>'Forms', 'action'=>'duplicate', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php //echo $this->Form->hidden('Form.id'); ?>
		<?php echo $this->Form->hidden('Form.document'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Make Duplicate</h5><a href="<?php echo $this->Html->url(array('controller'=>'Forms', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
			
			<div class="rowElem noborder"><label>Form Title<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Form.title', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Form.title', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			

				<div class="rowElem noborder"><label>Type<span style="color:red;">*</span> :</label><div class="formRight">
                    <?php
                    $plan_for=array('All'=>'All','Trainer'=>'Trainer','Club'=>'Club','Trainee'=>'Trainee');
                    ?>
				<?php  echo $this->Form->select('Form.type',$plan_for,array('empty'=>false,'class'=>'topAction validate[required]','style'=>'width:50%','empty'=>'-- Select Type --')); ?>

			</div><div class="fix"></div></div>
			
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'Forms', 'action'=>'index')); ?>">CANCEL</a>
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
