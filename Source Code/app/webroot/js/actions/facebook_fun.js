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
	
	
	$('#MemberBornMonth').focus(function(){
		$('#bornmonth').addClass('textBoxActive');	
	});
	
	$('#MemberBornMonth').blur(function(){
		$('#bornmonth').removeClass('textBoxActive');	
	});
	
	$('#MemberBornDay').focus(function(){
		$('#bornday').addClass('textBoxActive');	
	});
	
	$('#MemberBornDay').blur(function(){
		$('#bornday').removeClass('textBoxActive');	
	});
	
	$('#MemberBornYear').focus(function(){
		$('#bornyear').addClass('textBoxActive');	
	});
	
	$('#MemberBornYear').blur(function(){
		$('#bornyear').removeClass('textBoxActive');	
	});
	
	$('#MemberDiedMonth').focus(function(){
		$('#diedmonth').addClass('textBoxActive');	
	});
	
	$('#MemberDiedMonth').blur(function(){
		$('#diedmonth').removeClass('textBoxActive');	
	});
	
	$('#MemberDiedDay').focus(function(){
		$('#diedday').addClass('textBoxActive');	
	});
	
	$('#MemberDiedDay').blur(function(){
		$('#diedday').removeClass('textBoxActive');	
	});
	
	$('#MemberDiedYear').focus(function(){
		$('#diedyear').addClass('textBoxActive');	
	});
	
	$('#MemberDiedYear').blur(function(){
		$('#diedyear').removeClass('textBoxActive');	
	});
	
	$('#importContList').click(function(){
		$('.leftImportCon input').parent('div').addClass('textBoxActive1');	
	})
	
	// function for photo primary
	$('a.iconPrimary').click(function(){
		$(this).toggleClass('activePrimary');
	})
	
});



jQuery(function()
{
	jQuery('#termsBoxInner')
		.jScrollPane(
		{
			showArrows:true
		}
	);
});

jQuery(function()
{
	jQuery('#privacyBoxInner')
		.jScrollPane(
		{
			showArrows:true
		}
	);
});

$(document).ready(function() {
			
	$(".carousel").dualSlider({
		auto:true,
		autoDelay: 10000,
		easingCarousel: "swing",
		easingDetails: "easeOutBack",
		durationCarousel: 1000,
		durationDetails: 600
	});
	
});


var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

var reg1 = /^([A-Za-z0-9_\-\.])+\@([gmail|GMAIL|googlemail|GOOGLEMAIL])+\.(com)$/;

var cards = new Array();

var d = new Date();

cards[0] = { cardName: "Visa", lengths: "13,16", prefixes: "4", cvcdigit: "3", checkdigit: true };
cards[1] = { cardName: "MasterCard", lengths: "16", prefixes: "51,52,53,54,55", cvcdigit: "3", checkdigit: true };
cards[2] = { cardName: "AmEx", lengths: "15", prefixes: "34,37", cvcdigit: "3", checkdigit: true };
cards[3] = { cardName: "Discover", lengths: "16", prefixes: "60,62,64,65", cvcdigit: "3", checkdigit: true };

var cardType = -1;

Stripe.setPublishableKey('pk_qbJ7Z2g6PS1jd8qZ42vtwXIv1YD1k');

function stripeResponseHandler(status, response) {
	
	if (response.error) {
	
		$(".payment-errors").html(response.error.message);  // show the errors on the form
		
	} else {

		var form$ = $("#postvalid");
		var token = response['id'];  // token contains id, last4, and card type
		form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");  // insert the token into the form so it gets submitted to the server
		
	}
}

function formpost_submit(form){
	
	var msg = '';
	
	if($("#PostCardType").val()==''){
		msg += 'Please select card type<br/>';
	}
	
	
	if($("#PostCardNumber").val()==''){
		msg += '<br />Please enter valid credit card number<br/>';
	}
	
	if($("#PostCardNumber").val()!= ""){
		
		for (var i = 0; i < cards.length; i++) {
			if ($("#PostCardType").val().toLowerCase() == cards[i].cardName.toLowerCase()) {
				cardType = i;
				break;
			}
		}
		
        if(!$("#PostCardNumber").val().match('^(0|[1-9][0-9]*)$')){
        	msg += '<br />Please enter numeric value for credit card<br/>';
        }
    }
	 
    if($("#PostCardNumber").val()!= "" && $("#PostCardNumber").val().match('^(0|[1-9][0-9]*)$')){
    	
    	var prefix = cards[cardType].prefixes.split(",");
		
    	if($("#PostCardType").val()=='Visa'){
    		var valPrefix = $("#PostCardNumber").val().substring(0, 1);
    	}
    	else {
    		var valPrefix = $("#PostCardNumber").val().substring(0, 2);
    	}
    	
    	for (i = 0; i < prefix.length; i++) {
			
    		if(valPrefix!=prefix[i]){
				prefixValid = false;				
			}
			else{
				prefixValid = true;	
				break;			
			}
			
		}

		if (prefixValid == false) { 
		
			msg += '<br />'+$("#PostCardType").val()+' card number should be start with '+cards[cardType].prefixes.replace(',',' OR ')+'<br/>';
			
		} // prefix valid
    	else {
    		
		    var cardLength = $("#PostCardNumber").val().length;
		    
		    lengths = cards[cardType].lengths.split(",");
			
			for (j = 0; j < lengths.length; j++) {
				
				if (cardLength != lengths[j]){
					lengthValid = false;					
				}
				else{
					lengthValid = true;	
					break;			
				}
			}
			
			if (lengthValid==false) { 
			
				msg += '<br />Please enter '+cards[cardType].lengths.replace(',',' OR ')+' digit value for '+$("#PostCardType").val()+' card<br/>';
				
			} // wrong length
			
    	}		
    }
	
    if($("#PostCvc").val()==''){
		msg += '<br />Please enter credit card cvc number<br/>';
	}
	
	if($("#PostCvc").val()!= ""){
		
	    if(!$("#PostCvc").val().match('^(0|[1-9][0-9]*)$')){
        	msg += '<br />Please enter numeric value for CVC<br/>';
        }
    }
    
    if($("#PostCvc").val()!= "" && $("#PostCvc").val().match('^(0|[1-9][0-9]*)$')){
    	
    	if ($("#PostCvc").val().length != cards[cardType].cvcdigit) { 
		
			msg += '<br />Please enter '+cards[cardType].cvcdigit+' digit value for CVC<br/>';
			
		} // wrong length
    	
    }
	
	if($("#PostExpmonth").val()=='' || $("#PostExpyear").val()==''){
		msg += '<br />Please select credit card expiration month/year<br/>';
	}
	
	if($("#PostExpmonth").val()!='' && $("#PostExpyear").val()!=''){
		
		
		var PostMonth = $("#PostExpmonth").val();
		var PostDay = d.getDay();
		var PostYear = $("#PostExpyear").val();
		var PostDate = new Date(PostMonth+"/"+PostDay+"/"+PostYear);
		var currentDate = new Date(d.getMonth()+"/"+PostDay+"/"+d.getFullYear());

		if(PostDate < currentDate){
	 		
			msg += '<br/>Please select valid expiration month/year<br/>';
	 		
	 	}
		
		
	}
	
	if(msg.length == 0){
		
		if($("#MemberIsactive").val()==0 || $("#ServiceIsactive").val()==0 || $("#ImageIsactive").val()==0 || $("#VideoIsactive").val()==0 || $("#DonationIsactive").val()==0 || $("#SharingIsactive").val()==0){
			
			msg += 'Please complete the Basic Info/Page Design/Sharing tabs information<br/>';
			
		}
		
	}
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		Stripe.createToken({
			number: $("#PostCardNumber").val(),
			cvc: $("#PostCvc").val(),
			exp_month: $("#PostExpmonth").val(),
			exp_year: $("#PostExpyear").val()
		}, stripeResponseHandler);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#postloading").fadeIn('fast');
		
		$.ajax({
			type:"POST",
			url: site_url + 'stripe.php',
			data: form_data,
			success:function(data){
				
				
				
				$("#postloading").fadeOut('fast');
				/*
				windoPopupOpen('popoverLoading');
				*/
				setInterval("canHeight();",500);				
				scrollToTop();
				
			}
		});
	}
	
	return false;
}



function formbasicinfo_submit(form){
	
	var msg = '';
	
	if($("#MemberFirstName").val()=='' || $("#MemberFirstName").val() == "First Name"){
		msg += 'Please enter first name<br/>';
	}
	
	if($("#MemberLastName").val()=='' || $("#MemberLastName").val() == "Last Name"){
		msg += '<br/>Please enter last name<br/>';
	}
	
	if($("#MemberBornMonth").val()=='' || $("#MemberBornDay").val()=='' || $("#MemberBornYear").val()==''){
		msg += '<br/>Please select born month/day/year<br/>';
	}
	
	if($("#MemberDiedMonth").val()=='' || $("#MemberDiedDay").val()=='' || $("#MemberDiedYear").val()==''){
		msg += '<br/>Please select died month/day/year<br/>';
	}
	
	if($("#MemberBornMonth").val()!='' && $("#MemberBornDay").val()!='' && $("#MemberBornYear").val()!=''){
	
		var bornMonth = $("#MemberBornMonth").val();
		var bornDay = $("#MemberBornDay").val();
		var bornYear = $("#MemberBornYear").val();
		var bornDate = new Date(bornMonth+"/"+bornDay+"/"+bornYear);
		
	}
	
	if($("#MemberDiedMonth").val()!='' && $("#MemberDiedDay").val()!='' && $("#MemberDiedYear").val()!=''){
		
		var diedMonth = $("#MemberDiedMonth").val();
		var diedDay = $("#MemberDiedDay").val();
		var diedYear = $("#MemberDiedYear").val();
		var diedDate = new Date(diedMonth+"/"+diedDay+"/"+diedYear);
		
		if(bornDate > diedDate){
 		
	 		msg += '<br/>Born date must not be greater than Died date<br/>';
	 		
	 	}
		
		if(bornDate.getTime() == diedDate.getTime()){
	 		
			msg += '<br/>Born date must not be equal to Died date<br/>';
	 		
	 	}
		
	 	if(diedDate >= d){
	 		
			msg += '<br/>Died date must be less than current date<br/>';
	 		
	 	}
		
	}
	
	if($("#MemberBiography").val()=='' || $("#MemberBiography").val() == "Please provide a thoughtful memoir of the person you are memorializing. Include key accomplishments, family life, favorite hobbies, and interests. Visitors to the Evertalk page can leave their own memories in the Guestbook."){
		msg += '<br/>Please provide a thoughtful memoir of the person you are memorializing<br/>';
	}
	
	if($("#MemberBiography").val()!='' && $("#MemberBiography").val() != "Please provide a thoughtful memoir of the person you are memorializing. Include key accomplishments, family life, favorite hobbies, and interests. Visitors to the Evertalk page can leave their own memories in the Guestbook." && $("#MemberBiography").val().length < '250'){
		
		msg += '<br/>Please enter minimum 250 characters for biography<br/>';

	}
	
	if($("#MemberRemembered").val()=='' || $("#MemberRemembered").val() == "Enter the trait, behavior or interest that best describes how they would like to be remembered."){
		msg += '<br/>Enter the trait, behavior or interest that best describes how they would like to be remembered<br/>';
	}
	
	if($("#MemberRemembered").val()!='' && $("#MemberRemembered").val() != "Enter the trait, behavior or interest that best describes how they would like to be remembered." && $("#MemberRemembered").val().length > '50'){
		
		msg += '<br/>Please enter maximum 50 characters for remembered<br/>';

	}
	
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
	}
	else{
		
		$("#MemberIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#loading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#loading").fadeOut('fast');
				$("#details_link").removeClass('currentLink');
				$("#services_link").addClass('currentLink');
				$("#details").css('display','none');	
				$("#services").css('display','block');	
				
				$("#fillname").html($("#MemberFirstName").val());
				$("#fillname1").html($("#MemberFirstName").val());
				$("#deceasedname").html($("#MemberFirstName").val());
				
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
		
	}
	
	return false;
	
}



function formservices_submit(form){
	
	var msg = '';
		
	if($("#ServiceMonth").val()=='' || $("#ServiceDay").val()=='' || $("#ServiceYear").val()==''){
		msg += 'Please select service month/day/year<br/>';
	}
	
	if($("#ServiceMonth").val()!='' && $("#ServiceDay").val()!='' && $("#ServiceYear").val()!=''){
	
		var servicesMonth = $("#ServiceMonth").val();
		var servicesDay = $("#ServiceDay").val();
		var servicesYear = $("#ServiceYear").val();
		var servicesDate = new Date(servicesMonth+"/"+servicesDay+"/"+servicesYear);
		
		 if(servicesDate < d){
 		
			msg += '<br/>Service date must be greater than or equal to today<br/>';
 		
 		}
		
	}
	
	if($("#ServiceFhour").val()=='' || $("#ServiceFmin").val()==''){
		msg += '<br/>Please select from hours/minutes<br/>';
	}
	
	if($("#ServiceThour").val()=='' || $("#ServiceTmin").val()==''){
		msg += '<br/>Please select to hours/minutes<br/>';
	}
	
	if($("#ServiceFacilityName").val()==''){
		msg += '<br/>Please enter facility name<br/>';
	}
	
	if($("#ServiceAddress1").val()==''){
		msg += '<br/>Please enter address line 1<br/>';
	}
	
	if($("#ServiceCity").val()==''){
		msg += '<br/>Please enter city<br/>';
	}
	
	if($("#ServiceState").val()==''){
		msg += '<br/>Please enter state<br/>';
	}
	
	if(msg.length > 0 && $("#ServiceStatus").val()==1){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		$("#ServiceIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#serviceloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#serviceloading").fadeOut('fast');
				$(".liTab1").removeClass('currentTab');
				$(".liTab2").addClass('liTab2 currentTab');
				$("#tabMenu1").css('display','none');	
				$("#tabMenu2").css('display','block');
				$("#details_link").removeClass('currentLink');
				$("#templates_link").addClass('currentLink');
				$("#services").css('display','none');	
				$("#templates").css('display','block');
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}

function showisocode(){

	var countryName = $("#ServiceCountryId").val();
	
	$("#CountryId").val($("#ServiceCountryId").val());
	
	if(countryName!=''){
		
		$.ajax({
			type:"POST",
			url: site_url + 'members/basicinfo',
			data: "country_name="+countryName,
			success:function(data){
				
				$('div.isdcode').text("+"+data);
				
			}
		});
		
	}
	return false;
	
}


function formtemplates_submit(form){
	
	var msg = '';
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#templateloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#templateloading").fadeOut('fast');
				$("#templates_link").removeClass('currentLink');
				$("#photo_link").addClass('currentLink');
				$("#templates").css('display','none');	
				$("#photo").css('display','block');	
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}


function formpreview_submit(form){
	
	var msg = '';
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#previewloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#previewloading").fadeOut('fast');
				$(".liTab4").removeClass('currentTab');
				$(".liTab6").addClass('liTab6 currentTab');
				$("#tabMenu4").css('display','none');	
				$("#tabMenu6").css('display','block');
				$("#preview").css('display','none');	
				$("#postWrap").css('display','block');	
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}


function formvideo_submit(form){
	
	var msg = '';
	
	
	if($("#VideoTitle").val()=='' || $("#VideoTitle").val() == "Give your video a title"){
		msg += 'Please enter video title<br/>';
	}
	
	if($("#VideoUrl").val()=='' || $("#VideoUrl").val() == "Enter the link to the video here"){
		msg += '<br/>Please enter youtube video url<br/>';
	}
	
	if($("#VideoUrl").val()!='' && $("#VideoUrl").val() != "Enter the link to the video here"){
		
		var matches = $('#VideoUrl').val().match(/http:\/\/(?:www\.)?youtube.*watch\?v=([a-zA-Z0-9\-_]+)/);

		if (!matches) {

			msg += '<br/>Please enter valid youtube video url<br/>';
			
		}
		
	}
	
	if(msg.length > 0 && $("#VideoStatus").val()==1){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		$("#VideoIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#videoloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#videoloading").fadeOut('fast');
				$("#video_link").removeClass('currentLink');
				$("#donations_link").addClass('currentLink');
				$("#video").css('display','none');	
				$("#donations").css('display','block');	
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}



function formdonations_submit(form){
	
	var msg = '';
	
	
	if($("#DonationName").val()=='' || $("#DonationName").val() == "Memorial Fund or Charity Name"){
		msg += 'Please enter donation name/memorial fund<br/>';
	}
	
	if($("#DonationPaypalId").val()=='' || $("#DonationPaypalId").val() == "PayPal ID"){
		msg += '<br/>Please enter paypal id<br/>';
	}
	
	if($("#DonationPaypalId").val()!='' && $("#DonationPaypalId").val() != "PayPal ID"){
		
		if(reg.test($("#DonationPaypalId").val()) == false) {

			msg += '<br/>Please enter valid paypal id<br/>';
			
		}
	}
	
	if($("#DonationDesc").val()=='' || $("#DonationDesc").val() == "Please type a description that will be displayed on your memorial page that explains the charitable cause or how the memorial funds will be used."){
		msg += '<br/>Please enter donation description<br/>';
	}
	
	
	if($("#anotherDonation").css('display')=='block'){
	
		if($("#DonationName1").val()=='' || $("#DonationName1").val() == "Memorial Fund or Charity Name"){
			msg += '<br/>Please enter one more donation name/memorial fund<br/>';
		}
		
		if($("#DonationPaypalId1").val()=='' || $("#DonationPaypalId1").val() == "PayPal ID"){
			msg += '<br/>Please enter one more paypal id<br/>';
		}
		
		if($("#DonationPaypalId1").val()!='' && $("#DonationPaypalId1").val() != "PayPal ID"){
			
			if(reg.test($("#DonationPaypalId1").val()) == false) {
	
				msg += '<br/>Please enter valid paypal id<br/>';
				
			}
		}
		
		if($("#DonationDesc1").val()=='' || $("#DonationDesc1").val() == "Please type a description that will be displayed on your memorial page that explains the charitable cause or how the memorial funds will be used."){
			msg += '<br/>Please enter one more donation description<br/>';
		}
	}
	
	if(msg.length > 0 && $("#DonationStatus").val()==1){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		$("#DonationIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#donationloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#donationloading").fadeOut('fast');
				$(".liTab2").removeClass('currentTab');
				$(".liTab3").addClass('liTab3 currentTab');
				$("#tabMenu2").css('display','none');	
				$("#tabMenu3").css('display','block');
				$("#donations_link").removeClass('currentLink');
				$("#notifications_link").addClass('currentLink');
				$("#donations").css('display','none');	
				$("#notifications").css('display','block');	
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}


function formsharing_submit(form){
	
	var msg = '';
	
	if($("#SharingFacebookStatus").val()==1){
	
		if($("#SharingFacebookMessage").val()=='' || $("#SharingFacebookMessage").val() == "What would you like to tell them?"){
			msg += 'Please enter message to share on facebook<br/>';
		}
		
	}
	
	if($("#SharingTwitterStatus").val()==1){
	/*
		if($("#SharingTwitterUsername").val()=='' || $("#SharingTwitterUsername").val() == "Twitter Username"){
			msg += '<br/>Please enter twitter username<br/>';
		}*/
		
		if($("#SharingTwitterMessage").val()=='' || $("#SharingTwitterMessage").val() == "What would you like to tweet?"){
			msg += '<br/>Please enter message to share on twitter<br/>';
		}
	
	}
	
	/*if($("#SharingGmailId").val()=='' || $("#SharingGmailId").val() == "Gmail Address"){
		msg += '<br/>Please enter gmail id<br/>';
	}
	
	
	if(reg1.test($("#SharingGmailId").val()) == false && $("#SharingGmailId").val() != "Gmail Address"){		
		msg += '<br/>Please enter valid gmail id<br/>';
	}
	
	if($("#SharingGmailPassword").val()=='' || $("#SharingGmailPassword").val() == "Gmail password"){
		msg += '<br/>Please enter gmail password<br/>';
	}
	
	if($("#SharingMessage").val()=='' || $("#SharingMessage").val() == "Type Message"){
		msg += '<br/>Please enter message<br/>';
	}
	
	if($("#SharingMessage").val()!='' && $("#SharingMessage").val() != "Type Message" && $("#SharingMessage").val().length < '20'){
		msg += '<br/>Please enter minimum 20 characters for message<br/>';
	}*/
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		$("#SharingIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#sharingloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#sharingloading").fadeOut('fast');
				$(".liTab3").removeClass('currentTab');
				$(".liTab4").addClass('liTab4 currentTab');
				$("#tabMenu3").css('display','none');	
				$("#tabMenu4").css('display','block');
				$("#notifications_link").removeClass('currentLink');
				$("#notifications").css('display','none');	
				$("#preview").css('display','block');	
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
	
}


function formphotos_submit(form){
	
	var msg = '';
	
	if($("#totalcnt").val()>0){
		
		var sum = 0;

	    $("#PhotoList li").each(function(){
	      sum += parseInt(1);
	    });
	
		var photocount = sum;
		
	}
	else{
		var photocount = 0;
	}
	
	if(photocount<5){
		
		msg += 'Please upload minimum 5 photos<br/>';
		
	}	
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
		
		$("#ImageIsactive").val(1);
		
		var form_data = $("#" + form).serialize();
		var action = $("#" + form).attr('action');
		$("#photoloading").fadeIn('fast');
		$.ajax({
			type:"POST",
			url: action,
			data: form_data,
			success:function(data){
				$("#photoloading").fadeOut('fast');
				$("#photo_link").removeClass('currentLink');
				$("#video_link").addClass('currentLink');
				$("#photo").css('display','none');	
				$("#video").css('display','block');
				setInterval("canHeight();",500);				
				scrollToTop();
			}
		});
	}
	
	return false;
}


function changepasswordType(){
	
	$("#pass1").html('<input type="password" id="SharingGmailPassword" maxlength="255" name="data[Sharing][gmail_password]" tabindex="5">');	
	$("#SharingGmailPassword").css('font-size','18px');	
	$("#SharingGmailPassword").css('margin-top','6px');
	$("#SharingGmailPassword").focus();
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
	
	var diedDate = new Date(diedMonth+"/"+diedDay+"/"+diedYear);
	
	if(diedDate >= d){
 		
		return 'Died date must be less than current date.'
 		
 	}
 	
}


function importcontacts(){

	var msg = '';
	
	if($("#SharingGmailId").val()=='' || $("#SharingGmailId").val() == "Gmail Address"){
		msg += '<br/>Please enter gmail id<br/>';
	}
	
	
	if(reg1.test($("#SharingGmailId").val()) == false && $("#SharingGmailId").val() != "Gmail Address"){		
		msg += '<br/>Please enter valid gmail id<br/>';
	}
	
	if($("#SharingGmailPassword").val()=='' || $("#SharingGmailPassword").val() == "Gmail password"){
		msg += '<br/>Please enter gmail password<br/>';
	}
	
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
	
		var gmailusername = $("#SharingGmailId").val();
		var gmailpassword = $("#SharingGmailPassword").val();
		
		$.ajax({
			type:"POST",
			url: site_url + 'members/invite',
			data: "plugin=gmail&gmailusername="+gmailusername+"&gmailpassword="+gmailpassword,
			
			success:function(data){	
				
				var dataArr = data.split("||");	
				
				if(dataArr[1]=='error'){
					$('#formError').css('display', 'block');
					$('.layer').fadeIn('slow');
					$('#showMsg').html(dataArr[0]);
				}
				else{		
				
					$("#importContList").css('display','block');
					$("#gmailcontactlist").html(dataArr[0]);
				}
				
			}
		});
	}		
	
	return false;
}


function sendinvite(){
	
	var msg = '';
	
	if($("#SharingGmailId").val()=='' || $("#SharingGmailId").val() == "Gmail Address"){
		msg += '<br/>Please enter gmail id<br/>';
	}
	
	
	if(reg1.test($("#SharingGmailId").val()) == false && $("#SharingGmailId").val() != "Gmail Address"){		
		msg += '<br/>Please enter valid gmail id<br/>';
	}
	
	if($("#SharingGmailPassword").val()=='' || $("#SharingGmailPassword").val() == "Gmail password"){
		msg += '<br/>Please enter gmail password<br/>';
	}
	
	if($("#gmailcontactlist").html()==''){
		
		msg += '<br/>Please first import contacts to send an invite<br/>';
	}
	
	if($("#SharingMessage").val()=='' || $("#SharingMessage").val() == "Type Message"){
		msg += '<br/>Please enter message<br/>';
	}
	
	if($("#SharingMessage").val()!='' && $("#SharingMessage").val() != "Type Message" && $("#SharingMessage").val().length < '20'){
		msg += '<br/>Please enter minimum 20 characters for message<br/>';
	}
	
	if($("#gmailcontactlist").html()!='' && $("form input:checkbox:checked").length == 0){

		msg += '<br/>Please select atleast one contact to send invite<br/>';
		
	}	
	
	if(msg.length > 0){
		
		$('#formError').css('display', 'block');
		$('.layer').fadeIn('slow');
		$('#showMsg').html(msg);
		
	}
	else{
	
		var aChecked = $("form input:checkbox:checked");
		
		var aValues = [];
		
		aChecked.each(function(index){
         	aValues[index] = aChecked[index].value;
     	});
     	
		$.ajax({
			type:"POST",
			url: site_url + 'members/sendinvite',
			data: "send_invite=send_invite&provider_box=gmail&email_box="+$("#email_box").val()+"&oi_session_id="+$("#oi_session_id").val()+"&message="+$("#SharingMessage").val()+"&selected_contacts="+aValues,
			success:function(data){	
				
				var dataArr = data.split("||");
				
				if(dataArr[1]=='error'){
					$('#formError').css('display', 'block');
					$('.layer').fadeIn('slow');
					$('#showMsg').html(dataArr[0]);
				}
								
			}
		});
		
	}	
	
	return false;
}


$(document).ready(function(){

	
	setInterval("canHeight();",1000);  
	   
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
	
	
	document.getElementById('radioMonthly').checked=true;
	
	$('.leftConPlan #radioMonthly').click(function(){
		$('#monthlyPlan').css('display','block');
		$('#lifeTimePlan').css('display','none');
		$('#PostPlan').val('Monthly');
	});
	
	$('.leftConPlan #radioLife').click(function(){
		$('#lifeTimePlan').css('display','block');
		$('#monthlyPlan').css('display','none');
		$('#PostPlan').val('Lifetime');
	});
			
			
			
	

});
	
	
function displayContent(str, str1){
		$('.displaytabContent').hide();
		$('#' + str).show();
		$('#tabSubMenu a').removeClass('currentLink');
		$('#' + str1).addClass('currentLink');
		$('.formError').remove();
		setInterval("canHeight();",1000);
	
}

function displayForm(){
		$('.serviceForm').show();
		$('.btnControl a').removeClass('current');	
		setInterval("canHeight();",500);
		$("#ServiceStatus").val(1);
}

function hideForm(){
		$('.serviceForm').hide();	
		$('.btnControl a').addClass('current');	
		$('.formError').remove();
		$("#ServiceStatus").val(0);
}

function displayContainer(str, str1, menuNavi){
	
	
		$('.' + str).show();
		$('#' + menuNavi + ' ' + 'a').removeClass('activeBtn');	
		$('#'+str1).addClass('activeBtn');	
		
		if(str1=='btnYesVideo'){
			$("#VideoStatus").val(1);
		}
		
		if(str1=='btnYesDot'){
			$("#DonationStatus").val(1);
		}
		
		if(str1=='btnYesNot'){
			$("#SharingFacebookStatus").val(1);
		}
		
		if(str1=='btnYesNot1'){
			$("#SharingTwitterStatus").val(1);
		}

		
}

function hideContainer(str, str1, menuNavi){
		$('.' + str).hide();
		$('#' + menuNavi + ' ' + 'a').removeClass('activeBtn');	
		$('#'+str1).addClass('activeBtn');	
		
		if(str1=='btnNoVideo'){
			$("#VideoStatus").val(0);
		}
		
		if(str1=='btnNoDot'){
			$("#DonationStatus").val(0);
		}
		
		if(str1=='btnNoNot'){
			$("#SharingFacebookStatus").val(0);
		}
		
		if(str1=='btnNoNot1'){
			$("#SharingTwitterStatus").val(0);
		}
}

function showAns(str){
	$('#'+str).slideToggle('slow');
	setInterval("canHeight();",500);
}

function addPhotoTag(str){
	$('#'+str).slideToggle('slow');
	setInterval("canHeight();",500);
}

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

function setPrimary(id){
	
	var total_count = $("#totalcnt").val();
	
	for(i=1;i<=total_count;i++){
		
		$("#primaryphoto" + i).val(0);	
		$("#setprimary" + i).html('Make Primary');
		$("#setprimary" + i).css('color','');
		$("#setprimary" + i).css('background','');
		
	}
	
	$("#primaryphoto" + id).val(1);	
	$("#setprimary" + id).html('Primary');
	$("#setprimary" + id).css('color','#fff');
	$("#setprimary" + id).css('background','#0a7f28');
	
		
}


function removePhoto(id){
	
	var filename = $("#filename" + id).val();
	
	$("#listid" + id).remove();
	
	if(filename.length > 0){
	
		$.ajax({
			type:"POST",
			url: site_url + 'members/unlink',
			data: "filename="+filename,
			success:function(data){				
			}
		});
	
	}
}



var counter = 0;

// <![CDATA[
$(document).ready(function() {
	
$('#memory_image').uploadify({
    'uploader'  : site_url + 'app/webroot/js/uploadify/uploadify.swf',
    'script'    : site_url + 'uploadify.php',
    'cancelImg' : site_url + 'app/webroot/js/uploadify/cancel.png',
    'folder'    : '/uploads/temp/',
    'fileExt'   : '*.jpg;*.gif;*.png',
	'fileDesc'  : 'Image Files',
	'auto'      : true,
    'multi'		: true,
    'sizeLimit' : 5242880,
    'onComplete'  : function(event, ID, fileObj, response, data) {
    	
    	var sum1 = 0;

		$("#PhotoList li").each(function(){
		  sum1 += parseInt(1);
		});
		
		if(sum1==0){
			counter = parseInt(1);
			$("#totalcnt").val(0);
		}
		else{
			counter++;
		}
		
		add_images('logo', response, fileObj, counter)
		
	},
	'onAllComplete' : function(event,data) {
		
		$("#totalcnt").val(parseInt($("#totalcnt").val()) + parseInt(data.filesUploaded));	
		
    	$("#filesUploaded").html(data.filesUploaded + " files uploaded, " + data.errors + " errors.");
    }
  });
});
// ]]>


function setPhotoTag(value, id) {	
	
	$("#Phototag" + id).html(value);	
	
}
	



function add_images(type, fName, fileObj, ID){

	if(type == 'logo'){

		$(".fileUploadListWrap").css('display','block');
		
		if(ID==1){
		
			var primary = '<a href="javascript:void(0);" class="iconPrimary" onclick="setPrimary('+ID+');" id="setprimary'+ID+'" style="color:#fff;background:#0a7f28;">Primary</a>';	
			var inputPrimary = '<input type="hidden" name="data[Image][primary][]" value="1" id="primaryphoto'+ID+'">';
		}
		else{
			var primary = '<a href="javascript:void(0);" class="iconPrimary" onclick="setPrimary('+ID+');" id="setprimary'+ID+'">Make Primary</a>';	
			var inputPrimary = '<input type="hidden" name="data[Image][primary][]" value="0" id="primaryphoto'+ID+'">';
		}
		
		$("#PhotoList").append('<li id="listid'+ID+'"><div class="leftFileBox"><div class="imgInfoCon"><input type="hidden" name="data[Image][name][]" value="'+fName+'" id="filename'+ID+'">'+inputPrimary+'<span class="fl">'+fName+' ('+ fileObj.size +') - Complete</span>'+primary+'</div><div class="progressBar">&nbsp;</div><div class="clear"></div><div class="photoTagName"><div class="photoUptagName" id="Phototag'+ID+'">&nbsp;</div> <a href="javascript:void(0);" onclick="addPhotoTag(\'tagPhoto'+ID+'\');">Photo tag</a> | <a href="javascript:void(0);" onclick="removePhoto('+ID+')">Remove</a><div id="tagPhoto'+ID+'" class="phototagField"><div class="elmRow"><div class="bgInput350"><input type="text" id="tag'+ID+'" name="data[Image][tag][]" value="Add a tag for your photo" onfocus="if(this.value==\'Add a tag for your photo\') this.value=\'\'" onblur="if(this.value==\'\') this.value=\'Add a tag for your photo\'" onkeyup="setPhotoTag(this.value,'+ID+')" maxlength="30"></div></div></div></div></div><div class="uplodPicBox"><img src="'+site_url+'app/webroot/uploads/temp/'+fName+'" width="41" height="45" alt="" /></div><div class="clear"></div></li>');
		
		setInterval("canHeight();",500);

	}
	
}