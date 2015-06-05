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
	   /*var cardname  = $('#cardname').val();
	   var cardnumber  = $('#cardnumber').val();
	   var exyear  = $('#exyear').val();
	   var exmonth  = $('#exmonth').val();
	   var cvv  = $('#cvv').val();
	   var cardtype  = $('#cardtype').val();*/
	   var user_type=$('#user_type').val();
	
		//if(password!='' && conpass!='' && firstname!='' && lastname!='' &&emaill!='' && user_type!='' && cardname!='' && cardnumber!='' && exyear!='' && exmonth!='' && cvv!='' && cardtype!=''){
		
		if(password!='' && conpass!='' && firstname!='' && lastname!='' &&emaill!='' && user_type!=''){
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>index/jointoday';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		//data: "user_type="+user_type+"&password="+password+"&con_password="+conpass+"&first_name="+firstname+"&last_name="+lastname+"&email="+emaill+"&phone="+phonee+"&cardname="+cardname+"&cardnumber="+cardnumber+"&exyear="+exyear+"&exmonth="+exmonth+"&cvv="+cvv+"&cardtype="+cardtype,
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
						/*$("#cardname").val('');
						$("#cardnumber").val('');
						$("#exyear").val('');
						$("#exmonth").val('');
						$("#cvv").val('');
						$("#cardtype").val('');*/
						$("#notificatin_mes2").html(msg);
						//$("#notificatin_mes2").fadeOut( "slow" );
						$('#notificatin_mes2').fadeIn().delay(10000).fadeOut();
						
						
						if(user_type=='Club Owner'){
						window.location.href = '<?php echo $config['url']?>clubs/communication_center';
						} else {
						window.location.href = '<?php echo $config['url']?>home/index';
						}
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
	jQuery("#billingform").validationEngine();	
	jQuery("#validaddsession").validationEngine();
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
function alreadylogin()
{
  $('#thirtydays, .overlaybox').fadeOut('slow');	
  popupOpen('loginpop');
}
</script>  
<?php ?>
  <footer class="clearfix">
    <div class="row">
      <div class="footer-link five columns centered ">
        <dl class="sub-nav">
          <dd><a href="<?php echo $config['url']?>about-us" class="pd-none" target="_blank">About Us </a></dd>
          <!--<dd><a href="<?php //echo $config['url']?>index/contactus" target="_blank">Contact Us</a></dd>-->
		  <dd><a href="<?php echo $config['url']?>contact-us" target="_blank">Contact Us</a></dd>
          <dd><a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a></dd>
          <dd><a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a></dd>
          <dd><a href="<?php echo $config['url']?>faqs/" target="_blank">Faq</a></dd>
          <dd><a href="<?php echo $config['url']?>news/" class="bd-none" target="_blank">Health & Fitness News</a></dd>
        </dl>
        <div class="footer-social">
          <ul>
            <li><a href="" class="fbk"></a></li>
            <li><a href="" class="twi"></a></li>
            <li><a href="" class="google"></a></li>
          </ul>
        </div>
      </div>
      <!-- footer-links ends -->
      
      <div class="footer-copyright six columns centered">
        <p>&copy; All Right Reserved &nbsp; &nbsp; &nbsp; <!-- <a href="<?php echo $config['url']?>terms-and-condition">Terms & Conditions</a>--><!-- | <a href="#">Web Design</a>--></p>
      </div>
      <div class="social-icon-wrap three columns centered">
        <ul>
          <span>Follow Us</span>
          <li><a href="#" class="facebook"></a></li>
          <li><a href="#" class="twitter"></a></li>
          <li><a href="#" class="youtube"></a></li>
        </ul>
      </div>
    </div>
  </footer>
  <!-- close footer part --> 
</div>
<!-- Singup popup -->
<div class="overlaybox"></div>
<div id="thirtydays" class="register-form-popup"> <a class="close-nav" href="javascript:void(0);"></a>
  <div class="row register-popup-form">
    <div class="twelve field-pad columns">
     <form id="jointoday" method="post" action="">
      
        <h2>Join Today</h2>
         <div class="loaderResult2"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes2" style="color:#ff0000; padding:4px 0 4px 0;"></div><div id="notificatin_mes3" style="color:#0ea262;"></div>
       <!-- <input type="text" name="username" value="" id="username" placeholder="Username" class="validate[required] text-input"/>-->
         <div class="row">
          <div class="six columns">
            <input type="text" name="first_name" value="" id="firstname" placeholder="First Name" class="validate[required] text-input"/>
          </div>
          <div class="six columns">
            <input type="text" name="last_name" value="" id="lastname" placeholder="Last Name" class="validate[required] text-input" />
          </div>
        </div>
          <input type="text" name="email" value="" id="emaill" placeholder="Email Address" class="validate[required,custom[email]] text-input"/>
       
        <input type="password" name="password" value="" id="jppassword" placeholder="Password" class="validate[required,minSize[8]] text-input" />
        <input type="password" name="con_password" value="" id="conpass" placeholder="Comfirm Password" class="validate[required,equals[jppassword],minSize[8]]" />
      
     
        <input type="text" name="phone" value="" id="phonee" placeholder="(Optional) Phone" />
		
		<!-- CARD DETAILS
		
		<div class="row">
            <div class="twelve already-member columns">
				<input type="text" name="cardname" value="" id="cardname" placeholder="NAME ON CARD" class="validate[required] text-input"/>
            </div>
            <div class="twelve already-member columns">
                <input type="text" name="cardnumber" value="" id="cardnumber" placeholder="CARD NUMBER" class="validate[required,creditCard] text-input"/>
            </div>  
            <div class="four form-select columns">
				<select id="exmonth" name="exmonth"  onchange="document.getElementById('customExpmon').value= this.options[this.selectedIndex].text; ">
					<?php /*for($n=1;$n<=12;$n++){?>
						<option value="<?php echo $n;?>"  ><?php echo $n;?></option>
					<?php } */?>
					</select>
					<input type="text" value="Select Month" id="customExpmon">
			</div>  
			<div class="four form-select columns">
				<select id="exyear" name="exyear" onchange="document.getElementById('customExyear').value= this.options[this.selectedIndex].text; " >
					<?php /*for($y=date("Y");$y<=date("Y")+10;$y++) {?>
						<option value="<?php echo $y;?>" ><?php echo $y;?></option>
					<?php } */ ?>
				</select>
				<input type="text" value="Select Year" id="customExyear">
			</div> 
			<div class="four already-member columns">
                <input type="text" name="cvv" value="" maxlength="3" id="cvv" placeholder="CVV CODE" class="validate[required] text-input"/>
            </div>
			
			<div class="twelve register-radio columns">
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype1" name="cardtype" value="Visa" >
							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php //echo BASE_URL;?>img/visa.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype2" name="cardtype" value="Mastercard">							
							</div>
							<div class="card_img" style="float:left;"><img src="<?php //echo BASE_URL;?>img/master.png" /></div>
							
							<div class="radio rad" id="box-single" style="float:left;">
							<input type="radio" id="cardtype3" name="cardtype" value="AmericanExpress">
							</div>
							<div class="card_img" style="float:left;"><img src="<?php //echo BASE_URL;?>img/american.png" /></div>
							</div> 
		</div> 		   
		
		CARD DETAILS -->
		
		
        <div class="row">
              <div class="twelve form-select columns">
                <select name="user_type" id="user_type" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text" class="validate[required]">
					<option value=''>------</option>	
                  <option value='Club Owner'>Club Owner</option>
                  <option value='Trainer'>Trainer</option>
                </select>
                <input type="text" id="customSelect" value="Select For"/>
              </div>
            </div>
	 <!--<div class="row popup-term-field">-->
	 <div class="row">
      <div class="twelve I-agree columns">
        <input class="validate[required] checkbox" type="checkbox" id="agree" name="agree"  />
        Yes I agree to the Personal Training Partners <a href="<?php echo $config['url']?>terms-of-use" target="_blank">Terms of Use</a> and <a href="<?php echo $config['url']?>privacy-policy" target="_blank">Privacy Policy</a> </div>
      <div class="twelve already-member columns">
        <input type="button" value="Submit" class="submit-nav" onclick="return validatejointoday();">
        </form>
        <span>Already a member? <a href="javascript:void(0);" onclick="alreadylogin();">Login</a></span> </div>		
    </div>
      
    </div>
   
  </div>
</div>
<!-- Singup popup End -->

<!-- Login popup -->
<div id="loginpop" class="register-form-popup"> <a class="close-nav" href="javascript:void(0);"></a>
  <div class="row register-popup-form">
    <div class="twelve field-pad columns">
    <?php
   
    pr($cookiesDatas);
     ?>
      <form action="<?php echo $config['url']?>index/login" name="Login" id="Login" onsubmit="javascript: return loginval()" method="post" accept-charset="utf-8">
        <h2>Login</h2>
        <input type="text" id="LoginUsername" name="data[Login][username]" value="<?php if(isset($cookiesDatas['username'])) { echo $cookiesDatas['username']; } ?>" placeholder="Email" />
        <input type="password" name="data[Login][password]" id="LoginPassword" value="<?php if(isset($cookiesDatas['password'])) { echo $cookiesDatas['password']; } ?>" placeholder="Password" />
        
           <div class="row">
           <div class="pdg">Login As</div>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Club" id="Loginusertype1" /> Club
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Trainer" checked="checked" id="Loginusertype2" /> Trainer
          </div>
           <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Trainee" id="Loginusertype3" /> Client
          </div>
          <?php $on_off=$corporationshow; ?>
          <?php if($on_off=='1') {?>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Corporation" id="Loginusertype4" /> Corporation
          </div>
          <?php } ?>
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
                            <div class="six register-radio columns">
            <input type="radio" name="utype" value="Club" id="utype1" /> Club
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="utype" value="Trainer" checked="checked" id="utype2" /> Trainer
          </div>
           <div class="six register-radio columns">
            <input type="radio" name="utype" value="Trainee" id="utype3" /> Client
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="utype" value="Corporation" id="utype4" /> Corporation
          </div>
                               
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
