<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		08/03/2014
##  Description :		Admin Add New Nutritional Guide
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Nutritional' ,array('controller'=>'nutritionals', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Nutritional Guide</h5><a href="<?php echo $this->Html->url(array('controller'=>'nutritionals', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			

		<div class="rowElem noborder"><label>Guide Name:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Nutritional.guide_name', array('maxlength'=>255,'id'=>'GuideName', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Nutritional.guide_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Guide File(PDF,DOC,DOCX format):</label><div class="formRight">

				<?php echo $this->Form->file('Nutritional.guide_file');?>
				
				<?php echo $this->Form->error('Nutritional.guide_file', null, array('class' => 'error')); ?>		

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


