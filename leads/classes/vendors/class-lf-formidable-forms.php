<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Formidable_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'frm_after_create_entry', array( $this, 'capture_lead'), 30, 2 );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $entry_id, $form_id ) {

		$options = get_option( 'leadferry_options' );

		$items = $_POST['item_meta'];

		$lead_first_name = $items[ $options['lead_first_name'] ];
		$lead_last_name = $items[ $options['lead_last_name'] ];
		$lead_email = $items[ $options['lead_email'] ];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}
}

$formidable = new LF_Formidable_Forms();