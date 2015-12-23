<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom_Contact_Form extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_cfb_capture_lead', array( $this, 'cfb_capture_lead' ) );
		add_action( 'wp_ajax_cfb_capture_lead', array( $this, 'cfb_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function cfb_capture_lead() {

		$options = get_option( 'leadferry_options' );

		$lead_first_name = $_POST['firstname'];
		$lead_last_name = $_POST['lastname'];
		$lead_email = $_POST['email'];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		wp_enqueue_script( 'lf_cfb', LEADFERRY_URL . '/leads/classes/vendors/js/cfb.js', '', '', true );
		wp_localize_script( 'lf_cfb', 'ajax_object', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}
}

$cfb = new LF_Custom_Contact_Form();