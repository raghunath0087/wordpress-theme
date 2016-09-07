<?php
add_action( 'wp_ajax_nopriv_get_ve_blog_posts', 'get_ve_blog_posts' );
add_action( 'wp_ajax_get_ve_blog_posts', 'get_ve_blog_posts' );
if(!function_exists('get_ve_blog_posts')){
	function get_ve_blog_posts() {
		 if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
		 { 
			 
			            $postContent=''; 
					    $args = array(
										'post_type' => $_POST['post_type'],
										'showposts' => 5,
										'offset'    => $_POST['start'],
										'orderby'   => 'menu_order',
										'order'     => 'ASC',
									);

							wp_reset_query();
							$popularquery = new WP_Query( $args );
							//echo $popularquery->request;
							//echo $popularquery->request;
						 if ($popularquery->have_posts() ) : 
							while ( $popularquery->have_posts() ) : $popularquery->the_post();
							$postLink=get_the_permalink();
							$isFeatured=get_post_meta($post->ID, 've_blog_featured', true );
								 $postContent.='<li class="tiles  card-shadow">';
								 if ($isFeatured!='') :
								$postContent.='<span class="icon star"> <i class="icon2-star"></i></span>';
								endif;
								if ( has_post_thumbnail() ) 
									{
										$postContent.='<div class="img">'.get_the_post_thumbnail($post->ID,'full').'</div>';
									
									} 
									
								$postContent.='<div class="description">
									   <div class="timestamp_sec">'.get_the_date().'</div>
									<h3>'.get_the_title().'</h3>
								</div>
								<div class="social_link_section">
									<div class="col-md-7 blog_lt_sec">'.do_shortcode('[ve_social]').'</div>
									<div class="col-md-5 text-right blog_rt_sec">
									<a href="'.get_the_permalink().'">Read Blog <i class="icon2-right-open "></i> </a>
									</div>
								</div>
							</li>';
						  endwhile;
						else:
						$postContent='none';
						endif;
						echo $postContent;
						die();
		
		 }
		 
	 }
 }
