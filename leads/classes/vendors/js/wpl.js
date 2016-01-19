jQuery(window).load( function() {

	console.log(local_data);

	if( local_data.form_id ) {
		var wpl_id = local_data.form_id;
	}
	else{
		var wpl_id = jQuery('.inbound-now-form').attr('id');
	}

	jQuery("#" + wpl_id).submit(function () {

		var ajax_data = {
			action: 'wpl_capture_lead',
			'firstname': jQuery( '#' + local_data.first_name ).val(),
			'lastname': jQuery( '#' + local_data.last_name ).val(),
			'email': jQuery( '#' + local_data.email ).val(),
			'form_id': wpl_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});