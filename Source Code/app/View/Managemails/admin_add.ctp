<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Managemail' ,array('controller'=>'Managemails', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Mails</h5><a href="<?php echo $this->Html->url(array('controller'=>'Managemails', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			

			
			<div class="rowElem noborder"><label>Mail Type<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Managemail.mails_type', array('maxlength'=>255,'id'=>'subject', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Managemail.mails_type', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Subject<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('Managemail.subject', array('maxlength'=>255,'id'=>'subject', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Managemail.subject', null, array('class' => 'error')); ?>

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


