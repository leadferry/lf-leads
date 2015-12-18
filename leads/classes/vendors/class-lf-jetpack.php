<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Jetpack extends LF_Lead_Capture {

	function __construct() {
		add_action( 'grunion_pre_message_sent', array( $this, 'capture_lead'), 10, 3 );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $post_id, $all_values, $extra_values ) {

		
		$options = get_option( 'leadferry_options' );

		$lead_first_name = $all_values[ $options['lead_first_name'] ];
		$lead_last_name = $all_values[ $options['lead_last_name'] ];
		$lead_email = $all_values[ $options['lead_email'] ];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}
}

$jetpack = new LF_Jetpack();