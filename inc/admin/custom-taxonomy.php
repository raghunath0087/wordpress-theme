<?php
/**
 * The template for managing all custom taxonomy types
 * Displays all of the head element and everything up until the "site-content" div.
 * @package virtualemployeemployee
 * @subpackage virtualemployeemployee
 *
 */
 /*-------------------------------------------------
 FAQ Taxonomy
------------------------------------------------- */
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_ve_faq_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
if(!function_exists('create_ve_faq_taxonomies')):
function create_ve_faq_taxonomies() {
	$labels = array(
		'name' 				=> __('FAQ Categories', 'virtualemployee'),
		'singular_name' 	=> __('Category', 'virtualemployee'),
		'search_items'  	=>  __('Search Categories', 'virtualemployee'),
		'all_items' 		=> __('All Categories', 'virtualemployee'),
		'parent_item' 		=> __('Parent', 'virtualemployee'),
		'parent_item_colon' => __('Parent:', 'virtualemployee'),
		'edit_item' 		=> __('Edit Category', 'virtualemployee'),
		'update_item' 		=> __('Update Category', 'virtualemployee'),
		'add_new_item' 		=> __('Add New Category', 'virtualemployee'),
		'new_item_name' 	=> __('New Category', 'virtualemployee'),
		'menu_name' 		=> __('Categories', 'virtualemployee'),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
        'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 've_faqs','with_front' => false ),
	);
register_taxonomy( 've_faq_term', array( 've_faq' ), $args );  
}
endif;

/*-------------------------------------------------
 End FAQ Taxonomy
------------------------------------------------- */
/*-------------------------------------------------
 Start Blog Taxonomy
------------------------------------------------- */
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_ve_blogs_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
if(!function_exists('create_ve_blogs_taxonomies'))
{
	function create_ve_blogs_taxonomies() {
		$labels = array(
			'name' 				=> __('Blog Categories', 'virtualemployee'),
			'singular_name' 	=> __('Category', 'virtualemployee'),
			'search_items'  	=>  __('Search Categories', 'virtualemployee'),
			'all_items' 		=> __('All Categories', 'virtualemployee'),
			'parent_item' 		=> __('Parent', 'virtualemployee'),
			'parent_item_colon' => __('Parent:', 'virtualemployee'),
			'edit_item' 		=> __('Edit Category', 'virtualemployee'),
			'update_item' 		=> __('Update Category', 'virtualemployee'),
			'add_new_item' 		=> __('Add New Category', 'virtualemployee'),
			'new_item_name' 	=> __('New Category', 'virtualemployee'),
			'menu_name' 		=> __('Categories', 'virtualemployee'),
		);
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 've-blog-term','with_front' => false ),
		);
	register_taxonomy( 've_blog_term', array( 've_blog' ), $args );  
	}
}
/*-------------------------------------------------
 End Blog Taxonomy
------------------------------------------------- */
/*-------------------------------------------------
 Start Video Taxonomy
------------------------------------------------- */
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_ve_videos_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_ve_videos_taxonomies() {
	$labels = array(
		'name' 				=> __('Videos Categories', 'virtualemployee'),
		'singular_name' 	=> __('Category', 'virtualemployee'),
		'search_items'  	=>  __('Search Categories', 'virtualemployee'),
		'all_items' 		=> __('All Categories', 'virtualemployee'),
		'parent_item' 		=> __('Parent', 'virtualemployee'),
		'parent_item_colon' => __('Parent:', 'virtualemployee'),
		'edit_item' 		=> __('Edit Category', 'virtualemployee'),
		'update_item' 		=> __('Update Category', 'virtualemployee'),
		'add_new_item' 		=> __('Add New Category', 'virtualemployee'),
		'new_item_name' 	=> __('New Category', 'virtualemployee'),
		'menu_name' 		=> __('Categories', 'virtualemployee'),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'videos','with_front' => false ),
	);
register_taxonomy( 've_videos_term', array( 've_videos' ), $args );  
}
/*-------------------------------------------------
 End Video Taxonomy
------------------------------------------------- */
/*-------------------------------------------------
 Start Gallery Taxonomy
------------------------------------------------- */
// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_ve_gallery_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_ve_gallery_taxonomies() {
	$labels = array(
		'name' 				=> __('Gallery Categories', 'virtualemployee'),
		'singular_name' 	=> __('Category', 'virtualemployee'),
		'search_items'  	=>  __('Search Categories', 'virtualemployee'),
		'all_items' 		=> __('All Categories', 'virtualemployee'),
		'parent_item' 		=> __('Parent', 'virtualemployee'),
		'parent_item_colon' => __('Parent:', 'virtualemployee'),
		'edit_item' 		=> __('Edit Category', 'virtualemployee'),
		'update_item' 		=> __('Update Category', 'virtualemployee'),
		'add_new_item' 		=> __('Add New Category', 'virtualemployee'),
		'new_item_name' 	=> __('New Category', 'virtualemployee'),
		'menu_name' 		=> __('Categories', 'virtualemployee'),
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'galleries','with_front' => false ),
	);
register_taxonomy( 've_gallery_term', array( 've_gallery' ), $args );  
}

/*-------------------------------------------------
 End Gallery Taxonomy
------------------------------------------------- */
