<?php 
/*
* Template Name: 2016 Videos Page
* Description: This template is created only for implement new home page 
*/ 
?>
<?php get_header(''); ?>
<!-- Start Content Section -->
<!-- Ban STARTS -->
<?php 
	$banner = get_post_meta($post->ID,'ve_comman_banner',true); 
	$banner_class = get_post_meta($post->ID,'ve_comman_banner_class',true); 
	$container_class = get_post_meta($post->ID,'ve_comman_container_class',true); 	
	if('' != $banner):
?>
	<!-- Banner STARTS -->
	<div class="vido_banner  <?php echo $banner_class; ?>" style="background-image:url(<?php echo $banner; ?>)">
		<div class="vido_taglineholder">
			<div class="col-xs-12 text-center">
				<?php echo get_post_meta($post->ID,'ve_comman_banner_dec',true); ?>	
			</div>
		</div>
	  <div class="banneimageholder"><img src="<?php echo $banner; ?>"  alt="" width="1336" height="341"/></div>
	</div>
	<!-- Banner ENDS -->
<?php endif; ?>
<?php if (have_posts()) while ( have_posts() ): the_post(); ?>

			<?php the_content(); ?>
			
			<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'ss_framework' ), 'after' => '' ) ); ?>
			
			<p><?php edit_post_link( __( 'Edit', 'ss_framework' ), '', '' ); ?></p>

		<?php endwhile; ?>	
<?php get_footer(''); ?>
