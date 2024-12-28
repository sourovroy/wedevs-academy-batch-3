<?php

namespace AB_Three;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Enqueue {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
    }

    public function admin_enqueue_scripts( $screen ) {
        $my_pages = array( 'options-general.php', 'options-writing.php' );

        if ( in_array( $screen, $my_pages ) ) {
            $main_path = AB_THREE_PLUGIN_PATH . 'assets/admin/main.js';

            wp_enqueue_script( 'ab-three-admin', AB_THREE_PLUGIN_URL . 'assets/admin/main.js', array( 'jquery' ), filemtime( $main_path ), array(
                'in_footer' => true,
            ) );

            $main_css_path = AB_THREE_PLUGIN_PATH . 'assets/admin/main.css';
            wp_enqueue_style( 'ab-three-admin', AB_THREE_PLUGIN_URL . 'assets/admin/main.css', array(), filemtime( $main_css_path ) );
        }
    }

    /**
     * Load CSS and JS.
     */
    public function wp_enqueue_scripts() {
        // Check the current page is `new-page`.
        if ( is_page( 'new-page' ) ) {
            $main_css_path = AB_THREE_PLUGIN_PATH . 'assets/frontend/main.css';
            wp_enqueue_style( 'ab-three-frontend', AB_THREE_PLUGIN_URL . 'assets/frontend/main.css', array(), filemtime( $main_css_path ) );

            $main_path = AB_THREE_PLUGIN_PATH . 'assets/frontend/main.js';
            wp_enqueue_script( 'ab-three-frontend', AB_THREE_PLUGIN_URL . 'assets/frontend/main.js', array( 'jquery' ), filemtime( $main_path ), array(
                'in_footer' => true,
            ) );
        }

        // Remove CSS.
        wp_dequeue_style( 'ab-three-frontend' );

        $shortcode_path = AB_THREE_PLUGIN_PATH . 'assets/frontend/shortcode.css';
        wp_register_style( 'ab-three-shortcode', AB_THREE_PLUGIN_URL . 'assets/frontend/shortcode.css', array(), filemtime( $shortcode_path ) );
    }
}
