<?php 

require_once( '../lf-leads.php' );

class Test_Post_Data extends WP_UnitTestCase {

	private $data;

	function setUp() {

		parent::setUp();

		$this->data = $GLOBALS['test'];
	}

	function testSettingsPage() {
		$this->assertFalse( null == $this->settings );
	}
}