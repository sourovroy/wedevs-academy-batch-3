<?php

namespace AB_Three;

class Book_Reader {

    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );

        if ( file_exists( AB_THREE_PLUGIN_PATH . 'lib/CMB2/init.php' ) ) {
            require_once AB_THREE_PLUGIN_PATH . 'lib/CMB2/init.php';
        }

        add_action( 'cmb2_admin_init', array( $this, 'cmb2_admin_init' ) );
        add_filter( 'the_content', array( $this, 'book_the_content' ) );
        add_filter( 'the_content', array( $this, 'chapter_the_content' ) );
    }

    public function init() {
        register_post_type( 'book', array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'Book',
            ),
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
        ) );

        register_post_type( 'chapter', array(
            'labels' => array(
                'name' => 'Chapters',
                'singular_name' => 'Chapter',
            ),
            'public' => true,
            'show_in_rest' => true,
            'has_archive' => true,
        ) );
    }

    public function cmb2_admin_init() {
        $book_metabox = new_cmb2_box( array(
            'id' => 'book-settings-box',
            'title' => 'Book Settings',
            'object_types' => array( 'chapter' ),
        ) );

        $books_query = get_posts( array(
            'post_type' => 'book',
            'posts_per_page' => -1,
        ) );

        $books_option = array();

        foreach ( $books_query as $book_data ) {
            $books_option[ $book_data->ID ] = $book_data->post_title;
        }

        $book_metabox->add_field( array(
            'id' => '_book_id',
            'name' => 'Select Book',
            'desc' => 'Choose the book name',
            'type' => 'select',
            'options' => $books_option,
        ) );
    }

    public function book_the_content( $contents ) {
        global $post;

        if ( $post->post_type != 'book' ) {
            return $contents;
        }

        $chapters = get_posts( array(
            'post_type' => 'chapter',
            'posts_per_page' => -1,
            'meta_key' => '_book_id',
            'meta_value' => $post->ID,
        ) );

        ob_start();
        ?>
        <ul>
            <?php foreach ( $chapters as $chapter ) : ?>
            <li><a href="<?php the_permalink( $chapter->ID ); ?>"><?php echo $chapter->post_title; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php
        $contents .= ob_get_clean();

        return $contents;
    }

    public function chapter_the_content( $contents ) {
        global $post;

        if ( $post->post_type != 'chapter' ) {
            return $contents;
        }

        $book_id = get_post_meta( $post->ID, '_book_id', true );

        $book = get_post( $book_id );

        $contents .= '<p>Book Name: <a href="' . get_the_permalink( $book ) . '">' . $book->post_title . '</a></p>';

        return $contents;
    }
}
