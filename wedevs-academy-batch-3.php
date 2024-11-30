<?php
/**
 * Plugin Name: Academy Batch Three
 * Plugin URI: https://example.com
 * Description: This is plugin description.
 * Version: 1.0.0
 * Author: weDevs Academy
 * Author URI: https://wedevsacademy.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wedevs-academy-batch-3
 */

class Academy_Batch_Three {

    private static $instance;

    private function __construct() {
        add_filter( 'the_content', array( $this, 'the_content_callback' ) );

        add_action( 'wp_footer', array( $this, 'wp_footer' ) );

        add_filter( 'body_class', array( $this, 'body_class' ), 10, 2 );
    }

    public static function get_instance() {
        if ( self::$instance ) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::$instance;
    }

    public function the_content_callback( $content ) {

        $is_show = apply_filters( 'academy_show_post_content_qr_code', true );

        if ( ! $is_show ) {
            return $content;
        }

        $url = get_the_permalink();

        $custom_classes = implode(
            " ",
            apply_filters( 'qr_code_css_classes', array() )
        );

        $image = '<p><img class="' . $custom_classes . '" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $url . '"></p>';

        $content .= $image;

        return $content;
    }

    public function wp_footer() {
        do_action( 'before_footer_qr_code', array(1, 2, 3) );

        $url = home_url();

        $image = '<p><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $url . '"></p>';

        echo $image;
    }

    public function body_class( $classes, $css_class ) {
        $classes[] = 'my-custom-class';

        return $classes;
    }
}

Academy_Batch_Three::get_instance();


/* Other plugin code start */

function academy_show_post_content_qr_code_callback() {
    return false;
}

add_filter( 'academy_show_post_content_qr_code', 'academy_show_post_content_qr_code_callback' );

function academy_show_post_content_qr_code_callback2() {
    return true;
}

add_filter( 'academy_show_post_content_qr_code', 'academy_show_post_content_qr_code_callback2', 11 );

function before_footer_qr_code_callback( $args ) {
    print_r($args);
    echo 'This is before QR';
}

add_action( 'before_footer_qr_code', 'before_footer_qr_code_callback', 20, 1 );

// Another plugin/code
// remove_action( 'before_footer_qr_code', 'before_footer_qr_code_callback', 20 );

add_filter( 'qr_code_css_classes', function( $classes ) {

    $classes[] = 'my-image-class';

    return $classes;
} );
/* Other plugin code end */
