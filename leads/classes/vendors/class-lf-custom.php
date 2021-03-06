<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_custom_capture_lead', array( $this, 'custom_capture_lead' ) );
		add_action( 'wp_ajax_custom_capture_lead', array( $this, 'custom_capture_lead' ) );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function custom_capture_lead() {

		$lead['provider'] = "Custom Form";

		if( isset( $_POST['form_id'] ) )
			$lead['form_id'] = $_POST['form_id'];

		if( isset( $_POST['firstname'] ) )
			$lead['first_name'] = $_POST['firstname'];

		if( isset( $_POST['lastname'] ) )
			$lead['last_name'] = $_POST['lastname'];

		if( isset( $_POST['email'] ) )
			$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 *
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_custom_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_form_id', 'Form ID', array( $this, 'lf_lead_form_id_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_first_name', 'First Name', array( $this, 'lf_lead_first_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_last_name', 'Last Name', array( $this, 'lf_lead_last_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options['lead_form_id'] = sanitize_text_field( $input['lead_form_id'] );
		$options['lead_first_name'] = sanitize_text_field( $input['lead_first_name'] );
		$options['lead_last_name'] = sanitize_text_field( $input['lead_last_name'] );
		$options['lead_email'] = sanitize_text_field( $input['lead_email'] );
		return $options;
	}

	/**
	 * Output for settings section
	 *
	 */
	public function settings_section_text() {
		echo '<h2>Settings for any other form</h2><p>Please provide the IDs for the following fields.</p>';
	}

	/**
	 * Form ID
	 *
	 */
	public function lf_lead_form_id_callback() {
		$options = get_option( 'lf_custom_options' );
		$lead_form_id = isset( $options['lead_form_id'] ) ? $options['lead_form_id'] : '' ;
		echo '<input id="lf_lead_form_id" name="lf_custom_options[lead_form_id]" size="40" type="text" value="'. $lead_form_id .'">';
	}

	/**
	 * Lead First Name field
	 *
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_custom_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : '' ;
		echo '<input id="lf_lead_first_name" name="lf_custom_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 *
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_custom_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : '' ;
		echo '<input id="lf_lead_last_name" name="lf_custom_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 *
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_custom_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : '' ;
		echo '<input id="lf_lead_email" name="lf_custom_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {
		$options = get_option( 'lf_custom_options' );
		$local_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
			'form_id' => $options['lead_form_id'],
			'first_name' => $options['lead_first_name'],
			'last_name' => $options['lead_last_name'],
			'email' => $options['lead_email'],
		);
		wp_enqueue_script( 'lf_custom', LEADFERRY_URL . '/leads/classes/vendors/js/custom.js', '', '', true );
		wp_localize_script( 'lf_custom', 'local_data', $local_data );
	}
}

$custom = new LF_Custom();
