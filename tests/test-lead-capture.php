<?php

class Test_Lead_Capture extends WP_UnitTestCase{

	function setUp() {

		parent::setUp();

		$product = array( 'selected_product' => 'custom' );
		lf_support( $product );

		$this->lead_capture = new LF_Lead_Capture();

		$this->raw_lead = array(
			'provider' => 'provider',
			'form_id' => 'form_id',
			'first_name' => 'first_name',
			'last_name' => 'last_name',
			'email' => 'email',
		);
	}

	function test_prepare_data() {
		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"provider"}},"properties":{"name":"first_name last_name","email":"email"}}';
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_without_firstname() {
		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"provider"}},"properties":{"name":"Not Available","email":"email"}}';

		unset( $this->raw_lead['first_name'] );
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_without_lastname() {
		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"provider"}},"properties":{"name":"first_name","email":"email"}}';

		unset( $this->raw_lead['last_name'] );
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_without_email() {
		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"provider"}},"properties":{"name":"first_name last_name","email":"Not Available"}}';

		unset( $this->raw_lead['email'] );
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_without_provider() {
		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"Not Available"}},"properties":{"name":"first_name last_name","email":"email"}}';

		unset( $this->raw_lead['provider'] );
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_without_form_id() {
		$raw_json = '{"content":{"form":{"reference":"Not Available","source":"3rd Party","provider":"provider"}},"properties":{"name":"first_name last_name","email":"email"}}';

		unset( $this->raw_lead['form_id'] );
		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_prepare_data_with_cookies() {

		$raw_json = '{"content":{"form":{"reference":"form_id","source":"3rd Party","provider":"provider"}},"properties":{"name":"first_name last_name","email":"email"},"visitor":"visitor cookie is set","session":"session cookie is set"}';

		foreach( array( 'visitor', 'session' ) as $cookie ) {
			$_COOKIE[LF_PREFIX . $cookie] = $cookie . " cookie is set" ;
		}

		$this->assertJsonStringEqualsJsonString( json_encode( $raw_json ), json_encode( $this->lead_capture->prepare_data( $this->raw_lead ) ) );
	}

	function test_post_data() {
		// $args = array(
		// 	'visitor' => 'lf123',
		// 	'session' => 'lf456'
		// );

		$args = '{"content":{"form":{"reference":"Not Available","source":"3rd Party","provider":"Ninja Forms"}},"properties":{"name":"varunk mr","email":"imvarunkmr@gmail.com"},"visitor":"wp_lfv_8383","session":"wp_lfs_8383"}';
		update_option( LF_PREFIX . 'visitor_cookie_expires', '2D' );
		update_option( LF_PREFIX . 'session_cookie_expires', '2D' );
		// $this->lead_capture->post_data( $args );

		global $wpdb;
		$lf_lead_db_name = $wpdb->prefix . LF_LEAD;
		$results = $wpdb->get_results( 'SELECT * FROM ' . $lf_lead_db_name  );
		// $this->assertTrue( $results );
	}

	function test_visitor_cookie() {
		update_option(LF_PREFIX . 'visitor_cookie_expires', '2D');
		update_option(LF_PREFIX . 'cookie_domain', 'cookie_domain_name');
		update_option(LF_PREFIX . 'cookie_path', 'cookie_path_name');

		$result = $this->lead_capture->visitor_cookie('test_visitor_cookie');
		$this->assertArrayHasKey( 'name', $result );
		$this->assertArrayHasKey( 'value', $result );
		$this->assertArrayHasKey( 'expire', $result );
		$this->assertArrayHasKey( 'validity', $result );
		$this->assertArrayHasKey( 'domain', $result );
		$this->assertArrayHasKey( 'path', $result );
	}

	function test_session_cookie() {
		update_option( LF_PREFIX . 'session_cookie_expires', '2D' );
		update_option(LF_PREFIX . 'cookie_domain', 'cookie_domain_name');
		update_option(LF_PREFIX . 'cookie_path', 'cookie_path_name');

		$result = $this->lead_capture->session_cookie('test_visitor_cookie');
		$this->assertArrayHasKey( 'name', $result );
		$this->assertArrayHasKey( 'value', $result );
		$this->assertArrayHasKey( 'expire', $result );
		$this->assertArrayHasKey( 'validity', $result );
		$this->assertArrayHasKey( 'domain', $result );
		$this->assertArrayHasKey( 'path', $result );

		update_option( LF_PREFIX . 'session_cookie_expires', '0' );
		$result = $this->lead_capture->session_cookie('test_visitor_cookie');
		$this->assertEquals( 0, $result['validity']);
	}

	function test_cookie_expiry_date() {
		$interval = '1D';
		$range_start = new DateTime("now", new DateTimeZone("UTC"));
		$range_start->add(new DateInterval('P' . $interval));
		$cookie_expiry_time = DateTime::createFromFormat( 'l, d-M-Y H:i:s T', $this->lead_capture->cookie_expiry_date( $interval ) );
		$range_end = new DateTime("now", new DateTimeZone("UTC"));
		$range_end->add(new DateInterval('P' . $interval));
		$this->assertTrue( $range_start <= $cookie_expiry_time  && $range_end >= $cookie_expiry_time );
	}
}
