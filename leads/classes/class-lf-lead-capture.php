<?php

/**
 * Base class for capturing form/leads 
 * 
 */
class LF_Lead_Capture {

	public $lead_first_name;
	public $lead_last_name;
	public $lead_email;

	/**
	 * Prepare data to be posted
	 * 
	 */
	public function prepare_data( $lead_first_name, $lead_last_name, $lead_email ) {
		$this->lead_first_name = $lead_first_name;
		$this->lead_last_name = $lead_last_name;
		$this->lead_email = $lead_email;
	}

	/**
	 * POST data to remote server
	 * 
	 */
	public function post_data() {

		// wp_remote_post();

	}
}