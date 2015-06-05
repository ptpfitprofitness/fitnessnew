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
<?php echo $this->Form->create('Subscription' ,array('controller'=>'subscriptions', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Subscription Plan</h5><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
				

			
			<div class="rowElem noborder"><label>Subscription Name<span style="color:red;">*</span>:</label><div class="formRight">
              <?php echo $this->Form->text('Subscription.plan_name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Subscription.plan_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Subscription Type<span style="color:red;">*</span> :</label><div class="formRight">
                    <?php
                    $plan_type=array('Monthly'=>'Monthly','Yearly'=>'Yearly','One Time'=>'One Time');
                    ?>
				<?php  echo $this->Form->select('Subscription.plan_type',$plan_type,array('empty'=>false,'class'=>'topAction validate[required]','style'=>'width:50%','empty'=>'-- Select Type --')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Subscription Cost<span style="color:red;">*</span>:</label><div class="formRight">$ 
              <?php echo $this->Form->text('Subscription.plan_cost', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Subscription.plan_cost', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
				<div class="rowElem noborder"><label>Subscription For<span style="color:red;">*</span> :</label><div class="formRight">
                    <?php
                    $plan_for=array('All'=>'All','Trainer'=>'Trainer','Club'=>'Club','Trainee'=>'Trainee');
                    ?>
				<?php  echo $this->Form->select('Subscription.plan_for',$plan_for,array('empty'=>false,'class'=>'topAction validate[required]','style'=>'width:50%','empty'=>'-- Select Type --')); ?>

			</div><div class="fix"></div></div>
			
			
			
			
	

			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'subscriptions', 'action'=>'index')); ?>">CANCEL</a>
			
			<div class="fix"></div>



	</div>

</fieldset>

<?php echo $this->Form->end(); ?>



    </div>

    

<div class="fix"></div>

</div>



</div>


