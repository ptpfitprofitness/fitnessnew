<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Edit New Library
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create(null ,array('controller'=>'helpguides', 'action'=>'edithelpguide', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Help Guide</h5><a href="<?php echo $this->Html->url(array('controller'=>'helpguides', 'action'=>'helpguide')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
		
		
		<?php echo $this->Form->hidden('HelpGuide.id'); ?>
				
			<div class="rowElem noborder"><label>Document Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('HelpGuide.doc_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('HelpGuide.doc_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Upload Video<span style="color:red;"></span>:</label><div class="formRight">

				<?php echo $this->Form->file('HelpGuide.video_name');?>
				
				<?php echo $this->Form->error('HelpGuide.video_name', null, array('class' => 'error')); ?>	

			</div><div class="fix"></div></div>
		<?php echo $this->Form->hidden('HelpGuide.id'); ?>
							
							 <?php echo $this->Form->hidden('HelpGuide.old_video',array('value'=>$this->request->data["HelpGuide"]["video_name"]));?>
							 
				

<embed src="/var/www/html/app/webroot/plupload/<?php echo $this->data["HelpGuide"]["video_name"];?>" width="200" height="200">
			 
			
			<div class="rowElem noborder"><label>Description<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->textarea('HelpGuide.description', array('class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('HelpGuide.description', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
<div class="rowElem noborder"><label>Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('HelpGuide.status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('HelpGuide.status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			
			
			
			

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'helpguides', 'action'=>'helpguide')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>
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

