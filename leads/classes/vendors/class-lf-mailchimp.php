<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Mailchimp extends LF_Lead_Capture {

	function __construct() {
		add_action( 'mc4wp_form_success', array( $this, 'capture_lead') );
		
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $form) {
		$data = $form->data;

		$this->prepare_data( '', '', $data['EMAIL'] );
		$this->post_data();
		
	}
}

$mailchimp = new LF_Mailchimp();