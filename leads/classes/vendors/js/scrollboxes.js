jQuery(window).load( function() {

	jQuery('.stbContactForm').submit(function() {


		var ajax_data = {
			action: 'scrollboxes_capture_lead',
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