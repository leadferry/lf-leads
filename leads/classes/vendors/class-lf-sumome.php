<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Sumome extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_sumome_capture_lead', array( $this, 'sumome_capture_lead' ) );
		add_action( 'wp_ajax_sumome_capture_lead', array( $this, 'sumome_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function sumome_capture_lead() {

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
		wp_enqueue_script( 'lf_sumome', LEADFERRY_URL . '/leads/classes/vendors/js/sumome.js', '', '', true );
		wp_localize_script( 'lf_sumome', 'ajax_object', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}
}

$sumome = new LF_Sumome();