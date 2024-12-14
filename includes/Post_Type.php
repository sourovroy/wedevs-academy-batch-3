<?php

namespace AB_Three;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Post_Type {

    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );

        add_filter( 'the_content', array( $this, 'the_content' ) );

        add_action( 'book_category_edit_form_fields', array( $this, 'book_category_edit_form_fields' ) );
        add_action( 'edited_book_category', array( $this, 'edited_book_category' ) );
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
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'menu_position' => 3,
            'menu_icon' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBmaWxsPSIjZmZmIj48IS0tIUZvbnQgQXdlc29tZSBGcmVlIDYuNy4xIGJ5IEBmb250YXdlc29tZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tIExpY2Vuc2UgLSBodHRwczovL2ZvbnRhd2Vzb21lLmNvbS9saWNlbnNlL2ZyZWUgQ29weXJpZ2h0IDIwMjQgRm9udGljb25zLCBJbmMuLS0+PHBhdGggZD0iTTMuOSA1NC45QzEwLjUgNDAuOSAyNC41IDMyIDQwIDMybDQzMiAwYzE1LjUgMCAyOS41IDguOSAzNi4xIDIyLjlzNC42IDMwLjUtNS4yIDQyLjVMMzIwIDMyMC45IDMyMCA0NDhjMCAxMi4xLTYuOCAyMy4yLTE3LjcgMjguNnMtMjMuOCA0LjMtMzMuNS0zbC02NC00OGMtOC4xLTYtMTIuOC0xNS41LTEyLjgtMjUuNmwwLTc5LjFMOSA5Ny4zQy0uNyA4NS40LTIuOCA2OC44IDMuOSA1NC45eiIvPjwvc3ZnPg==',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'books' ),
        ) );

        register_post_type( 'movies', array(
            'labels' => array(
                'name' => 'Movies',
                'singular_name' => 'Movie',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
            'menu_position' => 4,
            'has_archive' => true,
            'show_in_menu' => 'edit.php?post_type=book'
        ) );

        register_taxonomy( 'book_category', 'book', array(
            'labels' => array(
                'name' => 'Categories',
                'singular_name' => 'Category',
                'add_new_item' => 'Add New Category',
            ),
            'show_in_rest' => true,
            'hierarchical' => true,
            'rewrite' => array( 'slug' => 'books-categories' ),
        ) );

        register_taxonomy( 'book_tags', 'book', array(
            'labels' => array(
                'name' => 'Tags',
                'singular_name' => 'Tag',
                'add_new_item' => 'Add New Tag',
            ),
            'show_in_rest' => true,
            'hierarchical' => false,
        ) );
    }

    public function the_content( $contents ) {
        if ( ! is_singular( 'book' ) ) {
            return $contents;
        }

        $terms = wp_get_post_terms( get_the_ID(), 'book_category' );

        ob_start();
        ?>
            <ul>
                <?php foreach( $terms as $term ): ?>
                <li><a href="<?php echo get_term_link( $term, 'book_category' ); ?>"><?php echo $term->name; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php
        $html = ob_get_clean();

        return $contents . $html;
    }

    public function book_category_edit_form_fields( $term ) {
        $extra_meta = get_term_meta( $term->term_id, 'extra_meta', true );
        ?>
        <tr class="form-field term-slug-wrap">
			<th scope="row"><label for="slug">Extra meta</label></th>
			<td><input name="extra_meta" id="slug" type="text" value="<?php echo $extra_meta; ?>" size="40" />
		</tr>
        <tr class="form-field term-slug-wrap">
			<th scope="row"><label for="slug">File</label></th>
			<td><input name="extra_file" id="slug" type="file" />
		</tr>
        <?php
    }

    public function edited_book_category( $term_id ) {
        update_term_meta( $term_id, 'extra_meta', $_POST['extra_meta'] );
    }
}
