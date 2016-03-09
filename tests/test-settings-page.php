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

	function test_settings_section_text() {
		$output = '<p>Choose the plugin or third party forms you are currently using for capturing leads</p>';
        $this->expectOutputString( $output, $this->settings_page->settings_section_text() );
	}
}
