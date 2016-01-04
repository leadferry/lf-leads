<?php

require_once( LEADFERRY_PATH . '/leads/classes/class-lf-lead-capture.php');

class LF_FS_Contact_Forms extends LF_Lead_Capture {

	function __construct() {
		add_action( 'fsctf_mail_sent', array( $this, 'capture_lead') );
		add_action( 'admin_init', array( $this, 'init_settings'));
	}

	/**
	 * Capture lead
	 *
	 */
	public function capture_lead( $form) {

		$form_data = $form->posted_data;
		$options = get_option( 'lf_fscf_options' );

		/* The form automatically converts the label of new fields in format such as 
		First-Name (for label First Name), Last-Name( for label Last Name ) and so on */

		$first_name = !empty( $options['lead_first_name'] ) ? str_replace( ' ', '-', $options['lead_first_name']) : 'from_name'; 
		$last_name = !empty( $options['lead_last_name'] ) ? str_replace( ' ', '-', $options['lead_last_name']) : ''; 
		$email = !empty( $options['lead_email'] ) ? str_replace( ' ', '-', $options['lead_email']) : 'from_email'; 

		$lead['provider'] = "Fast & Secure contact forms";
		// $lead['form_id'] = $_POST['form_id'];
		$lead['first_name'] = $form_data[$first_name];

		if( !empty( $last_name ) )
			$lead['last_name'] = $form_data[$last_name];
		$lead['email'] = $form_data[$email];

		$data = $this->prepare_data( $lead );
		$this->post_data( $data );
		
	}

	/**
	 * Allows user to provide names for name & email fields
	 * 
	 */
	public function init_settings() {
		register_setting( 'lf_lead_capture_options', 'lf_fscf_options', array( $this, 'validate_options' ) );
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

		$options = get_option( 'lf_fscf_options' );
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
		<h2>Fast & Secure Contact Forms Settings</h2>
		<p>
			If you have added First Name, Last Name or Email fields manually, please specify the Labels ( case sensitive ) for those fields below. 
			<br/>Leave blank for default form.
	   	</p>

	<?php }

	/**
	 * Lead First Name field
	 * 
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'lf_fscf_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : 'first_name' ;
		echo '<input id="lf_lead_first_name" name="lf_fscf_options[lead_first_name]" size="40" type="text" value="'. $lead_first_name .'">';
	}

	/**
	 * Lead Last Name field
	 * 
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'lf_fscf_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : 'last_name' ;
		echo '<input id="lf_lead_last_name" name="lf_fscf_options[lead_last_name]" size="40" type="text" value="'. $lead_last_name .'">';
	}

	/**
	 * Lead Email field
	 * 
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'lf_fscf_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : 'email' ;
		echo '<input id="lf_lead_email" name="lf_fscf_options[lead_email]" size="40" type="text" value="'. $lead_email .'">';
	}
}

$fscf = new LF_FS_Contact_Forms();