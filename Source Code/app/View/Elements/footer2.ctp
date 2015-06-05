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
		$j('#LoginPassword').focus();  
		i++;  					
		}	
		if(trimString(username)=='' || trimString(username)=='Username') {
			error_msg[i]= "Please Enter Username.";
			$j('#LoginUsername').focus();
			i++;			
		}
	} else {
		error_msg[i]= "Please Select User Type.";
		$j('#Loginusertype1').focus();  
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
	
	$j('.loaderResult2').show();
		var error_msg	=new Array();
	    var i=0;
	   var username  = $j('#username').val();
	   var password=$j('#password').val();
	   var conpass=$j('#conpass').val();
	  var firstname  = $j('#firstname').val();
	  var lastname  = $j('#lastname').val();
	  var emaill  = $j('#emaill').val();
	  var phonee  = $j('#phonee').val();
	  var user_type=$j('#user_type').val();
	 
		if(trimString(username)=='') {
		
		error_msg[i]= "Please Enter Username Name.";
		$j('#username').focus();  
		i++;  					
		}
		
		if(trimString(password)=='') {
		error_msg[i]= "Please Enter Password.";
		$j('#password').focus();  
		i++;  					
		}	
		
		if(trimString(user_type)=='') {
		error_msg[i]= "Please Select Usertype.";
		$j('#password').focus();  
		i++;  					
		}
		
		if(trimString(conpass)=='') {
		
		error_msg[i]= "Please Confirm Password.";
		$j('#cpass').focus();  
		i++;  					
		}		
	 if(trimString(firstname)=='') {
		error_msg[i]= "Please Enter First Name.";
		$j('#firstname').focus();  
		i++;  					
		}	
		
	if(trimString(lastname)=='') {
			error_msg[i]= "Please Enter Last Name.";
			$j('#lastname').focus();
			i++;			
		}
	if(trimString(emaill)=='') {
			error_msg[i]= "Please Enter Email Address.";
			$j('#emaill').focus();
			i++;			
		}
		else
		{
			 if ((isValid(trimString(email)) == false) && trimString(email) != '')
		        {
		            error_msg [i] = "Please Enter Valid Email Address.";
		            $j('#emaill').focus();
		            i++;
		        }
			
		}	

		
	
	if(i<1)
	{	
		
		//sbtn
		//return true;$data['Club']['username']=$this->request->data['username'];		
		 var website_url ='<?php echo $config['url']?>index/jointoday';
				$.ajax({
		   		type: "POST",
		   		url: website_url,
		   		data: "user_type="+user_type+"&password="+password+"&con_password="+conpass+"&username="+username+"&first_name="+firstname+"&last_name="+lastname+"&email="+emaill+"&phone="+phonee,
				beforeSend: function(){$j('.loaderResult2').show()},
				
		   		success: function(msg)
					{
						$j('.loaderResult2').hide();
						$j("#uname").val('');
						$j("#fname").val('');
						$j("#lname").val('');
						$j("#email").val('');
						$j("#phone").val('');
						$j("#notificatin_mes2").html(msg);
						
					}
				});	
		return false;
	}
	else
	{
		//var new_arr		=	error_msg.reverse();
		var new_arr		=	error_msg;
		var new_str		= 	new_arr.join('<br/>');
		$j('#notificatin_mes2').html(new_str);
		$j('.loaderResult2').hide();
		//alert(new_str);
		return false;
	}
	    
	

}
</script>
<?php ?>
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function(){
	var redirect;
	 $j("#register_subm").click(function(){      
      redirect= $j('input[name=register]:checked').val();
     // alert(<?php echo BASE_URL ?>.redirect+'register'):
     window.location.href = '<?php echo BASE_URL; ?>'+redirect+'/register';
    });
	
	 $j('.loaderResult2').hide();
});
</script>  
<?php ?>
  <footer class="clearfix">
    <div class="row">
      <div class="footer-link five columns centered ">
        <dl class="sub-nav">
          <dd><a href="<?php echo $config['url']?>about-us" class="pd-none">About Us </a></dd>
          <dd><a href="#">Contact Us</a></dd>
          <dd><a href="<?php echo $config['url']?>disclaimer">Disclaimer</a></dd>
          <dd><a href="<?php echo $config['url']?>terms-of-service">terms Of service</a></dd>
          <dd><a href="<?php echo $config['url']?>faq">Faq</a></dd>
          <dd><a href="<?php echo $config['url']?>news-feed" class="bd-none">News Feed</a></dd>
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
        <p>&copy; All Right Reserved &nbsp; &nbsp; &nbsp; | <a href="<?php echo $config['url']?>terms-and-condition">Terms & Conditions</a> | <a href="#">Web Design</a></p>
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
     <form>
      
        <h2>Join Today</h2>
         <div class="loaderResult2"><img src="<?php echo $config['url']?>images/ajax-loader.gif"/></div> <div id="notificatin_mes2" style="color:#ff0000;"></div>
        <input type="text" name="username" value="" id="username" placeholder="Username" />
        <input type="password" name="password" value="" id="password" placeholder="Password" />
        <input type="password" name="con_password" value="" id="conpass" placeholder="Comfirm Password" />
        <div class="row">
          <div class="six columns">
            <input type="text" name="first_name" value="" id="firstname" placeholder="First Name" />
          </div>
          <div class="six columns">
            <input type="text" name="last_name" value="" id="lastname" placeholder="Last Name" />
          </div>
        </div>
        <input type="text" name="email" value="" id="emaill" placeholder="Email Address" />
        <input type="text" name="phone" value="" id="phone" placeholder="(Optional) Phone" />
        <div class="row">
              <div class="twelve form-select columns">
                <select name="user_type" id="user_type" onChange="document.getElementById('customSelect').value= this.options[this.selectedIndex].text">
                  <option value='1'>Club Owner</option>
                  <option value='2'>Trainer</option>
                </select>
                <input type="text" id="customSelect" value="Select For"/>
              </div>
            </div>
      
    </div>
    <div class="row popup-term-field">
      <div class="twelve I-agree columns">
        <input type="checkbox" name="" value="" />
        Yes I agree to the <a href="#">Personal Training Partners</a> Terms of Use and Privacy Policy </div>
      <div class="twelve already-member columns">
        <input type="button" value="Submit" name="jointy" class="submit-nav" onclick="validatejointoday();">
        </form>
        <span>Already a member? <a href="#">Login</a></span> </div>
    </div>
  </div>
</div>
<!-- Singup popup End -->

<!-- Login popup -->
<div id="loginpop" class="register-form-popup"> <a class="close-nav" href="javascript:void(0);"></a>
  <div class="row register-popup-form">
    <div class="twelve field-pad columns">
      <form action="<?php echo $config['url']?>index/login" name="Login" id="Login" onsubmit="javascript: return loginval()" method="post" accept-charset="utf-8">
        <h2>Login</h2>
        <input type="text" id="LoginUsername" name="data[Login][username]" value="" placeholder="Username" />
        <input type="password" name="data[Login][password]" id="LoginPassword" value="" placeholder="Password" />
        
           <div class="row">
           <div class="pdg">Login As</div>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Club" id="Loginusertype1" /> Club Owner
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Trainer" checked="checked" id="Loginusertype2" /> Trainer
          </div>
           <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Trainee" id="Loginusertype3" /> Trainee
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="data[Login][usertype]" value="Corporation" id="Loginusertype4" /> Corporation
          </div>
            <input type="submit" value="Login" name="" class="submit-nav login-sub">
        </div>
      </form>
    </div>
    <div class="row popup-term-field login-filed">
      <div class="nine remember-me columns">
        <input type="checkbox" name="" value="" /> Remember Me  </div>
        <div class="three remember-me columns"><a href="#" class="forgot-me">Forget Password?</a></div>
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
            <input type="radio" name="register" value="clubs" /> Club Owner
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="register" value="trainers" /> Trainer
          </div>
           <div class="six register-radio columns">
            <input type="radio" name="register" value="trainees" /> Trainee
          </div>
          <div class="six register-radio columns">
            <input type="radio" name="register" value="corporations" /> Corporation
          </div>
            <input type="button" value="Ok" name="" id="register_subm" class="submit-nav login-sub">
        </div>
        
      </form>
    </div>
  </div>
</div>
<!-- Login popup End -->