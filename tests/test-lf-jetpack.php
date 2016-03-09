<?php

class Test_LF_Jetpack extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'jetpack' );
		lf_support( $product );
        $this->selected_product = new LF_Jetpack();
	}
    function test_capture_lead() {

        $option_values = array(
            'lead_first_name' => 'First Name ',
            'lead_last_name' => 'Last Name',
            'lead_email' => 'Email'
        );

        update_option( 'lf_jetpack_options', $option_values );

        $post_id = '';
        $extra_values = '';
        $all_values = array(
            '1_First_Name' => 'First Name',
            '2_Last_Name ' => 'Last Name',
            '3_Email' => 'Email',
        );

        $mock = $this->getMockBuilder('LF_Jetpack')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->capture_lead( $post_id, $all_values, $extra_values );
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
        $output = '<h2>Jetpack Settings</h2><p>Please provide the labels( case sensitive ) for your Jetpack form for the follwing fields.  </p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_first_name_callback() {
        update_option('lf_jetpack_options', array('lead_first_name' => 'firstname') );
        $output = '<input id="lf_lead_first_name" name="lf_jetpack_options[lead_first_name]" size="40" type="text" value="firstname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_first_name_callback() );
    }

    function test_lf_lead_last_name_callback(){
        update_option('lf_jetpack_options', array('lead_last_name' => 'lastname') );
        $output = '<input id="lf_lead_last_name" name="lf_jetpack_options[lead_last_name]" size="40" type="text" value="lastname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_last_name_callback() );
    }

    function test_lf_lead_email_callback(){
        update_option('lf_jetpack_options', array('lead_email' => 'email') );
        $output = '<input id="lf_lead_email" name="lf_jetpack_options[lead_email]" size="40" type="text" value="email">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_email_callback() );
    }
}
