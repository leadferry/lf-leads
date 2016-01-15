jQuery(window).load( function() {

	if( local_data.form_id ) {
		var simplycast_id = local_data.form_id;
	}
	else{
		var simplycast_id = jQuery('[id^="scInlineForm-"]').attr('id');
	}

	jQuery("#" + simplycast_id).submit(function () {

		var ajax_data = {
			action: 'simplycast_capture_lead',
			'firstname': jQuery( '[name="' + local_data.first_name + '"]' ).val(),
			'lastname': jQuery( '[name="' + local_data.last_name + '"]' ).val(),
			'email': jQuery( '[name="' + local_data.email + '"]' ).val(),
			'form_id': simplycast_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});