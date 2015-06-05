<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		04/03/2014
##  Description :		view Trainer Session Package
## *****************************************************************

?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'packages','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Trainers Session Packages',array('controller'=>'packages','action'=>'index'), array('title'=>'Trainers','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Trainer Session Package</h5><a href="<?php echo $this->Html->url(array('controller'=>'packages', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Trainer <span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php 
				echo $packageInfo['Trainer']['full_name'].'('.$packageInfo['Trainer']['username'].')';
				?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Package Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php 
				echo $packageInfo['Package']['package_name'];
				?>
			</div><div class="fix"></div></div>
			
			
			<div class="rowElem noborder"><label>No. Of Weeks<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $packageInfo['Package']['no_session']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Price<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo '$'.$packageInfo['Package']['price']; ?>
			</div><div class="fix"></div></div>					

			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
