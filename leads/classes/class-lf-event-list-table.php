<?php
require( LEADFERRY_PATH . 'vendor/wordpress/wp-list-table/class-wp-list-table.php' );

class LF_Event_List_Table extends LF_List_Table {
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    public function get_columns() {
        $columns = array(
            'event' => 'Event',
            'action' => 'Action',
            'source' => 'Source',
            'when' => 'When'
        );

        return $columns;
    }

    public function get_hidden_columns() {
        return array();
    }

    public function get_sortable_columns() {
    	return array();
    }

    private function table_data() {
    	$response = wp_remote_get('http://10.0.2.2:3001/events');
    	$data = json_decode( $response['body'], true );
    	return $data;
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'event':
            case 'source':
            case 'action':
            case 'when':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
}