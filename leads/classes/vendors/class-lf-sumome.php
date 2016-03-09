<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Sumome extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_sumome_capture_lead', array( $this, 'sumome_capture_lead' ) );
		add_action( 'wp_ajax_sumome_capture_lead', array( $this, 'sumome_capture_lead' ) );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function sumome_capture_lead() {

		$lead['provider'] = "Sumome";
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 *
	 */
	public function init_settings() {
		register_setting( 'lf_lead_capture_options', 'lf_sumome_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_email', 'Lead Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 *
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_sumome_options' );
		$options['lead_email'] = sanitize_text_field( $input['lead_email'] );
		return $options;
	}

	/**
	 * Output for settings section
	 *
	 */
	public function settings_section_text() {
		echo '<h2>Sumome Settings</h2><p>Please provide ID for the follwing fields in your sumome form. </p>';
	}

	/**
	 * Lead Email field
	 *
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_sumome_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : 'wysija[user][email]' ;
		echo '<input id="lf_lead_email" name="lf_sumome_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {

		$options = get_option( 'lf_sumome_options' );
		$local_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
			'email' => $options['lead_email'],
		);
		wp_enqueue_script( 'lf_sumome', LEADFERRY_URL . '/leads/classes/vendors/js/sumome.js', '', '', true );
		wp_localize_script( 'lf_sumome', 'local_data', $local_data );
	}
}

$sumome = new LF_Sumome();
