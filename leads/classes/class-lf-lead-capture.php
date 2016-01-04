<?php

/**
 * Base class for capturing form/leads 
 * 
 */
class LF_Lead_Capture {

	public $lead_name;
	public $lead_email;

	/**
	 * Prepare data to be posted
	 * 
	 */
	public function prepare_data( $lead ) {

		$name = isset( $lead['last_name'] ) ? $lead['first_name'] . ' ' . $lead['last_name'] : $lead['first_name'] ;

		$source = isset( $lead['source'] ) ? $lead['source'] : "3rd Party" ;
		$form = array(
			'reference' => isset( $lead['form_id'] ) ? $lead['form_id'] : 'Not Available',
			'source' => $source,
			'provider' => $lead['provider'],
		);

		$properties = array(
			'name' => $name,
			'email' => isset( $lead['email'] ) ? $lead['email'] : 'Not Available',
		);

		$data = array(
			'content' => array( 
				'form' => $form,
				'properties' => $properties,
				'visitor' => '<cookie_value>',
				'session' => '<cookie_value>'
			 ),
		);

		$json_data = json_encode( $data );

		return $json_data;	
	}

	/**
	 * POST data to remote server
	 * 
	 */
	public function post_data( $data ) {

		wp_die( $data );
	}
}