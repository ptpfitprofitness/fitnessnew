 <script language="JavaScript" type="text/JavaScript">
function loginval(){
	var error_msg	=new Array();
	var i				=0;
	//var mailPattern	=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	var username  = document.getElementById('LoginUsername').value;
	var password  = document.getElementById('LoginPassword').value;		
	chk1 = (document.getElementById("Loginusertype1").checked) || (document.getElementById("Loginusertype2").checked);	
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


function Specialistval(){
	var error_msg	=new Array();
	var i				=0;
	var mailPattern	=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	var username  = document.getElementById('SpecialistUsername').value;
	var password  = document.getElementById('SpecialistPassword').value;	
	var email     = document.getElementById('SpecialistEmail').value;	
	var first_name     = document.getElementById('SpecialistFirstname').value;	

	chkterm = document.getElementById("Specialistterm").checked;
	if(chkterm==false)
	{
	error_msg[i]= "Please Accept Terms & Conditions.";
		$('#Specialistterm').focus();
		i++;	
	}
	
	chk1 = (document.getElementById("Specialistgender1").checked) || (document.getElementById("Specialistgender2").checked);	if(chk1==false)
	{
	error_msg[i]= "Please Select Gender.";
		$('#Specialistgender1').focus();
		i++;	
	}	

	
	if(trimString(first_name)=='') {
		error_msg[i]= "Please Enter First name.";
		$('#SpecialistFirstname').focus();
		i++;			
	}

	if(trimString(email)=='') {
		error_msg[i]= "Please Enter Email Id.";
		$('#SpecialistEmail').focus();
		i++;			
	}
	if((mailPattern.test(trimString(email)) == false) && trimString(email)!='')
	{
		error_msg [i]= "Please Enter Valid Email.";
			$('#SpecialistEmail').focus();	
			i++;				
	}
	
	if(trimString(password)=='') {
	error_msg[i]= "Please Enter Password.";
	$('#SpecialistPassword').focus();  
	i++;  					
	}
	
	if(trimString(username)=='') {
		error_msg[i]= "Please Enter Username.";
		$('#SpecialistUsername').focus();
		i++;			
	}else {	     
    	if(hasWhiteSpace(trimString(username))) {
		    error_msg[i]= "Please Enter Valid Username.";
			$('#SpecialistUsername').focus();
			i++;							
	       }
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



function Memberval(){
	var error_msg	=new Array();
	var i				=0;
	var mailPattern	=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;	
	var username  = document.getElementById('MemberUsername').value;
	var password  = document.getElementById('MemberPassword').value;	
	var email     = document.getElementById('MemberEmail').value;	
	var first_name     = document.getElementById('MemberFirstname').value;	

	chkterm = document.getElementById("Memberterm").checked;
	if(chkterm==false)
	{
	error_msg[i]= "Please Accept Terms & Conditions.";
		$('#Memberterm').focus();
		i++;	
	}
		
  	
	/*
	chk1 = (document.getElementById("Membergender1").checked) || (document.getElementById("Membergender2").checked);	
	if(chk1==false)
	{
	error_msg[i]= "Please Select Gender.";
		$('#Membergender1').focus();
		i++;	
	}	
	*/
	
	/*if(trimString(first_name)=='') {
		error_msg[i]= "Please Enter First name.";
		$('#MemberFirstname').focus();
		i++;			
	}*/

	if(trimString(email)=='') {
		error_msg[i]= "Please Enter Email Id.";
		$('#MemberEmail').focus();
		i++;			
	}
	if((mailPattern.test(trimString(email)) == false) && trimString(email)!='')
	{
		error_msg [i]= "Please Enter Valid Email.";
			$('#MemberEmail').focus();	
			i++;				
	}
	
	if(trimString(password)=='') {
	error_msg[i]= "Please Enter Password.";
	$('#MemberPassword').focus();  
	i++;  					
	}
	
	if(trimString(username)=='') {
		error_msg[i]= "Please Enter Username.";
		$('#MemberUsername').focus();
		i++;			
	}else {	     
    	if(hasWhiteSpace(trimString(username))) {
		    error_msg[i]= "Please Enter Valid Username.";
			$('#MemberUsername').focus();
			i++;							
	       }
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
</script>

<form action="<?php echo $config['url']?>index/login" name="Login" id="Login" onsubmit="javascript: return loginval()" method="post" accept-charset="utf-8">
 <div class="popup_box" id="pop4">
<div class="login-page">
    <div class="close">
        <a href="javascript:void(0)" id="close" onclick="popupClose('pop4');"><img src="<?php echo $this->Html->url('/images');?>/close.png" /></a>
    </div>
   	<ul>
    <li>
    <label><?php echo __('UsernameH');?> <b>*</b></label>
    <input name="data[Login][username]" class="input" type="text" maxlength="50" value="Username" tabindex="1" onfocus="if(this.value==&#039;<?php echo __('UsernameH');?>&#039;) this.value=&#039;&#039;;" onblur="if(this.value==&#039;&#039;) this.value=&#039;Username&#039;;" id="LoginUsername" />    
    <div class="clr"></div>

    <label><?php echo __('Password');?> <b>*</b></label>
   <input type="password" class="input pwd" name="data[Login][password]" maxlength="50" value="Password" tabindex="1" onfocus="if(this.value==&#039;Password&#039;) this.value=&#039;&#039;;" onblur="if(this.value==&#039;&#039;) this.value=&#039;Password&#039;;" id="LoginPassword" /> 
     <div class="clr"></div>
     
   <div class="radio-button">
		<div class="radio-btn">
				<div id="box-single" class="radio radio_mrgn rd1" style="background-position: center -50px;">
				<input type="radio" name="data[Login][usertype]" value="Customer" id="Loginusertype1" checked="checked"></div>Customer
			</div>
			<div class="radio-btn">
				<div id="box-single" class="radio radio_mrgn rd2" style="background-position: center -50px;">
				<input type="radio" name="data[Login][usertype]" value="Specialist" id="Loginusertype2"></div><?php echo __('SpecialistsH');?>
			</div>
		</div>
     <div class="clr"></div>
     
    <input type="hidden" id="user_login" name="user_login" value="loginRegistred"/>
    <input type="submit" class="submit" value="Login">
    </li>
    </ul>
</div>
    <div class="clr"></div>
</div>
</form>




<form action="<?php echo $config['url']?>index/register_specialist" name="Specialist" id="Specialist" onsubmit="javascript: return Specialistval()" method="post" accept-charset="utf-8">
<div class="popup_box" id="pop5">
<div class="banner-box">
<div class="left popup">
  <div class="close">
        <a href="javascript:void(0)" id="close" onclick="popupClose('pop5');"><img src="<?php echo $this->Html->url('/images');?>/close.png" /></a>
    </div>
		<h2><?php echo __('SpecialistsH');?> Sign Up</h2>
		
		<fieldset>
			<p>
				<label><?php echo __('UsernameH');?> <span>*</span><span class="text"><?php echo __('AnythingYouLikeH');?></span></label>
				<span class="border"><input name="data[Specialist][username]" class="field" type="text" id="SpecialistUsername" value="" maxlength="50" tabindex="1"/></span>
			</p>
			<p>
				<label><?php echo __('Password');?> <span>*</span></label>
				<span class="border"><input name="data[Specialist][password]" class="field" type="password" id="SpecialistPassword" value="" maxlength="50" tabindex="2"/></span>
			</p>
			<p>
				<label><?php echo __('EmailH');?> <span>*</span></label>
				<span class="border"><input name="data[Specialist][email]" class="field" type="text" id="SpecialistEmail" value="" maxlength="50" tabindex="3"/></span>
			</p>
			<p>
				<label><?php echo __('FirstNameH');?><span class="text"><?php echo __('OptionalH');?></span></label>
			    <span class="border"><input name="data[Specialist][first_name]" class="field" type="text" id="SpecialistFirstname" value="" maxlength="50" tabindex="4"/></span>
			</p>
			<p>
				<label><?php echo __('LastNameH');?><span class="text"><?php echo __('OptionalH');?></span></label>
				 <span class="border"><input name="data[Specialist][last_name]" class="field" type="text" id="SpecialistLastname" value="" maxlength="50" tabindex="5"/></span>
			</p>
			<p>
				<label><?php echo __('GenderH');?></label>
				<div class="radio-button">
					<div class="radio-btn">
						<div id="box-single" class="radio radio_mrgn" style="background-position: center -50px;">
						<input type="radio" name="data[Specialist][gender]" value="Male" id="Specialistgender1" tabindex="6"></div><?php echo __('MaleH');?>
					</div>
					<div class="radio-btn">
						<div id="box-single" class="radio radio_mrgn" style="background-position: center -50px;">
						<input type="radio" name="data[Specialist][gender]" value="Female" id="Specialistgender2" tabindex="7"></div><?php echo __('FemaleH');?>
					</div>
				</div>
			</p>
			<div class="clr"></div>
			<div class="agree">
				<div class="checkbox1" id="Astrology">
				     <input type="checkbox" name="data[Specialist][term]" value="1" id="Specialistterm" tabindex="8">
				</div>
				<p><?php echo __('IAgreeToTheTermsConditionsH');?></p>
				<div class="clr"></div>
			</div>                            
			<div class="left-btn">
			 <input type="hidden" id="spec_Specialist" name="spec_Specialist" value="specRegistred"/>
				<button type="submit" class="button" tabindex="9"><?php echo __('JoinNow');?></button>
			</div>
		</fieldset>
		
	</div>
</div>
</div>    
</form>





<form action="<?php echo $config['url']?>index/register_member" name="Member" id="Member" onsubmit="javascript: return Memberval()" method="post" accept-charset="utf-8">
<div class="popup_box" id="pop6">
<div class="banner-box">
<div class="left popup">
  <div class="close">
        <a href="javascript:void(0)" id="close" onclick="popupClose('pop6');"><img src="<?php echo $this->Html->url('/images');?>/close.png" /></a>
    </div>
		<h2>Customer Sign Up</h2>
		
		<fieldset>
			<p>
				<label><?php echo __('UsernameH');?> <span>*</span><span class="text"><?php echo __('AnythingYouLikeH');?></span></label>
				<span class="border"><input name="data[Member][username]" class="field" type="text" id="MemberUsername" value="" maxlength="50" tabindex="1"/></span>
			</p>
			<p>
				<label><?php echo __('Password');?> <span>*</span></label>
				<span class="border"><input name="data[Member][password]" class="field" type="password" id="MemberPassword" value="" maxlength="50" tabindex="2"/></span>
			</p>
			<p>
				<label><?php echo __('EmailH');?> <span>*</span></label>
				<span class="border"><input name="data[Member][email]" class="field" type="text" id="MemberEmail" value="" maxlength="50" tabindex="3"/></span>
			</p>
			<p>
				<label><?php echo __('FirstNameH');?><span class="text"></span></label>
			    <span class="border"><input name="data[Member][first_name]" class="field" type="text" id="MemberFirstname" value="" maxlength="50" tabindex="4"/></span>
			</p>
			<p>
				<label><?php echo __('LastNameH');?><span class="text"><?php echo __('OptionalH');?></span></label>
				 <span class="border"><input name="data[Member][last_name]" class="field" type="text" id="MemberLastname" value="" maxlength="50" tabindex="5"/></span>
			</p>
			<p>
				<label><?php echo __('GenderH');?></label>
				<div class="radio-button">
					<div class="radio-btn">
						<div id="box-single" class="radio radio_mrgn" style="background-position: center -50px;">
						<input type="radio" name="data[Member][gender]" value="Male" id="Membergender1" tabindex="6"></div><?php echo __('MaleH');?>
					</div>
					<div class="radio-btn">
						<div id="box-single" class="radio radio_mrgn" style="background-position: center -50px;">
						<input type="radio" name="data[Member][gender]" value="Female" id="Membergender2" tabindex="7"></div><?php echo __('FemaleH');?>
					</div>
				</div>
			</p>
			<div class="clr"></div>
			<div class="agree">
				<div class="checkbox1" id="Astrology">
				     <input type="checkbox" name="data[Member][term]" value="1" id="Memberterm" tabindex="8">
				</div>
				<p><?php echo __('IAgreeToTheTermsConditionsH');?></p>
				<div class="clr"></div>
			</div>                            
			<div class="left-btn">
			 <input type="hidden" id="spec_cust1" name="spec_cust1" value="custRegistred"/>
				<button type="submit" class="button" tabindex="9"><?php echo __('JoinNow');?></button>
			</div>
		</fieldset>
		
	</div>
</div>
</div>    
</form>