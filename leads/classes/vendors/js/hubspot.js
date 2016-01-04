jQuery(window).load( function() {

	if( local_data.form_id ) {
		var hubspot_id = local_data.form_id;
	}
	else{
		var hubspot_id = jQuery('[id^="hsForm_"]').attr('id');
	}
	
	jQuery("#" + hubspot_id).submit(function () {

		var ajax_data = {
			action: 'hubspot_capture_lead',
			'firstname': jQuery("input[name=firstname]").val(),
			'lastname': jQuery("input[name=lastname]").val(),
			'email': jQuery("input[name=email]").val(),
			'form_id': hubspot_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});