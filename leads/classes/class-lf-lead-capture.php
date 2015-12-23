<?php

/**
 * Base class for capturing form/leads 
 * 
 */
class LF_Lead_Capture {

	public $lead_name;
	public $lead_email;

	/**
	 * Prepare data to be posted
	 * 
	 */
	public function prepare_data( $lead_first_name, $lead_last_name, $lead_email ) {

		if( empty( $lead_last_name )) {
			$this->lead_name = $lead_first_name;
		}
		else {
			$this->lead_name = $lead_first_name . ' ' . $lead_last_name;
		}
		$this->lead_email = $lead_email;	}

	/**
	 * POST data to remote server
	 * 
	 */
	public function post_data() {

		$msg = "Posting : " . $this->lead_name . $this->lead_email;

		wp_die( $msg );
	}
}