<?php
class LF_Lead {
	public $user_id;
	public $lead_id;
	public $first_visit;
	public $last_seen;

	function __construct( $user_id )  {
		$this->user_id = $user_id;
		$this->sync_api();
	}

	public function get_lead_id() {
		global $wpdb;
		$wpdb->lf_lead = $wpdb->prefix . 'lf_lead' ;
		$lead_id = $wpdb->get_row( "SELECT lead_id FROM $wpdb->lf_lead WHERE user_id = $this->user_id"  );
		if( $lead_id ) {
			$this->lead_id =  $lead_id->lead_id;
		}
	}

	public function sync_api() {

		$this->get_lead_id();

		$response = wp_remote_get( 'http://10.0.2.2:3000/leads/' . $this->user_id );
		if( is_wp_error( $response ) ) {
			$this->get_lead_meta();
		}
		else {
			$response = json_decode( $response['body'], true );
			$this->first_visit = $response['first visit'];
			$this->last_seen = $response['last seen'];

			$this->update_lead_meta();
		}
	}

	public function update_lead_meta() {
		update_user_meta( $this->user_id, '_first_visit', $this->first_visit );
		update_user_meta( $this->user_id, '_last_seen', $this->last_seen );

		$current_time =  date( "F j, Y, g:i a" );
		update_user_meta( $this->user_id, '_last_update', $current_time );
	}

	public function get_lead_meta() {
		$this->first_visit = get_user_meta( $user_id, '_first_visit', true );
		$this->last_seen = get_user_meta( $user_id, '_last_seen', true );
	}

	public function display_events() {
		require( LEADFERRY_PATH . 'leads/classes/class-lf-event-list-table.php' );
		$events_table = new LF_Event_List_Table();
		$events_table->prepare_items();
		$events_table->display();
	}
}