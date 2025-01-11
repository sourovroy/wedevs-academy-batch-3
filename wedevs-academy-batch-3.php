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

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class Academy_Batch_Three {

    private static $instance;

    private function __construct() {
        // add_filter( 'the_content', array( $this, 'the_content_callback' ) );

        // add_action( 'wp_footer', array( $this, 'wp_footer' ) );

        // add_filter( 'body_class', array( $this, 'body_class' ), 10, 2 );

        $this->define_constants();

        $this->load_classes();

        register_activation_hook( __FILE__, array( $this, 'register_activation_hook' ) );
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

    private function define_constants() {
        define( 'AB_THREE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        define( 'AB_THREE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    private function load_classes() {
        require_once AB_THREE_PLUGIN_PATH . 'includes/Admin_Menu.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Custom_Column.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Post_Type.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Book_Reader.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Enqueue.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Shortcode.php';
        require_once AB_THREE_PLUGIN_PATH . 'includes/Admin_Settings.php';

        // new AB_Three_Admin_Menu();
        // new AB_Three\Custom_Column();
        // new AB_Three\Post_Type();

        // new AB_Three\Enqueue();
        // new AB_Three\Shortcode();

        new AB_Three\Admin_Settings();
    }

    public function register_activation_hook() {
        $count_posts = get_posts( array(
            'post_type' => 'book',
            'fields' => 'ids'
        ) );

        if ( count( $count_posts ) > 0 ) {
            return;
        }

        // Create post.
        wp_insert_post( array(
            'post_type' => 'book',
            'post_title' => 'Auto Post',
            'post_content' => 'Auto Post content',
            'post_status' => 'publish',
        ) );
    }
}

Academy_Batch_Three::get_instance();
