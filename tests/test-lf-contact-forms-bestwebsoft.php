<?php

class Test_LF_Contact_Forms_Bestwebsoft extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'contact-forms-bestwebsoft' );
		lf_support( $product );
        $this->selected_product = new LF_Contact_Forms_Bestwebsoft();
	}
    function test_bestwebsoft_capture_lead() {

        $_POST['cntctfrm_contact_name'] = 'name';
        $_POST['cntctfrm_contact_email'] = 'email';

        $mock = $this->getMockBuilder('LF_Contact_Forms_Bestwebsoft')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->bestwebsoft_capture_lead( array() );
    }
}
