<script>
$(document).ready(function(){
	jQuery("#jointodayc").validationEngine();
	$('.loaderResultc').hide();
});
function validatecontact()
{
	
	  var firstname  = $('#c_firstname').val();
	  var lastname  = $('#c_lastname').val();
	  var emaill  = $('#c_email').val();
	  var phonee  = $('#c_phone').val();
	  var comments=$('#c_comments').val();
	
		if(comments!='' && firstname!='' && lastname!='' &&emaill!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>index/contact';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "comments="+comments+"&first_name="+firstname+"&last_name="+lastname+"&email="+emaill+"&phone="+phonee,
				beforeSend: function(){$('.loaderResult2').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResultc').hide();
						
						$('#c_firstname').val('');
						$('#c_lastname').val('');
						$('#c_comments').val('');
						
						$("#c_email").val('');
						$("#c_phone").val('');
						$("#notificatin_mesc").html(msg);
						//$("#notificatin_mes2").fadeOut( "slow" );
						$('#notificatin_mesc').fadeIn().delay(10000).fadeOut();
						window.location.href = window.location.href;
						//$("#notificatin_mes3").html(msg['success']);
						
					}
				});	
		return false;
		}

}
</script>
<section class="contentContainer clearfix">
<div class="clear" style="margin-top:120px;"></div>
    <div class="row">
      <div class="tweleve columns mid-panel">
        <h1 class="heading">Contact Us</h1>
        <p class="paragraph"></p>
       <form id="jointodayc">
      
        
         <div class="loaderResultc"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mesc" style="color:#ff0000; padding:4px 0 4px 0;"></div><div id="notificatin_mes3" style="color:#0ea262;"></div>
        
        <div class="row">
          <div class="six columns">
            <input type="text" name="first_name" value="" id="c_firstname" placeholder="First Name" class="validate[required] text-input"/>
          </div>
          <div class="six columns">
            <input type="text" name="last_name" value="" id="c_lastname" placeholder="Last Name" class="validate[required] text-input" />
          </div>
        </div>
        <input type="text" name="email" value="" id="c_email" placeholder="Email Address" class="validate[required,custom[email]] text-input"/>
        <input type="text" name="phone" value="" id="c_phone" placeholder="(Optional) Phone" />
        <textarea name="comments" id="c_comments" placeholder="Comments"></textarea>
         <input type="button" value="Submit" class="submit-nav" onclick="validatecontact();">
        </form>
   
    
        
     
        <!--<a href="#" class="read-more">Read More</a> -->
        </div>
         <div class="tweleve columns mid-panel">
        <h1 class="heading">Headquarter</h1>
        <p class="paragraph">
        <b>India Office :</b> F-18, Sector 11 Noida<br/>
        Uttar Pradesh India - 201301<br/>
        Website: www.abc.com<br/>
        Email : abc@abc.com<br/>
        Contact No : (+91)-120-430500
        </p>
       
        </div>
    </div>
  </section>
  <!-- contentContainer ends -->
  <div class="clear"></div>
   