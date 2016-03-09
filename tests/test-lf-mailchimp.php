<?php

class Test_LF_Mailchimp extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'mailchimp' );
		lf_support( $product );
        $this->selected_product = new LF_Mailchimp();
	}
    function test_capture_lead() {

        $form = new stdClass();
        $form->ID = 'form_id';
        $form->data = array(
            'FNAME' => 'First name',
            'LNAME' => 'Last name',
            'EMAIL' => 'Email'
        );

        $_POST['form_id'] = 'form_id';
        $_POST['first_name'] = 'first_name';
        $_POST['last_name'] = 'last_name';
        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Mailchimp')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->capture_lead( $form );
    }
}
