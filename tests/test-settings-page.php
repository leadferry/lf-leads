<?php 

class Test_Settings extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		$this->settings_page = new LF_Settings_Page();
	}

	function test_lead_setting_page() {

		$this->settings_page->lf_lead_settings_page();

		$this->assertFalse( empty($GLOBALS['admin_page_hooks']['lf_leadferry_settings'] ) );
	}
}