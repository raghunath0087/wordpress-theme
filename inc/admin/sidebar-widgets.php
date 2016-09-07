<?php
/**
 * The template for managing all custom metabox fields
 * Displays all of the head element and everything up until the "site-content" div.
 * @package VirtualEmployee
 * @subpackage virtualemployee
 *
 */
if (!function_exists('virtualemployee_widgets_init')):
    function virtualemployee_widgets_init()
    {
        register_sidebar(array(
            'name' 				=> __('Blog Widget Area', 'virtualemployee'),
            'id' 				=> 'blog-sidebar',
            'description' 		=> __('Add widgets here to appear in your blog sidebar.', 'virtualemployee'),
            'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 		=> '</aside>',
            'before_title' 		=> '<h2 class="widget-title">',
            'after_title' 		=> '</h2>'
        ));
        register_sidebar(array(
            'name' 				=> __('Footer Widget Area', 'virtualemployee'),
            'id' 				=> 'footer-area',
            'description' 		=> __('Add widgets here to appear in your sidebar.', 'virtualemployee'),
            'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
            'after_widget' 		=> '</aside>',
            'before_title' 		=> '<h2 class="widget-title">',
            'after_title' 		=> '</h2>'
        ));
    }
endif;
add_action('widgets_init', 'virtualemployee_widgets_init');
