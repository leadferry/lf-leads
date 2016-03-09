<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Formidable_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'frm_after_create_entry', array( $this, 'formidable_capture_lead'), 30, 2 );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function formidable_capture_lead( $entry_id, $form_id ) {

		$options = get_option( 'lf_formidable_options' );
		$items = $_POST['item_meta'];

		$lead['provider'] = "Formidable";
		$lead['form_id'] = $form_id;
		$lead['first_name'] = $items[ $options['lead_first_name'] ];
		$lead['last_name'] = $items[ $options['lead_last_name'] ];
		$lead['email'] = $items[ $options['lead_email'] ];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 *
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_formidable_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_first_name', 'First Name', array( $this, 'lf_lead_first_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_last_name', 'Last Name', array( $this, 'lf_lead_last_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_formidable_options' );
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
		echo '<h2>Formidable Forms Settings</h2><p>Please provide the IDs for the following fields.</p>';
	}

	/**
	 * Lead First Name field
	 *
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_formidable_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : '' ;
		echo '<input id="lf_lead_first_name" name="lf_formidable_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 *
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_formidable_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : '' ;
		echo '<input id="lf_lead_last_name" name="lf_formidable_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 *
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_formidable_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : '' ;
		echo '<input id="lf_lead_email" name="lf_formidable_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}
}

$formidable = new LF_Formidable_Forms();
