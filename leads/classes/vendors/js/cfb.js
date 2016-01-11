jQuery(document).ready( function() {

	if( local_data.form_id ) {
		var cfb_id = local_data.form_id;
	}
	else{
		var cfb_id = jQuery('form').attr('id');
	}

	jQuery( "#" + cfb_id ).submit(function () {

		var ajax_data = {
			action: 'cfb_capture_lead',
			'firstname': jQuery( "#" + local_data.first_name ).val(),
			'lastname': jQuery( "#" + local_data.last_name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': cfb_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});