<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom_Contact_Form extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_cfb_capture_lead', array( $this, 'cfb_capture_lead' ) );
		add_action( 'wp_ajax_cfb_capture_lead', array( $this, 'cfb_capture_lead' ) );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function cfb_capture_lead() {

		$options = get_option( 'leadferry_options' );

		$lead['provider'] = "Contact Form Builder";

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
		register_setting( 'lf_lead_capture_options', 'lf_cfb_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_form_id', 'Form ID', array( $this, 'lf_lead_form_id_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_first_name', 'Lead First Name', array( $this, 'lf_lead_first_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_last_name', 'Lead last Name', array( $this, 'lf_lead_last_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Lead Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_cfb_options' );
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
		echo '<h2>Custom Form Builder Settings</h2><p>Please provide the IDs for the following fields.</p>';
	}

	/**
	 * Form ID field
	 *
	 */
	public function lf_lead_form_id_callback() {
		$options = get_option( 'lf_cfb_options' );
		$lead_form_id = isset( $options['lead_form_id'] ) ? $options['lead_form_id'] : '' ;
		echo '<input id="lf_lead_form_id" name="lf_cfb_options[lead_form_id]" size="40" type="text" value="'. $lead_form_id .'">';
	}

	/**
	 * Lead First Name field
	 *
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_cfb_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : '' ;
		echo '<input id="lf_lead_first_name" name="lf_cfb_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 *
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_cfb_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : '' ;
		echo '<input id="lf_lead_last_name" name="lf_cfb_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 *
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_cfb_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : '' ;
		echo '<input id="lf_lead_email" name="lf_cfb_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {

		$options = get_option( 'lf_cfb_options' );
		$local_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
			'form_id' => $options['lead_form_id'],
			'first_name' => $options['lead_first_name'],
			'last_name' => $options['lead_last_name'],
			'email' => $options['lead_email'],
		);
		wp_enqueue_script( 'lf_cfb', LEADFERRY_URL . '/leads/classes/vendors/js/cfb.js', '', '', true );
		wp_localize_script( 'lf_cfb', 'local_data', $local_data );
	}
}

$cfb = new LF_Custom_Contact_Form();
