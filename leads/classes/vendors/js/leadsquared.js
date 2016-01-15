jQuery(window).load( function() {

	if( local_data.form_id ) {
		var leadsquared_id = local_data.form_id;
	}
	else{
		var leadsquared_id = jQuery('[id^="frmrlp-"]').attr('id');
	}

	jQuery("#" + leadsquared_id).submit(function (e) {

		var form = this;
		e.preventDefault();

		var ajax_data = {
			action: 'leadsquared_capture_lead',
			'firstname': jQuery( '#' + local_data.first_name ).val(),
			'lastname': jQuery( '#' + local_data.last_name ).val(),
			'email': jQuery( '#' + local_data.email ).val(),
			'form_id': leadsquared_id,
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