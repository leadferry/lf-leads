<?php 

require_once( '../lf-leads.php' );

class Basic_Test extends WP_UnitTestCase {

	private $settings;

	function setUp() {

		parent::setUp();

		$this->settings = $GLOBALS['test'];
	}

	function testSettingsPage() {
		$this->assertFalse( null == $this->settings );
	}
}