<?php

/**
 * Add a settings page in admin
 * 
 */
class LF_Settings_Page {

	// Constructor
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'lf_lead_settings_page' ) );
		add_action( 'admin_init', array( $this, 'lf_lead_settings_init' ) );
	}

	/**
	 * Add the menu page
	 * 
	 */
	public function lf_lead_settings_page() {
		$lf_users_page = plugin_basename(LEADFERRY_PATH . 'leads/profile.php');
		add_menu_page( 'Leadferry', 'Leadferry', 'manage_options', 'lf_leadferry_settings', array( $this, 'lf_leadferry_settings_callback' ), '', 59 );
	}

	/**
	 * Callback function to render the page
	 * 
	 */
	public function lf_leadferry_settings_callback() {
		?>
		<div>
			<h2>Leadferry Settings</h2>
			<form action="options.php" method="post">
				<?php settings_fields('leadferry_options'); ?>
				<?php do_settings_sections('lf_leadferry'); ?>
				<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
			</form>
		</div>

		<?php
	}

	/**
	 * Register settings and setting sections and setting fields
	 * 
	 */
	public function lf_lead_settings_init() {
		register_setting( 'leadferry_options', 'leadferry_options', array( $this, 'leadferry_options_validate' ) );
		add_settings_section( 'lf_lead_capture_section', 'Form Settings', array( $this, 'lf_lead_capture_section_text' ), 'lf_leadferry' );
		add_settings_field( 'lf_lead_first_name', 'Lead First Name', array( $this, 'lf_lead_first_name_callback' ), 'lf_leadferry', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_last_name', 'Lead last Name', array( $this, 'lf_lead_last_name_callback' ), 'lf_leadferry', 'lf_lead_capture_section' );
		add_settings_field( 'lf_lead_email', 'Lead Email', array( $this, 'lf_lead_email_callback' ), 'lf_leadferry', 'lf_lead_capture_section' );
	}

	/**
	 * Section Text
	 * 
	 */
	public function lf_lead_capture_section_text() {
		echo '<p>Provide the name of your form fields below</p>';

	}

	/**
	 * Lead First Name field
	 * 
	 */
	public function lf_lead_first_name_callback() {
		$options = get_option( 'leadferry_options' );
		$lead_first_name = isset( $options['lead_first_name'] ) ? $options['lead_first_name'] : 'first_name' ;
		echo '<input id="lf_lead_first_name" name="leadferry_options[lead_first_name]" size="40" type="text" value='. $lead_first_name .'>';
	}

	/**
	 * Lead Last Name field
	 * 
	 */
	public function lf_lead_last_name_callback() {
		$options = get_option( 'leadferry_options' );
		$lead_last_name = isset( $options['lead_last_name'] ) ? $options['lead_last_name'] : 'last_name' ;
		echo '<input id="lf_lead_last_name" name="leadferry_options[lead_last_name]" size="40" type="text" value='. $lead_last_name .'>';
	}

	/**
	 * Lead First Name field
	 * 
	 */
	public function lf_lead_email_callback() {
		$options = get_option( 'leadferry_options' );
		$lead_email = isset( $options['lead_email'] ) ? $options['lead_email'] : 'email' ;
		echo '<input id="lf_lead_email" name="leadferry_options[lead_email]" size="40" type="text" value='. $lead_email .'>';
	}

	/**
	 * Validation function
	 * 
	 */
	public function leadferry_options_validate( $input ) {
		$options = get_option( 'leadferry_options' );
		$options['lead_first_name'] = $input['lead_first_name'];
		$options['lead_last_name'] = $input['lead_last_name'];
		$options['lead_email'] = $input['lead_email'];
		return $options;
	} 
}

if( is_admin() )
	$lf_settings = new LF_Settings_Page();
