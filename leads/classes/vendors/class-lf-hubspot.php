<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Hubspot extends LF_Lead_Capture {

	function __construct() {
		add_action( 'admin_init', array( $this, 'init_settings'));
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_hubspot_capture_lead', array( $this, 'hubspot_capture_lead' ) );
		add_action( 'wp_ajax_hubspot_capture_lead', array( $this, 'hubspot_capture_lead' ) );
	}

	/**
	 * Capture lead
	 *
	 */
	public function hubspot_capture_lead() {

		$lead['provider'] = "hubspot";
		$lead['form_id'] = $_POST['form_id'];
		$lead['first_name'] = $_POST['firstname'];
		$lead['last_name'] = $_POST['lastname'];
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 *
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_hubspot_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_form_id', 'Hubspot Form ID', array( $this, 'lf_lead_form_id_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_hubspot_options' );
		$options['lead_form_id'] = sanitize_text_field( $input['lead_form_id'] );
		return $options;
	}

	/**
	 * Output for settings section
	 *
	 */
	public function settings_section_text() {
		echo '<h2>Hubspot Settings</h2><p>Please provide form ID for your hubspot form below.  </p>';
	}

	/**
	 * Lead First Name field
	 *
	 */
	public function lf_lead_form_id_callback() {
		$options = get_option( 'lf_hubspot_options' );
		$lead_form_id = isset( $options['lead_form_id'] ) ? $options['lead_form_id'] : '' ;
		echo '<input id="lf_lead_form_id" name="lf_hubspot_options[lead_form_id]" size="40" type="text" value="'. $lead_form_id .'">';
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		$options = get_option( 'lf_hubspot_options' );
		$local_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
			'form_id' => $options['form_id'],
		);

		wp_enqueue_script( 'lf_hubspot', LEADFERRY_URL . '/leads/classes/vendors/js/hubspot.js', '', '', true );
		wp_localize_script( 'lf_hubspot', 'local_data', $local_data );
	}
}

$hubspot = new LF_Hubspot();
