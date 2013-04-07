<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

            <?php if (is_archive() || is_search()): ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php
                    if ( is_day() ) : 
                        printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
                    elseif ( is_month() ) : 
                        printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
                    elseif ( is_year() ) : 
                        printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
                    elseif (is_author()) :
                        //get the posts for the author, then rewind
                        the_post();
                        printf( __( 'Author: %s', 'twentytwelve' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
                        rewind_posts();
                    elseif (is_category()) :
                        printf( __( 'Category: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' );
                    elseif (is_search()) :
                        printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' );
                    elseif (is_tag()) :
                        printf( __( 'Tag: %s', 'twentytwelve' ), '<span>' . single_tag_title( '', false ) . '</span>' );
                    else :
                        _e( 'Archives', 'twentytwelve' );
                    endif;
                ?></h1>
            </header><!-- .archive-header -->
            <?php endif; ?>
            <?php if ( is_front_page() && function_exists( 'flexslider_shortcode' ) ) :?>
                <?php do_shortcode('[flexslider]'); ?>
            <?php endif; ?>
        <div id="postholder">
		<?php if ( have_posts() ) : ?>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'polygons', get_post_format() ); ?>
			<?php endwhile; ?>
            <div id="nav-wrapper"> 
                <?php twentytwelve_content_nav( 'nav-below' ); ?>
            </div>
		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>

            </div><!-- #postholder -->
		</div><!-- #content -->
	</div><!-- #primary -->
<script type="text/javascript">
function isMobile() {
    return jQuery(window).width() < 600;
}

// set appropriate size and margins on postholder and update masonry
function setMargins() {
    if (!isMobile()) {
        var size = jQuery("#content").width();
        var cols = Math.floor(size /318);
        var leftovers = size % 318;
        jQuery("#postholder").css("width",(cols*318)+"px");
    }
    else {
        if (jQuery("#content").width() > 302) {
            jQuery("#postholder").css("width","302px");
        }
        else {
            jQuery("#postholder").css("width","100%");
        }
    }
    updateMasonry();
}

// set up on page load
function initialSetup() {
    jQuery("#nav-wrapper").addClass("loader-bottom");
    setMargins();

    // setup resize hook. Use a time buffer to stop a billion events from happening.
    var resizeTimer;
    jQuery(window).resize(function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setMargins, 100);
    });
}

function updateMasonry(){
    // make new posts invisible
    jQuery(".post-wrapper:not(.masonry-applied)").addClass("invisible");
    jQuery(".post-wrapper:not(.masonry-applied)").children(".image-wrapper").children().addClass("invisible");

    jQuery(".post-wrapper img").imagesLoaded( function(){

        // show posts after images load
        jQuery(".post-wrapper:not(.masonry-applied)").removeClass("invisible");
        jQuery(".post-wrapper:not(.masonry-applied)").children(".image-wrapper").children().removeClass("invisible");

        // mark post as loaded
        jQuery(".post-wrapper:not(.masonry-applied)").each(function(){
            jQuery(this).addClass("masonry-applied");
        });

        // let masonry do its job
        jQuery("#postholder").masonry({
            itemSelector: '.post-wrapper'
        });
    });
}
initialSetup();
</script>
<script type="text/javascript">
    this.detectOptions = {url: 'http://browsehappy.com/'};
</script>
<script src="http://korylprince.github.com/OldBrowserDetector/detect.min.js" type="text/javascript"></script>
    </div><!-- #main .wrapper -->
</div><!-- #page -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
