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


$(function() {
  $('#slides').slidesjs({
	width: 940,
	height: 528,
	auto:1,
	navigation: {
	  effect: "fade"
	},
	pagination: {
	  effect: "fade"
	},
	effect: {
	  fade: {
		speed: 400
	  }
	}
  });
  $(function(){
	 $('.already-sign').click(function(){
		 $(this).children('.profile-list').slideToggle();
		 $(this).toggleClass('active'); 
	 });
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


