<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Add New Library
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});

</script>

<style>
#SWFUpload_0{margin:0px;}
.swfupload{margin:0px !important;}
</style>

<!--<script type="text/javascript" src="/fitnessAaland/js/jquery.multifile.js"></script> 
<script type="text/javascript" src="<?php echo $config['url'];?>js/plupload/plupload.full.min.js"></script> -->
<?php echo $this->Html->css('uploadify'); ?>
	<?php echo $this->Html->script('uploadify/jquery.uploadify.js'); ?> 
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create(null ,array('controller'=>'helpguides', 'action'=>'addhelpguide', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Help Guide</h5><a href="<?php echo $this->Html->url(array('controller'=>'helpguides', 'action'=>'helpguide')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				
			<div class="rowElem noborder"><label>Document Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('HelpGuide.doc_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('HelpGuide.doc_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Upload Video<span style="color:red;"></span>:</label><div class="formRight">

			
				<?php echo $this->Form->hidden('HelpGuide.video_file');?>
				
				<?php echo $this->Form->error('HelpGuide.hidden', null, array('class' => 'error')); ?>	
          <input id="file_upload" name="Filedata" type="file" value="upload file"/>
			</div><div class="fix"></div></div>
		    
	<!--<div class="rowElem noborder"><label>Upload Photos<span style="color:red;"></span>:</label><div class="formRight">

				<?php //echo $this->Form->file('PhotosLibrary.photo[]');?>
				<input type="file" name="data[PhotosLibrary][photo][]" id=""  class="required multi" />
				<?php echo $this->Form->error('PhotosLibrary.photo', null, array('class' => 'error')); ?>	

			</div><div class="fix"></div></div>-->
		<div class="rowElem noborder"><label>Description<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->textarea('HelpGuide.description', array('class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('HelpGuide.description', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
		<div class="rowElem noborder"><label>Type*:</label><div class="formRight">
<?php $tpe=array('All'=>'All', 'Trainee'=>'Trainee', 'Club'=>'Club','Trainer'=>'Trainer');
 ?>
				<?php echo $this->Form->select('HelpGuide.user_type', $tpe, array('style'=>'','empty'=>'-- Select Status --','default'=>1));?>
				
				<?php echo $this->Form->error('HelpGuide.user_type', null, array('class' => 'error')); ?>

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
<script type="text/javascript">
$(function() {
	$("#file_upload").uploadify({
		'preventCaching' : false,
		height        : 30,
		swf           : '<?php echo $config["url"];?>uploadify/uploadify.swf',
		uploader      : '<?php echo $config["url"];?>helpguides/uploadVideo',
		width         : 120,
		maxFileSize:1024*100,
		'onUploadSuccess':function(file, data, response){
				console.log(data);
				alert(data);
				if(data=="10"){
					$('.errormsg').show();
					$('input[type="submit"]').attr('disabled','disabled');
				}else{
					console.log("33");
					$('.errormsg').hide();
					$("#HelpGuideVideoFile").val(data);
					$('input[type="submit"]').removeAttr('disabled');
				}
				return false;
		},
		'onError' : function(event, ID, fileObj, errorObj) {
				alert(errorObj.type+"::"+errorObj.info);
				console.log("Error");
		} 
	});
});

function setName(e)
{	
	//$('#exec_name').val($('#ExerciseExerciseId :selected').text());	
}
</script>
