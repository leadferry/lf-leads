<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom_Contact_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'ccf_successful_submission', array( $this, 'capture_lead'), 20, 2 );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $submission_id, $form_id ) {

		$this->prepare_data( $submission_id, '', '' );
		$this->post_data();
		
	}
}

$ccf = new LF_Custom_Contact_Forms();