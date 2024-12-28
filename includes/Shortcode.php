<?php

namespace AB_Three;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shortcode {

    public function __construct() {
        add_shortcode( 'enqueue_learning', array( $this, 'enqueue_learning' ) );
    }

    public function enqueue_learning() {
        wp_enqueue_style( 'ab-three-shortcode' );

        ob_start();
        ?>
        <h3 class="ab-three-heading">Hello world</h3>
        <p>
            <img src="<?php echo AB_THREE_PLUGIN_URL; ?>assets/frontend/images/jonatan-pie-Lyxlh8vuRmY-unsplash.jpg" alt="">
        </p>
        <?php
        return ob_get_clean();
    }

}
