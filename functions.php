<?php
/**
 * Virtual Employee functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 */
/**
 * Set the content width based on the theme's design and stylesheet.*/
if (!isset($content_width)) {
    $content_width = 660;
}

if (!function_exists('virtualemployee_setup')): /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since virtualemployee 1.0
 */ 
    function virtualemployee_setup()
    {
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag','page-attributes');
        add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link' ) );
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(825, 510, true);
        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'virtualemployee'),
            'social' => __('Social Menu', 'virtualemployee')
        ));
    }
endif; // virtualemployee_setup
add_action('after_setup_theme', 'virtualemployee_setup');
/**
 * Custom meta box for this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/config.php';
/**
 * Custom template tags for this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/template-tags.php';
/**
 * Custom post type this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/custom-post-type.php';
/**
 * Custom Taxonomy type this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/custom-taxonomy.php';
/**
 * Custom meta box for this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/custom-meta.php';
/**
 * User meta box for this theme.
 *
 * @since Virtual Employee 1.0
 */
require get_template_directory() . '/inc/admin/user-meta.php';
/**
 * Register widget area.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/admin/sidebar-widgets.php';
/**
 * Register inline script area.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/class-scripts.php';
/**
 * Register shortcode script area.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/shortcodes.php';
/**
 * Register shortcode script as per old theme.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/oldsite-shortcodes.php';
/**
 * Register breadcrumb script as per.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/breadcrumb.php';
/**
 * Social Share script.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/class-social-share.php';
/**
 * JSON format data.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/class-json.php';
/**
 * AJAX data.
 *
 * @since Virtual Employee 1.0
 *
 */
require get_template_directory() . '/inc/classes/class-ajax.php';
/**
 * Enqueue scripts and styles.
 *
 * @since Virtual Employee 1.0
 */
if (!function_exists('virtualemployee_common_scripts')):
    function virtualemployee_common_scripts()
    {
        // Load our main stylesheet.
        wp_enqueue_style('virtualemployee-style', get_stylesheet_uri());
        // Load main jQuery file
        wp_enqueue_script('jquery');
	    // Load Bootstrap files.
	    
        wp_enqueue_style('virtualemployee-bootstrap-min-css', get_template_directory_uri().'/css/bootstrap.min.css');
        wp_enqueue_style('virtualemployee-magnific-popup-css', get_template_directory_uri().'/css/magnific-popup.css'); 
        wp_enqueue_style('virtualemployee-style-css', get_template_directory_uri().'/css/style.css'); 
        wp_enqueue_style('virtualemployee-flag-css', get_template_directory_uri().'/css/flags.css'); 
        wp_enqueue_style('virtualemployee-animate-css', get_template_directory_uri().'/css/animate.css'); 
		wp_enqueue_script('virtualemployee-bootstrap-js', get_template_directory_uri().'/js/bootstrap.min.js');
		
    }
endif;
add_action('wp_enqueue_scripts', 'virtualemployee_common_scripts');
/**
 * Enqueue scripts and styles.
 *
 * @since Virtual Employee 1.0
 */
if (!function_exists('virtualemployee_extra_scripts')):
    function virtualemployee_extra_scripts()
    {
		wp_enqueue_script('virtualemployee-wow-js', get_template_directory_uri().'/js/wow.min.js');
		wp_enqueue_script('virtualemployee-magnific-popup-js', get_template_directory_uri().'/js/jquery.magnific-popup.min.js');
		wp_enqueue_script('virtualemployee-custom-js', get_template_directory_uri().'/js/custom.js');
    }
endif;
add_action('wp_footer', 'virtualemployee_extra_scripts');
 
 /*
  *  Assing specific templates to blog cateogry
  * 
  * */
if(!function_exists('virtual_blog_list_template'))
{
	function virtual_blog_list_template( $archive_template ) 
	{
	global $post;

     if ($post->post_type=='ve_blog') {
          $archive_template = $template = locate_template( 'archive-ve_blog.php' );
     }
     return $archive_template;
	}
}
add_filter( 'archive_template', 'virtual_blog_list_template' );
/*
  *  Assing specific templates to blog cateogry
  * 
  * */
 /* 
if(!function_exists('virtual_blog_category_template'))
{
	function virtual_blog_category_template( $template ) 
	{
		$term =	$wp_query->queried_object;
//echo '<h1>'.$term->name.'</h1>'; exit;
		
	  	$idObj = get_category_by_slug('blog'); // Get blog cat id using slug
		$parentCatid = $idObj->term_id;
		$CATARY=return_child_cat_list($parentCatid,true); // set false if you want exclude parent cat

		if ( in_array(get_queried_object_id(), $CATARY ) )
		{
			$template = locate_template( 'blog-list.php' );
			}
				//echo $template;
		return $template;
	}
}
remove_filter( 'category_template', 'virtual_blog_category_template' );*/
/** End specific templates to blog cateogry */
/** End specific templates to blog cateogry */
 /*
  *  Assing specific templates to blog cateogry posts
  * 
  * */
/*if(!function_exists('create_custom_post_template'))
{
	function create_custom_post_template($single_template) {
	global $post;
	// start update post count view
	
	if ( ! add_post_meta( $post->ID, 've_post_count_views', '1', true ) ) 
	{ 
	 $currentview = get_post_meta($post->ID, 've_post_count_views', '1', true);
	  update_post_meta( $post->ID, 've_post_count_views',  $currentview + 1 );
	}
	// end post count view
	$idObj = get_category_by_slug('blog'); // Get blog cat id using slug 
	
	$parentCatid = $idObj->term_id;
	
	$CATARY=return_child_cat_list($parentCatid,true); // set false if you want exclude parent cat
	$categories = get_the_category(); // get post cat
	
	foreach($categories as $category) {
	$cat_id = $category->cat_ID;
	$cat_name = $category->cat_name;
	}

	if (in_array($cat_id,$CATARY))
	{		
		//echo "blog post template page";	
		$single_template = TEMPLATEPATH."/blog-details.php";

	}else{
		//echo "default post template page";	
		}
	

	
		 return $single_template;
	}
}
remove_filter( 'single_template', 'create_custom_post_template' );
* */

if(!function_exists('ve_count_post_view_func'))
{
	function ve_count_post_view_func()
	{
	    global $post;
	    if(is_singular())
	    {
			// start update post count view
			if ( ! add_post_meta( $post->ID, 've_post_count_views', '1', true ) ) 
			{ 
			 $currentview = get_post_meta($post->ID, 've_post_count_views', '1', true);
			  update_post_meta( $post->ID, 've_post_count_views',  $currentview + 1 );
			}
		}
	
	}
}
add_action('wp_enqueue_scripts','ve_count_post_view_func');	
	/*
  *  End Assing specific templates to posts cateogry
  * 
  * */

if(!function_exists('return_child_cat_list'))
{
	function return_child_cat_list($parentCatId,$selfcat = false)
	{
		$CATARY = array();
		$categories = get_categories( array( 'child_of' => $parentCatId));  
		
		foreach($categories as $catval	 )
		{
			array_push($CATARY,$catval->cat_ID);
		}
		if($selfcat)
		{	
			array_push($CATARY,$parentCatId);
		}
		return $CATARY;
	}
}
// Breadcrumbs
/*
add_action( 'wp_ajax_nopriv_blog_contact_form', 'blog_contact_form' );
add_action( 'wp_ajax_blog_contact_form', 'blog_contact_form' );
if(!function_exists('blog_contact_form'))
{
	function blog_contact_form() {
		 if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
		 { 
			echo "yes"; 
		 }
	 }
}
* */

