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

}