<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		31/01/2014
##  Description :		Admin Add New Trainer
## *****************************************************************
?>
<script type="text/javascript">
$(function() {
$( "#datepicker" ).datepicker();
$( "#datepicker2" ).datepicker();
});
function getcoupontype(str)
{
	if (str=='Fixed')
	{
		$('#fixeddiscount').show();
		$('#percentagediscount').hide();
	}
	if (str=='Percentage')
	{		
		$('#percentagediscount').show();
		$('#fixeddiscount').hide();
	}
}
</script>
<div class="content" style="width:85%;padding-left:70px;">
 
<div class="content" id="container">

<?php echo $this->Form->create('Coupon' ,array('controller'=>'coupons', 'action'=>'add', 'enctype'=>'multipart/form-data', 'class'=>'mainForm', 'id'=>'valid')); ?>

<!-- Input text fields -->

<fieldset>

	<div class="widget first">

		<div class="head"><h5 class="iList">Add New Coupon</h5><a href="<?php echo $this->Html->url(array('controller'=>'coupons', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			

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
				<div class="radio rad" id="box-single" style="float:left;">
					<input type="radio" class="validate[required]" id="discount_type" name="data[Coupon][discount_type]" value="Fixed" onclick="getcoupontype('Fixed');" /> Fixed Discount				
				</div>
				<div class="radio rad" id="box-single" style="float:left;padding: 0 0 0 15px;">
					<input type="radio" class="validate[required]" id="discount_type" name="data[Coupon][discount_type]" value="Percentage" onclick="getcoupontype('Percentage');">Percentage Discount				
				</div>
			</div>
			<!--<div class="formRight">
				<?php /*$notify=array('F'=>'Fixed Value','P'=>'Percentage'); ?>
				
				<?php echo $this->Form->select('Coupon.discount_type', $notify, array('style'=>'','empty'=>'-- Select Coupon Type --','default'=>'F'));?>
				
				<?php echo $this->Form->error('Coupon.discount_type', null, array('class' => 'error')); */?>
			</div>
			<div class="fix"></div>-->
			
			
			
			
			
		</div>
		
		<div class="rowElem noborder" id="percentagediscount" style="display:none;">
			<label>Percentage Discount:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.discount_percent_value', array('maxlength'=>255,'id'=>'discount_percent_value')); ?>

				<?php echo $this->Form->error('Coupon.discount_percent_value', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
		</div>
		
		<div class="rowElem noborder" id="fixeddiscount" style="display:none;">
			<label>Fixed Discount:</label>
			<div class="formRight">
				<?php echo $this->Form->text('Coupon.discount_fixed_value', array('maxlength'=>255,'id'=>'discount_fixed_value')); ?>

				<?php echo $this->Form->error('Coupon.discount_fixed_value', null, array('class' => 'error')); ?>
			</div>
			<div class="fix"></div>
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
		
		<a class="blueBtn submitForm" style="padding: 2px 13px;font-size:12px;font-size:10px;" href="<?php echo $this->Html->url(array('controller'=>'faqs', 'action'=>'index')); ?>">CANCEL</a>
		
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

