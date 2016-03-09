<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Jetpack extends LF_Lead_Capture {

	function __construct() {
		add_action( 'grunion_pre_message_sent', array( $this, 'capture_lead'), 10, 3 );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $post_id, $all_values, $extra_values ) {

		$options = get_option( 'lf_jetpack_options' );

		/* $all_values is an array containing the data posted by Jetpack form
		The keys have a special posiiton based format like 1_First Name, 2_Last_Name etc.
		Therefore we need to first get the correct keys */


		$keys = array_keys($all_values);

		if( !empty( $options['lead_first_name'] ) ) {
			$pattern = $options['lead_first_name'];
			$firstname = array_keys( array_flip ( preg_grep( "/[$pattern]$/", $keys ) ) );
			$lead['first_name'] = $all_values[$firstname[0]];
		}

		if( !empty( $options['lead_last_name'] ) ) {
			$pattern = $options['lead_last_name'];
			$lastname = array_keys( array_flip ( preg_grep( "/[$pattern]$/", $keys ) ) );
			$lead['last_name'] = $all_values[$lastname[0]];
		}

		if( !empty( $options['lead_email'] ) ) {
			$pattern = $options['lead_email'];
			$email = array_keys( array_flip ( preg_grep( "/[$pattern]$/", $keys ) ) );
			$lead['email'] = $all_values[$email[0]];
		}

		$lead['provider'] = "Jetpack";
		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 *
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_jetpack_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_first_name', 'Lead First Name', array( $this, 'lf_lead_first_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_last_name', 'Lead last Name', array( $this, 'lf_lead_last_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Lead Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_jetpack_options' );
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
		echo '<h2>Jetpack Settings</h2><p>Please provide the labels( case sensitive ) for your Jetpack form for the follwing fields.  </p>';
	}

	/**
	 * Lead First Name field
	 *
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_jetpack_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : 'first_name' ;
		echo '<input id="lf_lead_first_name" name="lf_jetpack_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 *
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_jetpack_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : 'last_name' ;
		echo '<input id="lf_lead_last_name" name="lf_jetpack_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 *
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_jetpack_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : 'email' ;
		echo '<input id="lf_lead_email" name="lf_jetpack_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}
}

$lf_jetpack = new LF_Jetpack();
