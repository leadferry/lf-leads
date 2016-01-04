jQuery(window).load( function() {

	if( local_data.form_id ) {
		var mailpoet_id = local_data.form_id;
	}
	else{
		var mailpoet_id = jQuery('[id^="form-wysija-"]').attr('id');
	}

	jQuery( "#" + mailpoet_id ).submit(function () {


		var ajax_data = {
			action: 'mailpoet_capture_lead',
			'firstname': jQuery("input[name='" + local_data.first_name + "']").val(),
			'lastname': jQuery("input[name='" + local_data.last_name + "']").val(),
			'email': jQuery("input[name='" + local_data.email + "']").val(),
			'form_id': mailpoet_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});