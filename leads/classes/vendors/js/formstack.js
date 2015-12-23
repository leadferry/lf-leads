jQuery(window).load( function() {

	var formstack_id = "#" + jQuery('[id^="fsForm"]').attr('id');

	jQuery(formstack_id).submit(function () {

		console.log("Reached");

		var ajax_data = {
			action: 'formstack_capture_lead',
			'firstname': jQuery('[name$="-first"]').val(),
			'lastname': jQuery('[name$="-last"]').val(),
			'email': jQuery('[type="email"]').val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});