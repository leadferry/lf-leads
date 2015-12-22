jQuery(window).load( function() {

	var hubspot_id = "#" + jQuery('[id^="hsForm_"]').attr('id');

	jQuery(hubspot_id).submit(function () {

		var ajax_data = {
			action: 'hubspot_capture_lead',
			'firstname': jQuery("input[name=firstname]").val(),
			'lastname': jQuery("input[name=lastname]").val(),
			'email': jQuery("input[name=email]").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});