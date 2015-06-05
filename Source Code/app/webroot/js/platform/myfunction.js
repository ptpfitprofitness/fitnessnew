// popup function
var access_token='';
/* function popupOpen(str){
	$('#' + str).fadeIn('slow');
	$('.layer').fadeIn('slow');
}
function popupClose(str){
	$('#' + str).fadeOut('slow');
	$('.layer').fadeOut('slow');
}
 */
//custom scroll bar
$(window).load(function() {
	//mCustomScrollbars();
});

function mCustomScrollbars(){
	$("#mcs_container").mCustomScrollbar("vertical",600,"easeOutCirc",1.05,"auto","yes","yes",15); 
	$("#mcs_containerHandly").mCustomScrollbar("vertical",600,"easeOutCirc",1.05,"auto","yes","yes",15); 
}

/* function to fix the -10000 pixel limit of jquery.animate */
$.fx.prototype.cur = function(){
    if ( this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null) ) {
      return this.elem[ this.prop ];
    }
    var r = parseFloat( jQuery.css( this.elem, this.prop ) );
    return typeof r == 'undefined' ? 0 : r;
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
	$("#"+id+" .customScrollBox .content").load(file,function(){
		mCustomScrollbars();
	});
}



 /*script showing FILE BROWSER VALUE */


function  changeFile(getVal, setVal){
	 document.getElementById(setVal).value = getVal;	
  }

 /*end script showing FILE BROWSER VALUE*/
  
  
  
$(document).ready(function(){
	
	$(".confirmBidEdu").click(function(){
		var userId = $(this).attr("id");
		if(userId != ""){
			if( $("#eduEmailAddress").val() != "" ) {
				var eduEmail = validateEdu($("#eduEmailAddress"));
				if(eduEmail != "" && eduEmail != undefined){
					$("#eduEmailAddress").css("border","1px solid red");
				}else{
					$("#bid-response").slideDown();
					$.ajax({
						url:site_url+"browse/resendEduConfirmation",
						type:"POST",
						data:{email:$("#eduEmailAddress").val(),user_id:userId},
						dataType:"json",
						success:function(e){
							if(e.error == 1){
								$("#bid-response").html("<span style='margin-left: 2px;' class='error'>"+e.message+"</span>");
								return false;
							}else if(e.error == 0){
								$("#bid-response").html("<span class='success'>An activation is succesfully sent on .edu email address</span>");	
								location.reload();
							}							
						}
					});
				}
				return false;
			}else{
				$("#eduEmailAddress").css("border","1px solid red");
			}
		}
	});
	
	$(".releasefundandpay").click(function(){
		if($(this).attr("id")) {
			
			var r = confirm("Are you sure want to release the funds?");
			if(!r) return false;
			
			var current = $(this).next("div:first").fadeIn();			
			var admin = 0;
			if($(this).hasClass("admin"))
				admin = 1;
			
			$.ajax({
				url:site_url+"tasks/releaseFunds",
				type:"POST",
				data:{id:$(this).attr("id"),isAdmin:admin},
				success:function(e){
					var current = $(this).next("div:first").html("<span style='color:green'>Amount Successfully Transfered!</span>");
					location.reload();					
				}
			});
		}
	});
	
	$(".confirmAmazon1").click(function(){
		if ( $(this).attr("id") ){ 
			window.location = $(this).attr("id");
		} 
	});
	
	$(".markCompleted").click(function(){
		
		if( $(this).attr("id") ) {
			popupOpen('postBidForm1');
			$("#MemberTaskIds").val($(this).attr("id"));
			$("#poster").html($(this).attr("rel"));
			
			if($(this).hasClass("quickhire")) var taskType = "quickhire";else  var taskType = "task";
			$("#MemberTaskTypes").val(taskType);
		}
	});
		
	$(".leaveReview").click(function(){		
		popupOpen('leaveReview');		
		if($(this).hasClass("quickhire")) var type = "1"; else var type = "0";
			
		$("#MemberTaskType").val(type);
		$("#MemberReviews").val($(this).attr("id"));
	});
		
	$("#updateReview").click(function(){
		$("#MemberLeaveReviewsForm").submit();			
		return false;
	}); 
		
	$(".messagebox").click(function(){window.location = $(this).attr("id");	});
	$(".messagebox1").click(function(){	window.location = $(this).attr("id");});
  
	$(".conTabDiv").hide();
	//to fix u know who
	$(".conTabDiv:first").show();
	
	$(".msgNavi a").click(function()
	{
		$('.msgNavi li').removeClass('currentMenu');
		stringref = $(this).attr("href").split('#')[1];
		$(this).parent('li').addClass('currentMenu');
		$('.conTabDiv:not(#'+stringref+')').hide();
		if ($.browser.msie && $.browser.version.substr(0,3) == "6.0") {
			$('.conTabDiv#' + stringref).show();
		}else 
		$('.conTabDiv#' + stringref).css("display", "block");
		return false;
		
		
		
	});
	
	$("#TaskCategoryId").change(function(){
		if( $(this).val() != "" ) {
			$.ajax({
				url:site_url+"browse/loadSubCategories",
				type:"POST",
				data:{id:$(this).val()},
				dataType:"json",
				success:function(e){
					$("#TaskSubcategoryId").children().remove();
					if( $("#TaskSubcategoryId").parent().parent().parent().attr("id") == "s-box-m5")
						$("#TaskSubcategoryId").append($('<option></option>').val("").html("--Select SubCategory--"));
					else
						$("#TaskSubcategoryId").append($('<option></option>').val("").html("Pick a SubCategory"));
						
					$.each(e,function(id,name){
						$("#TaskSubcategoryId").append($('<option></option>').val(id).html(name));
					});
				}
			});
		}
	});
	
	$("#HirerTaskCategoryId").change(function(){
		var current = $(this);
		if( $(this).val() != "" ) {
			$.ajax({
				url:site_url+"browse/loadSubCategories",
				type:"POST",
				data:{id:$(this).val()},
				dataType:"json",
				success:function(e){				
					$("#hirHelpler").children().remove();
					$("#hirHelpler").append($('<option></option>').val("").html("--Select SubCategory--"));
					$.each(e,function(id,name){
						$("#hirHelpler").append($('<option></option>').val(id).html(name));
					});
				}
			});
		}
	});
	
	$("#s-box-m3 ul li").live("click",function(){
		if( $(this).attr("id") != "" ) {
			if( location.href == site_url) {
				var limits = 6;
			}else{
				var limits = 100;
			}
			
			$.ajax({
				url:site_url+"browse/sort_jobs",
				type:"POST",
				data:{sort:$(this).attr("id"),keyword:$("#BrowseKeyword").val(),limit:limits,category:$("#BrowseSearchKeyword").val(),subcategory:$(".subCategoryActive").attr("id")},
				success:function(e){
					$("#seaechResult").html(e);
					/* $("#mcs_container").mCustomScrollbar("vertical",500,"easeOutCirc",1.05,"auto","yes","yes",15);
					$("#mcs_container1").mCustomScrollbar("vertical",500,"easeOutCirc",1.05,"auto","yes","yes",15); */
				}
			});		
		}
	});
	
	$("#s-box-m4 ul li").live("click",function(){
		if( $(this).attr("id") != "" ) {
		
			if( location.href == site_url) {
				var limits = 6;
			}else{
				var limits = 100;
			}
			
			$.ajax({
				url:site_url+"browse/sort_quick_jobs",
				type:"POST",
				data:{sort:$(this).attr("id"),keyword:$("#BrowseKeyword").val(),limit:limits,category:$("#BrowseSearchKeyword").val(),subcategory:$(".subCategoryQuickActive").attr("id")},
				success:function(e){
					$("#seaechQuickResult").html(e); 
					/* $("#mcs_container").mCustomScrollbar("vertical",500,"easeOutCirc",1.05,"auto","yes","yes",15);
					$("#mcs_container1").mCustomScrollbar("vertical",500,"easeOutCirc",1.05,"auto","yes","yes",15); */
				}
			});		
		}
	});
	
	$("#s-box-m2 ul li").live("click",function(){
		if( $(this).attr("id") != "" ) {
			$.ajax({
				url:site_url+"browse/loadSubCategories",
				type:"POST",
				data:{id:$(this).attr("id")},
				dataType:"json",
				success:function(e){
					$("#pickuptime3_container ul li").remove();
					var i = 0;
					$.each(e,function(id,name){
						if(i==0){
							$("#pickuptime3_input").val(name);
							$("#subcategory_id").val(id);
						}
							
						$("#pickuptime3_container ul").append('<li id="pickuptime3_input_'+id+'">'+name+'</li>');
						i++;
					});
					
					$("#s-box-m5 ul li").bind("click",function(){
						$("#pickuptime3_input").val(name);
						return false;
					});
				}
			});
		}
	});	
	
	$(".subCategorySort").live("click",function(){
		if($(this).attr("id"))	{
			var currentCategory = $(this);
			var subCategoryId = $(this).attr("id");
			var Ids = subCategoryId.split("|");
			$.ajax({
				url:site_url+"browse/sortSubCategories",
				type:"POST",
				data:{id:$(this).attr("id")},
				success:function(e){
					var currentPage = location.href;
					if(currentPage.indexOf("tasks") < 0) 
						$("#subCategoryParse").html(e);		
					else 
						$("#seaechQuickResult").html(e);
				
					//$("#TaskSubcategoryId").val(Ids[0]);
					$("#hirHelpler").val(Ids[0]);
					
					$(".subCategorySort").removeClass("subCategoryQuickActive");
					$(".subCategorySort").css({"font-weight":"normal","text-decoration":"none"});		
					$(currentCategory).css({"font-weight":"bold","text-decoration":"underline"});		
					$(currentCategory).addClass("subCategoryQuickActive");
				}
			});		
		}
	});
	
	$(".subCategorySortTask").live("click",function(){
		if($(this).attr("id"))	{
			var currentCategory = $(this);
			var subCategoryId = $(this).attr("id");
			var Ids = subCategoryId.split("|");
			$.ajax({
				url:site_url+"browse/sortSubCategoriesTask",
				type:"POST",
				data:{id:$(this).attr("id")},
				success:function(e){
					$("#seaechResult").html(e);				
					$("#TaskSubcategoryId").val(Ids[0]);
					
					$(".subCategorySortTask").removeClass("subCategoryActive");		
					$(".subCategorySortTask").css({"font-weight":"normal","text-decoration":"none"});		
					$(currentCategory).css({"font-weight":"bold","text-decoration":"underline"});		
					$(currentCategory).addClass("subCategoryActive");
				}
			});		
		}
	});
	
	$(".friends").live("click",function(){
		if( $(this).hasClass("activeFacebook") ){
			$(this).removeClass("activeFacebook");
			$(this).attr("style","");
		}else{		
			$(this).addClass("activeFacebook");		
			$(this).attr("style","background-color:#FFD83F");
		}
		return false;
	});
	
	$(".selectAllFriends").live("click",function(){
		$(".friends").each(function(){
			if( $(this).hasClass("activeFacebook") ){
				/* $(this).removeClass("activeFacebook");
				$(this).attr("style",""); */
			}else{		
				$(this).addClass("activeFacebook");		
				$(this).attr("style","background-color:#FFD83F");
			}
		});		
		
		$(this).html("DeselectAll");
		$(this).removeClass("selectAllFriends");
		$(this).addClass("deselectAllFriends");		
	
	});
	
	$(".deselectAllFriends").live("click",function(){
		$(".friends").each(function(){
			if( $(this).hasClass("activeFacebook") ){
				$(this).removeClass("activeFacebook");
				$(this).attr("style","");
			}else{		
				/* $(this).addClass("activeFacebook");		
				$(this).attr("style","background-color:#FFD83F"); */
			}
		});		
		
		$(this).html("SelectAll");
		$(this).removeClass("deselectAllFriends");
		$(this).addClass("selectAllFriends");
	});
	
	$(".hasDocument").click(function(){
		if($(this).is(":checked")){
			$("#uploadDocument").fadeIn();
		}else{
			$("#uploadDocument").fadeOut();
		}
	});
	
	$(".settings").click(function(){
		if($(this).attr("checked") == "checked")
			var value = $(this).val();
		else
			var value = 0;
		
		$.ajax({
			url:site_url+"members/updateAlerts",
			data:{name:$(this).attr("name"),value:value},
			type:"POST",
			success:function(e){}
		});				
	});
	
	$("#seaechResult .row .img").click(function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$(".taskListRow").live("click",function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$(".taskListRow1").live("click",function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$(".taskListRow3").live("click",function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$("#seaechResult .row .col_1").click(function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$(".discuss .chatbx_main .mid .row").click(function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$("#seaechQuickResult .row1").click(function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});	
	
	$("#subCategoryParse .row1").click(function(){
		if($(this).attr("id")) window.location = $(this).attr("id");
	});
	
	$(".releasefunds").click(function(){
		
		if($(this).attr("id")){
			
			var r = confirm("Are you sure want to release the funds?");
			if(!r) return false;
			
			var admin = 0;
			if($(this).hasClass("admin"))
				admin = 1;
			
			$(this).parent().next("div#releaseResponse:first").fadeIn();
			$.ajax({
				url:site_url+"members/releaseTaskFund",
				type:"POST",
				dataType:"json",
				data:{taskId:$(this).attr("id"),isAdmin:admin},
				success:function(e){	
					if(e.error == 1)
						$(this).parent().next("div#releaseResponse:first").html("<span style='color:red'>"+e.message+"</span>");
					else
						$(this).parent().next("div#releaseResponse:first").html("<span style='color:green'>"+e.message+"</span>");
				
					location.reload();
				}
			});		
		}
		return false;
	});
	
});
  
	function validateEdu(field,i,rules,options) {
		if( field.val() != "") {
			var value    = field.val();
			var parts    = value.split(".");
			var extCount = parts.length;
			extCount--;
			
			if(parts[extCount] != "edu") {
				return "This email should have a valid .edu address";
			}
		}
	}
	
	function changetab(tabname)
	{
		//alert(tabname);
		$.cookie("activeTab",tabname);		
		if(tabname=='chgpwd'){
			$("#myaccount").css('display','none');		
			$("#chgpwd").css('display','block');
			$("#cpassword").parent().addClass("currentMenu");
			$("#uinformation").parent().removeClass("currentMenu");
		}else{
			$("#myaccount").css('display','block');		
			$("#chgpwd").css('display','none');
			$("#cpassword").parent().removeClass("currentMenu");
			$("#uinformation").parent().addClass("currentMenu");
		}
		//alert($.cookie("activeTab"));
	}
	
	function postToWall() {
		
		var friendIds = new Array();
		var i = 0;
		$(".activeFacebook").each(function(){
			friendIds[i] = $(this).attr("id");
			//$(this).removeClass("activeFacebook");
			i++;	
		});	
		
		if(friendIds.length > 0) {
			if( $("#post_message").val() != "Please write your message here!" ) {
				var messages = $("#post_message").val();
			}else{
				var messages = 'Helpler.com';
			}
			
			FB.ui({method: 'apprequests',redirect_uri : site_url,to: friendIds.join(","),title : 'Helpler.com',		message : messages},clearFacebook);		 
		}else{
			$("#facebookPostResponse").html("<p style='color:red;'>Please select at least one friend</p>");
		}
		$("#facebookPostResponse").slideDown();		
	}
	
	function clearFacebook(response) {		
		if(response != null) {
			$("#post_message").val("Please write your message here!");
			$("#facebookPostResponse").html("<p>Invitation Successfully Sent!</p>");
			setTimeout("clearFacebook1()",2000); 			
		}		
	}
	
	function clearFacebook1(){
		$("#facebookPostResponse").slideUp();
		$("#postButton").hide();
		$("#facebookFriends").hide();
		$("#facebookButton").show();
	}
	
	function facebookLogin() 
	{
		FB.login(function(response) {
			if (response.authResponse) {
				access_token =   FB.getAuthResponse()['accessToken'];
				FB.api('/me', function(response) {
					var query = 'SELECT uid,name,pic FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = '+response.id+') order by name';
				
					FB.api('/fql',{q:query}, function(friends){
						if( friends.data.length > 0 ) {
							$("#facebookButton").hide();
							$("#postButton").show();
							$("#facebookFriends").slideDown();
							$("#facebookFriends ul li").remove(); 
							var i = 0;
							$(".propdiv").html("");
							$.each(friends.data,function(id,friend)
							{
								if(i==0){ i=1;var className = "gray"; }else{ var className = "white"; i=0;} 
								$(".propdiv").append("<div id='"+friend.uid+"' class='friends "+className+"'><table width='50%'><tr><td align='center' width='20%'><img width='50px' height='50px' src='"+friend.pic+"'></td><td  valign='top' align='left' width='70%'><table width='100%' align='left'><tr><td valign='top'>"+friend.name+"</td></tr></table></td></tr></table></div>");
							});	
							
							$("#mcscontainer").niceScroll({cursorcolor:"#ccc",cursoropacitymax:1,cursorwidth:12});
							
							/* if(friends.data.length >20)
								mCustomScrollbars(); */
						}
					});
				});
				return false;
			}
		});		
	}
	
	function hireQuickTask() {
		
		if( $(".hireme").attr("id") ){
			var id     =  $(".hireme").attr("id");
			var userId =  id.split("|");
			$("#loader"+userId[0]).fadeIn();
			
			if( userId[1] != ""){
				$.ajax({
					url:site_url+"tasks/hireme",
					type:"POST",
					data:{taskId:userId[0],user_id:userId[1],request:$(".hireme").attr("id")},
					success:function(e){
						$("#loader"+userId[0]).fadeOut();
						window.location = site_url+"members/taskposted";
					}
				});		
			}else{
				popupOpen('login');
				lastAction = 'hiring';
				window.scrollTo(200,0);
			}
		}
	}
	
	function displayDetail(elem){
	
		if( $("."+elem.id).css("display") == "block"){
			$("."+elem.id).slideUp();			
			$("#"+elem.id+" img").attr("src",site_url+"img/marketplace/downarrow.png");			
		}else{
			$("."+elem.id).slideDown();			
			$("#"+elem.id+" img").attr("src",site_url+"img/marketplace/uparrow.png");
		}
		
	}