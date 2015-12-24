jQuery(window).load( function() {

	var seedprod_id = "#" + jQuery('[id$="-form"]').attr('id');

	jQuery( seedprod_id ).submit(function() {


		var ajax_data = {
			action: 'seedprod_capture_lead',
			'firstname': jQuery( "#" + ajax_object.name ).val(),
			'email': jQuery(  "#" + ajax_object.email ).val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});