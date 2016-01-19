<?php

/**
 * Add a settings page in admin
 * 
 */
class LF_Settings_Page {

	// Constructor
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'lf_lead_settings_page' ) );
		add_action( 'admin_init', array( $this, 'init_settings' ) );
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
			<form action="options.php" method="post">
				<?php settings_fields('lf_lead_forms'); ?>
				<?php do_settings_sections('lf_select_lead_form'); ?>
			</form>
			<form action="options.php" method="post">
				<?php settings_fields('lf_lead_capture_options'); ?>
				<?php do_settings_sections('lf_lead_capture_settings'); ?>
				<input class="button button-primary" name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
			</form>
		</div>

		<?php
	}

	/**
	 * Select the product
	 * 
	 */
	public function init_settings(){
		register_setting( 'lf_lead_forms', 'lf_lead_forms', array( $this, 'validate_options' ) );
		add_settings_section( 'lf_lead_capture_section', 'Select Forms/Plugins', array( $this, 'settings_section_text' ), 'lf_select_lead_form' );
		add_settings_field( 'lf_select_product', 'Supported Products', array( $this, 'lf_product_callback' ), 'lf_select_lead_form', 'lf_lead_capture_section' );
	}

	/**
	 * Sanatizes options value
	 * 
	 */
	public function validate_options( $input ) {

		return $input;
	}

	/**
	 * Output for settings section
	 * 
	 */
	public function settings_section_text() {
		echo '<p>Choose the plugin or third party forms you are currently using for capturing leads</p>';
	}

	/**
	 * Callback for Select box
	 * 
	 */
	public function lf_product_callback() {
		$options = get_option( 'lf_lead_forms' );
		$selected_product = isset( $options['selected_product'] ) ? $options['selected_product'] : 'none' ;
		?>
			<select id="lf_select_product" name="lf_lead_forms[selected_product]" onchange="this.form.submit()">
				<option value="none" <?php selected( $selected_product, 'none' );?>>None</option>
				<option value="jetpack" <?php selected( $selected_product, 'jetpack' );?>>Jetpack</option>
				<option value="ninja-forms" <?php selected( $selected_product, 'ninja-forms' ); ?>>Ninja Forms</option>
				<option value="formstack" <?php selected( $selected_product, 'formstack' ); ?>>Formstack</option>
				<option value="cfb" <?php selected( $selected_product, 'cfb' ); ?>>Custom Form Builder</option>
				<option value="contact-forms-bestwebsoft" <?php selected( $selected_product, 'contact-forms-bestwebsoft' ); ?>>BestWebSoft Contact Forms</option>
				<option value="custom-contact-forms" <?php selected( $selected_product, 'custom-contact-forms' ); ?>>Custom Contact Forms</option>
				<option value="formidable-forms" <?php selected( $selected_product, 'formidable-forms' ); ?>>Formidable Forms</option>
				<option value="fs-contact-forms" <?php selected( $selected_product, 'fs-contact-forms' ); ?>>Fast & Secure contact forms</option>
				<option value="hubspot" <?php selected( $selected_product, 'hubspot' ); ?>>Hubspot</option>
				<option value="hellobar" <?php selected( $selected_product, 'hellobar' ); ?>>Hellobar</option>
				<option value="launchpad" <?php selected( $selected_product, 'launchpad' ); ?>>Launchpad</option>
				<option value="leadsquared" <?php selected( $selected_product, 'leadsquared' ); ?>>Leadsquared</option>
				<option value="leadsquared-cf7" <?php selected( $selected_product, 'leadsquared-cf7' ); ?>>Leadsquared ( Contact form 7 )</option>
				<option value="mailchimp" <?php selected( $selected_product, 'mailchimp' ); ?>>Mailchimp</option>
				<option value="mailpoet" <?php selected( $selected_product, 'mailpoet' ); ?>>Mailpoet</option>
				<option value="newsletter" <?php selected( $selected_product, 'newsletter' ); ?>>Newsletter</option>
				<option value="pardot" <?php selected( $selected_product, 'pardot' ); ?>>Pardot</option>
				<option value="scrollboxes" <?php selected( $selected_product, 'scrollboxes' ); ?>>Dreamgrow Scroll Triggered Box</option>
				<option value="seedprod" <?php selected( $selected_product, 'seedprod' ); ?>>Seedprod</option>
				<option value="simplycast" <?php selected( $selected_product, 'simplycast' ); ?>>Simplycast</option>
				<option value="sumome" <?php selected( $selected_product, 'sumome' ); ?>>Sumome</option>
				<option value="visual-form-builder" <?php selected( $selected_product, 'visual-form-builder' ); ?>>Visual Form Builder</option>
				<option value="wp-leads" <?php selected( $selected_product, 'wp-leads' ); ?>>WP Leads</option>
				<option value="wordpress-landing-pages" <?php selected( $selected_product, 'wordpress-landing-pages' ); ?>>Wordpress Landing Pages</option>
				<option value="custom" <?php selected( $selected_product, 'custom' );?>>Custom</option>
			</select>
		<?php
	}
}

if( is_admin() )
	$lf_settings = new LF_Settings_Page();