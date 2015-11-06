<?php
require( LEADFERRY_PATH . 'vendor/wordpress/wp-list-table/class-wp-list-table.php' );

class LF_Event_List_Table extends LF_List_Table {
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();

        // Pagination
        $perPage = 1;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        if ( $data )
            $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

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
        if( is_wp_error( $response ) ) {
            $data = false;
            return $data;
        }
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