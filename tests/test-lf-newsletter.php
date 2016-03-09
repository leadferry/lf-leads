<?php

class Test_LF_Newsletter extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'newsletter' );
		lf_support( $product );
        $this->selected_product = new LF_Newsletter();
	}
    function test_newsletter_capture_lead() {

        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Newsletter')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->newsletter_capture_lead();
    }



    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_newsletter', 'enqueued') );
    }
}
