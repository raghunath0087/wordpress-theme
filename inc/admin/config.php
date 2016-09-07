<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*  Create new option page for theme */
add_action('admin_menu', 'virtualemployee_register_ref_page');
/**
 * Adds a submenu page under a custom post type parent.
 */
 if(!function_exists('virtualemployee_register_ref_page')):
function virtualemployee_register_ref_page() {
    add_submenu_page(
        'themes.php',
        __( 'Theme Option', 'virtualemployee' ),
        __( 'Theme Option', 'virtualemployee' ),
        'manage_options',
        've-options',
        'virtualemployee_ref_page_callback'
    );
}
endif;
/** Define Action for register Options */
add_action('admin_init','ve_register_settings_init');
if(!function_exists('ve_register_settings_init')):
	function ve_register_settings_init(){
	 register_setting('ve_options','ve_logo');
	 register_setting('ve_options','ve_head');
	 register_setting('ve_options','ve_footer');
	 register_setting('ve_options','ve_favicon');
	 register_setting('ve_options','ve_share_buttons'); 
	 register_setting('ve_options','ve_share_on');
	} 
endif;
/**
 * Display callback for the submenu page.
 */
if(!function_exists('virtualemployee_ref_page_callback')):
function virtualemployee_ref_page_callback() { 
    ?>
    <div class="wrap">
        <h1><?php _e( 'Virtual Employee Theme Settings', 'virtualemployee' ); ?></h1>
		<hr>
    </div>
	<div style="width: 80%; padding: 10px; mamain: 10px;"> 
<!-- Start Options Form -->
	<form action="options.php" method="post" id="ve-admin-form">
	<div id="ve-tab-menu"><a id="ve-general" class="ve-tab-links active" >General Settings</a> <a id="ve-share" class="ve-tab-links" >Social Share Buttons</a> </div>
	<!-- General Setting -->	
	<div class="first ve-tab" id="div-ve-general">
	<p><label><?php _e('Site Logo:');?></label> <input type="text" id="ve_logo" name="ve_logo" value="<?php echo get_option('ve_logo'); ?>" placeholder="Insert site logo image path" size="30" class="inputButtonid"/><input id="ve_logo_button" data-id="ve_logo" type="button" value="Upload Image" class="imgUploadBtn"/>
	<?php if(get_option('ve_logo')!=''){ echo ' <img src="'.get_option('ve_logo').'" width="100">';}?>
	</p>
	<p><label><?php _e('Favicon icon:');?></label> <input type="text" id="ve_favicon" name="ve_favicon" value="<?php echo get_option('ve_favicon'); ?>" placeholder="Insert site favicon image path" size="30" class="inputButtonid"/><input data-id="ve_favicon" id="ve_favicon_button" type="button" value="Upload Image" class="imgUploadBtn"/>
	<?php if(get_option('ve_favicon')!=''){ echo ' <img src="'.get_option('ve_favicon').'" width="20">';}?>
	</p>
	
	<h2>Tracking code area</h2>
	<hr>
	<p><label><?php _e('Header Area');?></label><br><textarea rows="10" cols="80" id="ve_head" name="ve_head"  placeholder=""> <?php echo get_option('ve_head'); ?></textarea> </p>
	<p><label><?php _e('Footer Area');?></label><br><textarea rows="10" cols="80"  id="ve_footer" name="ve_footer" > <?php echo get_option('ve_footer'); ?></textarea> </p>
	</div>
	<!-- Shortcodes -->
	<div class="author ve-tab" id="div-ve-share">
	<h2>Social Share Buttons </h2>
	<p>Publish Buttons: &nbsp;
	<?php $ve_share_buttons=get_option('ve_share_buttons'); ?>
	<input type="checkbox" name="ve_share_buttons[]" id="vefb" value="fb" <?php if(isset($ve_share_buttons['0'])){checked( $ve_share_buttons['0'], 'fb' );} ?>>Facebook &nbsp;
	<input type="checkbox" name="ve_share_buttons[]" id="vetw" value="tw" <?php if(isset($ve_share_buttons['1'])){checked( $ve_share_buttons['1'], 'tw' );} ?>>Twitter &nbsp;
	<input type="checkbox" name="ve_share_buttons[]" id="veli" value="li" <?php if(isset($ve_share_buttons['2'])){checked( $ve_share_buttons['2'], 'li' );} ?>>Linkdin &nbsp;
	<input type="checkbox" name="ve_share_buttons[]" id="vepi" value="pi" <?php if(isset($ve_share_buttons['3'])){checked( $ve_share_buttons['3'], 'pi' );} ?>>Pinterest &nbsp;
	<input type="checkbox" name="ve_share_buttons[]" id="vegp" value="gp" <?php if(isset($ve_share_buttons['4'])){checked( $ve_share_buttons['4'], 'gp' );} ?>>Google Plus &nbsp;</p>
	<p>Show Buttons on : <?php 
	$ve_share_on=get_option('ve_share_on');
	$args = array(
			   'public'   => true,
			   '_builtin' => false
			);

			$output = 'names'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'

			$post_types = get_post_types( $args, $output, $operator ); 
			array_push($post_types,'post');array_push($post_types,'page');
			foreach ( $post_types  as $post_type ) {
           
				//echo '<option value="'.$post_type.'" >'.$post_type.'</option>';
				echo '<input type="checkbox" name="ve_share_on['.$post_type.']"';
				 if(isset($ve_share_on[$post_type])){checked( $ve_share_on[$post_type], $post_type );} 
				echo 'id="vegp" value="'.$post_type.'">'.strtoupper(str_replace('_',' ',$post_type)).' ';
			}
 ?></p>
	<p><strong>Shortcode:</strong> [ve-sharebuttons]</p>
	</div>
    <span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
    <?php settings_fields('ve_options'); ?>
	</form>
<!-- End Options Form -->
	</div>
    <?php
}
endif;
/** add js into admin footer */
if(isset($_GET['page']) && $_GET['page']=='ve-options'):
	add_action('admin_footer','init_ve_admin_scripts');
	add_action('admin_print_scripts','add_ve_admin_style_script');
endif;
if(!function_exists('init_ve_admin_scripts')):
	function init_ve_admin_scripts()
	{
	wp_register_style( 've_admin_style', get_template_directory_uri().'/inc/admin/admin.css');
	wp_enqueue_style( 've_admin_style' );
	echo $script='<script type="text/javascript">
		/* Virtual Employee js for admin */
		jQuery(document).ready(function(){
			jQuery(".ve-tab").hide();
			jQuery("#div-ve-general").show();
			jQuery(".ve-tab-links").click(function(){
			var divid=jQuery(this).attr("id");
			//alert(divid);
			jQuery(".ve-tab-links").removeClass("active");
			jQuery(".ve-tab").hide();
			jQuery("#"+divid).addClass("active");
			jQuery("#div-"+divid).fadeIn();
			});
		/* add image upload image button */
		jQuery(".imgUploadBtn").click(function() {
		formfield = jQuery(this).attr("data-id");
		//alert(formfield);
		tb_show( "", "media-upload.php?type=image&amp;TB_iframe=true" );
		return false;
		});
		window.send_to_editor = function(html) {
		imgurl = jQuery(html).attr("src");
		jQuery("#"+formfield).val(imgurl);
		tb_remove();
	   }
			})
		</script>';

		}	
endif;	
/** Load media and thick box library files*/
if(!function_exists('add_ve_admin_style_script')):
	function add_ve_admin_style_script()
	{
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}	
endif;
/** REMOVE SLUG FOR CUSTOM POST TYPE */
/** Start Removed custom post_type slug from posts url**/
function custom_parse_request_tricksy( $query ) {
    // Only noop the main query
    if ( ! $query->is_main_query() )
        return;
    // Only noop our very specific rewrite rule match
    if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }
    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'applications','post','page','service') ); // define all post type here
    }
}
add_action( 'pre_get_posts', 'custom_parse_request_tricksy' );
 function custom_remove_cpt_slug( $post_link, $post, $leavename ) {
  $postypeary=array( 'applications','post','page','service'); // define all post type here
    if (!in_array($post->post_type,$postypeary)  || 'publish' != $post->post_status ) {
        return $post_link;
    }
    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'custom_remove_cpt_slug', 10, 3 );
/** ADD TRACKING CODE INTO HEAD AND FOOTER SECTION */
// HEADER SECTION
add_action('wp_head','ve_hook_javascript');
if(!function_exists('ve_hook_javascript')):
	function ve_hook_javascript() {
	$faviocn=get_option('ve_favicon');
	if($faviocn!='')
	 print '<link rel="icon" href="'.$faviocn.'">';
	
	$output=get_option('ve_head');
	if($output!='')
	print $output;
  }
endif;
/** FOOTER SECTION */
add_action( 'wp_footer','ve_add_script_in_footer_sec');
if(!function_exists('ve_add_script_in_footer_sec')):
	function ve_add_script_in_footer_sec()
	{
		$output=get_option('ve_footer');
		echo $output;
	}	
endif;
/**
* Remove auto save functionality
*
*/
if(!function_exists('ve_disableAutoSave')):
function ve_disableAutoSave(){
    wp_deregister_script('autosave');
}
endif;
add_action( 'wp_print_scripts', 've_disableAutoSave' );
/** apply shortcode for text widget **/
add_filter('widget_text', 'do_shortcode');
/** 
 * Start ADD POST SPECIFIC SCRIPT
 * 
 * */
add_action( 'wp_enqueue_scripts', 've_enqueue_conditional_func' );
if(!function_exists('ve_enqueue_conditional_func'))
{ 
	function ve_enqueue_conditional_func() {
			  global $post;
		
				if(isset($post->post_type) && is_singular($post->post_type))
				{
					
					
					 $ve_comman_script       = get_post_meta($post->ID,'ve_comman_script',true) ? get_post_meta($post->ID,'ve_comman_script',true) : ''; 
		    
		             $executed_postion = get_post_meta($post->ID,'executed_postion',true) ? get_post_meta($post->ID,'executed_postion',true) : '';  
		             
		             $ve_comman_load_postion = get_post_meta($post->ID,'ve_comman_load_postion',true) ? get_post_meta($post->ID,'ve_comman_load_postion',true) : ''; 
		      
					if( $ve_comman_script!='')
					{
					add_action( 'wp_'.$ve_comman_load_postion, 've_enqueue_common_script_func',  $executed_postion );
				    }
					
					
		}
	}
}

if(!function_exists('ve_enqueue_common_script_func'))
{ 
	function ve_enqueue_common_script_func() {
			  global $post;
		    
		       $ve_comman_script       = get_post_meta($post->ID,'ve_comman_script',true);
				
				if($ve_comman_script  != '')
				{
					echo $ve_comman_script;
					
				}
	}
}

 
/**  * End ADD POST SPECIFIC SCRIPT * * */

/** Start Remove P Tag */
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
/** End Remove P Tag */
/*
 * Start Sort multi dimentation array on base of key value
 * 
 * */
/*if(!function_exists('virtual_array_sort_func')){
		function virtual_array_sort_func($filterAry,$sortkey='id')
		{
			
			$sortArray = array();
				foreach($filterAry as $person){
					foreach($person as $key=>$value){
						if(!isset($sortArray[$key])){
							$sortArray[$key] = array();
						}
						$sortArray[$key][] = $value;
					}
				}

			array_multisort($sortArray[$sortkey],SORT_ASC,$filterAry);
			
			return $filterAry;
			//echo '<pre>';print_r($newfilterAry);
			//exit;
			
			}

}
* */
/*
 * End Sort multi dimentation array on base of key value
 * 
 * */
 /* -----------------------------------------------------------------------------------
 *   Start Video Json Text File Fucntion
 *...................................................................................*/
 /**
 * Adds a submenu page under a custom post type parent.
 */
add_action('admin_menu', 've_videos_register_ref_page');

function ve_videos_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=ve_videos',
        __( 'Video Settings ', 'virtualemployee' ),
        __( 'Settings', 'virtualemployee' ),
        'manage_options',
        've_videos_settings',
        've_videos_page_callback'
    );
}
function ve_videos_page_callback() { 
 if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient pilchards to access this page.')    );
  }
?>
<div id="virtual-settings"> 
<div class="wrap">
    <h1>Videos Settings</h1><hr />
    <form class="add:the-list: validate" method="post" enctype="multipart/form-data">
		   <?php wp_nonce_field( 've_videos_action'); ?>
		   <input type="hidden" value="true" name="ve_video_action" /> 
		   <input type="hidden" value="ve_videos" name="type" /> 
		   <input type="hidden" value="ve_videos_term" name="term_type" />
		   <table>
		   <tr>
			<td><label>Hide Empty: </label></td>
			<td>
				<select name="hide_empty" id="hide_empty">
					<option value="1">True</option>
					<option value="0">False</option>
				</select>
			</td>
		   </tr>
		   <tr>
			<td><label>Init: </label></td>
			<td>
				<select name="init" id="init">
					<option value="1">True</option>
					<option value="0">False</option>
				</select>
			</td>
		   </tr>
		   <tr>
			<td><label>External: </label></td>
			<td>
				<select name="external" id="external">
					<option value="1">True</option>
					<option value="0">False</option>
				</select>
			</td>
		   </tr>
		   <tr>
			<td><label>Exclude Term: </label></td>
			<td>
				<input type="text" name="exclude" value="" placeholder="1,2,3"><br><i>add comma seprate ids</i>
			</td>
		   </tr>
		   <tr>
			<td><label>File Name:</label></td>
			<td>
				<input type="text" name="filename" value="" placeholder="videos.txt"><br><i>define json file name</i>
			</td>
		   </tr>
		   </table>
          <?php  submit_button('Create JSON File'); ?>
    </form>
</div><!-- end wrap -->
</div>
<?php
  // Check whether the button has been pressed AND also check the nonce
  $upload_dir = wp_upload_dir();
  $basedir = $upload_dir['basedir'];
  $direcotry_path = $basedir . '/ve_assets/json/';
  if (isset($_POST['ve_video_action']) && check_admin_referer('ve_videos_action')) {
	
    // the button has been pressed AND we've passed the security check
    ve_video_create_json_func($direcotry_path);
  }
  
	// Open json file directory, and read its contents
	if (is_dir($direcotry_path))
	{
	  if ($dh = opendir($direcotry_path))
	  {
		echo "<strong>Exist Json Files : </strong>";
		echo "<ol>";
		$jk=1;
		while (($file = readdir($dh)) !== false)
		{

	     if($jk > 2 )
		  {
		   echo "<li >" . $file . "</li>";
			}
		$jk++;
		}
		echo "</ol>";
	
		closedir($dh);
	  }
	}

}

function ve_video_create_json_func($direcotry_path)
{
 echo '<div id="message" class="updated fade"><p>'
    .'The Video JSON file was created.' . '</p></div>';
    

   if (!file_exists($direcotry_path)) {
    mkdir($direcotry_path, 0777, true);
   }
   
   $filename = (isset($_REQUEST['filename']) && $_REQUEST['filename']!='') ? $_REQUEST['filename']:'videos.txt';
   
   $path = $direcotry_path . $filename;
    
    $handle = fopen($path,"w");

  if ($handle == false) {
    echo '<p>Could not write the log file to the temporary directory: ' . $path . '</p>';
  }
  else {
    echo '<p>JSON files written to: ' . $path . '</p>';
    /** create videos json file * */
				 // update_post_meta( $_POST['post_id'], 'post_love', $love );
					 // custom query
			if(isset($_REQUEST['type']) && $_REQUEST['type'] !='' )
			{		 
					$post_type=$_REQUEST['type'];	
					$term_type=$_REQUEST['term_type'];	
					$exclude=isset($_REQUEST['exclude']) ? $_REQUEST['exclude'] : '';
					$external=isset($_REQUEST['external']) ? $_REQUEST['external'] : 0;	
					$init = isset($_REQUEST['init']) ? $_REQUEST['init'] : 0;	
					$init = (($init==0) ? 10000 : 4);
					$offset = (($init!=4) ? 4 : 0);
					if(isset($_REQUEST['hide_empty']) && $_REQUEST['hide_empty']!='')
					{		 
					$hide_empty=$_REQUEST['hide_empty'];	
					}else
					{
					$hide_empty=0;
					}
					$terms = get_terms($term_type, 
										array(
											'orderby'      => 'count',	
											'hierarchical' => true,
											'hide_empty' => $hide_empty,
											'exclude_tree' => $exclude
											)
										);
					$posts = array(); 
					$updated_terms = array();
					
					foreach($terms as $term) 
					{ 
						$term_meta 				= get_option( "taxonomy_term_$term->term_id" ); // Do the check
						$updated_term 			= array();
						$updated_term['id']		= (int) $term->term_id; 
						$updated_term['parent'] = (int) $term->parent; 
						$updated_term['name']	= $term->name;
						$updated_term['slug']	= $term->slug;
						$updated_term['external_link']	= ($term_meta['ve_custom_term_link'] && $external == 1) ? $term_meta['ve_custom_term_link'] : false;
						$updated_term['term_order']			= $term_meta['ve_custom_term_sort_order'] ? (int) $term_meta['ve_custom_term_sort_order'] : 0;
						$updated_term['icon']			= $term_meta['ve_custom_term_class'] ? $term_meta['ve_custom_term_class'] : '';
						$updated_term['type']			= $term_meta['ve_custom_term_type'] ? $term_meta['ve_custom_term_type'] : '';
						$updated_term['video_count']	= (int) $term->count;
						$updated_term['sub_category']	= array();
						
						$updated_terms[] = $updated_term; //print_r($updated_term); 
						
				if($updated_term['video_count'] > 0){
							
					$postsList=get_posts(array(
										'post_type' 	=> $post_type,
										'post_status'   => 'publish',
										'posts_per_page'=> $init,
										'order'			=> 'ASC',
										'orderby'		=>	'menu_order',
										'offset'		=> $offset,
										'tax_query' => array(
															array(
															'taxonomy' 	=> $term_type,
															'field' 	=> 'term_id',
															'terms' 	=> $term->term_id)
															)
										)
									); 
									
									foreach($postsList as $post) 
									{
										$getPostAry = array(); 
										$getPostAry['id']		     = $post->ID;
										$getPostAry['title']		 = $post->post_title;
										$getPostAry['link']			 = get_permalink($post->ID);
										$getPostAry['videoLink']	 = get_post_meta($post->ID,'_client_comp_vid_id',true) ? get_post_meta($post->ID,'_client_comp_vid_id',true) : '';		
										$getPostAry['image']		 = get_post_meta($post->ID,'_image_path',true) ? '/wp-content/uploads/ve_assets/' . get_post_meta($post->ID,'_image_path',true) : '';
										
										$getPostAry['country']		 = get_post_meta($post->ID,'_country',true) ? get_post_meta($post->ID,'_country',true) : '';
										$getPostAry['rank']		 = get_post_meta($post->ID,'_rank',true) ? get_post_meta($post->ID,'_rank',true) : '';
										$getPostAry['domain_hired_page_url']		 = get_post_meta($post->ID,'_domain_hired_page_url',true) ? get_post_meta($post->ID,'_domain_hired_page_url',true) : '';
										$getPostAry['domain_hired']		 = get_post_meta($post->ID,'_domain_hired',true) ? get_post_meta($post->ID,'_domain_hired',true) : '';
										$getPostAry['client_name']		 = get_post_meta($post->ID,'_client_name',true) ? get_post_meta($post->ID,'_client_name',true) : '';
										$getPostAry['company_info']		 = get_post_meta($post->ID,'_company_info',true) ? get_post_meta($post->ID,'_company_info',true) : '';
										$getPostAry['company_name']		 = get_post_meta($post->ID,'_company_name',true) ? get_post_meta($post->ID,'_company_name',true) : '';
										
										// get current post term ID
										$term_list = wp_get_post_terms($post->ID, $term_type, array("fields" => "ids"));
										$getPostAry['catID']		 = (int) $term_list[0];
										$getPostAry['content']		 = trim($post->post_content) != '' ? trim($post->post_content) : '';
										$getPostAry['order']		 = (int) $post->menu_order;
										//$getPostAry[$aaaa]['catID']= $term->term_id;
										$posts[] 					 = $getPostAry;
									}
					}
					}
					
					
					
					$data = array();
					$categoryHierarchy = array();
					// If its not the initial request send only the posts 
					if($init != -1) 
					{	
						//sort_ve_terms_hierarchicaly($updated_terms, $categoryHierarchy);
						$categoryHierarchy = $updated_terms;
					}	     
					$data['offset'] = $offset;
					$data['terms'] = $categoryHierarchy;
					$data['posts'] = $posts;
					
					//print_r($data);
					echo $json = json_encode($data);
					//$postlist = get_posts( 'orderby=menu_order&sort_order=asc' );
			
		 }
		 else
		 {
			echo ''; 
			 }
	   
			
        /* end json file */
    fwrite ($handle , $json); 
    fclose ($handle);
  }
} 
/* -----------------------------------------------------------------------------------
 *   End Video Json Text File Fucntion
 *...................................................................................*/
/** 
 * Start Define from email and name 
 * 
 * */ 
add_filter( 'wp_mail_from', 've_admin_mail_from' );
if(!function_exists('ve_admin_mail_from')):
function ve_admin_mail_from( $email )
{
	return get_site_option('admin_email');
}
endif;
add_filter( 'wp_mail_from_name', 've_admin_from_name' );
if(!function_exists('ve_admin_from_name')):
function ve_admin_from_name( $name )
{
	return get_site_option('site_name');
}
endif;
/** 
 * End Define from email and name 
 * 
 * */ 
 
/** 
 * Define Country list
 * 
 * */ 
add_action('init','ve_return_country_list_func') ;
if(!function_exists('ve_return_country_list_func')):
	function ve_return_country_list_func(){
		$option_name = 've_country_list' ;
		$countrylist_value =array('Afghanistan','Algeria','Argentina','Australia','Austria','Bahamas','Bahrain','Bangladesh','Belgium','Bhutan','Brazil','Cambodia','Cameroon','Canada','Chile','China','Colombia','Cuba','Denmark','Doha','Dubai','Ecuador','Egypt','Ethiopia','Finland','France','Germany','Ghana','Greece','Greenland','Guyana','Honduras','Hong Kong','Hungary','India','Indonesia','Ireland','Israel','Italy','Jamaica','Japan','Jordan','Kenya','Kuwait','Lebanon','Libya','Luxembourg','Macau','Malaysia','Maldives','Mauritius','Mexico','Myanmar','Namibia','Nepal','Netherlands','New Zealand','Nigeria','Norway','Oman','Pakistan','Panama','Peru','Philippines','Poland','Portugal','Qatar','Quilon','Romania','Russia','Saudi Arabia','Serbia','Singapore','South Africa','South Korea','Spain','Sri Lanka','Sweden','Switzerland','Thailand','UAE','UK','US','Yemen','Zimbabwe');

		if ( get_option( $option_name ) !== false ) {
			// The option already exists, so we just update it.
			update_option( $option_name, $countrylist_value  );
		} else {
			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $countrylist_value , $deprecated, $autoload );
		}

	}
endif;
