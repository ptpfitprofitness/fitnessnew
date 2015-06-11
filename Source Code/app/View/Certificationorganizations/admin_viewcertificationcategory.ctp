<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		Admin view Certification info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Home',array('controller'=>'certificationorganizations','action'=>'certificationcategory'), array('title'=>'Home','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Certification Category',array('controller'=>'certificationorganizations','action'=>'certificationcategory'), array('title'=>'Certifications','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
<?php //pr($clubInfo); ?>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Certification Category</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'certificationcategory')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>	
			
			
					
			<div class="rowElem noborder"><label>Certification Category<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $certificationcategoryInfo['CertificationCat']['category_name']; ?>
			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Status<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $certificationcategoryInfo['CertificationCat']['status']; ?>
			</div><div class="fix"></div></div>
			<div class="rowElem noborder"><label>Certification Added date<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $certificationcategoryInfo['CertificationCat']['date_addded']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Certification Modified date<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $certificationcategoryInfo['CertificationCat']['date_modified']; ?>
			</div><div class="fix"></div></div>
			
			
			
			
		
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
