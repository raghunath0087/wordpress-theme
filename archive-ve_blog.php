<?php get_header(); ?>
<!-- Ban STARTS -->
<!-- Banner STARTS -->
<div class="new_blog_banner">
	<div class="com_taglineholder">
		<div class="col-xs-12 text-center ">
			<h1 class="com_taglineholder_title cap_txt">Virtualemployee</h1>
			<h4 class="com_taglineholder_sub cap_txt ">.Your cloud company.</h1>
			<p class="com_taglineholder_desc">Welcome to our Blog—a place for marketers to keep up with the latest trends & everything.</p>
		</div>
	</div>
  <div class="banneimageholder"><img src="<?php echo get_template_directory_uri(); ?>/images/new_blogs.jpg"  alt="" width="1336" height="470"/></div>
</div>
<!-- Banner ENDS -->

<!-- start video section -->

<section>
	<div class="device_blog_wd col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
		<h1 class="mrg_45_tp">LATEST CONTENT </h1>
		<p class="mrg_45_bt">Enjoy our latest blog posts, webinars, podcasts, eBooks, and more. Your content deserves a remarkable experience — request a demo to learn more!</p>
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
				<!-- Start 1st sec-->
					<div class="all_blogs_section">
						<ul class="clearfix">
						<?php 
						
							//post_type_archive_title();
						         $postPerPage = 5;
							     $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
							     
								$args = array(
										'post_type'  	 => 've_blog',
										'posts_per_page' =>  $postPerPage,
										'orderby'      	 => 'menu_order',
										'order'      	 => 'ASC',
									);							     
							     

								if($term) 
								{
									$args['tax_query'] = array(
															array(
																'taxonomy' => 've_blog_term',
																'field'    => 'slug',
																'terms'    => $term->slug,
															),
														);
								}	
								 
							

							wp_reset_query();
							$popularquery = new WP_Query( $args );
							$queryvcount = $popularquery->post_count;
							//echo '<pre>';print_r($popularquery);
							 $jk=1;
						if ($popularquery->have_posts() ) : 
							while ( $popularquery->have_posts() ) : $popularquery->the_post();?>
							<?php 
							$postLink=get_the_permalink();
							$isFeatured=get_post_meta($post->ID, 've_blog_featured', true );
							if($jk==1){
								
								?>
							<li class="tiles hot_topic  card-shadow">
								<?php if ($isFeatured!='') :?>
								<span class="icon star"> <i class="icon2-star"></i></span> 
								<?php endif;?>
								<div class="img">
								<?php 
								if ( has_post_thumbnail() ) 
								{
								the_post_thumbnail();
								} 
								?>
							</div> 
								<div class="description">
									<div class="timestamp_sec"><?php the_date();?></div>
									<h3><?php the_title();?></h3>
								</div>
								<div class="social_link_section">
									<div class="col-md-7 blog_lt_sec">
									   <?php echo do_shortcode('[ve_social]');?>
									</div>
									<div class="col-md-5 text-right blog_rt_sec">
									<a href="<?php the_permalink();?>">Read Blog <i class="icon2-right-open "></i> </a>
									</div>
								</div>
							</li>
							
							<li class="tiles email_box_bg  card-shadow">
									 <?php /*
									  <form id="ve_blog_form" name="blogform" method="post" action="">
										<a class="blg_close_btn"> <i class=""></i></a>
										<div class="emailtp">
											<div class="form-group">
												<label class="fnt_16 wht_col">Work Email</label>
												<input type="text" placeholder="Enter email" id="email" name="email" class="form-control">
												<div id="email-msg" class="msgstatus"></div>
											</div>
											<div class="form-group">
												<label class="fnt_16 wht_col">First Name </label>
												<input type="text" placeholder="Enter first name" id="fname" name="fname" class="form-control">
												<div id="fname-msg" class="msgstatus"></div>
											</div>
											<div class="form-group">
												<label class="fnt_16 wht_col">Last Name  </label>
												<input type="text" placeholder="Enter last name" id="lname" name="lname" class="form-control">
												<div id="lname-msg" class="msgstatus"></div>
											</div>
											<div class="checkbox">
												<label><input type="checkbox" name="blog_newsletter" id="blog_newsletter" value="">Allow virtualemployee to email me</label>
											</div>
											<input class="btn btn-default subsc_btn" type="submit" name="blog_submit" id="blog_submit" value="SUBSCRIBE" />
											<input type="hidden" name="form_type" id="form_type" value="Blog_Newsletter">
											<div id="blogformresposnse"></div>
										</div>
									  </form> 
									  <?php  */ 
									  echo do_shortcode('[contact-form-7 id="28467" title="Blog Form"]');?>
								
							</li>
							<?php $jk++;}else{?>
							<li class="tiles  card-shadow">
								<?php if ($isFeatured!='') :?>
								<span class="icon star"> <i class="icon2-star"></i></span> 
								<?php endif;?>
								<div class="img">
									<?php 
									if ( has_post_thumbnail() ) 
									{
									the_post_thumbnail();
									} 
									?>
									</div> 
								<div class="description">
									<div class="timestamp_sec"><?php the_date();?></div>
									<h3><?php the_title();?></h3>
								</div>
								<div class="social_link_section">
									<div class="col-md-7 blog_lt_sec">
									 <?php echo do_shortcode('[ve_social]');?>
									</div>
									<div class="col-md-5 text-right blog_rt_sec">
									<a href="<?php the_permalink();?>">Read Blog <i class="icon2-right-open "></i> </a>
									</div>
								</div>
							</li>
						<?php 
								}
							endwhile;
						endif;
						?>
						</ul>
						<div class="animation_image" style="display:none;" align="center"><p><img src="<?php echo get_template_directory_uri().'/images/ajax-loader.gif';?>"></p></div>
					</div>  
				<!-- End 1st sec-->
			</div>
			<?php get_sidebar();?>
			<div class="clearfix"></div>
		</div>
	</div>
</section>

<!-- End video section -->

 <!-- END Content Section -->

<?php get_footer(); ?>
<script>
/**  load blog post on window scroll **/
<?php if( $queryvcount >= 5 ){?>
$(document).ready(function() {
    var track_load = 0; //total loaded record group(s)
    var loading  = false; //to prevents multipal ajax loads
    var init_counter = <?php echo $postPerPage;?> //total record group(s)
   // $('#results').load("autoload_process.php", {'page':track_load}, function() {track_load++;}); //load first group
    $(window).scroll(function() { //detect page scroll
       
        if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
        {
			
            $('.animation_image').show(); //hide loading image
            
            if(track_load <= init_counter && loading==false) //there's more data to load
             {
                loading = true; //prevent further ajax loading
                //$('.animation_image').show(); //show loading image
                
				 jQuery.post(
							'<?php echo admin_url('admin-ajax.php');?>', 
							{
							'action': 'get_ve_blog_posts',
							'post_type': 've_blog',
							'start':init_counter
							}, 
							function(response,status){
                              loading = false;
							  $(".all_blogs_section .clearfix").append(response).show(500); 
							  $('.animation_image').hide(); //hide loading image
							 //console.log('The server responded: ' + init_counter);
							 console.log('The server responded: ' + response);
							 init_counter= (init_counter + 5);
							}
				).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                    
                    console.log(thrownError); //alert with HTTP error
                    $('.animation_image').hide(); //hide loading image
                    loading = false;
                
                });
            }
        }
    });
});
<?php } ?>
jQuery(document).ready(function(){
	jQuery('.email_fild_section .blg_close_btn').hide();
	jQuery('#email').on("mousedown",function(e){
		if(!jQuery(".email_fild_section").hasClass('show_dv')) {
			e.preventDefault();
			jQuery('.email_fild_section .blg_close_btn').show();
			jQuery(".email_fild_section").addClass('show_dv',5000);		
		} 
		//blg_close_btn
	});
	jQuery('.email_fild_section .blg_close_btn').on("click",function(e){
		
		jQuery('.email_fild_section .blg_close_btn').hide();
		jQuery(".email_fild_section").removeClass('show_dv',5000);		
		 
		//blg_close_btn
	});	
});								
</script>
