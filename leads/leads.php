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
	$lf_lead_db_name = $wpdb->prefix . LF_LEAD;;

	$wpdb->insert($lf_lead_db_name, array(
			'sync_status' => $sync_status,
			'user_id' => $user_id,
			'lead_id' => $lead_id,
	));
}