<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		15/07/2014
##  Description :		Admin Add New Trainer Session Package
## *****************************************************************
?>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create('Form' ,array('controller'=>'Forms', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Upload New Document</h5><a href="<?php echo $this->Html->url(array('controller'=>'Forms', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			
			<div class="rowElem noborder"><label>Title<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Form.title', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Form.title', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Upload Form<span style="color:red;">*</span> :</label><div class="formRight">
                    <?php
                     echo $this->Form->input('Form.document', array('label'=>false,'type' => 'file','class'=>'validate[required]'));
                    ?>
                                         
	<?php echo $this->Form->error('Form.document', null, array('class' => 'error')); ?>
                    

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


