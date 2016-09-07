<?php
/**
 * Template Name: FULL WIDTH PAGE
 *
 * @package VirtualEmployee
 */

get_header(); ?>
<!-- Start Content Section -->

<?php 
	$banner = get_post_meta($post->ID,'ve_comman_banner',true); 
	$banner_class = get_post_meta($post->ID,'ve_comman_banner_class',true); 
	$container_class = get_post_meta($post->ID,'ve_comman_container_class',true); 
	if('' != $banner):
?>
<!-- Banner STARTS -->
<div class="top_sec_ban <?php echo $banner_class; ?>" style="background-image:url(<?php echo $banner; ?>)">
   <?php echo get_post_meta($post->ID,'ve_comman_banner_dec',true); ?>	
   <div class="show_ie8_ban"><img src="<?php echo $banner; ?>"  alt="" width="1336" height="491"/></div>
   <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<!-- Banner ENDS -->
<?php endif; ?>

<!-- start content section -->
<section class="<?php echo '' != $banner ? 'cleartop_mrg_banr ' : 'cleartop_mrg '; ?> <?php echo $container_class; ?>">
	<div class="">
		<?php ve_breadcrumbs(); ?>
		<div class="com_min_ht_dv ">
			
		<?php if (have_posts()) while ( have_posts() ): the_post(); ?>

			<?php the_content(); ?>
			
			<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'ss_framework' ), 'after' => '' ) ); ?>
			
			<p><?php edit_post_link( __( 'Edit', 'ss_framework' ), '', '' ); ?></p>

		<?php endwhile; ?>			
			
		</div>
	</div>
</section>
<!-- End content section -->
<?php get_footer(); ?>
