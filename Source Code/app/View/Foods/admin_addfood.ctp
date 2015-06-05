<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin Add New Club
## *****************************************************************
?>

<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">
<?php echo $this->Form->create(null,array('controller'=>'foods', 'action'=>'addfood', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Food Log</h5><a href="<?php echo $this->Html->url(array('controller'=>'foods', 'action'=>'food')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
			
			<div class="rowElem noborder"><label>Type<span style="color:red;">*</span>:</label><div class="formRight">
<?php $notify=array('Breakfast'=>'Breakfast','Lunch'=>'Lunch','Dinner'=>'Dinner','Snacks'=>'Snacks');
 ?>
				<?php echo $this->Form->select('FoodNutritionLog.type', $notify, array('style'=>'','empty'=>'-- Select Type --','default'=>0,'class'=>'validate[required]'));?>
				
				<?php echo $this->Form->error('FoodNutritionLog.type', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
		
		
			<div class="rowElem noborder"><label>Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('FoodNutritionLog.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
		
			<div class="rowElem noborder"><label>Calories<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.calories', array('maxlength'=>255, 'class'=>'validate[required,custom[number]')); ?>

				<?php echo $this->Form->error('FoodNutritionLog.calories', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Carbs<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.carbs', array('maxlength'=>255,'id'=>'Carbs','class'=>'validate[required,custom[number]' )); ?>

				<?php echo $this->Form->error('FoodNutritionLog.carbs', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			<div class="rowElem noborder"><label>Fat<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.fat', array('maxlength'=>255,'id'=>'Fat','class'=>'validate[required,custom[number]')); ?>

				<?php echo $this->Form->error('FoodNutritionLog.fat', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>

			
			<div class="rowElem noborder"><label>Protein<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.protein', array('maxlength'=>255,'id'=>'Protein','class'=>'validate[required,custom[number]')); ?>

				<?php echo $this->Form->error('FoodNutritionLog.protein', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			

			<div class="rowElem noborder"><label>Mineral<span style="color:red;">*</span>:</label><div class="formRight">	
				
				<?php echo $this->Form->text('FoodNutritionLog.mineral', array('maxlength'=>255,'id'=>'Mineral','class'=>'validate[required,custom[number]')); ?>

				<?php echo $this->Form->error('FoodNutritionLog.mineral', null, array('class' => 'error')); ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Vitamin<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('FoodNutritionLog.vitamin', array('maxlength'=>255, 'id'=>'Vitamin','class'=>'validate[required,custom[number]')); ?>
				
				<?php echo $this->Form->error('FoodNutritionLog.vitamin', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Status:</label><div class="formRight">
<?php $notify=array('0'=>'No','1'=>'Yes');
 ?>
				<?php echo $this->Form->select('FoodNutritionLog.status', $notify, array('style'=>'','empty'=>'-- Select Status --','default'=>0));?>
				
				<?php echo $this->Form->error('FoodNutritionLog.status', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>	
			
			
			<input type="submit" value="Save" class="blueBtn submitForm" />

<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'foods', 'action'=>'food')); ?>">CANCEL</a>
			
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

