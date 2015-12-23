jQuery(window).load( function() {


	jQuery('button.sumome-contactform-button.sumome-contactform-button-text').click(function () {

		var ajax_data = {
			action: 'sumome_capture_lead',
			// 'firstname': jQuery("input[name=firstname]").val(),
			// 'lastname': jQuery("input[name=lastname]").val(),
			// 'email': jQuery("input[name=email]").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});