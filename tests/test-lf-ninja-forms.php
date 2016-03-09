<?php

class Test_LF_Ninja_Forms extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'ninja-forms' );
		lf_support( $product );
        $this->selected_product = new LF_Ninja_Forms();
	}
    function test_capture_lead() {

        // global $ninja_forms_processing;
        // $ninja_forms_processing = new stdClass();
        //
        // $_POST['first_name'] = 'first_name';
        // $_POST['last_name'] = 'last_name';
        // $_POST['email'] = 'email';
        //
        // $mock = $this->getMockBuilder('LF_Ninja_Forms')
        //         ->setMethods( array( 'prepare_data', 'post_data' ) )
        //         ->getMock();
        // $mock->expects($this->once())
        //      ->method('prepare_data');
        // $mock->expects($this->once())
        //      ->method('post_data');
        // $mock->capture_lead();
    }

    function test_validate_options() {
        $input = array(
            'lead_first_name' => '<b>test_first_name</b>',
            'lead_last_name' => 'test_last_name',
            'lead_email'=> 'test_email'
        );
        $this->assertContains( 'test_first_name', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_last_name', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_email', $this->selected_product->validate_options($input));
    }

    function test_settings_section_text() {
        $output = '<h2>Ninja Forms Settings</h2><p>Please provide field IDs for the follwing fields in Ninja Forms. You can find the IDs while creating or editing these fields on the Ninja Forms plugin page  </p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_first_name_callback() {
        update_option('lf_ninja_options', array('lead_first_name' => 'firstname') );
        $output = '<input id="lf_lead_first_name" name="lf_ninja_options[lead_first_name]" size="40" type="text" value="firstname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_first_name_callback() );
    }

    function test_lf_lead_last_name_callback(){
        update_option('lf_ninja_options', array('lead_last_name' => 'lastname') );
        $output = '<input id="lf_lead_last_name" name="lf_ninja_options[lead_last_name]" size="40" type="text" value="lastname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_last_name_callback() );
    }

    function test_lf_lead_email_callback(){
        update_option('lf_ninja_options', array('lead_email' => 'email') );
        $output = '<input id="lf_lead_email" name="lf_ninja_options[lead_email]" size="40" type="text" value="email">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_email_callback() );
    }
}
