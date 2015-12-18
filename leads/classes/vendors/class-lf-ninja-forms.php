<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Ninja_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'ninja_forms_post_process', array( $this, 'capture_lead') );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead() {

		global $ninja_forms_processing;
		$all_values = $ninja_forms_processing->get_all_fields();

		$options = get_option( 'leadferry_options' );

		$lead_first_name = $all_values[ $options['lead_first_name'] ];
		$lead_last_name = $all_values[ $options['lead_last_name'] ];
		$lead_email = $all_values[ $options['lead_email'] ];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}
}

$ninja_forms = new LF_Ninja_Forms();