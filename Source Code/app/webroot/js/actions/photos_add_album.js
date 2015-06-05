$(document).ready(function(){
	$('#file_upload').uploadify({
		'uploader'  : SITE_URL+'js/uploadify/uploadify.swf',
		'script'    : SITE_URL+'photos/photos/upload',
		'cancelImg' : SITE_URL+'js/uploadify/cancel.png',
		'folder'    : 'files/photos',
		'removeCompleted' : false,
		'sizeLimit' : 10485760,
		'buttonImg'	: SITE_URL+'img/upload.jpg',
		'width'		: 90,
		'height'	: 28,
		'queueSizeLimit' : 100,
		'multi'          : true,
		'auto'        : true,
		'onComplete': function(event, ID, fileObj, responseText, data){
						//try{
							var responseText = eval('(' + responseText + ')');
							
							if(responseText.error == false){
								
								var temp_html = '<div class="uploadConRow" id="uploadConRow_'+responseText.filename+'"><div class="uploadPic cursor-pointer" rel="'+responseText.filename+'" onClick="make_cover_photo(\''+responseText.filename+'\',this);"><img alt="" src="'+responseText.url+'"></div><div class="removeBtn fr"><div class="grayBtnWrap"><a href="javascript:void(0);" rel="uploadConRow_'+responseText.filename+'" onClick="delete_album_photo(\''+responseText.filename+'\');">Remove<span class="btnCurveRight"></span></a></div></div><div class="clear"></div> <input type="hidden" name="photo_path[]" value="'+responseText.filename+'" /></div>';
								$("#recentUploadCon").prepend(temp_html);
								
								//### show the next step [Choose an album for your photos]
								$("#choose_album_step_2").removeClass('dnone');
								//alert("completed");
								
							} else {
								showMessage(responseText.message, "errorMessage", 'recentUploadCon');
							}
						//} catch(ex){
						//	show_default_error_message();
						//}
		},
		'onError'   : function (event,ID,fileObj,errorObj) {
						//alert("error");
						
		},
		'onProgress'   : function (event,ID,fileObj,data) {
							$("#updateMemberNameLoading").removeClass('dnone');
							//alert("on progress");
		},
		'onAllComplete'   : function(event,data) {
							$("#updateMemberNameLoading").addClass('dnone');
							//alert("all completed");
		},
		'onSelect'   : function(event,data) {
							$("#updateMemberNameLoading").removeClass('dnone');
							//alert("seelcted");
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

function delete_album_photo(file_id){
	document.getElementById("recentUploadCon").removeChild(document.getElementById("uploadConRow_"+file_id));
	var n = $('#recentUploadCon').children('div').length;
	if(n==0){
		$("#choose_album_step_2").addClass('dnone');
		$("#temp_selection_message").removeClass('dnone');
		$("#create_an_album").addClass('dnone');
		$("#choose_an_album").addClass('dnone');
	}
}

function make_cover_photo(fl_name, elm){
	if($(elm).hasClass('blue-border')) {
		$("#AlbumCoverPhoto").val('');
		$(".uploadPic").removeClass('blue-border');
		//$(elm).removeClass('blue-border');
	} else {
		$("#AlbumCoverPhoto").val(fl_name);
		$(".uploadPic").removeClass('blue-border');
		$(elm).addClass('blue-border');
	}
	
	
}