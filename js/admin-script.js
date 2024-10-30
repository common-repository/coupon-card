(function($) {
	"use strict";

	// Variables to be used in scope
	var uploadBackground;

	$( '#cc-btn-background' ).on('click', function(e){
		e.preventDefault();

		// If the media frame already exists, reopen it.
		if(uploadBackground){
			uploadBackground.open();
			return;
		}

		// Create a new media frame
		var uploadBackground = wp.media({
			title: 'Choose a background image',
			button: {
				text: 'Use this image'
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected in the media frame.
		uploadBackground.on('select', function(){
			var image = uploadBackground.state().get('selection').first().toJSON();
			$('#cc-background-url').val(image.url);
		});

		// Finally, open the modal on click
		uploadBackground.open();

	});

	$('#cc-coupon').on('click', function(){
		$('.cc-coupon-box').fadeIn('slow');
	});

	$('#cc-discount').on('click', function(){
		$('.cc-coupon-box').fadeOut('slow');
	});

	/*-------------------------------------------------------------------------
     ========================= Send data to database ==========================
     -------------------------------------------------------------------------*/
    
    $('#cc-publish').on( 'click', function(e){
        e.preventDefault();
        var page = $("#cc-page option:selected").val();
        var title = $('#cc-title').val();
        var btntitle = $('#cc-btn-title').val();
        var aff_url = $('#aff-url').val();
        var bg_url = $('#cc-background-url').val();
        var type = $('input[name=offer-type]:checked').val();
        var reply = $('#reply');
        var coupon = '';
        if( type === 'coupon' ){
        	var coupon = $('#cc-coupon-code').val();
        }

        $.ajax({
            url: ajaxurl,
            method: "POST",
            dataType: "json",
            data: {
                action: 'card',
                page: page,
                title: title,
                btntitle: btntitle,
                aff_url: aff_url,
                bg_url: bg_url,
                type: type,
                coupon: coupon,
                security: CC.security
            },
            success: function( response ){
                if( !response.error  ){
                	reply.html( '<p class="cc-success">' + response.success + '</p>' );
                } else {
                	reply.html( '<p class="cc-error">' + response.error + '</p>' );
                }
            },
            error: function( error ){
            	
            }
        });

    } );

    /*-------------------------------------------------------------------------
     =========================== Delete coupon card ===========================
     -------------------------------------------------------------------------*/

    $('.cc-delete').on( 'click', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var t_row = $('#card-'+id);
        var con = confirm( CC.delete );
        
        if( con ){

            $.ajax({
                url: ajaxurl,
                method: "POST",
                dataType: "json",
                data: {
                    action: 'delete_card',
                    id: id,
                    security: CC.security
                },
                success: function( response ){
                    if( response.data == true ){
                        t_row.css('background', 'red');
                        t_row.fadeOut('slow');
                    }
                },
                error: function( error ){
                    
                }
            });
        }

    } );

})(jQuery);