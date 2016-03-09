<?php

/**
 * Base class for capturing form/leads
 *
 */
class LF_Lead_Capture {

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
			// else {
			// 	$data['visitor'] = "wp_lfv_8383";
			// 	$data['session'] = "wp_lfs_8383";
			// }
		}
		return json_encode( $data );
	}

	function post_data( $data ) {
		$public_key = get_option( LF_PREFIX . 'public_key' );
		$args = array(
			'method' => 'POST',
			'headers' => array(
				'Authorization' => 'Token ' . $public_key,
				'Content-Type' => 'application/json',
			),
			'body' => $data,
		);
		$response = wp_remote_request( LF_EVENTS_API, $args );
		if( !is_wp_error( $response ) && $response['response']['code'] == 201 ) {
			$body = json_decode( $response['body'], true );
			$cookie = $this->visitor_cookie( $body['visitor'] );
			setcookie( $cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain'] );
			$cookie = $this->session_cookie( $body['session'] );
			setcookie( $cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain'] );
			lf_add_lead( $body['visitor'], $user_id, LF_SYNC_STATUS_OK );
		}
		else {
			if( isset($body['visitor'] ) ) {
				lf_add_lead($body['visitor'], $user_id, LF_SYNC_STATUS_UPDATE_PENDING );
			}
		}
	}

	function visitor_cookie( $value='' ) {
		$cookie_expires = $this->cookie_expiry_date( get_option(LF_PREFIX . 'visitor_cookie_expires') );
		$cookie_expires = strtotime( $cookie_expires );
		$cookie_validity = strtotime($cookie_expires) - strtotime("now");
		$cookie_domain = get_option(LF_PREFIX . 'cookie_domain');
		$cookie_path = get_option(LF_PREFIX . 'cookie_path');
		return array(
			'name' => LF_PREFIX . 'visitor',
			'value' => $value,
			'expire' => $cookie_expires,
			'validity' => $cookie_validity,
			'domain' => $cookie_domain,
			'path' => $cookie_path,
		);
	}

	function session_cookie( $value='' ) {
		$cookie_expires = get_option(LF_PREFIX . 'session_cookie_expires');
		if ($cookie_expires != '0') {
			$cookie_expires = $this->cookie_expiry_date($cookie_expires);
			$cookie_expires = strtotime( $cookie_expires );
			$cookie_validity = strtotime($cookie_expires) - strtotime("now");
		} else {
			$cookie_validity = 0;
		}
		$cookie_domain = get_option(LF_PREFIX . 'cookie_domain');
		$cookie_path = get_option(LF_PREFIX . 'cookie_path');
		return array(
			'name' => LF_PREFIX . 'session',
			'value' => $value,
			'expire' => $cookie_expires,
			'validity' => $cookie_validity,
			'domain' => $cookie_domain,
			'path' => $cookie_path,
		);
	}

	function cookie_expiry_date($interval) {
		$today = new DateTime("now", new DateTimeZone("UTC"));
		$today->add(new DateInterval('P' . $interval));
		return $today->format(DateTime::COOKIE);
	}
}
