<script>
function leftop()
{
	 $( ".dashboardLeftlisting" ).toggle( "slow", function() {
// Animation complete.

		if($('#leftpp').html()=='-')
		{
			$('#leftpp').html('+');
		}
		else
		{
			$('#leftpp').html('-');
		}
});
	
}
</script>
<div class="dashboardLeft">
        <div class="listing-cart">  <span class="ListingPadd">My Account</span> <a href="javascript:void(0);" onclick="leftop();" id="leftpp" style="color:#fff;font-size:18px;margin-left: 15px;">-</a> </div>
        <ul class="dashboardLeftlisting" style="display:block;">
          <li><a href="<?php echo $config["url"]?>home/index/" class="active">My Profile</a></li>
          <?php if($dbusertype=='Specialist'){?>
           <li><a href="<?php echo $config["url"]?>home/myservices/" >Manage Services</a></li>
           <?php }?>
          
           <li><a href="<?php echo $config["url"]?>home/invitations/" >Private Message</a></li>
          
            <li><a href="<?php echo $config["url"]?>home/privatemessage/" >Email Sessions</a></li>
             <?php if($dbusertype=='Specialist'){?>
             <!-- <li><a href="<?php echo $config["url"]?>home/processedsession/" >View Session Processed</a></li>-->
             <li><a href="<?php echo $config["url"]?>full_calendar/" target="_blank" >View Session Processed</a></li>
              <li><a href="<?php echo $config["url"]?>home/managediscount/" >Manage Discount</a></li>
              <li><a href="<?php echo $config["url"]?>home/spcpaymenthistory/" >My Order History</a></li>
             <?php } else{?>
            <!--  <li><a href="<?php echo $config["url"]?>home/processedsessioncust/" >My Processed Session</a></li>-->
            <li><a href="<?php echo $config["url"]?>full_calendar/" target="_blank" >View Session Processed</a></li>
            <li><a href="<?php echo $config["url"]?>home/feedback/">Gave Feedback</a></li>
              <li><a href="<?php echo $config["url"]?>home/custpaymenthistory/" >My Payment History</a></li>
             <?php }?>
 
        </ul>
      </div>