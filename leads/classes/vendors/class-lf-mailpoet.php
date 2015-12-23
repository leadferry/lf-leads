<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Mailpoet extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_mailpoet_capture_lead', array( $this, 'mailpoet_capture_lead' ) );
		add_action( 'wp_ajax_mailpoet_capture_lead', array( $this, 'mailpoet_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function mailpoet_capture_lead() {

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
		wp_enqueue_script( 'lf_mailpoet', LEADFERRY_URL . '/leads/classes/vendors/js/mailpoet.js', '', '', true );
		wp_localize_script( 'lf_mailpoet', 'ajax_object', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}
}

$mailpoet = new LF_Mailpoet();