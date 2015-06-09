<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin edit Trainer
## *****************************************************************
?>
<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker2" ).datepicker();
});
function getcoupontype()
{
var content_html='';
var content_html1='';
var selectvalue = $('#CouponDiscountType option:selected').text();
	if (selectvalue=='Fixed Value')
	{
	//	$('#main-discount_fixed_value').show();
	//	$('#main-discount_percent_value').hide();
		 content_html = "<div class='rowElem noborder' id='main-discount_fixed_value'>	<label>Fixed Discount:</label><div class='formRight'><input name='data[Coupon][discount_fixed_value]' maxlength='255' id='discount_fixed_value' type='text' value='<?php echo $this->request->data['Coupon']['discount_fixed_value']; ?>'></div><div class='fix'></div></div>";
		
		
		$('#coupon_type_values').html(content_html);
	}
	if (selectvalue=='Percentage')
	{		
		//$('#main-discount_percent_value').show();
		//$('#main-discount_fixed_value').hide();
		 content_html1 = "<div class='rowElem noborder' id='main-discount_percent_value'><label>Percentage Discount:</label><div class='formRight'><input name='data[Coupon][discount_percent_value]' maxlength='255' id='discount_percent_value' type='text' value='<?php echo $this->request->data['Coupon']['discount_percent_value']; ?>'></div><div class='fix'></div></div>";
		$('#coupon_type_values').html(content_html1);
	}
}
</script>
<div class="content">
	<div class="content" id="container">
		<?php echo $this->Form->create('Coupon' ,array('controller'=>'coupons', 'action'=>'edit', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>
		<?php echo $this->Form->hidden('Coupon.id'); ?>
		<!-- Input text fields -->
		<fieldset>
		<div class="widget first">
		<div class="head"><h5 class="iList">Edit Coupons</h5><a href="<?php echo $this->Html->url(array('controller'=>'coupons', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>
			
			
		<div class="rowElem noborder">
			<label>Coupon Name<span style="color:red;">*</span>:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.coupon_name', array('maxlength'=>255,'id'=>'coupon_name', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Coupon.coupon_name', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>			
		
		<div class="rowElem noborder">
			<label>Coupon Code<span style="color:red;">*</span>:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.coupon_code', array('maxlength'=>255,'id'=>'coupon_code', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Coupon.coupon_code', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>

		<div class="rowElem noborder">
			<label>Coupon Type:</label>
			<div class="formRight">
				<?php $notify=array('Fixed'=>'Fixed Value','Percentage'=>'Percentage'); ?>
				
				<?php echo $this->Form->select('Coupon.discount_type', $notify, array('empty'=>'-- Select Coupon Type --','default'=>'Fixed', 'onchange'=>
				"getcoupontype();"));?>
				
				<?php echo $this->Form->error('Coupon.discount_type', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		
		<div id="coupon_type_values" >
		
		
		<?php if($this->data[Coupon][discount_type]=='Percentage'){ ?>
		<div class="rowElem noborder" id="main-discount_percent_value">
			<label>Percentage Discount:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.discount_percent_value', array('maxlength'=>255,'id'=>'discount_percent_value')); ?>

				<?php echo $this->Form->error('Coupon.discount_percent_value', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		<?php }else { ?>
		
		<div class="rowElem noborder" id="main-discount_fixed_value">
			<label>Fixed Discount:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.discount_fixed_value', array('maxlength'=>255,'id'=>'discount_fixed_value')); ?>

				<?php echo $this->Form->error('Coupon.discount_fixed_value', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		<?php } ?>
		</div>
		<div class="rowElem noborder">
			<label>Redemption Limit<span style="color:red;">*</span>:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.redemption_limit', array('maxlength'=>255,'id'=>'redemption_limit', 'class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Coupon.redemption_limit', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		
		<div class="rowElem noborder">
			<label>Start Date:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.start_date', array('maxlength'=>255,'id'=>'datepicker','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Coupon.start_date', null, array('class' => 'error')); ?>

			</div>
			<div class="fix"></div>
		</div>
		
		<div class="rowElem noborder">
			<label>End Date:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.expiry_date', array('maxlength'=>255,'id'=>'datepicker2','class'=>'validate[required] ')); ?>

				<?php echo $this->Form->error('Coupon.expiry_date', null, array('class' => 'error')); ?>

			</div>
			<div class="fix"></div>
		</div>
		
		<div class="rowElem noborder">
			<label>Coupon Status:</label>
			<div class="formRight">
				<?php $couponstatus=array('1'=>'Active','0'=>'In Active'); ?>
				
				<?php echo $this->Form->select('Coupon.status', $couponstatus, array('style'=>'','empty'=>'-- Select Coupon Status --','default'=>'1'));?>
				
				<?php echo $this->Form->error('Coupon.status', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		
		<input type="submit" value="Save" class="blueBtn submitForm" />

		<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'coupons', 'action'=>'index')); ?>">CANCEL</a>

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
		$('#datepicker2').datepicker({
			inline: true,
			changeMonth: true,
            changeYear: true,
            maxDate: '-1',
            dateFormat: 'mm-dd-yy',
            yearRange:'-100:+0'
		});	
		
		
	});
	
</script>
