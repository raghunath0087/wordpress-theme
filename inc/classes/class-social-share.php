<?php
// returns the content of $GLOBALS['post']
// if the page is called 'debug'
if(!function_exists('ve_content_filter'))
{
	function ve_content_filter($content) 
	{
	  $list_ve_share_on=get_option('ve_share_on'); 
	  $postType=$GLOBALS['post']->post_type;
	  $postLink=get_permalink($GLOBALS['post']->ID);
	  $postTitle=wp_slash($GLOBALS['post']->post_title);
	  $socialShareText='';
	  $ve_share_buttons=get_option('ve_share_buttons'); 
	  if($list_ve_share_on && $ve_share_buttons && in_array($postType, $list_ve_share_on)){
		
			  $socialShareText='<div id="ve-social-share" class="vesocial-share">';
				  foreach( $ve_share_buttons as $shareval)
				  {
						switch($shareval):
										case "fb":
										 $socialShareText.= '<a href="https://www.facebook.com/sharer/sharer.php?'.$postLink.'" class="blg_facebook ve-share"><i class="icon2-facebook"></i></a>';
										break;
										case "tw":
										 $socialShareText.= '<a href="https://www.twitter.com/share?url='.$postLink.'&text='.get_the_title().'" class="blg_twiter ve-share"><i class="icon2-twitter"></i></a>';
										break;
										case "li":
										 $socialShareText.= '<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$postLink.'&title='.$postTitle.'" class="blg_lnkd ve-share"><i class="icon2-linkedin"></i></a>';
										break;
										case "pi":
										$socialShareText.= '<a href="https://www.pinterest.com/pin/create/button/?url='.$postLink.'" class="blg_pntst ve-share"><i class="icon2-pinterest"></i></a>';
										break;
										case "gp":
										$socialShareText.= '<a href="https://plus.google.com/share?url='.$postLink.'" class="blg_gplus ve-share"><i class="icon2-gplus"></i></a>';
										break;
										default:
										$socialShareText.= '';
						endswitch;
					  
					  }
		  $socialShareText.= '</div>';
		  $socialShareText.= "<script>jQuery(document).ready(function() {
										jQuery('.ve-share').click(function(e) {
										e.preventDefault();
										window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
										return false;
										});
										});
								</script>";
	  }
	  // otherwise returns the database content
	  return $content.$socialShareText;
	}
}
add_filter( 'the_content', 've_content_filter' );
