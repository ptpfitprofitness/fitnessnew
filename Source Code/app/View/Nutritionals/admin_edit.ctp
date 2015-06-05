<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		08/03/2014
##  Description :		Admin edit Nutritional Guide
## *****************************************************************
?>
<script>
function removePicNguide(elem) {
		
	r = confirm("Are you sure want to remove the File ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:"<?php echo $config['url'];?>nutritionals/removePicNguide/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#ClubOldImage").val("");
						$("#file").className  = 'validate[required]';
					}
				}
		});
	}
}
</script>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Nutritional' ,array('controller'=>'nutritionals', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Nutritional.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Nutritional Guide</h5><a href="<?php echo $this->Html->url(array('controller'=>'nutritionals', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
			
			
			
			
			<div class="rowElem noborder"><label>Guide Name:<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Nutritional.guide_name', array('maxlength'=>255,'id'=>'GuideName', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Nutritional.guide_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Guide File(PDF,DOC,DOCX format):</label><div class="formRight">

				<?php echo $this->Form->file('Nutritional.guide_file');?>
								<?php echo $this->Form->error('Nutritional.guide_file', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Nutritional.id'); ?>
							
							 <?php echo $this->Form->hidden('Nutritional.old_file',array('value'=>$this->request->data["Nutritional"]["guide_file"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder"><label></label>
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("guide_file",$this->request->data["Nutritional"]) && !empty($this->request->data["Nutritional"]["guide_file"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("guide_file",$this->request->data["Nutritional"]) && !empty($this->request->data["Nutritional"]["guide_file"]) ) { ?>
								<a href="<?php echo $config['url']; ?>uploads/<?php echo $this->data['Nutritional']['guide_file']; ?>" target="_blank"  ><?php echo $this->data["Nutritional"]["guide_file"];?></a>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Nutritional"]["id"];?>" onclick="removePicNguide(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						<div class="fix"></div>
					</div>
			
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'nutritionals', 'action'=>'index')); ?>">CANCEL</a>
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
