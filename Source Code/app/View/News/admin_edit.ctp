<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin edit Trainer
## *****************************************************************
?>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create(null ,array('controller'=>'news', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Trainee.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit News</h5><a href="<?php echo $this->Html->url(array('controller'=>'news', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
				
			
			
			
			<div class="rowElem noborder"><label>Heading<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Neww.heading', array('maxlength'=>255,'id'=>'heading', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Neww.heading', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
            <div class="rowElem noborder"><label>Description<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Neww.description', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Neww.description', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Photo:</label><div class="formRight">

				<?php echo $this->Form->file('Neww.logo');?>
								<?php echo $this->Form->error('Neww.logo', null, array('class' => 'error'));?>
							</div>
							<div class="fix"></div>
							<?php echo $this->Form->hidden('Neww.id'); ?>
							
							 <?php echo $this->Form->hidden('Neww.old_image',array('value'=>$this->request->data["Neww"]["logo"]));?>
							
						</div>
							<div id="imgCont" class="rowElem noborder"><label></label>
						<div class="formRight">
						
							<div style="float:left;<?php if( array_key_exists("logo",$this->request->data["Neww"]) && !empty($this->request->data["Neww"]["logo"]) ) { ?>border:1px solid #d8d8d8;<?php } ?>padding:8px;" id="video_container">
							<?php if( array_key_exists("logo",$this->request->data["Neww"]) && !empty($this->request->data["Neww"]["logo"]) ) { ?>
								<img border="1"  width="100px" src="<?php echo $config["imgurl"];?>uploads/<?php echo $this->data["Neww"]["logo"];?>"/>
								<span style="margin-left:11px;margin-top:-22px;position:absolute;">
									<a id="<?php echo $this->data["Neww"]["id"];?>" onclick="removePicne(this);"  style="cursor:pointer" title="click to delete">
										<img border="1" src="<?php echo $config["imgurl"];?>img/cross.png"/>
									</a>
								</span>
							<?php 	} ?>	
							</div>
						</div>
						<div class="fix"></div>
					</div>
					
					
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'news', 'action'=>'index')); ?>">CANCEL</a>
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
