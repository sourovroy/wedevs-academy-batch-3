<?php

namespace AB_Three;

class Admin_Settings {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {

        add_menu_page(
            'Admin Settings',
            'Admin Settings',
            'manage_options',
            'ab_three_admin_settings',
            array( $this, 'ab_three_admin_settings' ),
            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBmaWxsPSIjZmZmIj48IS0tIUZvbnQgQXdlc29tZSBGcmVlIDYuNy4yIGJ5IEBmb250YXdlc29tZSAtIGh0dHBzOi8vZm9udGF3ZXNvbWUuY29tIExpY2Vuc2UgLSBodHRwczovL2ZvbnRhd2Vzb21lLmNvbS9saWNlbnNlL2ZyZWUgQ29weXJpZ2h0IDIwMjUgRm9udGljb25zLCBJbmMuLS0+PHBhdGggZD0iTTk2IDc3LjNjMC03LjMgNS45LTEzLjMgMTMuMy0xMy4zYzMuNSAwIDYuOSAxLjQgOS40IDMuOWwxNC45IDE0LjlDMTMwIDkxLjggMTI4IDEwMS43IDEyOCAxMTJjMCAxOS45IDcuMiAzOCAxOS4yIDUyYy01LjMgOS4yLTQgMjEuMSAzLjggMjljOS40IDkuNCAyNC42IDkuNCAzMy45IDBMMjg5IDg5YzkuNC05LjQgOS40LTI0LjYgMC0zMy45Yy03LjktNy45LTE5LjgtOS4xLTI5LTMuOEMyNDYgMzkuMiAyMjcuOSAzMiAyMDggMzJjLTEwLjMgMC0yMC4yIDItMjkuMiA1LjVMMTYzLjkgMjIuNkMxNDkuNCA4LjEgMTI5LjcgMCAxMDkuMyAwQzY2LjYgMCAzMiAzNC42IDMyIDc3LjNMMzIgMjU2Yy0xNy43IDAtMzIgMTQuMy0zMiAzMnMxNC4zIDMyIDMyIDMybDQ0OCAwYzE3LjcgMCAzMi0xNC4zIDMyLTMycy0xNC4zLTMyLTMyLTMyTDk2IDI1NiA5NiA3Ny4zek0zMiAzNTJsMCAxNmMwIDI4LjQgMTIuNCA1NCAzMiA3MS42TDY0IDQ4MGMwIDE3LjcgMTQuMyAzMiAzMiAzMnMzMi0xNC4zIDMyLTMybDAtMTYgMjU2IDAgMCAxNmMwIDE3LjcgMTQuMyAzMiAzMiAzMnMzMi0xNC4zIDMyLTMybDAtNDAuNGMxOS42LTE3LjYgMzItNDMuMSAzMi03MS42bDAtMTZMMzIgMzUyeiIvPjwvc3ZnPg==',
            3
        );

        add_submenu_page(
            'ab_three_admin_settings',
            'Sub menu',
            'Sub menu',
            'manage_options',
            'ab_three_admin_settings_sub_menu',
            array( $this, 'sub_menu' )
        );

        // remove_submenu_page( 'ab_three_admin_settings', 'ab_three_admin_settings' );
    }

    public function ab_three_admin_settings() {
        $get_page = filter_input( INPUT_GET, 'page' );
        var_dump( $get_page );

        // Check the form is submitted.
        if ( isset( $_POST['submit'] ) ) {
            // Verify nonce.
            if ( ! wp_verify_nonce( $_POST['ab_three_nonce'], 'ab_three' ) ) {
                echo 'You are not valid';
                return;
            }

            $ab_three_title = isset( $_POST['ab_three_title'] ) ? sanitize_text_field( $_POST['ab_three_title'] ) : '';
            $ab_three_email = isset( $_POST['ab_three_email'] ) ? sanitize_text_field( $_POST['ab_three_email'] ) : '';
            $ab_three_option = isset( $_POST['ab_three_option'] ) ? sanitize_text_field( $_POST['ab_three_option'] ) : '';

            $post_array = array(
                'ab_three_title' => $ab_three_title,
                'ab_three_email' => $ab_three_email,
                'ab_three_option' => $ab_three_option,
            );

            update_option( 'ab_three_settings', $post_array );
        }

        $setings_data = get_option( 'ab_three_settings', array() );

        $ab_three_option_value = isset( $setings_data['ab_three_option'] ) ? $setings_data['ab_three_option'] : '1';
        ?>
            <div class="wrap">
                <h1>Admin Settings</h1>

                <form action="<?php echo esc_url( admin_url() ); ?>admin.php?page=ab_three_admin_settings" method="post">
                    <input type="hidden" name="ab_three_nonce" value="<?php echo wp_create_nonce( 'ab_three' ); ?>">
                    <?php // echo wp_nonce_field( 'ab_three', 'ab_three_nonce' ); ?>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th>
                                    <label>Title</label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="ab_three_title" value="<?php echo isset( $setings_data['ab_three_title'] ) ? esc_attr( wp_unslash( $setings_data['ab_three_title'] ) ) : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label>Email</label>
                                </th>
                                <td>
                                    <input type="text" class="regular-text" name="ab_three_email" value="<?php echo isset( $setings_data['ab_three_email'] ) ? esc_attr( wp_unslash( $setings_data['ab_three_email'] ) ) : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label>Choose One</label>
                                </th>
                                <td>
                                    <select name="ab_three_option">
                                        <option value="1" <?php echo $ab_three_option_value == '1' ? 'selected' : ''; ?> >1</option>
                                        <option value="2" <?php echo $ab_three_option_value == '2' ? 'selected' : ''; ?>>2</option>
                                        <option value="3" <?php echo $ab_three_option_value == '3' ? 'selected' : ''; ?>>3</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                    </p>
                </form>
            </div>
        <?php
    }

    public function sub_menu() {
        ?>
            Sub menu
        <?php
    }
}
