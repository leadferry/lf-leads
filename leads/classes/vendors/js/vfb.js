jQuery(window).load( function() {

	jQuery('.visual-form-builder').submit(function ( e ) {


		var ajax_data = {
			action: 'vfb_capture_lead',
			'firstname': jQuery( "#" + ajax_object.name ).val(),
			'email': jQuery(  "#" + ajax_object.email  ).val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});