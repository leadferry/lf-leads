<?php

class Test_LF_Hellobar extends WP_UnitTestCase{

    function setUp() {
		parent::setUp();
		$product = array( 'selected_product' => 'hellobar' );
		lf_support( $product );
        $this->selected_product = new LF_Hellobar();
	}
    function test_hellobar_capture_lead() {

        $_POST['form_id'] = 'form_id';
        $_POST['firstname'] = 'first_name';
        $_POST['email'] = 'email';

        $mock = $this->getMockBuilder('LF_Hellobar')
                ->setMethods( array( 'prepare_data', 'post_data' ) )
                ->getMock();
        $mock->expects($this->once())
             ->method('prepare_data');
        $mock->expects($this->once())
             ->method('post_data');
        $mock->hellobar_capture_lead();
    }

    function test_add_scripts() {
        $this->selected_product->add_scripts();
        $this->assertTrue( wp_script_is( 'lf_hellobar', 'enqueued') );
    }
}
