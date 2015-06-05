<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view ClubBranch info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'FoodNutritionLog','action'=>'food'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Food',array('controller'=>'clubs','action'=>'food'), array('title'=>'Foods','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
<?php //pr($clubInfo); ?>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Food</h5><a href="<?php echo $this->Html->url(array('controller'=>'FoodNutritionLog', 'action'=>'food')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>	
			
			
			<div class="rowElem noborder">
				<label>Type:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
					if(!empty($foodInfo['FoodNutritionLog']['type']) && ($foodInfo['FoodNutritionLog']['type'])==Breakfast)
					{
						echo "Breakfast";
					} 
					elseif(!empty($foodInfo['FoodNutritionLog']['type']) && ($foodInfo['FoodNutritionLog']['type'])==Lunch)
					{	
					echo "Lunch";
					}
					elseif(!empty($foodInfo['FoodNutritionLog']['type']) && ($foodInfo['FoodNutritionLog']['type'])==Dinner)
					{	
					echo "Dinner";
					}
					elseif(!empty($foodInfo['FoodNutritionLog']['type']) && ($foodInfo['FoodNutritionLog']['type'])==Snacks)
					{	
					echo "Snacks";
					}
					
					
					?>
				</div>
				<div class="fix"></div>
			</div>
			
			<div class="rowElem noborder"><label>Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $foodInfo['FoodNutritionLog']['name']; ?>
			</div><div class="fix"></div></div>
					
			<div class="rowElem noborder"><label>Calories<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $foodInfo['FoodNutritionLog']['calories']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Carbs<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $foodInfo['FoodNutritionLog']['carbs']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Fat<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $foodInfo['FoodNutritionLog']['fat']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Protein <span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $foodInfo['FoodNutritionLog']['protein']; ?>
			</div><div class="fix"></div></div>					

			<div class="rowElem noborder">
				<label>Mineral:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $foodInfo['FoodNutritionLog']['mineral']; ?>
				</div>
				<div class="fix"></div>
			</div>
			<div class="fix"></div>
			
			<div class="rowElem noborder">
				<label>Vitamin:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $foodInfo['FoodNutritionLog']['vitamin']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			
			
			<div class="rowElem noborder">
				<label>Status:</label>
				<div class="formRight" style="margin:0px;">
					<?php 
					if(!empty($foodInfo['FoodNutritionLog']['status']) && ($foodInfo['FoodNutritionLog']['status'])==1)
					{
						echo "Yes";
					} 
					else {
						echo "No";
					}
					
					
					?>
				</div>
				<div class="fix"></div>
			</div>
			
			
			<div class="rowElem noborder">
				<label>Date Enrolled:</label>
				<div class="formRight" style="margin:0px;">
					<?php echo $foodInfo['FoodNutritionLog']['added_date']; ?>
				</div>
				<div class="fix"></div>
			</div>
			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
