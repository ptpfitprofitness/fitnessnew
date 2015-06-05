<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer Session Package
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Package' ,array('controller'=>'packages', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Trainer Session Package</h5><a href="<?php echo $this->Html->url(array('controller'=>'packages', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			<div class="rowElem noborder"><label>Trainer :</label><div class="formRight">
                    
				<?php  echo $this->Form->select('Package.trainer_id',$trainers,array('empty'=>false,'class'=>'topAction','onchange'=>'getTrainerType()','style'=>'width:50%','empty'=>'-- Trainer --')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Package Name<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Package.package_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Package.package_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>No. Of Session<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Package.no_session', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Package.no_session', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Price<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Package.price', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Package.price', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
	

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'packages', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


