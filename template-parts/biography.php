<?php
/**
 * The template part for displaying an Author biography
 *
 * @package VirtualEmployee
 */
?>

<div class="about_author">
					<h5> About the Author </h5>
					<div class="avatar">
					<?php 
					 $authorpic=get_the_author_meta( 'user_pic' );
						if($authorpic!=''):
							echo '<img src="'.$authorpic.'" >';
						endif; 
					 ?>
					</div>
					<div class="description">
					<?php 
					    $authorDescription=get_the_author_meta( 'description' );
						if($authorDescription!=''):
							echo '<p>'.$authorDescription.'</p>';
						endif; 
					 ?>
					
					<p> <a href="https://twitter.com/virtualemp" class="follow_btn" target="_blank">Follow On Twitter</a> <a class="follow_btn" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"> More Content by Author</a></p>
					</div>
					<div class="clearfix"></div>
				</div>
