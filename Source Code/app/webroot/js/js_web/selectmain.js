jQuery(document).ready(function() {
    jQuery('#mycarouse').jcarousel();
});

$(document).ready(function() {    

makeslect('#my_select1');
makeslect('#my_select2');
makeslect('#my_select3');
makeslect('#my_select4');
makeslect('#my_select5');
makeslect('#my_select6');
makeslect('#my_select7');
makeslect('#my_select8');
makeslect('#my_select9');
makeslect('#my_select10');
makeslect('#my_select11');
makeslect('#my_select12');
});
function makeslect(id)
{
// Create Select box
    	//var no_select = $('option').length;

		//alert(id);
		 //  $(id).each(function(j){
			
				var no_select = $(id).find('option').length;
				var i=0;
					no_select = no_select-1;

					for(i;i<=no_select;i++)
						{
								//alert($(this).find('option').eq(i).val());
							$(id).find('.me_list ul').append('<li>' + $(id).find('option').eq(i).val()+'</li>');
						}
		//	});
			// show and hide selectbox
					//.find(":input")	
					//.find('.me_list')
				  $(id).find(":input").click(function(){

						     $(this).parent().parent().find('.me_list').slideToggle();
				    });
						  
						  						  
					  $(id).find('.me_list').mouseleave(function(){
							 $(this).parent().find('.me_list').slideUp();
					});
				 


			//SHOW SELECTION VALUE
			
			$(id).find('.me_list ul li').click(function(){
					var selected_value = $(this).text();
				
					 $(this).parent().parent().parent().find('.ckl').val(selected_value);
					 $(this).parent().parent().hide();			
				});			

}