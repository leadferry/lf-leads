<?php

class Test_LF_Seedprod extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'seedprod' );
		lf_support( $product );
        $this->selected_product = new LF_Seedprod();
	}
    function test_seedprod_capture_lead() {

        $_POST['form_id'] = 'form_id';
        $_POST['name'] = 'name';
        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Seedprod')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->seedprod_capture_lead();
    }

    function test_validate_options() {
        $input = array(
            'lead_form_id' => '123',
            'lead_name' => '<b>test_name</b>',
            'lead_email'=> 'test_email'
        );

        $this->assertContains( '123', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_name', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_email', $this->selected_product->validate_options($input));
    }

    function test_settings_section_text() {
        $output = '<h2>Seedprod Settings</h2><p>Please provide the IDs for following fields in Seedprod form</p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_form_id_callback() {
        update_option('lf_seedprod_options', array('lead_form_id' => '1') );
        $output = '<input id="lf_lead_form_id" name="lf_seedprod_options[lead_form_id]" size="40" type="text" value="1">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_form_id_callback() );
    }

    function test_lf_lead_name_callback() {
        update_option('lf_seedprod_options', array('lead_name' => 'firstname') );
        $output = '<input id="lf_lead_name" name="lf_seedprod_options[lead_name]" size="40" type="text" value="firstname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_name_callback() );
    }

    function test_lf_lead_email_callback(){
        update_option('lf_seedprod_options', array('lead_email' => 'email') );
        $output = '<input id="lf_lead_email" name="lf_seedprod_options[lead_email]" size="40" type="text" value="email">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_email_callback() );
    }

    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_seedprod', 'enqueued') );
    }
}
