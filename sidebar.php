<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Virtual Employee
 * @since Virtual Employee 1.0
 */
?>
<?php if ( is_active_sidebar( 'blog-sidebar' )  ) : ?>
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
				<div class="newblog_rt_bg card-shadow">
					<div class="drkbl_bg_title col-md-12">
					<div class="tbl_cell wid_1">Follow:</div>
					<div class="tbl_cell text-right">
					<a href="https://twitter.com/virtualemp"> <i class="icon2-twitter wht_col"></i> </a>
					<a href="https://www.facebook.com/Virtual.Employee.Pvt.Ltd"> <i class="icon2-facebook wht_col"></i> </a>
					<a href="https://plus.google.com/101180966521196222258/posts"> <i class="icon2-gplus wht_col"></i> </a>
					<a href="https://www.linkedin.com/company/virtual-employee-pvt--ltd"> <i class="icon2-linkedin wht_col"></i> </a>
					<a href="http://www.youtube.com/user/virtualemployee/videos"> <i class="icon2-youtube wht_col"></i> </a>
					<a href="https://www.pinterest.com/virtualemployee/"> <i class="icon2-pinterest wht_col"></i> </a>
					<a href="http://feedburner.google.com/fb/a/mailverify?uri=virtualemployee"> <i class="icon2-rss wht_col"></i> </a>
					</div>
					
					</div>
					<div class="col-md-12 ">	
						<p class="popular_title">Popular Posts</p>
					<!--	<ul class="popular_post_list">
							<li>
								<div class="image"> <a href="JavaScript:;"><img src="<?php echo get_template_directory_uri(); ?>/images/rc-pst-1.JPG"></a></div>
								<div class="post-holder"> <a href="JavaScript:;">One Page Free HTML CSS Website Template</a> </div>
							</li>
							<li>
								<div class="image"> <a href="JavaScript:;"><img src="<?php echo get_template_directory_uri(); ?>/images/rc-pst-1.JPG"></a></div>
								<div class="post-holder"> <a href="JavaScript:;">One Page Free HTML CSS Website Template</a> </div>
							</li> 
							 
						</ul> -->
						<?php dynamic_sidebar( 'blog-sidebar' ); 
						
						//echo do_shortcode('[blog_popular_posts]');
						/*
						?>
						<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
						<div ng-app="myApp" ng-controller="namesCtrl">
						<ul class="popular_post_list">
					     <li ng-repeat="data in posts | orderBy:'order'">
						  <div class="image"> <a href="{{data.link}}"><img src="{{data.image}}"></a></div>
							<div class="post-holder"> <a href="{{data.link}}">{{data.title}}</a> </div>
					     </li>
					    </ul>
					 </div>
					
					<script>
					angular.module('myApp', []).controller('namesCtrl', function($scope, $http) {
						var responsePosts = $http.get("<?php echo admin_url( 'admin-ajax.php' )?>?action=get_post_post&type=ve_blog");
			               responsePosts.success(function(data) {
						 // console.log(data);
						   $scope.posts = data;
						   });
			                responsePosts.error(function(data) {
							alert("AJAX failed!");
						   });
		  
							});
					</script>
					<?php */?>
					</div>
				
				<div class="clearfix"></div>
				</div>
				
			</div>
<!-- .sidebar .widget-area -->
<?php endif; ?>
