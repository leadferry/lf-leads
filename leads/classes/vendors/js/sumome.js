jQuery(window).load( function() {

	setTimeout( function() {

		jQuery('button.sumome-contactform-button.sumome-contactform-button-text').on( 'click', function () {

			var ajax_data = {
				action: 'sumome_capture_lead',
				'email': jQuery( "#" + local_data.email ).val(),
			}
			
			jQuery.ajax( {
				url: local_data.url,
				type: 'POST',
				dataType: 'json',
				data: ajax_data,
			});
		});

	}, 5000 );	
});
