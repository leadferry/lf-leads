<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom_Contact_Forms extends LF_Lead_Capture {

	function __construct() {
		// add_action( 'ccf_successful_submission', array( $this, 'capture_lead'), 20, 2 );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $submission_id, $form_id ) {

		// wp_die(var_dump($_POST));

		$options = get_option( 'leadferry_options' );

		$name = $_POST['ccf_field_' . $options['lead_first_name']];
		$email = 'ccf_field_' . $options['lead_email'];

		$lead_first_name = $name['first'];
		$lead_last_name = $name['last'];
		$lead_email = $_POST[$email];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}
}

$ccf = new LF_Custom_Contact_Forms();