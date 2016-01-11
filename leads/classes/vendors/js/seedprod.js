jQuery(window).load( function() {

	if( local_data.form_id ) {
		var seedprod_id = local_data.form_id;
	}
	else{
		var seedprod_id = jQuery('[id$="-form"]').attr('id');
	}

	jQuery( "#" + seedprod_id ).submit(function (e) {

		var form = this;
		e.preventDefault();
		
		var ajax_data = {
			action: 'seedprod_capture_lead',
			'name': jQuery( "#" + local_data.name ).val(),
			'email': jQuery( "#" + local_data.email ).val(),
			'form_id': seedprod_id,
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