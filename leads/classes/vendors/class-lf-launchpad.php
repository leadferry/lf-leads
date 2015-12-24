<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Launchpad extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_launchpad_capture_lead', array( $this, 'launchpad_capture_lead' ) );
		add_action( 'wp_ajax_launchpad_capture_lead', array( $this, 'launchpad_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function launchpad_capture_lead() {

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
		$options = get_option( 'leadferry_options' );

		wp_enqueue_script( 'lf_launchpad', LEADFERRY_URL . '/leads/classes/vendors/js/launchpad.js', '', '', true );

		wp_localize_script( 'lf_launchpad', 'ajax_object', array( 
			'url' => admin_url( 'admin-ajax.php' ), 
			'firstname' => $options['lead_first_name'],
			'lastname' => $options['lead_last_name'],
			'email' => $options['lead_email'],
		) );
	}
}

$launchpad = new LF_Launchpad();