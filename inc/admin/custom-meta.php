<?php
/**
 * The template for managing all custom metabox fields
 * Displays all of the head element and everything up until the "site-content" div.
 * @package VirtualEmployee
 * @subpackage virtualemployee
 *
 */
/*------------------------------------------------------------------------------------------------------
                                           Start Custom Meta Boxes
 ------------------------------------------------------------------------------------------------------ */
 /*-------------------------------------------------
 Start Comman
 ------------------------------------------------- */
if(!function_exists('add_ve_comman_post_meta_box')){ 
	function add_ve_comman_post_meta_box()
	{
			$args = array(
			   'public'   => true,
			   '_builtin' => false
			);

			$output = 'names'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'

			$post_types = get_post_types( $args, $output, $operator ); 
			array_push($post_types,'post');array_push($post_types,'page');
			
		$screens = $post_types;
		foreach ( $screens as $screen ) {
			add_meta_box(
				've-comman-meta-box',
				__( 'Comman Information', 'virtualemployee' ),
				'show_ve_comman_meta_box',
				$screen
			);
		}

	}
}
  //Define meta box fields
  $prefix='ve_comman_';
  $ve_comman_meta_box = array(
		'id'      => 've-commanmeta-box',
		'title'   => 'Comman Information',
		'page'    => '',
		'context' => 'normal',
		'priority'=> 'high',
		'fields'  => 
				  array(
						array(
						'name' => 'Banner Section',
						'id'   => 'heading',
						'type' => 'heading'
						),
						array(
						'name' => 'Banner Image',
						'desc' => '',
						'id'   => $prefix.'banner',
						'type' => 'image',
						'std'  => ''
						),
						array(
						'name' => 'Banner Text',
						'desc' => '',
						'id'   => $prefix.'banner_dec',
						'type' => 'textarea',
						'std'  => ''
						),
						array(
						'name' => 'Banner Class',
						'desc' => '',
						'id'   => $prefix.'banner_class',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Container Class',
						'desc' => '',
						'id'   => $prefix.'container_class',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Script Section',
						'id'   => $prefix.'heading1',
						'type' => 'heading'
						),
						array(
						'name' => 'Add Script',
						'desc' => '',
						'id'   => $prefix.'script',
						'type' => 'textarea',
						'std'  => ''
						),
						array(
						'name' => 'Load Script in',
						'desc' => '',
						'id'   => $prefix.'load_postion',
						'type' => 'select',
						'options' => array('footer','head'),
						'std'  => ''
						),
						array(
						'name' => 'Define Execute postion',
						'desc' => '',
						'id'   => $prefix.'executed_postion',
						'type' => 'text',
						'std'  => '20'
						),
						
		)
    );
//Display Adds Videos Meta Box
if(!function_exists('show_ve_comman_meta_box')){ 
	function show_ve_comman_meta_box()
	{
		global $ve_comman_meta_box, $post;
		$crnimg='';
		wp_nonce_field( 've_comman_box_field', 've_comman_box_meta_box_once' );
		echo '<table class="form-table"><tbody>';
		foreach ($ve_comman_meta_box['fields'] as $field) {
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>';
			if($field['type']!=='heading'){
			echo '<td><label for="', $field['id'], '">', $field['name'], '</label>','</td>';}
			switch ($field['type']) {
			case 'heading':
			echo '<th colspan="2"><strong>', $field['name'],'</strong><hr></th>';
			break;
			case 'text':
			echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="60" />', '<br />', $field['desc'],'</td>';
			break;
			case 'checkbox':
			echo '<td><input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'"', checked( $meta, 'yes' ),' size="60" />', '<br />', $field['desc'],'</td>';
			break;
			case 'image':
				echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '-img" value="', $meta ? $meta : $field['std'], '" size="60" />', '<br />', $field['desc'],'<input type="button" class="select-img" value="Upload Image" id="',$field['id'],'" /></td>';
				break;
			case 'textarea':
			echo '<td><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'],'</td>';
			break;
			case 'select':
			echo '<td><select name="', $field['id'], '" id="', $field['id'], '" >';
			$optionVal=$field['options'];
			foreach($optionVal as $optVal):
			if($meta==$optVal){
			$valseleted =' selected="selected"';}else {
				 $valseleted ='';
				}
			echo '<option value="', $optVal, '" ',$valseleted,' id="', $field['id'], '">', $optVal, '</option>';
		endforeach;
		echo '</select>','<br />',$field['desc'],'</td>';
		break;
		echo '</tr>';
		
		
		}

		}
		
	echo '</tbody></table>';
/*echo "<script>
		var image_field;
		jQuery(function($){
		  jQuery(document).on('click', 'input.select-img', function(evt)
		  {
			image_field = jQuery(this).attr('id');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		  });
		  window.send_to_editor = function(html) 
		  {
			imgurl = jQuery(html).attr('src');
			jQuery('#'+image_field+'-img').val(imgurl);
			tb_remove();
		  }
		});
</script>";*/
	}
}


if(!function_exists('save_ve_comman_post_meta_box')){ 
	function save_ve_comman_post_meta_box($post_id) {
		global $ve_comman_meta_box,$post_types;
		// Check if our nonce is set.
		 if ( ! isset( $_POST['ve_comman_box_meta_box_once'] ) ) {
				return;
			}
			
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
		}

		// check permissions
		if (!in_array($_POST['post_type'],$post_types)) 
		{
			if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} 
		elseif(!current_user_can('edit_post', $post_id)){
		return $post_id;
		}
		
		foreach ($ve_comman_meta_box['fields'] as $field) 
		{
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old){
			 update_post_meta($post_id, $field['id'], $new);
			} 
			elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
//define action for create new meta boxes
add_action( 'add_meta_boxes', 'add_ve_comman_post_meta_box' );
//Define action for save to "Video" Meta Box fields Value
add_action( 'save_post', 'save_ve_comman_post_meta_box' );
 /*-------------------------------------------------
 End Comman Settings
 ------------------------------------------------- */
 /*-------------------------------------------------
 Start VE Team
 ------------------------------------------------- */
if(!function_exists('add_ve_team_post_meta_box')){ 
	function add_ve_team_post_meta_box()
	{
		$screens = array('ve_team');
		foreach ( $screens as $screen ) {
			add_meta_box(
				've-team-meta-box',
				__( 'Team Information', 'virtualemployee' ),
				'show_ve_team_meta_box',
				$screen
			);
		}

	}
}
  //Define meta box fields
  $prefix='ve_team_';
  $ve_team_meta_box = array(
		'id'      => 've-veteam-box',
		'title'   => 'Team Information',
		'page'    => '',
		'context' => 'normal',
		'priority'=> 'high',
		'fields'   => array(
       array(
			'name' => __('The Job Title', 'virtualemployee'),
			'id'   => $prefix . 'job_title',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Profile pic', 'virtualemployee'),
			'id'   => $prefix . 'profile_pic',
			'type' => 'image',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Text', 'virtualemployee'),
			'id'   => $prefix . 'text',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Social Links', 'virtualemployee'),
			'id'   => $prefix . 'heading',
			'type' => 'heading',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Facebook Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'facebook',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Twitter Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'twitter',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Linkdin Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'linkdin',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Google Plus Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'google_plus',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Yutube Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'youtube',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Pinterest Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'pinit',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Skype Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'skype',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		),
		array(
			'name' => __('Email Profile URL', 'virtualemployee'),
			'id'   => $prefix . 'social_link_email',
			'type' => 'text',
			'std'  => '',
			'desc' => ''
		)
		
	)
    );
//Display Adds Team Meta Box
if(!function_exists('show_ve_team_meta_box')){ 
	function show_ve_team_meta_box()
	{
		global $ve_team_meta_box, $post;
		$crnimg='';
		wp_nonce_field( 've_team_box_field', 've_team_box_meta_box_once' );
		echo '<table class="form-table"><tbody>';
		foreach ($ve_team_meta_box['fields'] as $field) {
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>';
			if($field['type']!=='heading'){
			echo '<td><label for="', $field['id'], '">', $field['name'], '</label>','</td>';}
			switch ($field['type']) {
			case 'heading':
			echo '<th colspan="2"><strong>', $field['name'],'</strong><hr></th>';
			break;
			case 'text':
			echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="60" />', '<br />', $field['desc'],'</td>';
			break;
			case 'checkbox':
			echo '<td><input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'"', checked( $meta, 'yes' ),' size="60" />', '<br />', $field['desc'],'</td>';
			break;
			case 'image':
				echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '-img" value="', $meta ? $meta : $field['std'], '" size="60" />', '<br />', $field['desc'],'<input type="button" class="select-img" value="Choose Image" id="',$field['id'],'" /></td>';
				break;
			case 'textarea':
			echo '<td><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'],'</td>';
			break;
			case 'select':
			echo '<td><select name="', $field['id'], '" id="', $field['id'], '" >';
			$optionVal=$field['options'];
			foreach($optionVal as $optVal):
			if($meta==$optVal){
			$valseleted =' selected="selected"';}else {
				 $valseleted ='';
				}
			echo '<option value="', $optVal, '" ',$valseleted,' id="', $field['id'], '">', $optVal, '</option>';
		endforeach;
		echo '</select>','<br />',$field['desc'],'</td>';
		break;
		echo '</tr>';
		
		
		}

		}
		
	echo '</tbody></table>';
/*echo "<script>
		var image_field;
		jQuery(function($){
		  jQuery(document).on('click', 'input.select-img', function(evt)
		  {
			image_field = jQuery(this).attr('id');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		  });
		  window.send_to_editor = function(html) 
		  {
			imgurl = jQuery(html).attr('src');
			jQuery('#'+image_field+'-img').val(imgurl);
			tb_remove();
		  }
		});
</script>";*/
	}
}


if(!function_exists('save_ve_team_post_meta_box')){ 
	function save_ve_team_post_meta_box($post_id) {
		global $ve_team_meta_box,$post_types;
		// Check if our nonce is set.
		 if ( ! isset( $_POST['ve_team_box_meta_box_once'] ) ) {
				return;
			}
			
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
		}

		// check permissions
		if (!in_array($_POST['post_type'],$post_types)) 
		{
			if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} 
		elseif(!current_user_can('edit_post', $post_id)){
		return $post_id;
		}
		
		foreach ($ve_team_meta_box['fields'] as $field) 
		{
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old){
			 update_post_meta($post_id, $field['id'], $new);
			} 
			elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
//define action for create new meta boxes
add_action( 'add_meta_boxes', 'add_ve_team_post_meta_box' );
//Define action for save to "Video" Meta Box fields Value
add_action( 'save_post', 'save_ve_team_post_meta_box' );
 /*-------------------------------------------------
 End team Settings
 ------------------------------------------------- */
 
/*-------------------------------------------------
 Start Video Meta Boxes
 ------------------------------------------------- */
if(!function_exists('add_ve_video_post_meta_box')){ 
	function add_ve_video_post_meta_box()
	{
		$screens = array( 've_videos');
		foreach ( $screens as $screen ) {
			add_meta_box(
				've-video-meta-box',
				__( 'Video Extra Information', 'virtualemployee' ),
				'show_ve_video_meta_box',
				$screen
			);
		}

	}
}
  //Define meta box fields
  $prefix='ve_';
  $ve_video_meta_box = array(
		'id'      => 've-videometa-box',
		'title'   => 'Videos Information',
		'page'    => '',
		'context' => 'normal',
		'priority'=> 'high',
		'fields'  => 
				  array(
						array(
						'name' => 'Company Name',
						'desc' => '',
						'id'   => '_company_name',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Company Info',
						'desc' => '',
						'id'   => '_company_info',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Client Name',
						'desc' => '',
						'id'   => '_client_name',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Client Pic',
						'desc' => '',
						'id'   => '_client_pic',
						'type' => 'image',
						'std'  => ''
						),
						array(
						'name' => 'Domain Hired For',
						'desc' => '',
						'id'   => '_domain_hired',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Domain Page Link',
						'desc' => '',
						'id'   => '_domain_hired_page_url',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Youtube Video ID',
						'desc' => '',
						'id'   => '_client_comp_vid_id',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Banner Image',
						'desc' => '',
						'id'   => '_image_path',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name' => 'Rank',
						'desc' => '',
						'id'   => '_rank',
						'type' => 'text',
						'std'  => ''
						),
						array(
						'name'  => 'Country',
						'desc'  => '',
						'id'    => '_country',
						'type'  => 'select',
						'options' =>get_option('ve_country_list'), 
						'std'  => ''
						)
		)
    );
//Display Adds Videos Meta Box
if(!function_exists('show_ve_video_meta_box')){ 
	function show_ve_video_meta_box()
	{
		global $ve_video_meta_box, $post;
		$crnimg='';
		wp_nonce_field( 've_video_box_field', 've_video_box_meta_box_once' );
		echo '<table class="form-table"><tbody>';
		foreach ($ve_video_meta_box['fields'] as $field) {
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>',
			'<td><label for="', $field['id'], '">', $field['name'], '</label>','</td>';
			switch ($field['type']) {
			case 'text':
			echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" />', '<br />', $field['desc'],'</td>';
			break;
			case 'image':
				echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" />', '<br />', $field['desc'],'</td>';
				break;
			case 'textarea':
			echo '<td><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'],'</td>';
			break;
			case 'select':
			echo '<td><select name="', $field['id'], '" id="', $field['id'], '" >';
			$optionVal=$field['options'];
			foreach($optionVal as $optVal):
			if($meta==$optVal){
			$valseleted =' selected="selected"';}else {
				 $valseleted ='';
				}
			echo '<option value="', $optVal, '" ',$valseleted,' id="', $field['id'], '">', $optVal, '</option>';
		endforeach;
		echo '</select>','<br />',$field['desc'],'</td>';
		break;
		echo '</tr>';
		
		
		}

		}
	echo '</tbody></table>';
	}
}
/*
function load_wp_media_files() {
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );

function admin_inline_js(){
	echo '

  <script>
jQuery(document).ready(function($){
  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;
  // Runs when the image button is clicked.
  $(\'#meta-image-button\').click(function(e){
    // Prevents the default action from occuring.
    e.preventDefault();
    // If the frame already exists, re-open it.
   if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }
    // Sets up the media library frame
    meta_image_frame= wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( \'uploader_title\' ),
      button: {
        text: jQuery( this ).data( \'uploader_button_text\' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
    // Runs when an image is selected.
    meta_image_frame.on(\'select\', function(){
    alert("ffff");
      // Grabs the attachment selection and creates a JSON representation of the model.
      var media_attachment = meta_image_frame.state().get(\'selection\').first().toJSON();
      // Sends the attachment URL to our custom image input field.
      
      $("#csbwfs_og_image_path").val(media_attachment.url);
        
     // $(\'#csbwfs_og_image_path\').val(media_attachment.url);
    });
    // Opens the media library frame.
    wp.media.editor.open();
  });
 });

 </script> ';

}
add_action( 'admin_footer', 'admin_inline_js' );
*/

if(!function_exists('save_ve_video_post_meta_box')){ 
	function save_ve_video_post_meta_box($post_id) {
		global $ve_video_meta_box;
		// Check if our nonce is set.
		 if ( ! isset( $_POST['ve_video_box_meta_box_once'] ) ) {
				return;
			}
			
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
		}

		// check permissions
		if ('ve_videos' == $_POST['post_type']) 
		{
			if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} 
		elseif(!current_user_can('edit_post', $post_id)){
		return $post_id;
		}
		
		foreach ($ve_video_meta_box['fields'] as $field) 
		{
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old){
			 update_post_meta($post_id, $field['id'], $new);
			} 
			elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
//define action for create new meta boxes
add_action( 'add_meta_boxes', 'add_ve_video_post_meta_box' );
//Define action for save to "Video" Meta Box fields Value
add_action( 'save_post', 'save_ve_video_post_meta_box' );
/*-------------------------------------------------
 End Video Meta Boxes
 ------------------------------------------------- */
 /*-------------------------------------------------
 Start Blog Meta Boxes
 ------------------------------------------------- */
if(!function_exists('add_ve_blog_post_meta_box')){ 
	function add_ve_blog_post_meta_box()
	{
		$screens = array( 've_blog');
		foreach ( $screens as $screen ) {
			add_meta_box(
				've-blog-meta-box',
				__( 'Blog Extra Information', 'virtualemployee' ),
				'show_ve_blog_meta_box',
				$screen
			);
		}

	}
}
  //Define meta box fields
  $prefix='ve_blog_';
  $ve_blog_meta_box = array(
		'id'      => 've-blogmeta-box',
		'title'   => 'Blog Information',
		'page'    => '',
		'context' => 'normal',
		'priority'=> 'high',
		'fields'  => 
				  array(
						array(
						'name' => 'Is Featured post',
						'desc' => '',
						'id'   => $prefix.'featured',
						'type' => 'checkbox',
						'std'  => 'yes'
						)
		)
    );
//Display Adds Blog Meta Box
if(!function_exists('show_ve_blog_meta_box')){ 
	function show_ve_blog_meta_box()
	{
		global $ve_blog_meta_box, $post;
		$crnimg='';
		wp_nonce_field( 've_blog_box_field', 've_blog_box_meta_box_once' );
		echo '<table class="form-table"><tbody>';
		foreach ($ve_blog_meta_box['fields'] as $field) {
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>',
			'<td><label for="', $field['id'], '">', $field['name'], '</label>','</td>';
			switch ($field['type']) {
			case 'text':
			echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" />', '<br />', $field['desc'],'</td>';
			break;
			case 'checkbox':
			echo '<td><input type="checkbox" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'"', checked( $meta, 'yes' ),' size="30" />', '<br />', $field['desc'],'</td>';
			break;
			case 'image':
				echo '<td><input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" />', '<br />', $field['desc'],'</td>';
				break;
			case 'textarea':
			echo '<td><textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'],'</td>';
			break;
			case 'select':
			echo '<td><select name="', $field['id'], '" id="', $field['id'], '" >';
			$optionVal=$field['options'];
			foreach($optionVal as $optVal):
			if($meta==$optVal){
			$valseleted =' selected="selected"';}else {
				 $valseleted ='';
				}
			echo '<option value="', $optVal, '" ',$valseleted,' id="', $field['id'], '">', $optVal, '</option>';
		endforeach;
		echo '</select>','<br />',$field['desc'],'</td>';
		break;
		echo '</tr>';
		
		
		}

		}
	echo '</tbody></table>';
	}
}

if(!function_exists('save_ve_blog_post_meta_box')){ 
	function save_ve_blog_post_meta_box($post_id) {
		global $ve_blog_meta_box;
		// Check if our nonce is set.
		 if ( ! isset( $_POST['ve_blog_box_meta_box_once'] ) ) {
				return;
			}
			
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
		}

		// check permissions
		if ('ve_blog' == $_POST['post_type']) 
		{
			if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} 
		elseif(!current_user_can('edit_post', $post_id)){
		return $post_id;
		}
		//print_r($ve_blog_meta_box['fields']); exit;
		foreach ($ve_blog_meta_box['fields'] as $field) 
		{
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old){
			 update_post_meta($post_id, $field['id'], $new);
			} 
			elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
}
//define action for create new meta boxes
add_action( 'add_meta_boxes', 'add_ve_blog_post_meta_box' );
//Define action for save to "Blog" Meta Box fields Value
add_action( 'save_post', 'save_ve_blog_post_meta_box' );
/*-------------------------------------------------
 End Blog Meta Boxes
 ------------------------------------------------- */
 
/*-------------------------------------------------
 Start Taxonomy Meta Boxes
 ------------------------------------------------- */
 // A callback function to add a custom field to our "presenters" taxonomy
if(!function_exists('ve_edit_taxonomy_custom_fields'))
{ 
	function ve_edit_taxonomy_custom_fields($tag) {
	   // Check for existing taxonomy meta for the term you're editing
		$t_id = $tag->term_id; // Get the ID of the term you're editing
		$term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_videos_category_id"><?php _e('Class:'); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[ve_custom_term_class]" id="term_meta[ve_custom_term_class]" size="25" style="width:60%;" value="<?php echo isset($term_meta['ve_custom_term_class']) ? $term_meta['ve_custom_term_class'] : ''; ?>"><br />
			<span class="description"><?php _e('Define category specific class name'); ?></span>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_videos_category_order"><?php _e('Sort Order:'); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[ve_custom_term_sort_order]" id="term_meta[ve_custom_term_sort_order]" size="25" style="width:60%;" value="<?php echo isset($term_meta['ve_custom_term_sort_order']) ? $term_meta['ve_custom_term_sort_order'] : '0'; ?>"><br />
			<span class="description"><?php _e('Define category short order'); ?></span>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_videos_category_link"><?php _e('External Link:'); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[ve_custom_term_link]" id="term_meta[ve_custom_term_link]" size="25" style="width:60%;" value="<?php echo isset($term_meta['ve_custom_term_link']) ? $term_meta['ve_custom_term_link'] : ''; ?>"><br />
			<span class="description"><?php _e('Define category external link'); ?></span>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_videos_category_link"><?php _e('Type:'); ?></label>
		</th>
		<td>
			<select name="term_meta[ve_custom_term_type]" id="term_meta[ve_custom_term_type]">
				<option value="video" <?php isset($term_meta['ve_custom_term_type'])? selected($term_meta['ve_custom_term_type'],'video'):''; ?>> Video</option>
				<option value="text" <?php isset($term_meta['ve_custom_term_type'])? selected($term_meta['ve_custom_term_type'],'text'):''; ?>>Text</option>
			</select>
			<br />
			<span class="description"><?php _e('Define category type link'); ?></span>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_custom_term_image"><?php _e('Image path 1:'); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[ve_custom_term_image]" id="term_meta[ve_custom_term_image]" size="25" style="width:60%;" value="<?php echo isset($term_meta['ve_custom_term_image']) ? $term_meta['ve_custom_term_image'] : ''; ?>"><br />
			<span class="description"><?php _e('Define category image path 1'); ?></span>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="ve_custom_term_image_2"><?php _e('Image path 2:'); ?></label>
		</th>
		<td>
			<input type="text" name="term_meta[ve_custom_term_image_2]" id="term_meta[ve_custom_term_image_2]" size="25" style="width:60%;" value="<?php echo isset($term_meta['ve_custom_term_image_2']) ? $term_meta['ve_custom_term_image'] : ''; ?>"><br />
			<span class="description"><?php _e('Define category image path 2'); ?></span>
		</td>
	</tr>
	<?php
 }
}
// A callback function to save our extra taxonomy field(s)
if(!function_exists('save_taxonomy_custom_fields'))
{
	function save_taxonomy_custom_fields( $term_id ) 
	{
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ){
				if ( isset( $_POST['term_meta'][$key] ) ){
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			//save the option array
			update_option( "taxonomy_term_$t_id", $term_meta );
		}
	}
}
// ADD
// Add term page
function ve_add_taxonomy_custom_fields() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="term_meta[ve_custom_term_class]"><?php _e( 'Class:', 'virtualemployee' ); ?></label>
		<input type="text" name="term_meta[ve_custom_term_class]" id="term_meta[ve_custom_term_class]" value="">
		<p class="description"><?php _e( 'Define category specific class name','virtualemployee' ); ?></p>
	</div>
	
	<div class="form-field">
		<label for="term_meta[ve_custom_term_sort_order]"><?php _e( 'Sort Order:', 'virtualemployee' ); ?></label>
		<input type="text" name="term_meta[ve_custom_term_sort_order]" id="term_meta[ve_custom_term_sort_order]" value="">
		<p class="description"><?php _e( 'Define category short order','virtualemployee' ); ?></p>
	</div>

	<div class="form-field">
		<label for="term_meta[ve_custom_term_link]"><?php _e( 'External Link', 'virtualemployee' ); ?></label>
		<input type="text" name="term_meta[ve_custom_term_link]" id="term_meta[ve_custom_term_link]" value="">
		<p class="description"><?php _e( 'Define category external link','virtualemployee' ); ?></p>
	</div>
	
	<div class="form-field">
		<label for="term_meta[ve_custom_term_type]"><?php _e( 'Type', 'virtualemployee' ); ?></label>
		<select name="term_meta[ve_custom_term_type]" id="term_meta[ve_custom_term_type]">
				<option value="video">Video</option>
				<option value="text">Text</option>
		</select>
		<p class="description"><?php _e( 'Define category type','virtualemployee' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[ve_custom_term_image]"><?php _e( 'Image Path 1', 'virtualemployee' ); ?></label>
		<input type="text" name="term_meta[ve_custom_term_image]" id="term_meta[ve_custom_term_image]" value="">
		<p class="description"><?php _e( 'Define category image path 1','virtualemployee' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[ve_custom_term_image_2]"><?php _e( 'Image Path 2', 'virtualemployee' ); ?></label>
		<input type="text" name="term_meta[ve_custom_term_image_2]" id="term_meta[ve_custom_term_image_2]" value="">
		<p class="description"><?php _e( 'Define category image path 2','virtualemployee' ); ?></p>
	</div>
<?php
}

add_action('init','add_custom_term_field_all');
if(!function_exists(''))
{
 function add_custom_term_field_all()
 {
		$args = array(
					  'public'   => true,
					  '_builtin' => false
					); 
	     $output = 'names'; // or objects
		 $operator = 'and'; // 'and' or 'or'
		 $taxonomies = get_taxonomies( $args, $output, $operator ); 
		//			array_push($taxonomies,'category');
		if ( $taxonomies ) 
		{
			foreach ( $taxonomies as $taxonomy ) 
			{
			$taxonomyType=$taxonomy;
			add_action( $taxonomyType.'_add_form_fields', 've_add_taxonomy_custom_fields', 10, 2 );
			add_action('created_'.$taxonomyType, 'save_taxonomy_custom_fields', 10, 2);

			// Edit the fields to the "presenters" taxonomy, using our callback function
			add_action( $taxonomyType.'_edit_form_fields', 've_edit_taxonomy_custom_fields', 10, 2 );
			add_action( 'edited_'.$taxonomyType, 'save_taxonomy_custom_fields', 10, 2 );
			}
		}
		
					

	 }	
}
/*-------------------------------------------------
 End Taxonomy Meta Boxes
 ------------------------------------------------- */
 /*-------------------------------------------------
 Start Testimonials
 ------------------------------------------------- */
if(!function_exists('ve_testimonials_metabox_func')){ 
	function ve_testimonials_metabox_func() {
		add_meta_box( 've_testimonial_metabox', __('Testimonial Settings', 'virtualE'), 've_testimonials_metabox_render_html', 'testimonial', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes', 've_testimonials_metabox_func' );

if(!function_exists('ve_testimonials_metabox_render_html')){
	function ve_testimonials_metabox_render_html() {

		global $post;
	 
		$country_list = get_option('ve_country_list');
		
		$company_name			= get_post_meta( $post->ID, '_company_name', true ); 
		$client_name 			= get_post_meta( $post->ID, '_client_name', true );
		$domain_hired 			= get_post_meta( $post->ID, '_domain_hired', true );
		$domain_hired_page_url 	= get_post_meta( $post->ID, '_domain_hired_page_url', true );
		$country 				= get_post_meta( $post->ID, '_country', true );
		$client_comp_vid_id 	= get_post_meta( $post->ID, '_client_comp_vid_id', true );  
		$client_pic 			= get_post_meta( $post->ID, '_client_pic', true );
		$type 					= get_post_meta( $post->ID, '_type', true );	 
		$company_info			= get_post_meta( $post->ID, '_company_info', true );
	 
		echo '<input type="hidden" name="crosby_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
		echo '<table class="form-table"><tbody>';
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Company Name', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_company_name"  style="width:100%;" value="'.$company_name.'"  placeholder="Company Name" />';    
		 echo '</td>';
		echo '</tr>';

		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Client Name', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_client_name"  style="width:100%;" value="'.$client_name.'"  placeholder="Client Name" />';    
		 echo '</td>';
		echo '</tr>';

		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Domain Hired For', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_domain_hired"  style="width:100%;" value="'.$domain_hired.'"  placeholder="Ex: Hired a team of PHP Web Developers" />';    
		 echo '</td>';
		echo '</tr>';

		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Domain Page Link', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_domain_hired_page_url"  style="width:100%;" value="'.$domain_hired_page_url.'"  placeholder="Ex: http://www.virtualemployee.com/services/it-outsourcing/hire-php-developer" />';    
		 echo '</td>';
		echo '</tr>';	
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Youtube Video ID', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_client_comp_vid_id"  style="width:100%;" value="'.$client_comp_vid_id.'"  placeholder="Video ID" />';    
		 echo '</td>';
		echo '</tr>';		
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Client Pic', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<input type="text" name="_client_pic"  style="width:100%;" value="'.$client_pic.'"  placeholder="Client pic URL" />';
		  echo $client_pic != '' ? '<br /><img src="'.$client_pic.'" />' : '';	
		 echo '</td>';
		echo '</tr>';		
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Country', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<select name="_country"  style="width:100%;"><option value="">Select Country</option>'; 
		  foreach( $country_list as $index=>$value )
		  {
			echo '<option value="' . $value. '" ' . ($country == $value ? ' selected' : ''). '>' . $value . '</option>';
		  }
		  echo '</select>';    
		 echo '</td>';
		echo '</tr>';	
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Company Info', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<textarea name="_company_info" style="width:100%" placeholder="Text to be shown in blue for Text Testimonials">'.$company_info.'</textarea>';    
		 echo '</td>';
		echo '</tr>';		
		
		echo '<tr>';
		 echo '<th scope="row">';
		  echo '<label>'.__('Testimonial Type', 'virtualE').'</label>';    
		 echo '</th>';
		 echo '<td>';
		  echo '<select name="_type"  style="width:100%;">'; 
			echo '<option value="Video" ' . ($type == 'Video' ? ' selected' : ''). '>Video</option>';
			echo '<option value="Text" ' . ($type == 'Text' ? ' selected' : ''). '>Text</option>';
		  echo '</select>';    
		 echo '</td>';
		echo '</tr>';		
		
		echo '<tbody></table>';

	 
	 echo  '<input type="hidden" name="testimonials" value="1" />';
	}
}

/* --------------------------------------------------------- /
/ !Save the custom meta - 1.0.0 /
/ --------------------------------------------------------- */
if(!function_exists('ve_testimonials_metabox_save')){
	function ve_testimonials_metabox_save( $post_id ) 
	{
		global $post;
		// verify nonce
		if ( !isset($_POST['crosby_nonce']) || !wp_verify_nonce($_POST['crosby_nonce'], basename(__FILE__)) ) {
			return $post_id;
		}
		// Save Client Competition Meta Data 
		if(isset($_POST['client_competition_video']) && $_POST['client_competition_video'] == 1) 
		{
			$country 				= isset($_POST['_country']) ? $_POST['_country'] : '';
			$client_comp_vid_id 	= isset($_POST['_client_comp_vid_id']) ? $_POST['_client_comp_vid_id'] : ''; 
			
			update_post_meta( $post_id, '_country', $country );
			update_post_meta( $post_id, '_client_comp_vid_id', $client_comp_vid_id );
		} 
		
		// Save Testimonial Meta Data 
		if(isset($_POST['testimonials']) && $_POST['testimonials'] == 1) 
		{
			$company_name			= isset($_POST['_company_name']) ? $_POST['_company_name'] : ''; 
			$client_name 			= isset($_POST['_client_name']) ? $_POST['_client_name'] : '';
			$domain_hired 			= isset($_POST['_domain_hired']) ? $_POST['_domain_hired'] : '';
			$domain_hired_page_url 	= isset($_POST['_domain_hired_page_url']) ? $_POST['_domain_hired_page_url'] : '';
			$country 				= isset($_POST['_country']) ? $_POST['_country'] : '';
			$client_comp_vid_id 	= isset($_POST['_client_comp_vid_id']) ? $_POST['_client_comp_vid_id'] : ''; 
			$client_pic			 	= isset($_POST['_client_pic']) ? $_POST['_client_pic'] : '';
			$type 					= isset($_POST['_type']) ? $_POST['_type'] : ''; 
			$company_info			= isset($_POST['_company_info']) ? $_POST['_company_info'] : '';

			update_post_meta( $post->ID, '_company_name', $company_name );
			update_post_meta( $post->ID, '_client_name', $client_name );
			update_post_meta( $post->ID, '_domain_hired', $domain_hired );
			update_post_meta( $post->ID, '_domain_hired_page_url', $domain_hired_page_url );
			update_post_meta( $post->ID, '_country', $country ); 
			update_post_meta( $post->ID, '_client_comp_vid_id', $client_comp_vid_id );
			update_post_meta( $post->ID, '_client_pic', $client_pic );
			update_post_meta( $post->ID, '_type', $type ); 
			update_post_meta( $post->ID, '_company_info', $company_info );
		} 	
	}
}
add_action( 'save_post', 've_testimonials_metabox_save' );
// Adding the Post Type Column in Testimonial Listing and allowing the sorting for the field 
if(!function_exists('show_testimonial_type')){
	function show_testimonial_type($columns){
		$new_columns = (is_array($columns)) ? $columns : array();
		//add column
		$new_columns['_type'] = __( 'Type'); 
		return $new_columns;
	}
}
add_filter( 'manage_edit-testimonial_columns', 'show_testimonial_type',6 );

if(!function_exists('show_testimonial_type_value')){
	function show_testimonial_type_value( $column, $postid ) {
		if ( $column == '_type' ) {
			echo get_post_meta( $postid, '_type', true );
		}
	}
}
add_action( 'manage_testimonial_posts_custom_column', 'show_testimonial_type_value', 10, 2 );

if(!function_exists('testimonial_type_sort')){
	function testimonial_type_sort( $columns ) {
		$custom = array(
			'_type'    => '_type'
		);
		return wp_parse_args( $custom, $columns );
	}
}
add_filter( "manage_edit-testimonial_sortable_columns", 'testimonial_type_sort' );
/*-------------------------------------------------
 End Testimonials
 ------------------------------------------------- */
