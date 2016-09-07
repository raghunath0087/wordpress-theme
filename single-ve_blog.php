<?php get_header(); ?>

<!-- Start Content Section -->
<section>
	<div class="container">
		<div class="col-md-12  col-xs-12 col-xs-offset-0 card-shadow blog_min_ht_dv ">
		<?php ve_breadcrumbs(); ?>
		<?php while ( have_posts() ) : the_post();?>	
			<article class="entry-wrapper">
				<?php the_title( '<h1 class="blog_d_title">', '</h1>' ); ?>
				<div class="meta-wrapper">
					<div class="meta-inner">
						<div class="meta">
							<span class="date"><i class="icon2-clock-1"></i><?php echo get_the_date();?></span>
							<span class="author">
								<?php printf( __( '%s', 'virtualemployee' ), get_the_author() ); ?>
								<?php /* <a class="auth_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><i class="icon2-users"></i>
				<?php printf( __( '%s', 'virtualemployee' ), get_the_author() ); ?></a> */ ?></span>
						</div>
					</div>
				</div>
				
				<div class="entry">

						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php 
							if ( has_post_thumbnail() ) 
							{
							the_post_thumbnail();
							} 
								
							?>

							<div class="entry-content">
								<?php
									the_content();

									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'virtualemployee' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'virtualemployee' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									) );
								?>
							</div><!-- .entry-content -->

						</div><!-- #post-## -->
				</div>
				
				<?php 
				if ( '' !== get_the_author_meta( 'description' ) ) 
				{
					//get_template_part( 'template-parts/biography' );
					}
				?>

				<?php
				
				if ( comments_open() || get_comments_number() ) {
				comments_template();
				}
				
				?>
			 		
			</article>
		<?php endwhile;?>
		<?php 
			/**  pagination */
			 $prev_post = get_adjacent_post( false, '', true, 've_blog_term' ); 
			 $next_post = get_adjacent_post( false, '', false, 've_blog_term' );
			 $strlimt=45; 
			 $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
             $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

			?>
			<div class="item-next-prev">
		<?php 
		if ( is_a( $prev_post, 'WP_Post' ) ) 
		{ 
			$pre_feat_image = wp_get_attachment_url( get_post_thumbnail_id($prev_post->ID) );
			?>	
				<div class="item-prev">
					<div class="arrow"> <i class="icon2-left-open-big"></i></div>
					<div class="preview">
					<h6>Previous Article</h6>
					<div class="meta-top">
					<div class="prev-next"><img src="<?php echo $pre_feat_image;?>" alt="" /></div>
					<span class="title"><?php echo substr(get_the_title($prev_post->ID),0,$strlimt);?>...</span>
					<p><?php echo substr(strip_shortcodes(strip_tags(get_the_content($prev_post->ID))),0,$strlimt);?>...</p>
					</div>
					</div>
					<a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="hooked"></a>
				</div>
		<?php } ?>
		<?php 
		if ( is_a( $next_post, 'WP_Post' ) ) 
		{  
		$next_feat_image = wp_get_attachment_url( get_post_thumbnail_id($next_post->ID) );
			?>	
				<div class="item-next">
					<div class="arrow"> <i class="icon2-right-open-big"></i></div>
					<div class="preview">
					<h6>Next Article</h6>
					<div class="meta-top">
					<div class="prev-next"><img src="<?php echo $next_feat_image;?>" alt="" /></div>
					<span class="title"><?php echo substr(get_the_title($next_post->ID),0,$strlimt);?>...</span>
					<p><?php echo substr(strip_shortcodes(strip_tags(get_the_content($next_post->ID))),0,$strlimt);?>...</p>
					</div>
					</div>
					<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="hooked"></a>
				</div>
		<?php } ?>
				<div class="clearfix"></div>
			</div>
			
		</div>
	</div>
</section>

 <!-- END Content Section -->
<?php get_footer(); ?>
