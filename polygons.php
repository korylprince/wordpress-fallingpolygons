<?php
$cats = implode(', ',array_map(function($x) {
        $x = $x->name;
        if (substr($x,-1) == 's') { $x = substr($x,0,-1);} 
        return strtolower($x);
    },get_the_category()));
?>
<div id="post-<?php the_ID(); ?>" class="post-wrapper">
<div class="image-wrapper">
<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) )); ?>" rel="bookmark" class="post-link">
<img class="post-image" src="<?php echo wp_get_attachment_url(get_post_thumbnail_id( $post->ID ), 'medium' ); ?>">
<span class="post-title"><?php the_title(); ?><br /><span class="post-type">a <?php echo $cats;?></span></span>
</a>
</div>
</div>
