$(document).ready(function() {
	$('.thirty-days-nav').click(function(){
		$('.overlaybox, #thirtydays').fadeIn( "slow");
	});
	$('.Login').click(function(){
		$('.overlaybox, #loginpop').fadeIn( "slow");
	});
	$('.Register').click(function(){
		$('.overlaybox, #register-popup').fadeIn( "slow");
	});
$('.close-nav, .overlaybox').click(function(){
$('#thirtydays, #loginpop, #register-popup, .overlaybox').fadeOut('slow');
});
});	




$(document).ready(function() {

});
$(document).ready(function(){
    var highestBox = 0;
        $('.euual-height').each(function(){  
                if($(this).height() > highestBox){  
                highestBox = $(this).height();  
        }
    });    
    $('.euual-height').height(highestBox);
	$('.add-height').height(highestBox-22);
  var windw= $(window).width();
  if (windw <= 767 )  { 
 $('.euual-height').removeClass("euual-height");
 $('.add-height').removeClass("add-height");
 $('.desktop-tab').removeClass('desktop-tab');
 $('.profile-tabs-content').addClass('mobile-tabs');
 }
    function switch_tabs($obj){    
    $('.profile-tabs-content').hide(); 
    $('.profile-tabs-list li a').removeClass('active');
    var id = $obj.attr('href');
    $(id).show();
    $obj.addClass('active');
	}
  $('.profile-tabs-list li a').click(function(){
    switch_tabs($(this));

    return false;
  });
  switch_tabs($('.profile-tabs-list li a.active'));
});


function galleryPopOpen(str){
	//alert('#'+str);
		$('.galleryCont').css('display','none');
		$('#'+str).fadeIn('slow');
	}
	
// Popoup Script	
function popupOpen(str){
		//var popupText = $(this).attr('title');
//		$('.buttons').children('span').text(popupText);
		$('#'+str).css('display','block');
		$('#'+str).animate({"opacity":"1"}, 300);
		$('#'+str).css('z-index','9999999999');				
	}
	
function popupClose(str){
			$('#'+str).stop().animate({"opacity":"0"}, 300);
			$('#'+str).css({"display": "none"});			
			$('#'+str).css({"display": "none"});
				
	}
