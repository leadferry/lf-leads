<?php
require( LEADFERRY_PATH . 'vendor/wordpress/wp-list-table/class-wp-list-table.php' );

class LF_Event_List_Table extends LF_List_Table {
    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();


        // Pagination
        $perPage = $this->get_items_per_page( 'lf_per_page' );
        $currentPage = $this->get_pagenum();
        $totalItems = 123;

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        if ( $data )
            // $data = array_slice( $data, ( ( $currentPage-1 ) * $perPage ), $perPage);

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
        var_dump($this->get_pagenum());
        $start = $this->get_pagenum() * $this->get_items_per_page( 'lf_per_page' );
    	$response = wp_remote_get('http://10.0.2.2:3001/events?_start=' . $start . '&_limit=' . $this->get_items_per_page( 'lf_per_page' ) );
        var_dump('http://10.0.2.2:3001/events?_start=' . $start . '&_limit=' . $this->get_items_per_page( 'lf_per_page' ) );
        if( is_wp_error( $response ) ) {
            $data = false;
            return $data;
        }
    	$data = json_decode( $response['body'], true );
    	return $data;
    }


    public function column_default( $item, $column_name ) {
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

    public function pagination( $which ) {
        if ( empty( $this->_pagination_args ) )
            return;

        
        extract( $this->_pagination_args, EXTR_SKIP );

        $output = '<span class="displaying-num">' . sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';

        $current = $this->get_pagenum();

        $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

        $current_url = remove_query_arg( array( 'hotkeys_highlight_last', 'hotkeys_highlight_first' ), $current_url );


        $page_links = array();

        $disable_first = $disable_last = '';
        if ( $current == 1 )
            $disable_first = ' disabled';
        if ( $current == $total_pages )
            $disable_last = ' disabled';

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
            'first-page' . $disable_first,
            esc_attr__( 'Go to the first page' ),
            esc_url( remove_query_arg( 'paged', $current_url ) ),
            '&laquo;'
        );

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
            'prev-page' . $disable_first,
            esc_attr__( 'Go to the previous page' ),
            esc_url( add_query_arg( 'paged', max( 1, $current-1 ), $current_url ) ),
            '&lsaquo;'
        );

        if ( 'bottom' == $which )
            $html_current_page = $current;
        else
            $html_current_page = sprintf( "<input class='current-page' title='%s' type='text' name='paged' value='%s' size='%d' />",
                esc_attr__( 'Current page' ),
                $current,
                strlen( $total_pages )
            );

        $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
        $page_links[] = '<span class="paging-input">' . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . '</span>';

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
            'next-page' . $disable_last,
            esc_attr__( 'Go to the next page' ),
            esc_url( add_query_arg( 'paged', min( $total_pages, $current+1 ), $current_url ) ),
            '&rsaquo;'
        );

        $page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
            'last-page' . $disable_last,
            esc_attr__( 'Go to the last page' ),
            esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
            '&raquo;'
        );

        $pagination_links_class = 'pagination-links';
        if ( ! empty( $infinite_scroll ) )
            $pagination_links_class = ' hide-if-js';
        $output .= "\n<span class='$pagination_links_class'>" . join( "\n", $page_links ) . '</span>';

        if ( $total_pages )
            $page_class = $total_pages < 2 ? ' one-page' : '';
        else
            $page_class = ' no-pages';

        $this->_pagination = "<div class='tablenav-pages{$page_class}'>$output</div>";

        echo $this->_pagination;
    }
}