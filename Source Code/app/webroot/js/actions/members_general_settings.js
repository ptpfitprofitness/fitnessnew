$(document).ready(function(){
	$(".updateForm").click(function(){
		var fid = $(this).attr('id');
		var data = $("#"+fid+"Form").serialize();
		var url = SITE_URL+"members/ajax";
		var flag = true;
		
		$("#"+fid+"Form .required").each(function(){
			if(isEmpty($(this).val())){
				$(this).parent().addClass('errorTxt');
				flag = false;
			} 
		});
		
		if(flag){
			$("#"+fid+"Loading").removeClass('dnone');
			$.ajax({
				url:url,
				data:data,
				type:'POST',
				asynch:false,
				success:function(responseText){
					try{
						var responseText = eval('(' + responseText + ')');
						var class_name = 'successMessage';
						var message = responseText.message;
						var parent_node = fid+"Fieldset";
						if(responseText.error == true)
							class_name = "errorMessage";
						showMessage(message, class_name, parent_node);
						$("#"+fid+"Loading").addClass('dnone');
					} catch(ex){
						show_default_error_message();
					}
				}
			});
		}
		return false;
	});
});