<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Hubspot extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_hubspot_capture_lead', array( $this, 'hubspot_capture_lead' ) );
		add_action( 'wp_ajax_ajx_hubspot_capture_lead', array( $this, 'hubspot_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function hubspot_capture_lead() {

		$options = get_option( 'leadferry_options' );

		$lead_first_name = $_POST['firstName'];
		$lead_last_name = $_POST['lastName'];
		$lead_email = $_POST['email'];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		wp_enqueue_script( 'lf_hubspot', LEADFERRY_URL . '/leads/classes/vendors/js/hubspot.js', '', '', true );
		wp_localize_script( 'lf_hubspot', 'ajax_object', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function hubspot_ajx_callback() {}
}

$hubspot = new LF_Hubspot();