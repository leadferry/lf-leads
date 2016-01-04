jQuery(window).load( function() {

	console.log(local_data);

	if( local_data.form_id ) {
		var wp_leads_id = local_data.form_id;
	}
	else{
		var wp_leads_id = jQuery('.inbound-now-form ').attr('id');
	}

	jQuery( "#" + wp_leads_id ).submit(function (e) {
		e.preventDefault();

		var ajax_data = {
			action: 'wp_leads_capture_lead',
			'firstname': jQuery( "#" + local_data.first_name ).val(),
			'lastname': jQuery( "#" + local_data.last_name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': wp_leads_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});