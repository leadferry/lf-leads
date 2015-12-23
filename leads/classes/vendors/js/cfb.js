jQuery(document).ready( function() {


	jQuery("#contactform1.contactform1").submit(function () {
		console.log("reached");

		var ajax_data = {
			action: 'cfb_capture_lead',
			'name': jQuery("#wdform_2_element1").val(),
			'email': jQuery("#wdform_4_element1").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});