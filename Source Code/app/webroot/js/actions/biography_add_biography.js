$(document).ready(function(){
	$('#file_upload').uploadify({
		'uploader'  : SITE_URL+'js/uploadify/uploadify.swf',
		'script'    : SITE_URL+'biography/biography/upload',
		'cancelImg' : SITE_URL+'js/uploadify/cancel.png',
		'folder'    : 'files/biography',
		'removeCompleted' : false,
		'sizeLimit' : 10485760,
		'buttonImg'	: SITE_URL+'img/upload.jpg',
		'width'		: 90,
		'height'	: 28,
		'queueSizeLimit' : 100,
		'multi'          : false,
		'auto'        : true,
		'onComplete': function(event, ID, fileObj, responseText, data){
						try{
							var responseText = eval('(' + responseText + ')');
							
							if(responseText.error == false){
								$("#avatar_pics").attr('src',SITE_URL+"files/biography/150x150/"+responseText.filename);
								$("#userMainProfilePicture").attr('src',SITE_URL+"files/biography/160x160/"+responseText.filename);
								$("#BiographyAvatar").val(responseText.filename);
							} else {
								//alert("return false");
								showMessage(responseText.message, "errorMessage", 'recentUploadCon');
							}
						} catch(ex){
							//alert("error occur");
							show_default_error_message();
						}
		},
		'onError'   : function (event,ID,fileObj,errorObj) {
						//alert(errorObj.type + ' Error: ' + errorObj.info);
						
		},
		'onProgress'   : function (event,ID,fileObj,data) {
							//alert("In progress");
							$("#updateAvatar").removeClass('dnone');
		},
		'onAllComplete'   : function(event,data) {
							//alert("In complete");
							$("#updateAvatar").addClass('dnone');
		},
		'onSelect'   : function(event,data) {
							//alert("In select");
							$("#updateAvatar").removeClass('dnone');
		},
	});
	
	$(".albumPicBox").click(function(){
		$(".albumFrame").removeClass('blue-border');
		$(".albumFrame",$(this)).addClass('blue-border');
		$("#PhotoAlbumId").val($(this).attr('rel'));
	});
	
	$("#AlbumAddAlbumForm").submit(function(){
		var flag = true;
		if($("#album_type_existing").attr('checked')) {
			if(isEmpty($("#PhotoAlbumId").val())){
				$("#PhotoAlbumId").addClass("errorTxt");
				flag = false;
			}
		} else {
			if(isEmpty($("#AlbumAlbumTitle").val())){
				$("#AlbumAlbumTitle").parent().addClass('errorTxt');
				flag = false;
			}
		}
		return flag;
	});
});