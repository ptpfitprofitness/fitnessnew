function writeCookie(name,value,days) {
	if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
	}
	else 
		var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') 
				c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) 
				return c.substring(nameEQ.length,c.length);
	}
	return null;
}


function deleteCookie(name) {
	createCookie(name,"",-1);
}


$(document).ready(function(){
	//################ SAVE USERNAME/PASSWORD WHEN REMEMBER ME CHECKED ############
	$("#MemberLoginForm").submit(function(){
		if($("#remember_me").attr('checked')){
			var username = $("#MemberEmail").val();
			var password = $("#MemberPassword").val();
			if(username!='' && password !=''){
				writeCookie("MyDementiaUserName",username,365);
				writeCookie("MyDementiaPassword",password,365);
			}
		} else {
			
		}
	});
	//################ END SAVE USERNAME/PASSWORD WHEN REMEMBER ME CHECKED ############
	
	//################ READ SAVED USERNAME/PASSWORD ############
	
	var username = readCookie('MyDementiaUserName');
	var password = readCookie('MyDementiaPassword');
	if(username) $("#MemberEmail").val(username);
	if(password) $("#MemberPassword").val(password);	
});