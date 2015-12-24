jQuery(window).load( function() {

	jQuery('.inbound-now-form ').submit(function() {


		var ajax_data = {
			action: 'wp_leads_capture_lead',
			'firstname': jQuery( "#" + ajax_object.firstname ).val(),
			'lastname': jQuery( "#" + ajax_object.lastname ).val(),
			'email': jQuery(  "#" + ajax_object.email ).val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});