<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Seedprod extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_seedprod_capture_lead', array( $this, 'seedprod_capture_lead' ) );
		add_action( 'wp_ajax_seedprod_capture_lead', array( $this, 'seedprod_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function seedprod_capture_lead() {

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

		wp_enqueue_script( 'lf_seedprod', LEADFERRY_URL . '/leads/classes/vendors/js/seedprod.js', '', '', true );

		wp_localize_script( 'lf_seedprod', 'ajax_object', array( 
			'url' => admin_url( 'admin-ajax.php' ), 
			'name' => $options['lead_first_name'],
			'email' => $options['lead_email'],
		) );
	}
}

$seedprod = new LF_Seedprod();