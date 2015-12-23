jQuery(window).load( function() {

	var simplycast_id = "#" + jQuery('[id^="scInlineForm-"]').attr('id');

	jQuery(simplycast_id).submit(function () {

		var ajax_data = {
			action: 'simplycast_capture_lead',
			'firstname': jQuery(".firstInput").val(),
			'lastname': jQuery(".secondInput").val(),
			'email': jQuery("#EmailElement_0_input").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});