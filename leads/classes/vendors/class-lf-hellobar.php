<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Hellobar extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_hellobar_capture_lead', array( $this, 'hellobar_capture_lead' ) );
		add_action( 'wp_ajax_hellobar_capture_lead', array( $this, 'hellobar_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function hellobar_capture_lead() {

		$lead['provider'] = "Hellobar";
		$lead['form_id'] = $_POST['form_id'];
		$lead['first_name'] = $_POST['firstname'];
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );

	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		$options = get_option( 'lf_hellobar_options' );
		$local_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
		);
		wp_enqueue_script( 'lf_hellobar', LEADFERRY_URL . '/leads/classes/vendors/js/hellobar.js', '', '', true );
		wp_localize_script( 'lf_hellobar', 'local_data', $local_data );
	}
}

$hellobar = new LF_Hellobar();
