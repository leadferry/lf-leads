<?php

/**
 * Add a settings page in admin
 * 
 */
class LF_Settings_Page {

	// Constructor
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'lf_lead_settings_page' ) );
		// add_action( 'admin_init', array( $this, 'lf_lead_settings_init' ) );
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
				<?php settings_fields('lf_lead_capture_options'); ?>
				<?php do_settings_sections('lf_lead_capture_settings'); ?>
				<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
			</form>
		</div>

		<?php
	}
}

if( is_admin() )
	$lf_settings = new LF_Settings_Page();
