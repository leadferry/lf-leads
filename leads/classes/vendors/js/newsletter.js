jQuery(window).load( function() {

	jQuery('.newsletter form').submit(function (e) {

		var form = this;
		e.preventDefault();

		var ajax_data = {
			action: 'newsletter_capture_lead',
			'email': jQuery("input[name=ne]").val(),
		}
		
		jQuery.ajax( {
			url: ajax_object.url,
			type: 'POST',
			dataType: 'json',
			data: ajax_data,
		});

		jQuery( document ).ajaxComplete( function () {
			form.submit();
		});
	});
});