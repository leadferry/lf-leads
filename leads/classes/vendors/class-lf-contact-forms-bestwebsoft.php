<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Contact_Forms_Bestwebsoft extends LF_Lead_Capture {

	function __construct() {
		add_action( 'cntctfrm_check_dispatch', array( $this, 'capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $all_values ) {

		$options = get_option( 'leadferry_options' );

		$lead_name = $_POST['cntctfrm_contact_name'];
		$lead_email = $_POST['cntctfrm_contact_email'];

		$this->prepare_data( $lead_name, '', $lead_email );
		$this->post_data();
		
	}
}

$contact_form_bws = new LF_Contact_Forms_Bestwebsoft();