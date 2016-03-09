jQuery(window).load( function() {
	jQuery('.wpcf7-form').submit(function (e) {
		var form = this;
		e.preventDefault();

		var ajax_data = {
			action: 'custom_capture_lead',
			'firstname': jQuery( '#' + local_data.first_name ).val(),
			'lastname': jQuery( '#' + local_data.last_name ).val(),
			'email': jQuery( '#' + local_data.email ).val(),
			'form_id': local_data.form_id ,
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
