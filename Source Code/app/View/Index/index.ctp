<script>
$( document ).ready(function() {
$('.loaderResult').hide();
});
function vlaidatefrmntr()
{
	$('.loaderResult').show();
		var error_msg	=new Array();
	    var i				=0;
	    
	  var fname  = $('#fname').val();
	  var lname  = $('#lname').val();
	  var email  = $('#email').val();
	  var phone  = $('#phone').val();
		
	 if(trimString(fname)=='') {
		error_msg[i]= "Please Enter First Name.";
		$('#fname').focus();  
		i++;  					
		}	
	if(trimString(lname)=='') {
			error_msg[i]= "Please Enter Last Name.";
			$('#lname').focus();
			i++;			
		}
	if(trimString(email)=='') {
			error_msg[i]= "Please Enter Email Address.";
			$('#email').focus();
			i++;			
		}
		else
		{
			 if ((isValid(trimString(email)) == false) && trimString(email) != '')
		        {
		            error_msg [i] = "Please Enter Valid Email Address.";
		            $('#email').focus();
		            i++;
		        }
			
		}	

		
	
	if(i<1)
	{	//sbtn
		//return true;
		
		 var website_url ='<?php echo $config['url']?>index/nutrionalguiderq';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "fname="+fname+"&lname="+lname+"&email="+email+"&phone="+phone,
				beforeSend: function(){$('.loaderResult').show()},
				
		   		success: function(msg)
					{
						$('.loaderResult').hide();
						$("#fname").val('');
						$("#lname").val('');
						$("#email").val('');
						$("#phone").val('');
						$("#notificatin_mes").html(msg);
						
					}
				});	
		return false;
	}
	else
	{
		//var new_arr		=	error_msg.reverse();
		var new_arr		=	error_msg;
		var new_str		= 	new_arr.join('<br/>');
		$('#notificatin_mes').html(new_str);
		$('.loaderResult').hide();
		//alert(new_str);
		return false;
	}
	    
	

}
function gtvtime()
{
 var currentTime = new Date()
  var hours = currentTime.getHours()
  var minutes = currentTime.getMinutes()
var stvkal='Morning';
  if (hours >= 12 && hours < 17)
  {
  	stvkal='Afternoon';
  }
  
  if (hours >= 17 )
  {
  	stvkal='Evening';
  }
  //alert(stvkal);
  var wcm='Good '+stvkal+' & Welcome to PTP';
	$('#gmts1').html(wcm);
	$('#gmts2').html(wcm);
	$('#gmts3').html(wcm);
	$('#gmts4').html(wcm);
	
}


</script>

<section class="contentContainer clearfix">
    <div class="container fullBanner">
      <div id="slides">
        <div class="slidecont"><img src="<?php echo $config['url']?>images/banner2.jpg" alt="">
          <div class="slide-content-wrap"><span>FREE Nutritional <br/> Reference  Guide</span>
            <div class="find-out-more"><a href="javascript:void(0);" onclick="popupOpen('pop4');">Click Here</a></div>
          </div>
          <div class="orbit-caption"> <span id="gmts1">Good Afternoon & Welcome to PTP</span> <b>P</b>ersonal <b>T</b>raining <b>P</b>ersonalized … through Simplicity and Innovation</div>
        </div>
        <div class="slidecont"> <img src="<?php echo $config['url']?>images/banner3.jpg" alt="">
          <div class="slide-content-wrap"><span>FREE Nutritional <br/> Reference  Guide</span>
            <div class="find-out-more"><a  href="javascript:void(0);" onclick="popupOpen('pop4');">Click Here</a></div>
          </div>
           <div class="orbit-caption"> <span id="gmts2">Good Afternoon & Welcome to PTP</span> <b>P</b>ersonal <b>T</b>raining <b>P</b>ersonalized … through Simplicity and Innovation</div>
        </div>
        <div class="slidecont"><img src="<?php echo $config['url']?>images/banner4.jpg" alt="">
          <div class="slide-content-wrap"><span>FREE Nutritional <br/> Reference  Guide</span>
            <div class="find-out-more"><a  href="javascript:void(0);" onclick="popupOpen('pop4');">Click Here</a></div>
          </div>
         <div class="orbit-caption"> <span id="gmts3">Good Afternoon & Welcome to PTP</span> <b>P</b>ersonal <b>T</b>raining <b>P</b>ersonalized … through Simplicity and Innovation</div>
        </div>
        <div class="slidecont"><img src="<?php echo $config['url']?>images/banner5.jpg" alt="">
          <div class="slide-content-wrap"><span>FREE Nutritional <br/> Reference  Guide</span>
            <div class="find-out-more"><a  href="javascript:void(0);" onclick="popupOpen('pop4');">Click Here</a></div>
          </div>
          <div class="orbit-caption"> <span id="gmts4">Good Afternoon & Welcome to PTP</span> <b>P</b>ersonal <b>T</b>raining <b>P</b>ersonalized … through Simplicity and Innovation</div>
        </div>
      </div>
    </div>
    <!--fullBanner ends:-->
    <div class="row">
      <div class="tweleve columns mid-panel">
        <h1 class="heading">About Us</h1>
        <p class="paragraph"><?php echo $content;?></p>
        <a href="<?php echo $config['url'];?>about-us" class="read-more">Read More</a> </div>
    </div>
  </section>
 
  <!-- contentContainer ends -->
  <div class="clear"></div>
     <!-- Singup popup -->
                <div id="pop4" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop4');" id="pop4" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                       <form>
        <h2>Free Nutritional Guide</h2>
        <div class="loaderResult"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div>
        <div id="notificatin_mes" style="color:#ff0000;"></div>
        <div class="row">
          <div class="six columns">
            <input type="text" name="fname" id="fname" value="" placeholder="First Name" />
          </div>
          <div class="six columns">
            <input type="text" name="lname" id="lname" value="" placeholder="Last Name" />
          </div>
        </div>
        <input type="text" name="email" id="email" value="" placeholder="Email Address" />
        <input type="text" name="phone" id="phone" value="" placeholder="(Optional) Phone" />
       
                        <div class="twelve already-member columns">
                          <input type="button" id="sbtn" value="Submit" name="" class="submit-nav" onclick="vlaidatefrmntr();">
                       </div>   
     
      </form>
                      </div>
                    
                    </div>
                  </div>
                </div>
                <!-- Singup popup End --> 
                
 <script>
  gtvtime();
  </script>                