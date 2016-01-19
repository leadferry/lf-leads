jQuery(window).load( function() {


	jQuery( ".hb-cta" ).on( 'submit', function () {
		console.log("click");

		var ajax_data = {
			action: 'hellobar_capture_lead',
			'firstname': jQuery( ).val(),
			'email': jQuery().val(),
			'form_id': hellobar_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});