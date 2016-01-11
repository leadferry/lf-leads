jQuery(window).load( function() {

	if( local_data.form_id ) {
		var pardot_id = local_data.form_id;
	}
	else{
		var pardot_id = jQuery('[id^="form-wysija-"]').attr('id');
	}

	jQuery('.pardotform').contents().find('#pardot-form').submit(function () {


		var ajax_data = {
			action: 'pardot_capture_lead',
			'firstname': jQuery("input[name='" + local_data.first_name + "']").val(),
			'lastname': jQuery("input[name='" + local_data.last_name + "']").val(),
			'email': jQuery("input[name='" + local_data.email + "']").val(),
			'form_id': pardot_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});