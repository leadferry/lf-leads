<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Contact_Forms_Bestwebsoft extends LF_Lead_Capture {

	function __construct() {
		add_action( 'cntctfrm_check_dispatch', array( $this, 'bestwebsoft_capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function bestwebsoft_capture_lead( $all_values ) {

		$lead['provider'] = "Bestwebsoft Contact Form";
		$lead['first_name'] = $_POST['cntctfrm_contact_name'];
		$lead['email'] = $_POST['cntctfrm_contact_email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );

	}
}

$contact_form_bws = new LF_Contact_Forms_Bestwebsoft();
