<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		15/07/2014
##  Description :		view Subscription Plan
## *****************************************************************

?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'subscriptions','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Subscriptions Plan',array('controller'=>'subscriptions','action'=>'index'), array('title'=>'Subscriptions','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Subscription Plan</h5><a href="<?php echo $this->Html->url(array('controller'=>'subscriptions', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Subscription Name :</label><div class="formRight" style="margin:0px;">
				<?php 
				echo $SubscriptionInfo['Subscription']['full_name'];
				?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Subscription Type :</label><div class="formRight" style="margin:0px;">
				<?php 
				echo $SubscriptionInfo['Subscription']['plan_type'];
				?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>Subscription Cost :</label><div class="formRight" style="margin:0px;">
				<?php echo '$'.$SubscriptionInfo['Subscription']['plan_cost']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Subscription For :</label><div class="formRight" style="margin:0px;">
				<?php echo $SubscriptionInfo['Subscription']['plan_for']; ?>
			</div><div class="fix"></div></div>					

			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
