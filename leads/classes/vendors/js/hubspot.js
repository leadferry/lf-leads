jQuery( 'document' ).ready( function( $ ) {

	$( '#hsForm_1b8a829b-e610-4ac4-a04c-de3cb9aa5600' ).submit( function() {

		var ajax_data = {
			action: 'hubspot_capture_lead',
			'firstname': $("input[name=firstname]").val(),
			'lastname': $("input[name=lastname]").val(),
			'email': $("input[name=email]").val(),

		};

		$.ajax( {
			url: ajax_object.url,
			type: 'GET',
			dataType: 'json',
			data: ajax_data,
		});
	});
});