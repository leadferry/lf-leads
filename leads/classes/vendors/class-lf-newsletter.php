<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Newsletter extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_newsletter_capture_lead', array( $this, 'newsletter_capture_lead' ) );
		add_action( 'wp_ajax_newsletter_capture_lead', array( $this, 'newsletter_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function newsletter_capture_lead() {


		$lead['provider'] = 'newsletter';
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
		
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		wp_enqueue_script( 'lf_newsletter', LEADFERRY_URL . '/leads/classes/vendors/js/newsletter.js', '', '', true );
		wp_localize_script( 'lf_newsletter', 'ajax_object', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
	}
}

$newsletter = new LF_Newsletter();