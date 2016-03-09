<?php

class Test_Leads extends WP_UnitTestCase {

	function test_lead_install() {

		lf_lead_install();
		$this->assertInstanceOf( 'WP_Role', get_role( LF_LEAD ) );
	}

	function test_lead_install_create_table() {
		update_option( 'lf_lead_db_ver', '0.0' );
		lf_lead_install();
		$this->assertInstanceOf( 'WP_Role', get_role( LF_LEAD ) );

	}

	function test_lead_update() {
		lf_lead_update();
		$this->assertInstanceOf( 'WP_Role', get_role( LF_LEAD ) );
	}

	function test_lead_update_create_table() {
		update_option( 'lf_lead_db_ver', '0.0' );
		lf_lead_update();
		$this->assertInstanceOf( 'WP_Role', get_role( LF_LEAD ) );
	}

	function test_add_lead() {
		$lead_id = 999;
		$user_id = 999; 
		$sync_status = 1;
		lf_add_lead($lead_id, $user_id, $sync_status);

		global $wpdb;
		$lf_lead_db_name = $wpdb->prefix . LF_LEAD;
		$results = $wpdb->get_results( 'SELECT lead_id FROM ' . $lf_lead_db_name . ' WHERE user_id = ' . $user_id );

		$this->assertEquals( '999', $results['0']->lead_id );
	}

	function test_get_edit_lead_link() {

		$link = "http://www.exam.ple.com";
		$user_id = 99;

		global $role;
		$role = LF_LEAD;
		$output = lf_get_edit_lead_link( $link, $user_id );

		$this->assertStringEndsWith( 'user_id=99', $output );
	}

	function test_lead_user_profile_page() {

		$slug = plugin_basename(LEADFERRY_PATH . 'leads/profile.php');
		lf_lead_user_profile_page();
		$this->assertFalse( false == has_action("load-$slug", 'lf_users_page_screen_options') );
	}

	function test_lf_support() {

		$product = array( 'selected_product' => 'custom' );
		lf_support( $product );
		$this->assertTrue( class_exists('LF_Custom') );
	}
}