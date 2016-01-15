<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_Seedprod extends LF_Lead_Capture {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts') );
		add_action( 'wp_ajax_nopriv_seedprod_capture_lead', array( $this, 'seedprod_capture_lead' ) );
		add_action( 'wp_ajax_seedprod_capture_lead', array( $this, 'seedprod_capture_lead' ) );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function seedprod_capture_lead() {
		
		$lead['provider'] = "seedprod";
		$lead['form_id'] = $_POST['form_id'];
		$lead['first_name'] = $_POST['name'];
		$lead['email'] = $_POST['email'];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
		
	}

	/**
	 * Allows user to provide names for name & email fields
	 * 
	 */
	public function init_settings(){
		register_setting( 'lf_lead_capture_options', 'lf_seedprod_options', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Integration Details', array( $this, 'settings_section_text' ), 'lf_lead_capture_settings' );
		add_settings_field( 'lf_lead_form_id', 'Form ID', array( $this, 'lf_lead_form_id_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_name', 'Name', array( $this, 'lf_lead_name_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Email', array( $this, 'lf_lead_email_callback' ), 'lf_lead_capture_settings', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 * 
	 */
	public function validate_options( $input ) {

		$options = get_option( 'lf_seedprod_options' );
		$options['lead_form_id'] = sanitize_text_field( $input['lead_form_id'] );
		$options['lead_name'] = sanitize_text_field( $input['lead_name'] );
		$options['lead_email'] = sanitize_text_field( $input['lead_email'] );
		return $options;
	}

	/**
	 * Output for settings section
	 * 
	 */
	public function settings_section_text() { ?>
		<h2>Seedprod Settings</h2>
		<p>Please provide the IDs for following fields in Seedprod form
	<?php }

	/**
	 * Form ID field
	 * 
	 */
	public function lf_lead_form_id_callback() {
		$options = get_option( 'lf_seedprod_options' );
		$lead_form_id = isset( $options['lead_form_id'] ) ? $options['lead_form_id'] : '' ;
		echo '<input id="lf_lead_form_id" name="lf_seedprod_options[lead_form_id]" size="40" type="text" value="'. $lead_form_id .'">';
	}

	/**
	 * Lead Name field
	 * 
	 */
	public function lf_lead_name_callback() {
		$options = get_option( 'lf_seedprod_options' );
		$lead_name = isset( $options['lead_name'] ) ? $options['lead_name'] : '' ;
		echo '<input id="lf_lead_name" name="lf_seedprod_options[lead_name]" size="40" type="text" value="'. $lead_name .'">';
	}

	/**
	 * Lead Email field
	 * 
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_seedprod_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : '' ;
		echo '<input id="lf_lead_email" name="lf_seedprod_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}

	/**
	 * Enqueue JS files
	 * 
	 */
	public function add_scripts() {
		$options = get_option( 'lf_seedprod_options' );
		$local_data = array( 
			'url' => admin_url( 'admin-ajax.php' ),
			'form_id' => $options['lead_form_id'],
			'name' => $options['lead_name'],
			'email' => $options['lead_email'],
		);

		wp_enqueue_script( 'lf_seedprod', LEADFERRY_URL . '/leads/classes/vendors/js/seedprod.js', '', '', true );
		wp_localize_script( 'lf_seedprod', 'local_data', $local_data );
	}
}

$seedprod = new LF_Seedprod();