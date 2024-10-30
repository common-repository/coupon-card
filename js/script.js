(function($) {
  "use strict";

  	// Show coupon
	$('#cc-show-coupon').on('click', function(e){
		$(this).css({ 'display': 'none' });
		$('.cc-coupon').css({ 'display': 'inline-block' });
	});

	// Close Coupon card
	$('.cc-closo').on('click', function(){
		$('.coupon-card').removeClass('bounceInRight');
		$('.coupon-card').addClass('bounceOutRight');
	});

})(jQuery);
