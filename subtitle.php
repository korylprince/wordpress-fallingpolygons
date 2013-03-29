<?php
/* Add subtitle meta-box */

function fallingpolygons_add_subtitle_meta_box() {
    $screens = array( 'post', 'page' );
    foreach ($screens as $screen) {
        add_meta_box(
            'fallingpolygons-subtitle',
            'Subtitle',
            'fallingpolygons_create_subtitle_meta_box',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'fallingpolygons_add_subtitle_meta_box' );

function fallingpolygons_create_subtitle_meta_box($post) {


    wp_nonce_field( plugin_basename( __FILE__ ), 'fallingpolygons_subtitle_nonce' );
    $id = $post->ID;
    $subtitle = get_post_meta($id, '_fallingmeta_subtitle',true);
    echo '<label for="_fallingmeta_subtitle">Subtitle:</label><br /><input type="text" id="_fallingmeta_subtitle" name="_fallingmeta_subtitle" value="'.esc_attr($subtitle).'" style="width:100%;" /><br />';
}

function fallingpolygons_subtitle_save( $post_id ) {
    // First we need to check if the current user is authorised to do this action.
    if ( 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return;
    } else {
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;
    }

    // Secondly we need to check if the user intended to change this value.
    if ( ! isset( $_POST['fallingpolygons_subtitle_nonce'] ) || ! wp_verify_nonce( $_POST['fallingpolygons_subtitle_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    //Thirdly check if trying to autosave
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    // Finally we can save the value to the database

    $post_ID = $_POST['post_ID'];
    //sanitize user input
    $subtitle = sanitize_text_field( $_POST['_fallingmeta_subtitle'] );
        add_post_meta($post_ID, '_fallingmeta_subtitle', $subtitle, true) or
            update_post_meta($post_ID, '_fallingmeta_subtitle', $subtitle);
}
add_action( 'save_post', 'fallingpolygons_subtitle_save' );

?>
