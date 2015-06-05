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
		<?php echo $this->Form->create('Managemail' ,array('controller'=>'Managemails', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Managemail.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Mails</h5><a href="<?php echo $this->Html->url(array('controller'=>'Managemails', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
			
			<div class="rowElem noborder"><label>Mail Type<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Managemail.mails_type', array('maxlength'=>255,'id'=>'subject', 'class'=>'validate[required] ')); ?>
			
				<?php echo $this->Form->error('Managemail.mails_type', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Subject<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Managemail.subject', array('maxlength'=>255,'id'=>'subject', 'class'=>'validate[required] ')); ?>
			
				<?php echo $this->Form->error('Managemail.subject', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Mail Fire Event<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Managemail.mail_fire_events', array('id'=>'mail_fire_events')); ?>
			
				<?php echo $this->Form->error('Managemail.mail_fire_events', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
           
			
			
			
			
			
			
			<div class="rowElem noborder">

				<label>Content<span style="color:red;">*</span> :</label>

				<div class="formRight">                      
					<?php 
						echo $this->Cksource->create('CKSource');
						echo $this->Cksource->ckeditor('content',array('name'=>'data[Managemail][content]','value'=>$this->data['Managemail']['content']));
						
						
					?>
					 
					  
					<?php echo $this->Form->error('Managemail.content', null, array('class' => 'error')); ?>

				</div>

				<div class="fix"></div>

			</div>
			
					
					
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'Managemails', 'action'=>'index')); ?>">CANCEL</a>
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
