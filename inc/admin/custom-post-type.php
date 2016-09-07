<?php
/**
 * The template for managing all custom post types
 * Displays all of the head element and everything up until the "site-content" div.
 * @package virtualemployeemployee
 * @subpackage virtualemployeemployee
 *
 */
 
/* --------------------------------------------------------- /
/ Start VE Videos /
/ --------------------------------------------------------- */
if(!function_exists('ve_video_post_type_func')){
	function ve_video_post_type_func()
	{

		$labels = array(
			'name' => __( 'Videos', 'virtualemployee' ),
			'singular_name' => __( 'Video', 'virtualemployee' ),
			'add_new' => __( 'Add New', 'virtualemployee' ),
			'add_new_item' => __( 'Add New Video', 'virtualemployee' ),
			'edit_item' => __( 'Edit Video', 'virtualemployee' ),
			'new_item' => __( 'New Video', 'virtualemployee' ),
			'view_item' => __( 'View Video', 'virtualemployee' ),
			'search_items' => __( 'Search Video', 'virtualemployee' ),
			'not_found' => __( 'No Video Found', 'virtualemployee' ),
			'not_found_in_trash' => __( 'No Videos Found In Trash', 'virtualemployee' ),
			'parent_item_colon' => '',
			'menu_name' => __( 'Videos', 'virtualemployee' )
		);
		$args = array(
			'labels' 			 => $labels,
			'menu_icon' 		 => 'dashicons-video-alt',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'video' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports' => array( 'title', 'editor', 'page-attributes' )
		);

		 register_post_type( 've_videos', $args);
	}
}

add_action('init', 've_video_post_type_func');
/* --------------------------------------------------------- /
   End VE Videos /
/  --------------------------------------------------------- */
/* --------------------------------------------------------- /
/ Start VE Gallery /
/ --------------------------------------------------------- */
if(!function_exists('ve_gallery_post_type_func')){
	function ve_gallery_post_type_func()
	{

		$labels = array(
			'name' => __( 'VE Gallery Images', 'virtualemployee' ),
			'singular_name' => __( 'Gallery', 'virtualemployee' ),
			'add_new' => __( 'Add New Image', 'virtualemployee' ),
			'add_new_item' => __( 'Add New Image', 'virtualemployee' ),
			'edit_item' => __( 'Edit Image', 'virtualemployee' ),
			'new_item' => __( 'New Image', 'virtualemployee' ),
			'view_item' => __( 'View Image', 'virtualemployee' ),
			'search_items' => __( 'Search Image', 'virtualemployee' ),
			'not_found' => __( 'No Image Found', 'virtualemployee' ),
			'not_found_in_trash' => __( 'No Image Found In Trash', 'virtualemployee' ),
			'parent_item_colon' => '',
			'menu_name' => __( 'Galleries', 'virtualemployee' )
		);
		$args = array(
			'labels' 			 => $labels,
			'menu_icon' 		 => 'dashicons-format-gallery',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'gallery' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports' => array( 'title', 'editor', 'page-attributes' )
		);

		 register_post_type( 've_gallery', $args);
	}
}

add_action('init', 've_gallery_post_type_func');
/* --------------------------------------------------------- /
   End VE Gallery /
/  --------------------------------------------------------- */
/*-------------------------------------------------
 Start FAQ
 ------------------------------------------------- */
add_action( 'init', 've_faq_post_type_func' );
if(!function_exists('ve_faq_post_type_func'))
{
	function ve_faq_post_type_func() {
		  $labels = array(
			'name' 				 => _x('FAQ', 'post type general name'),
			'singular_name' 	 => _x('FAQ', 'post type singular name'),
			'add_new' 			 => _x('Add New', 'FAQ'),
			'add_new_item' 		 => __('Add New FAQ'),
			'edit_item' 		 => __('Edit FAQ'),
			'new_item' 			 => __('New FAQ'),
			'view_item' 		 => __('View FAQ'),
			'search_items' 		 => __('Search FAQ'),
			'not_found' 		 =>  __('No FAQ found'),
			'not_found_in_trash' => __('No FAQ found in Trash'),
			'parent_item_colon'  => '',
			'menu_name' => __( 'FAQ', 'virtualemployee' )
		  );

		 $args = array(
		  'labels' 				=> $labels,
		  'menu_icon' 			=> 'dashicons-format-chat',
		  'public' 				=> true,
		  'has_archive' 		=> true,
		  'publicly_queryable' 	=> true,
		  'capability_type' 	=> 'post',
		  'map_meta_cap' 		=> true,
		  'hierarchical' 		=> true,
		  'rewrite' 			=> false,
		  'query_var' 			=> true,
		  'exclude_from_search' => true,
		  'supports' 			=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		 );  

	  register_post_type( 've_faq',$args);
	}
}
 /*-------------------------------------------------
 End FAQ
 ------------------------------------------------- */
 /* --------------------------------------------------------- /
/ Start VE Blogs /
/ --------------------------------------------------------- */
if(!function_exists('ve_blog_post_type_func')){
	function ve_blog_post_type_func()
	{

		$labels = array(
			'name' => __( 'Blog', 'virtualemployee' ),
			'singular_name' => __( 'Blog', 'virtualemployee' ),
			'add_new' => __( 'Add New', 'virtualemployee' ),
			'add_new_item' => __( 'Add New Post', 'virtualemployee' ),
			'edit_item' => __( 'Edit Post', 'virtualemployee' ),
			'new_item' => __( 'New Post', 'virtualemployee' ),
			'view_item' => __( 'View Post', 'virtualemployee' ),
			'search_items' => __( 'Search Post', 'virtualemployee' ),
			'not_found' => __( 'No Post Found', 'virtualemployee' ),
			'not_found_in_trash' => __( 'No Posts Found In Trash', 'virtualemployee' ),
			'parent_item_colon' => '',
			'menu_name' => __( 'Blog', 'virtualemployee' )
		);
		$args = array(
			'labels' 			 => $labels,
			'menu_icon' 		 => 'dashicons-admin-post',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'blog' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports' => array( 'title', 'editor','thumbnail', 'page-attributes', 'comments', 'author')
		);

		 register_post_type( 've_blog', $args);
	}
}
add_action('init', 've_blog_post_type_func');
/* --------------------------------------------------------- /
   End VE Blogs/
/  --------------------------------------------------------- */

/* ---------------------------------------------------------------------- */
/*	Team
/* ---------------------------------------------------------------------- */

// Register Custom Post Type: 'Team'
function ve_team_post_type_func() {

	$labels = array(
		'name'               => __( 'Team', 'ss_framework' ),
		'singular_name'      => __( 'Member', 'ss_framework' ),
		'add_new'            => __( 'Add New', 'ss_framework' ),
		'add_new_item'       => __( 'Add New Member', 'ss_framework' ),
		'edit_item'          => __( 'Edit Member', 'ss_framework' ),
		'new_item'           => __( 'New Member', 'ss_framework' ),
		'view_item'          => __( 'View Member', 'ss_framework' ),
		'search_items'       => __( 'Search Members', 'ss_framework' ),
		'not_found'          => __( 'No members found', 'ss_framework' ),
		'not_found_in_trash' => __( 'No members found in Trash', 'ss_framework' ),
		'parent_item_colon'  => __( 'Parent Member:', 'ss_framework' ),
		'menu_name'          => __( 'Team', 'ss_framework' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'            => array( 'title','page-attributes'),
		'rewrite'             => array( 'slug' => 'team-member' ),
		'menu_icon'           => 'dashicons-groups'
	);

   register_post_type( 've_team', $args );

} 
add_action('init', 've_team_post_type_func');
/*
// Custom colums for 'Team'
function ss_framework_edit_team_columns() {

	$columns = array(
		'cb'          => '<input type="checkbox" />',
		'thumbnail'   => __( 'Photo', 'ss_framework' ),
		'title'       => __( 'Name', 'ss_framework' ),
		'job_title'   => __( 'Job Title', 'ss_framework' ),
		'description' => __( 'Description', 'ss_framework' ),
		'shortcode'   => __( 'Shortcode', 'ss_framework' )
	);

	return $columns;

}
add_action('manage_edit-team_columns', 'ss_framework_edit_team_columns');

// Custom colums content for 'Team'
function ss_framework_manage_team_columns( $column, $post_id ) {

	global $post;

	switch ( $column ) {

		case 'thumbnail':

			echo '<a href="' . get_edit_post_link( $post_id ) . '">' . get_the_post_thumbnail( $post_id, array(50, 50), array( 'title' => get_the_title( $post_id ) ) ) . '</a>';

			break;

		case 'job_title':
			
			echo ss_framework_get_custom_field( 'ss_job_title', $post_id );

			break;

		case 'description':
			
			echo get_the_excerpt();

			break;

		case 'shortcode':
			
			echo '<span class="shortcode-field">[team_member id="'. $post->post_name . '"]</span>';

			break;
		
		default:
			break;
	}

}
add_action('manage_team_posts_custom_column', 'ss_framework_manage_team_columns', 10, 2);
*/

/* --------------------------------------------------------- /
   End VE Team/
/  --------------------------------------------------------- */

/*-------------------------------------------------
 Start Testimonials
 ------------------------------------------------- */
remove_action( 'init', 've_testimonials_post_type_func' );
if(!function_exists('ve_testimonials_post_type_func')){
	function ve_testimonials_post_type_func() {
		  $labels = array(
			'name' 				 => _x('Testimonials', 'post type general name'),
			'singular_name' 	 => _x('Testimonial', 'post type singular name'),
			'add_new' 			 => _x('Add New', 'Testimonial'),
			'add_new_item' 		 => __('Add New Testimonial'),
			'edit_item' 		 => __('Edit Testimonial'),
			'new_item' 			 => __('New Testimonial'),
			'view_item' 		 => __('View Testimonial'),
			'search_items' 		 => __('Search Testimonials'),
			'not_found' 		 =>  __('No Testimonials found'),
			'not_found_in_trash' => __('No Testimonials found in Trash'),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Testimonials', 'ss_framework' ),
		  );

		 $args = array(
		  'labels' 				=> $labels,
		  'menu_icon' 			=> 'dashicons-format-quote',
		  'public' 				=> true,
		  'has_archive' 		=> true,
		  'publicly_queryable' 	=> true,
		  'capability_type' 	=> 'post',
		  'map_meta_cap' 		=> true,
		  'hierarchical' 		=> true,
		  'rewrite' 			=> array( 'slug' => 'testimonial' ),
		  'query_var' 			=> true,
		  'exclude_from_search' => true,
		  'supports' 			=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		 );  

	  register_post_type( 'testimonial',$args);
	}
}
 /*-------------------------------------------------
 End Testimonials
 ------------------------------------------------- */
