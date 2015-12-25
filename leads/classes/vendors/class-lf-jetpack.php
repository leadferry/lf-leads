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

		
		$options = get_option( 'leadferry_options' );

		$lead_first_name = $all_values[ $options['lead_first_name'] ];
		$lead_last_name = $all_values[ $options['lead_last_name'] ];
		$lead_email = $all_values[ $options['lead_email'] ];

		$this->prepare_data( $lead_first_name, $lead_last_name, $lead_email );
		$this->post_data();
		
	}

	/**
	 * Allows user to provide names for name & email fields
	 * 
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_jetpack_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Settings', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
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
		$options['lead_last_name'] = $input['lead_last_name'];
		$options['lead_email'] = $input['lead_email'];
		return $options;
	}

	/**
	 * Output for settings section
	 * 
	 */
	public function settings_section_text() {
		echo '<p>Settings for Jetpack</p>';

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