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
			$options = get_option( 'leadferry_options' );

        	$data = $submission->get_posted_data();

        	$lead_first_name = $data[ $options['lead_first_name'] ];
			$lead_last_name = $data[ $options['lead_last_name'] ];
			$lead_email = $data[ $options['lead_email'] ];

			$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
			$this->post_data();
			return;
	        	
    	}		
	}
}

$leadsquared_cf7 = new LF_Leadsquared_CF7();