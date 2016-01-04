jQuery(window).load( function() {

	if( local_data.form_id ) {
		var scrollboxes_id = local_data.form_id;
	}
	else{
		var scrollboxes_id = jQuery('.stbContactForm').attr('id');
	}

	var selector;

	if( scrollboxes_id ) {
		selector = "#" + scrollboxes_id;
	}
	else {
		selector = '.stbContactForm';
	}

	jQuery( selector ).submit(function () {


		var ajax_data = {
			action: 'scrollboxes_capture_lead',
			'firstname': jQuery( "#" + local_data.first_name ).val(),
			'lastname': jQuery( "#" + local_data.last_name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': scrollboxes_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});