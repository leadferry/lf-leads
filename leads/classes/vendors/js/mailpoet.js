jQuery(window).load( function() {

	var mailpoet_id = "#" + jQuery('[id^="form-wysija-"]').attr('id');

	jQuery(mailpoet_id).submit(function () {


		var ajax_data = {
			action: 'mailpoet_capture_lead',
			'firstname': jQuery("input[name='wysija[user][firstname]']").val(),
			'lastname': jQuery("input[name='wysija[user][lastname]']").val(),
			'email': jQuery("input[name='wysija[user][email]']").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});
	});
});