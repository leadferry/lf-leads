<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Leadsquared_CF7 extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wpcf7_mail_sent', array( $this, 'capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $contact_form ) {

		$submission = WPCF7_Submission::get_instance();
		if ( $submission ) {
        	$data = $submission->get_posted_data();
        	wp_die( $data );
    	}		
	}
}

$leadsquared_cf7 = new LF_Leadsquared_CF7();