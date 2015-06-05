<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		21/02/2014
##  Description :		Admin edit Certification Organization
## *****************************************************************
?>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Certificationorganization' ,array('controller'=>'certificationorganizations', 'action'=>'edit', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('CertificationOrganization.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Certification Organization</h5><a href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div> 
		
			<div class="rowElem noborder"><label>Acronym<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.acronym', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.acronym', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
		
			<div class="rowElem noborder"><label>Name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.name', array('maxlength'=>255, 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Phone Number<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.phone', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.phone', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Web address<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.webaddress', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.webaddress', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			
			
			<div class="rowElem noborder"><label>Contact name<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.contact_name', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.contact_name', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Verification link<span style="color:red;">*</span>:</label><div class="formRight">

				<?php echo $this->Form->text('CertificationOrganization.verification_link', array('maxlength'=>255, 'class'=>' ')); ?>

				<?php echo $this->Form->error('CertificationOrganization.verification_link', null, array('class' => 'error')); ?>

			</div><div class="fix"></div></div>
			
					
			<input type="submit" value="Save" class="blueBtn submitForm" />

			<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'certificationorganizations', 'action'=>'index')); ?>">CANCEL</a>
			<div class="fix"></div>
		</div>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
<div class="fix"></div>
</div>
</div>
<style>
.divFormCon .divRow .divColm2 {
    float: left;
    width: 490px;
}
.checkBoxList {
    width: 330px;
}
.whiteBoxWrap {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DBDBDB;
    padding: 22px 30px;
}
.checkBoxList .checkListCon {
    float: left;
    width: 350px;
}

.checkBoxList .checkListCon li {
    float: left;
    width: 30%;
}
.checkListCon ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
.checkListCon li {
    color: #818181;
    display: block;
    font-size: 12px;
    list-style-type: none;
    margin: 0 0 5px;
    padding: 0;
	float:left;
	width:40%;
}
.checkListCon li input {
    margin-right: 5px;
    vertical-align: middle;
}
</style>


