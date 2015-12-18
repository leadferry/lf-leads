<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Mailpoet extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wysija_subscriber_added', array( $this, 'capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $id )  {

		wp_die( $id );

		$this->prepare_data( $submission_id, '', '' );
		$this->post_data();
		
	}
}

$mailpoet = new LF_Mailpoet();