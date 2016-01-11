jQuery(window).load( function() {

	function attachHook() {

		if( jQuery('.sumome-contactform-button').length == 0 ) {
			setTimeout( attachHook, 1000 );
		}
		else {
			jQuery('.sumome-contactform-button').on( 'click', function () {

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
		}
	}
    attachHook();
});