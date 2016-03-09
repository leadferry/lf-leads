<?php

class Test_LF_Hubspot extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'hubspot' );
		lf_support( $product );
        $this->selected_product = new LF_Hubspot();
	}
    function test_hubspot_capture_lead() {

        $_POST['form_id'] = 'form_id';
        $_POST['firstname'] = 'first_name';
        $_POST['lastname'] = 'last_name';
        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Hubspot')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->hubspot_capture_lead();
    }

    function test_validate_options() {
        $input = array(
            'lead_form_id' => '123',
        );

        $this->assertContains( '123', $this->selected_product->validate_options($input));
    }

    function test_settings_section_text() {
        $output = '<h2>Hubspot Settings</h2><p>Please provide form ID for your hubspot form below.  </p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_form_id_callback() {
        update_option('lf_hubspot_options', array('lead_form_id' => '1') );
        $output = '<input id="lf_lead_form_id" name="lf_hubspot_options[lead_form_id]" size="40" type="text" value="1">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_form_id_callback() );
    }

    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_hubspot', 'enqueued') );
    }
}
