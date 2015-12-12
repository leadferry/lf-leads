<?php
defined('ABSPATH') or die();

require_once(dirname(__FILE__) . '/constants.php');

function lf_lead_install() {
	global $wpdb;
	$lf_lead_db_ver = LF_LEAD_DB_VER;
	$lf_lead_db_name = $wpdb->prefix . LF_LEAD;
	$lf_lead_db_cur = get_option('lf_lead_db_ver');

	if($lf_lead_db_cur != $lf_lead_db_ver) {
		$charset_collate = $wpdb->get_charset_collate();
		$sql =
		"CREATE TABLE $lf_lead_db_name (
			lead_id char(32) NOT NULL,
			user_id bigint(20) unsigned NOT NULL,
			sync_status tinyint(4) unsigned NOT NULL DEFAULT 0,
			PRIMARY KEY (lead_id,user_id),
			KEY user_id (user_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( 'lf_lead_db_ver', $lf_lead_db_ver);
	}
	
	add_role(LF_LEAD, 'Lead');
}

register_activation_hook( LEADFERRY_PLUGIN, 'lf_lead_install' );

function lf_lead_update() {
	$lf_lead_db_ver = LF_LEAD_DB_VER;
	$lf_lead_db_cur = get_option('lf_lead_db_ver');

	if($lf_lead_db_cur != $lf_lead_db_ver) {
		lf_lead_install();
	}
}

add_action('plugins_loaded', 'lf_lead_update');

function lf_add_lead($lead_id, $user_id, $sync_status) {

	global $wpdb;
	$lf_lead_db_name = $wpdb->prefix . LF_LEAD;

	$wpdb->insert($lf_lead_db_name, array(
			'sync_status' => $sync_status,
			'user_id' => $user_id,
			'lead_id' => $lead_id,
	));
}

/**
 * Change the edit link
 */
add_filter( 'get_edit_user_link', 'lf_get_edit_lead_link', 10, 2 );
function lf_get_edit_lead_link( $link, $user_id ) {
    global $role;
    
    if(isset($role) && $role==LF_LEAD) {
        $link = add_query_arg( array(
                'role' => LF_LEAD,
                'page' => plugin_basename(LEADFERRY_PATH . 'leads/profile.php'),
                'user_id' => $user_id,
        ), self_admin_url( 'users.php' ) );
    }
    return $link;
}

add_action( 'admin_menu', 'lf_lead_user_profile_page' );
/**
 * Add the menu page
 */
function lf_lead_user_profile_page() {
	$lf_users_page = plugin_basename(LEADFERRY_PATH . 'leads/profile.php');
	add_users_page( 'User Profile', 'User Profile', 'manage_options', $lf_users_page, '', '', 71 );
	add_action( "load-$lf_users_page", 'lf_users_page_screen_options' );
}

function lf_users_page_screen_options() {
	$args = array(
		'label' => 'Events per page',
		'default' => 10,
		'option' => 'lf_per_page'
		);
	add_screen_option( 'per_page', $args );
}

add_filter( 'set-screen-option', 'lf_set_screen_option', 10, 3 );
function lf_set_screen_option( $status, $option, $value ) {
	if( 'lf_per_page' == $option )
		return $value;
}


// Settings Page
require_once(dirname(__FILE__) . '/classes/class-lf-settings-page.php');

// Lead Capture Support
require_once(dirname(__FILE__) . '/classes/vendors/class-lf-formidable-forms.php');