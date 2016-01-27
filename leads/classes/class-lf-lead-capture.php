<?php

/**
 * Base class for capturing form/leads 
 * 
 */
class LF_Lead_Capture {

	/**
	 * Prepare data to be posted
	 * 
	 */
	public function prepare_data( $lead ) {

		if( isset($lead['first_name'] ) )
			$name = isset( $lead['last_name'] ) ? $lead['first_name'] . ' ' . $lead['last_name'] : $lead['first_name'] ;
		else
			$name = 'Not Available';

		$data = array(
			'content' => array( 
				'form' => array(
					'reference' => isset( $lead['form_id'] ) ? $lead['form_id'] : 'Not Available',
					'source' => isset( $lead['source'] ) ? $lead['source'] : "3rd Party",
					'provider' => isset( $lead['provider'] ) ? $lead['provider'] : 'Not Available',
				),
			),
			'properties' => array(
				'name' => $name,
				'email' => isset( $lead['email'] ) ? $lead['email'] : 'Not Available',
			),
		);

		foreach(array('visitor','session',) as $cookie) {
			if(isset($_COOKIE[LF_PREFIX . $cookie])) {
				$data[$cookie] = $_COOKIE[LF_PREFIX . $cookie];
			}
		}
		
		$json_data = json_encode( $data );
		return $json_data;
	}

	/**
	 * POST data to remote server
	 * 
	 */
	public function post_data( $args ) {

		$public_key = get_option(LF_PREFIX . 'public_key');
		$defaults = array(
				'method' => 'POST',
				'headers' => array(
						'Authorization' => 'Token ' . $public_key,
						'Content-Type' => 'application/json',
				),
		);
		
		$args = wp_parse_args($args, $defaults);
		
		$response = wp_remote_request(LF_EVENTS_API, $args);

		if(!is_wp_error($response) && $response['response']['code'] == 201) {
			$body = json_decode($response['body'], true);
			$cookie = lf_visitor_cookie($body['visitor']);
			setcookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain']);
			$cookie = lf_session_cookie($body['session']);
			setcookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain']);
			lf_add_lead($body['visitor'], $user_id, LF_SYNC_STATUS_OK);
		} else {
			if(isset($body['visitor'])) {
				lf_add_lead($body['visitor'], $user_id, LF_SYNC_STATUS_UPDATE_PENDING);
			}
		}
	}
}