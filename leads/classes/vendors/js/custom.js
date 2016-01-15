jQuery(window).load( function() {

	if( local_data.form_id ) {
		var custom_id = local_data.form_id;
	}
	else{
		var custom_id = jQuery('form').attr('id');
	}

	var selector = ( custom_id ) ? "#" + custom_id : 'form';

	jQuery(selector).submit(function () {

		var ajax_data = {
			action: 'custom_capture_lead',
			'firstname': jQuery( '#' + local_data.first_name ).val(),
			'lastname': jQuery( '#' + local_data.last_name ).val(),
			'email': jQuery( '#' + local_data.email ).val(),
			'form_id': custom_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});