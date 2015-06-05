<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		30/01/2014
##  Description :		view club info
## *****************************************************************
?>
<div class="content">
	<div class="title">
		<h5><?php echo $this->Html->link('Coupon',array('controller'=>'coupons','action'=>'index'), array('title'=>'Coupon','escape'=>false));?>&nbsp;&raquo;&nbsp;<?php echo $this->Html->link('Manage Coupons',array('controller'=>'coupons','action'=>'index'), array('title'=>'Coupons','escape'=>false));?></h5>
	</div>
	<div class="content" id="container">
	<!-- Input text fields -->
	<fieldset>
		<div class="widget first">
			<div class="head"><h5 class="iList">View Coupons</h5><a href="<?php echo $this->Html->url(array('controller'=>'coupons', 'action'=>'index')); ?>" style="float: right; margin-top: 5px; padding: 2px 13px;margin-right:15px;" class='blueBtn'>List All</a></div>			
			
			
			
			<div class="rowElem noborder"><label>Coupon Name<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['coupon_name']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Code<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['coupon_code']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Discount Type<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php if($couponInfo['Coupon']['discount_type']=='F'){echo "Fixed Value";}else{echo "Percentage Value";} ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Percentage Value<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['discount_percent_value']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Fixed Value<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['discount_fixed_value']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Redemption Limit<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['redemption_limit']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Redemption Count<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['redemption_count']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Start Date<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['start_date']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Expiry Date<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['expiry_date']; ?>
			</div><div class="fix"></div></div>
			
			<div class="rowElem noborder"><label>Coupon Status<span style="color:red;">&nbsp;</span>:</label><div class="formRight" style="margin:0px;">
				<?php echo $couponInfo['Coupon']['status']; ?>
			</div><div class="fix"></div></div>
			
			</div>
			
			
			<div class="fix"></div>
			
			
			
		</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
  </div>
<div class="fix"></div>
</div>
</div>
