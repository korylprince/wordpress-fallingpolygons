<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', '' ); ?>

    <nav class="nav-single">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
    <span class="nav-previous"><?php previous_post_link('%link','<span class="nav-label">Previous</span><img src="'.get_stylesheet_directory_uri().'/img/arrow_left.png"><br><span class="nav-title">%title</span>');?></span>
    <span class="nav-next"><?php next_post_link('%link','<span class="nav-label">Next</span><img src="'.get_stylesheet_directory_uri().'/img/arrow_right.png"><br><span class="nav-title">%title</span>');?></span>
    </nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
