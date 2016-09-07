<?php
if(!function_exists('add_inline_scrpit_blog')):
	function add_inline_scrpit_blog()
	{
		if ( is_page_template('blog-list.php') ) 
		{
          echo "hello ccc";
			} 
		}
endif;
add_action('wp_enqueue_scripts','add_inline_scrpit_blog');
