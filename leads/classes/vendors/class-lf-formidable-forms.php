<?php

require( '../class-lf-lead-capture.php' );

class LF_Formidable_Forms extends LF_Lead_Capture {

	public function __contruct() {
		add_action( 'frm_after_create_entry', array( $this, 'capture_lead'), 10, 2 );
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $entry_id, $form_id ) {

		$items = $_POST['item_meta'];
		
	}
}