<?php

class Test_LF_Sumome extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'sumome' );
		lf_support( $product );
        $this->selected_product = new LF_Sumome();
	}
    function test_sumome_capture_lead() {

        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Sumome')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->sumome_capture_lead();
    }

    function test_validate_options() {
        $input = array(
            'lead_email'=> 'test_email'
        );
        $this->assertContains( 'test_email', $this->selected_product->validate_options($input));
    }

    function test_settings_section_text() {
        $output = '<h2>Sumome Settings</h2><p>Please provide ID for the follwing fields in your sumome form. </p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_email_callback(){
        update_option('lf_sumome_options', array('lead_email' => 'email') );
        $output = '<input id="lf_lead_email" name="lf_sumome_options[lead_email]" size="40" type="text" value="email">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_email_callback() );
    }

    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_custom', 'enqueued') );
    }
}
