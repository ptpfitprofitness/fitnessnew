$(function() {
	//===== Alert windows =====//
	
	$(".bAlert").click( function() {
		jAlert('This is a custom alert box. Title and this text can be easily editted', 'Alert Dialog Sample');
	});
	
	$(".bConfirm").click( function() {
		jConfirm('Can you confirm this?', 'Confirmation Dialog', function(r) {
			jAlert('Confirmed: ' + r, 'Confirmation Results');
		});
	});
	
	$(".bPromt").click( function() {
		jPrompt('Type something:', 'Prefilled value', 'Prompt Dialog', function(r) {
			if( r ) alert('You entered ' + r);
		});
	});
	
	$(".bHtml").click( function() {
		jAlert('You can use HTML, such as <strong>bold</strong>, <em>italics</em>, and <u>underline</u>!');
	});
	//===== Accordion =====//		
	
	$('div.menu_body:eq(0)').show();
	$('.acc .head:eq(0)').show().css({color:"#2B6893"});
	
	$(".acc .head").click(function() {	
		$(this).css({color:"#2B6893"}).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
		$(this).siblings().css({color:"#404040"});
	});
	
	
	
	
	
	//===== Form elements styling =====//
	
	
	//===== Form validation engine =====//
	
	 $("#valid").validationEngine({scroll: true});
	 
	 $("#servicesvalid").validationEngine({scroll: true});
	 
	 $("#templatesvalid").validationEngine({scroll: true});
	 
	  $("#videovalid").validationEngine({scroll: true});
	  
	  $("#donationsvalid").validationEngine({scroll: true});
	  
	  $("#sharingvalid").validationEngine({scroll: true});
	
	
	//===== Information boxes =====//
		
	$(".hideit").click(function() {
		$(this).fadeOut(400);
	});
	
	
	
	//===== Autofocus =====//	
	
	$('.autoF').focus();
	
	//===== Placeholder for all browsers =====//
	
	$("input").each(
		function(){
			if($(this).val()=="" && $(this).attr("placeholder")!=""){
			$(this).val($(this).attr("placeholder"));
			$(this).focus(function(){
				if($(this).val()==$(this).attr("placeholder")) $(this).val("");
			});
			$(this).blur(function(){
				if($(this).val()=="") $(this).val($(this).attr("placeholder"));
			});
		}
	});
	
});



$(document).ready( function(){ 
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
	
	$('input, textarea, select').focus(function(){
		$(this).parent('div').addClass('textBoxActive');	
	});
	
	$('input, textarea, select').blur(function(){
		$(this).parent('div').removeClass('textBoxActive');	
	});
	
	
	$('.visitorPhotoWrap a.iconRemove').click(function(){
		$(this).parent('li').fadeOut('slow');
	});
	
	
	
	
	// function for photo primary
	$('a.iconPrimary').click(function(){
		$(this).toggleClass('activePrimary');
	})
	
	
});



var accepted = ["gmail.com", "googlemail.com"];

var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


function form_submit(form){
	if($("#" + form).validationEngine('validate')){
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#loading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#loading").fadeOut('fast');
				$("#errorMsg").html(data);
				scrollToTop();
			}
		});
	}
	return false;
	
}


function ValidateEmail(emailId)
{
        var splitEmail = emailId.split("@");
        
        if (emailId.indexOf("@") != -1 && emailId.indexOf(".") > emailId.indexOf("@") && splitEmail[0].length > 0)
        {
        	if(accepted.indexOf(splitEmail[1]) < 0){ // doesn't exist
			    return false;
			}			
        }
        else
        {
            return false;
        }
}

                

function checkmessage(field, rules, i, options){
	
	if (field.val() == "Tell us how we can help you") {
		return 'Please enter valid message'
	}
	
	if (field.val() == "First Name") {
		return 'Please enter first name'
	}
	
	if (field.val() == "Middle") {
		return 'Please enter middle name'
	}
	
	if (field.val() == "Last Name") {
		return 'Please enter last name'
	}
	
	if (field.val() == "Please provide a thoughtful memoir of the person you are memorializing. Include key accomplishments, family life, favorite hobbies, and interests. Visitors to the Evertalk page can leave their own memories in the Guestbook.") {
		return 'Please provide a thoughtful memoir of the person you are memorializing.'
	}
	
	if (field.val() == "Enter the trait, behavior or interest that best describes how they would like to be remembered.") {
		return 'Enter the trait, behavior or interest that best describes how they would like to be remembered.'
	}
	
}	

function checkDate(){
	
	var bornMonth = $("#MemberBornMonth").val();
	var bornDay = $("#MemberBornDay").val();
	var bornYear = $("#MemberBornYear").val();
	
	var diedMonth = $("#MemberDiedMonth").val();
	var diedDay = $("#MemberDiedDay").val();
	var diedYear = $("#MemberDiedYear").val();
	
	var d = new Date();
	
	var bornDate = new Date(bornMonth+"/"+bornDay+"/"+bornYear);
 	var diedDate = new Date(diedMonth+"/"+diedDay+"/"+diedYear);
 	
		
 	if(bornDate > diedDate){
 		
 		return 'Born date must not be greater than Died date.'
 		
 	}
	
	if(bornDate.getTime() == diedDate.getTime()){
 		
		return 'Born date must not be equal to Died date.'
 		
 	}
 	
}


function checkDiedDate(){
	
	
	var diedMonth = $("#MemberDiedMonth").val();
	var diedDay = $("#MemberDiedDay").val();
	var diedYear = $("#MemberDiedYear").val();
	
	var d = new Date();
	
	var diedDate = new Date(diedMonth+"/"+diedDay+"/"+diedYear);
	
	if(diedDate >= d){
 		
		return 'Died date must be less than current date.'
 		
 	}
 	
}



$(document).ready(function(){

	
	$(".tabMenu").hide();
	//to fix u know who
	$(".tabMenu:first").show();
	$("#basicTabNavi a").click(function(){
			$('#basicTabNavi li').removeClass('currentTab');
			stringref = $(this).attr("href").split('#')[1];
			$(this).parent('li').addClass('currentTab');
			$('.tabMenu:not(#'+stringref+')').hide();
			if ($.browser.msie && $.browser.version.substr(0,3) == "6.0") {
				$('.tabMenu#' + stringref).show();
			}
			else 
			$('.tabMenu#' + stringref).css("display", "block");
			return false;
		
	});
	
	
	$('.leftConPlan #radioMonthly').click(function(){
		$('#monthlyPlan').css('display','block');
		$('#lifeTimePlan').css('display','none');
	});
	
	$('.leftConPlan #radioLife').click(function(){
		$('#lifeTimePlan').css('display','block');
		$('#monthlyPlan').css('display','none');
	});
			
			
			
	

});
	
	
	//popup function

function popupOpen(str){
	$('#' + str).fadeIn('slow');
}
function popupClose(str){
	$('#' + str).fadeOut('slow');
}


//popup function window

function windoPopupOpen(str){
	
	$('#' + str).css('display', 'block');
	$('.layer').fadeIn('slow');

}
function windoPopupClose(str){
	$('#' + str).css('display', 'none');
	$('.layer').fadeOut('slow');

}

function editPayment(str){
	$('#'+str).slideToggle('slow');
}

function deleteimage(id,filename){
	
	if(!confirm("Are you sure want to perform this action?")){
		return false;
	}else{

		/*var url = site_url + 'admin/members/memorialview/'+id+'/'+filename;
		window.parent.location = url;*/
					
		if(filename.length > 0){
			
			$.ajax({
				type:"POST",
				url: site_url + 'admin/users/unlink',
				data: "filename="+filename+"&id="+id,
				success:function(data){	
					
					var dataArr = data.split("|||");
					
					if(dataArr[1]=='Success'){
						
						$('#imageData').html(dataArr[0]);
						$('#showMSG').html('Image has been deleted successfully.');
						
					}
					
				}
			});
		}
	}
	return false;
	
}

function deleteguestbook(member_id,guestbook_id){
	
	if(!confirm("Are you sure want to perform this action?")){
		return false;
	}else{

		$.ajax({
			type:"POST",
			url: site_url + 'admin/users/deleteguestbook',
			data: "member_id="+member_id+"&guestbook_id="+guestbook_id,
			success:function(data){	
				
				var dataArr = data.split("|||");
				
				if(dataArr[1]=='Success'){
					
					$('#guestbookData').html(dataArr[0]);
					$('#guestbookMSG').html('Guestbook entry has been deleted successfully.');
					
				}
				
			}
		});
		
	}
	return false;
	
}
	
	function playVideo(){
		$(".player").each(function(){
			$f( $(this).attr("id"),"http://releases.flowplayer.org/swf/flowplayer-3.2.15.swf", {
				clip: {
						// use baseUrl so we can play with shorter file names
						baseUrl: '<?php echo $config["url"];?>users/videos/',		 
						// use first frame of the clip as a splash screen
						autoPlay: false,
						autoBuffering: true
					}
			});	
		});	
	}

function removePic(elem) {
		
	r = confirm("Are you sure want to remove the image ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:site_url+"clubs/removePic/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#ClubOldImage").val("");
						$("#file").className  = 'validate[required]';
					}
				}
		});
	}
} 

function removeEvePic(elem) {
		
	r = confirm("Are you sure want to remove the evidence ?");
	if(r){
		elem.innerHTML = "Please Wait,while deleting";
		$.ajax({
				url:site_url+"specialists/removeEviePic/",
				type:"POST",
				data:{id:elem.id},
				success:function(e) {
					var response = eval(' ( '+e+' ) ');
					if( response.responseclassName == "nSuccess" ) {
						elem.innerHTML = "Successfully deleted";
						$("#imgEveCont").slideUp("slow");
						$("#image").val("");
						$("#new_image").val("");
						$("#CategoryImagePath").val("");
						$("#SpecialistOldEvidence").val("");
						$("#file").className  = 'validate[required]';
					}
				}
		});
	}
}