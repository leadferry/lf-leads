<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_FS_Contact_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'fsctf_mail_sent', array( $this, 'capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $form) {
		$data = $form->posted_data;

		$this->prepare_data( $data['from_name'], '', $data['from_email'] );
		$this->post_data();
		
	}
}

$fscf = new LF_FS_Contact_Forms();