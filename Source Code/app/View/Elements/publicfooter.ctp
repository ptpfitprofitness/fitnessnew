<!-- footer part -->
<script>

function loginval(){
	var error_msg	=new Array();
	var i				=0;
	//var mailPattern	=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	var username  = document.getElementById('LoginUsername').value;
	var password  = document.getElementById('LoginPassword').value;		
	chk1 = (document.getElementById("Loginusertype1").checked) || (document.getElementById("Loginusertype2").checked) || (document.getElementById("Loginusertype3").checked) || (document.getElementById("Loginusertype4").checked);	
	if(chk1==true)
	{		
	    if(trimString(password)=='' || trimString(password)=='Password') {
		error_msg[i]= "Please Enter Password.";
		$('#LoginPassword').focus();  
		i++;  					
		}	
		if(trimString(username)=='' || trimString(username)=='Username') {
			error_msg[i]= "Please Enter Username.";
			$('#LoginUsername').focus();
			i++;			
		}
	} else {
		error_msg[i]= "Please Select User Type.";
		$('#Loginusertype1').focus();  
		i++;
	}	
	
	if(i<1)
	{	
		return true;
	}
	else
	{
		var new_arr		=	error_msg.reverse();
		var new_arr		=	error_msg;
		var new_str		= 	new_arr.join('\n');
		alert(new_str);
		return false;
	}
}

function validatejointoday()
{
	//jQuery("#jointoday").validationEngine();
	//$('.loaderResult2').show();
		
		//var username  = $('#username').val();
	   var password=$('#jppassword').val();
	   var conpass=$('#conpass').val();
	  var firstname  = $('#firstname').val();
	  var lastname  = $('#lastname').val();
	  var emaill  = $('#emaill').val();
	  var phonee  = $('#phonee').val();
	  var user_type=$('#user_type').val();
	
		if(username!='' && password!='' && conpass!='' && firstname!='' && lastname!='' &&emaill!='' && user_type!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>index/jointoday';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "user_type="+user_type+"&password="+password+"&con_password="+conpass+"&first_name="+firstname+"&last_name="+lastname+"&email="+emaill+"&phone="+phonee,
				beforeSend: function(){$('.loaderResult2').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResult2').hide();
						//$("#username").val('');
						$('#firstname').val('');
						$('#lastname').val('');
						$("#jppassword").val('');
						$("#conpass").val('');
						$("#emaill").val('');
						$("#phonee").val('');
						$("#notificatin_mes2").html(msg);
						//$("#notificatin_mes2").fadeOut( "slow" );
						$('#notificatin_mes2').fadeIn().delay(10000).fadeOut();
						window.location.href = '<?php echo $config['url']?>index/';
						//$("#notificatin_mes3").html(msg['success']);
						
					}
				});	
		return false;
		}

}
function frtnpass()
{
	
	  var emaill  = $('#femail').val();
	  var utype= $('input[name=utype]:checked').val();
	  
	
		if(emaill!='' && utype!=''){
			
		 var website_url ='<?php echo $config['url']?>home/forgotpassword';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "user_type="+utype+"&email="+emaill,
				beforeSend: function(){$('.loaderResult3').show()},
				
		   		success: function(msg)
					{
						
						$('.loaderResult3').hide();
						
						$("#femail").val('');
						
						$("#notificatin_mes4").html(msg);
						//$("#notificatin_mes2").fadeOut( "slow" );
						$('#notificatin_mes4').fadeIn().delay(10000).fadeOut();
						//window.location.href = window.location.href;
						//$("#notificatin_mes3").html(msg['success']);
						
					}
				});	
		return false;
		}
		return false;
}
</script>
<?php ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery("#jointoday").validationEngine();
	jQuery("#forgotPass").validationEngine();
	jQuery("#validclubtrainer").validationEngine();
	jQuery("#validclubbranch").validationEngine();
	jQuery("#validmeasurement").validationEngine();
	jQuery("#validcorporationbranch").validationEngine();
	jQuery("#validcertificationtrainers").validationEngine();
	jQuery("#validTraineeed").validationEngine();
	jQuery("#measurmnt").validationEngine();
	jQuery("#validmycnts").validationEngine();
	jQuery("#validmyempt").validationEngine();
	jQuery("#addffod").validationEngine();
	jQuery("#creditCardForm").validationEngine();
	//jQuery("#calavdays").validationEngine();
	var redirect;
	 $("#register_subm").click(function(){      
      redirect= $('input[name=register]:checked').val();
     // alert(<?php echo BASE_URL ?>.redirect+'register'):
     window.location.href = '<?php echo BASE_URL; ?>'+redirect+'/register';
    });
	
	 $('.loaderResult2').hide();
	 $('.loaderResult3').hide();
	 $('.loaderResult99').hide();
	 $('.loaderResultMesr').hide();
	 $('.loaderResultFd').hide();
	
});
function frtpass()
{
  $('#loginpop, .overlaybox').fadeOut('slow');	
  popupOpen('pop6');
}
</script>  
<?php ?>
  <footer class="clearfix">
    
  </footer>
  <!-- close footer part --> 
</div>


<!-- Login popup -->
<div id="loginpop" class="register-form-popup"> <a class="close-nav" href="javascript:void(0);"></a>
  <div class="row register-popup-form">
    <div class="twelve field-pad columns">
    <?php
   
    //pr($cookiesDatas);
     ?>
      <form action="<?php echo $config['url']?>index/loginclient" name="Login" id="Login" onsubmit="javascript: return loginval()" method="post" accept-charset="utf-8">
        <h2>Login</h2>
        <input type="text" id="LoginUsername" name="data[Login][username]" value="<?php if(isset($cookiesDatas['username'])) { echo $cookiesDatas['username']; } ?>" placeholder="Email" />
        <input type="password" name="data[Login][password]" id="LoginPassword" value="<?php if(isset($cookiesDatas['password'])) { echo $cookiesDatas['password']; } ?>" placeholder="Password" />
         <input type="hidden" name="data[Login][usertype]" value="Trainee" id="Loginusertype3" /> 
           <div class="row">
                    
           <div class="clear"></div>
            <input type="submit" value="Login" name="" class="submit-nav login-sub">
        </div>
     
    </div>
    <div class="row popup-term-field login-filed">
      <div class="nine remember-me columns">
        <input type="checkbox" name="data[Login][remember]" value="1" /> Remember Me  </div>
        <div class="three remember-me columns"><a href="javascript:void(0);" onclick="frtpass();" class="forgot-me">Forget Password?</a></div>
         </form>
    </div>
  </div>
</div>
<!-- Login popup End -->
<!-- Login popup -->
<div id="register-popup" class="register-form-popup"> <a class="close-nav" href="javascript:void(0);"></a>
  <div class="row register-popup-form">
    <div class="twelve field-pad Fregister-radio columns">
      <form action="">
        <h2>Register As</h2>
        <div class="row">
          <div class="six register-radio columns">
            <input type="radio" name="register" value="clubs" /> Club
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="register" value="trainers" checked="checked" /> Trainer
          </div>
           <!--div class="six register-radio columns">
            <input type="radio" name="register" value="trainees" /> Client
          </div-->
          <?php $on_off=$corporationshow; ?>
          <?php if($on_off=='1') {?>
          <div class="six register-radio columns">
            <input type="radio" name="register" value="corporations" /> Corporation
          </div>
          <?php }?>
          <div class="clear"></div>
            <input type="button" value="Ok" name="" id="register_subm" class="submit-nav login-sub">
        </div>
        
      </form>
    </div>
  </div>
</div>
<!-- Login popup End -->

<!-- Forgotten popup -->
  <div id="pop6" class="main-popup">
                  <div class="overlaybox common-overlay"></div>
                  <div id="thirtydays" class="register-form-popup common-overlaycontent"> <a class="close-nav" onclick="popupClose('pop6');" id="pop6" href="javascript:void(0);"></a>
                    <div class="row register-popup-form">
                      <div class="twelve field-pad columns">
                        <form action="" controller="home"  class="resform-wrap" id="forgotPass" method="post" accept-charset="utf-8" onsubmit="return frtnpass();" >
                          <h2>Forgotten Password</h2>
                            <div class="loaderResult3"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes4" style="color:#ff0000; padding:4px 0 4px 0;"></div><div id="notificatin_mes3" style="color:#0ea262;"></div>
                           <input type="text" name="femail" value="" id="femail" placeholder="Email Address" class="validate[required,custom[email]] text-input"/>
                           
         
          
            <input type="hidden" name="utype" value="Trainee" id="utype3" /> 
         
                               
                            <div class="row">
                        
                        <div class="twelve already-member columns">
                          <input type="submit" value="Submit" name="" class="submit-nav">
                       </div>   
                      </div>                    
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
<!-- Forgotten popup End -->