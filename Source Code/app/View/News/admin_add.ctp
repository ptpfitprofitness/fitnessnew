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
<?php echo $this->Form->create(null ,array('controller'=>'news', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New News</h5><a href="<?php echo $this->Html->url(array('controller'=>'news', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			

			
			
			
			
			

			
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
				
				<?php echo $this->Form->error('Neww.logo', null, array('class' => 'error')); ?>		

			</div><div class="fix"></div></div>	

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


