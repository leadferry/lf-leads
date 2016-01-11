<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Custom_Contact_Forms extends LF_Lead_Capture {

	function __construct() {
		// add_action( 'ccf_successful_submission', array( $this, 'capture_lead'), 20, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_ccf_capture_lead', array( $this, 'ccf_capture_lead' ) );
		add_action( 'wp_ajax_ccf_capture_lead', array( $this, 'ccf_capture_lead' ) );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function ccf_capture_lead() {

		$lead['provider'] = "Custom contact forms";
		$lead['form_id'] = $_POST['form_id'];
		$lead['first_name'] = $_POST['firstname'];
		$lead['last_name'] = $_POST['lastname'];
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );


		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
	}

	/**
	 * Allows user to provide names for name & email fields
	 * 
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_ccf_options', array( $this, 'validate_options' ) );
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

		$options = get_option( 'lf_ccf_options' );
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
	public function settings_section_text() { ?>
		<h2>Custom Contact Forms Settings</h2>
		<p>Please provide the values of "name attributes" for the following fields.  </p>

	<?php }

	/**
	 * Form ID
	 * 
	 */
	public function lf_lead_form_id_callback() {
		$options = get_option( 'lf_ccf_options' );
		$lead_form_id = isset( $options['lead_form_id'] ) ? $options['lead_form_id'] : '' ;
		echo '<input id="lf_lead_form_id" name="lf_ccf_options[lead_form_id]" size="40" type="text" value="'. $lead_form_id .'">';
	}

	/**
	 * Lead First Name field
	 * 
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_ccf_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : 'first_name' ;
		echo '<input id="lf_lead_first_name" name="lf_ccf_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 * 
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_ccf_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : 'last_name' ;
		echo '<input id="lf_lead_last_name" name="lf_ccf_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 * 
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_ccf_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : 'email' ;
		echo '<input id="lf_lead_email" name="lf_ccf_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}

	/**
	 * Enqueue JS files
	 */
	public function add_scripts() {

		$options = get_option( 'lf_ccf_options' );
		$local_data = array( 
			'url' => admin_url( 'admin-ajax.php' ),
			'form_id' => $options['lead_form_id'],
			'first_name' => $options['lead_first_name'],
			'last_name' => $options['lead_last_name'],
			'email' => $options['lead_email'],
		);
		wp_enqueue_script( 'lf_ccf', LEADFERRY_URL . '/leads/classes/vendors/js/ccf.js', '', '', true );
		wp_localize_script( 'lf_ccf', 'local_data', $local_data );
	}
}

$ccf = new LF_Custom_Contact_Forms();