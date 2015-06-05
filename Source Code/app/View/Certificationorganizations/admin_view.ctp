<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		view Certification info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'certificationorganizations','action'=>'index'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Certification Organization',array('controller'=>'certificationorganizations','action'=>'index'), array('title'=>'Certification Organization','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Certification Organization</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			<div class="rowElem noborder"><label>Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $CertificationOrganizationInfo['CertificationOrganization']['name']; ?>
			</div><div class="fix"></div></div>
			
			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
