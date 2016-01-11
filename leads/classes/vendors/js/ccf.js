jQuery(window).load( function() {

	if( local_data.form_id ) {
		var ccf_id = local_data.form_id;
	}
	else{
		var ccf_id = jQuery('.ccf-form').attr('data-form-id');
	}

	jQuery('.ccf-form').submit(function () {


		var ajax_data = {
			action: 'ccf_capture_lead',
			'firstname': jQuery("#" + local_data.first_name ).val(),
			'lastname': jQuery("#" + local_data.last_name ).val(),
			'email': jQuery("#" + local_data.email ).val(),
			'form_id': ccf_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});