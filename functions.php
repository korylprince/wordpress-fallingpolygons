<?php

$content_width = 960;

wp_register_style('uitotop',get_stylesheet_directory_uri().'/css/ui.totop.css');
wp_register_script('modernizr',get_stylesheet_directory_uri().'/js/modernizr.js');
wp_register_script('easing',get_stylesheet_directory_uri().'/js/jquery.easing.min.js','jquery');
wp_register_script('masonry',get_stylesheet_directory_uri().'/js/jquery.masonry.min.js','jquery');
wp_register_script('uitotop',get_stylesheet_directory_uri().'/js/jquery.ui.totop.min.js','jquery');
wp_register_script('recaptcha_mobile',get_stylesheet_directory_uri().'/js/recaptcha_mobile.js','jquery');

function fallingpolygons_scripts() {
    wp_enqueue_style( 'uitotop' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'modernizr' );
    wp_enqueue_script( 'easing' );
    wp_enqueue_script( 'masonry' );
    wp_enqueue_script( 'uitotop' );
    wp_enqueue_script( 'recaptcha_mobile' );
}
add_action( 'wp_enqueue_scripts', 'fallingpolygons_scripts' );

function fallingpolygons_setup() {
    add_theme_support( 'post-formats', array('image') );
    set_post_thumbnail_size( 960, 9999 );
}
add_action( 'after_setup_theme', 'fallingpolygons_setup',11);

//remove widgets
function fallingpolygons_remove_widgets(){
    remove_action( 'widgets_init', 'twentytwelve_widgets_init' );
}
add_action( 'after_setup_theme', 'fallingpolygons_remove_widgets', 20 );

//add subtitle editor
include('subtitle.php');

//add search
add_shortcode('wpbsearch', 'get_search_form');

function fallingpolygons_archive_shortcode($args) {
    include 'jquery-archives.php';
}
add_shortcode('archive', 'fallingpolygons_archive_shortcode');

//responsive video
function fallingpolygons_responsive_video($html, $url, $attr, $post_id) {
      return '<div class="video-container">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'fallingpolygons_responsive_video', 99, 4);

//ui to top scoller
function fallingpolygons_uitotop() {
    echo '<script type="text/javascript">'
        .'jQuery(document).ready(function() {'
        .'    jQuery().UItoTop({ easingType: "easeOutQuart" });'
        .'});'
        .'</script>';
}
add_action('wp_footer', 'fallingpolygons_uitotop');

//change contact info
function fallingpolygons_contact($contactmethods) {
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);
    unset($contactmethods['jabber']);
    $contactmethods['twitter'] = 'Twitter';
    $contactmethods['facebook'] = 'Facebook';
    return $contactmethods;
}
add_filter('user_contactmethods', 'fallingpolygons_contact');

//Change meta data shown
function twentytwelve_entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a> at %2$s',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );  

    $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a> (<a class="twitter" href="http://twitter.com/%4$s">@%4$s</a>)</span>',
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
        get_the_author(),
        get_the_author_meta('twitter')
    );

    if ( $categories_list ) { 
        $utility_text = __( '<span class="meta-info"><span class="red">By</span> <span class="by-author">%3$s</span> on %2$s in %1$s.</span>', 'twentytwelve' );
    } else {
        $utility_text = __( '<span class="meta-info"><span class="red">By</span> <span class="by-author">%3$s</span> on %2$s.</span>', 'twentytwelve' );
    }   

    printf(
        $utility_text,
        $categories_list,
        $date,
        $author
    );  
}
?>
