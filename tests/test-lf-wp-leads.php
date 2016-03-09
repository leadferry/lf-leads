<?php

class Test_LF_WP_Leads extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'wp-leads' );
		lf_support( $product );
        $this->selected_product = new LF_WP_Leads();
	}
    function test_wp_leads_capture_lead() {

        $_POST['form_id'] = 'form_id';
        $_POST['firstname'] = 'first_name';
        $_POST['lastname'] = 'last_name';
        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_WP_Leads')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->wp_leads_capture_lead();
    }

    function test_validate_options() {
        $input = array(
            'lead_form_id' => '123',
            'lead_first_name' => '<b>test_first_name</b>',
            'lead_last_name' => 'test_last_name',
            'lead_email'=> 'test_email'
        );

        $this->assertContains( '123', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_first_name', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_last_name', $this->selected_product->validate_options($input));
        $this->assertContains( 'test_email', $this->selected_product->validate_options($input));
    }

    function test_settings_section_text() {
        $output = '<h2>WP Leads Settings</h2><p>Please provide the IDs for the follwing fields in your WP Leads form. </p>';
        $this->expectOutputString( $output, $this->selected_product->settings_section_text() );
    }

    function test_lf_lead_form_id_callback() {
        update_option('lf_wp_leads_options', array('lead_form_id' => '1') );
        $output = '<input id="lf_lead_form_id" name="lf_wp_leads_options[lead_form_id]" size="40" type="text" value="1">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_form_id_callback() );
    }

    function test_lf_lead_first_name_callback() {
        update_option('lf_wp_leads_options', array('lead_first_name' => 'firstname') );
        $output = '<input id="lf_lead_first_name" name="lf_wp_leads_options[lead_first_name]" size="40" type="text" value="firstname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_first_name_callback() );
    }

    function test_lf_lead_last_name_callback(){
        update_option('lf_wp_leads_options', array('lead_last_name' => 'lastname') );
        $output = '<input id="lf_lead_last_name" name="lf_wp_leads_options[lead_last_name]" size="40" type="text" value="lastname">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_last_name_callback() );
    }

    function test_lf_lead_email_callback(){
        update_option('lf_wp_leads_options', array('lead_email' => 'email') );
        $output = '<input id="lf_lead_email" name="lf_wp_leads_options[lead_email]" size="40" type="text" value="email">';
        $this->expectOutputString( $output, $this->selected_product->lf_lead_email_callback() );
    }

    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_wp_leads', 'enqueued') );
    }
}
