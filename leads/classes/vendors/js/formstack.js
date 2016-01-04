jQuery(window).load( function() {

	if( local_data.form_id ) {
		var formstack_id = local_data.form_id;
	}
	else{
		var formstack_id = jQuery('[id^="fsForm"]').attr('id');
	}

	jQuery("#" + formstack_id).submit(function () {

		var ajax_data = {
			action: 'formstack_capture_lead',
			'firstname': jQuery( "#" + local_data.first_name ).val(),
			'lastname': jQuery( "#" + local_data.last_name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': formstack_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});