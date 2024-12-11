<?php

namespace AB_Three;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Post_Type {

    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init() {
        register_post_type( 'book', array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'Book',
                'add_new_item' => 'Add New Book',
                'search_items' => 'Search Books',
                'view_item' => 'View Book',
                'not_found' => 'No Books Found',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
            'hierarchical' => true,
            'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'menu_position' => 3,
            'menu_icon' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBmaWxsPSIjZmZmIj48IS0tIUZvbnQgQXdlc29tZSBGcmVlIDYuNy4xIGJ5IEBmb250YXdlc29tZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tIExpY2Vuc2UgLSBodHRwczovL2ZvbnRhd2Vzb21lLmNvbS9saWNlbnNlL2ZyZWUgQ29weXJpZ2h0IDIwMjQgRm9udGljb25zLCBJbmMuLS0+PHBhdGggZD0iTTMuOSA1NC45QzEwLjUgNDAuOSAyNC41IDMyIDQwIDMybDQzMiAwYzE1LjUgMCAyOS41IDguOSAzNi4xIDIyLjlzNC42IDMwLjUtNS4yIDQyLjVMMzIwIDMyMC45IDMyMCA0NDhjMCAxMi4xLTYuOCAyMy4yLTE3LjcgMjguNnMtMjMuOCA0LjMtMzMuNS0zbC02NC00OGMtOC4xLTYtMTIuOC0xNS41LTEyLjgtMjUuNmwwLTc5LjFMOSA5Ny4zQy0uNyA4NS40LTIuOCA2OC44IDMuOSA1NC45eiIvPjwvc3ZnPg==',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'books' ),
        ) );
    }
}
