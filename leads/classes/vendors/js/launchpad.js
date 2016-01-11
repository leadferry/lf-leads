jQuery(window).load( function() {

	if( local_data.form_id ) {
		var launchpad_id = local_data.form_id;
	}
	else{
		var launchpad_id = jQuery('form').attr('id');
	}

	var selector;

	if( launchpad_id ) {
		selector = "#" + launchpad_id;
	}
	else {
		selector = 'form';
	}

	jQuery( selector ).submit(function (e) {

		var form = this;
		e.preventDefault();

		var ajax_data = {
			action: 'launchpad_capture_lead',
			'firstname': jQuery( "#" + local_data.first_name ).val(),
			'lastname': jQuery( "#" + local_data.last_name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': launchpad_id,
		}
		
		jQuery.ajax( {
			url: local_data.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});

		jQuery( document ).ajaxComplete( function () {
			form.submit();
		});
	});
});