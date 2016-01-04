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
		$form_data = $form->data;

		$lead['provider'] = "MailChimp";
		$lead['form_id'] = $form->ID;
		if( isset( $form_data['FNAME'] ) )
			$lead['first_name'] = $form_data['FNAME'];
		if( isset( $form_data['LNAME'] ) )
		$lead['last_name'] = $form_data['LNAME'];
		$lead['email'] = $form_data['EMAIL'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
		
	}
}

$mailchimp = new LF_Mailchimp();