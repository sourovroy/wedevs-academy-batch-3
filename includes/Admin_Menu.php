<?php

class AB_Three_Admin_Menu {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {
        add_menu_page(
            'Query Post',
            'Query Post',
            'administrator',
            'ab_three_query_post',
            array( $this, 'query_post_callback' )
        );
    }

    public function query_post_callback() {
        $filter_cat = 0;

        if ( isset( $_GET['filter_cat'] ) ) {
            $filter_cat = $_GET['filter_cat'];
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 10,
        );

        if ( ! empty( $filter_cat ) ) {
            $args['cat'] = $filter_cat;
        }

        $posts = get_posts( $args );

        $terms = get_terms( array(
            'taxonomy' => 'category',
        ) );

        include AB_THREE_PLUGIN_PATH . 'includes/templates/query-post.php';
    }
}
