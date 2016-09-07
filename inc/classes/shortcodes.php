<?php
/**
 * Register all shortcode here
 *
 * @since Virtual Employee 1.0
 *
 */ 
 /** Start Social Share Buttons */
add_shortcode('ve_social','ve_content_filter');
 /** End Social Share Buttons */ 

/** Start Popular Share Buttons */ 
if(!function_exists('return_blog_popular_post'))
{
	function return_blog_popular_post($attr)
	{
		
	$args = array(
	'post_type'  	 => 've_blog',
	'posts_per_page' => 5,
	'meta_key'  	 => 've_post_count_views',
	'orderby'    	 => 'meta_value_num',
	'order'      	 => 'ASC',
	);
     $popularquery = get_posts( $args );
    // print_r(   $popularquery);
	 //$popularquery = new WP_Query( $args );
	
	$content='';
	if($popularquery)
	{
		$content.='<ul class="popular_post_list">';
		 foreach ( $popularquery as $post ) : 
			
			 $content.='<li>
							 <div class="image"> <a href="'.get_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a></div>
								<div class="post-holder"> <a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a> </div>
							</li>';
		endforeach;
		 $content.='</ul>';
		}
				 
	return $content;
	}
}
add_shortcode('blog_popular_posts','return_blog_popular_post');
/** End popular post shortocde */

/** Start Latest Share Buttons */ 
if(!function_exists('return_blog_latest_post'))
{
	function return_blog_latest_post($attr)
	{
	$count   =	3; 
	$heading ='From our Blog';
	if(isset($attr['heading']) && $attr['heading']!=''){ $heading =$attr['heading'];}
	if(isset($attr['count']) && $attr['count']!=''){ $count =$attr['count'];}
		
	$args = array(
	'post_type'  	 => 've_blog',
	'posts_per_page' => $count,
	);
     $popularquery = get_posts( $args );
    // print_r(   $popularquery);
	 //$popularquery = new WP_Query( $args );
	
	$content=' <h4 class="title">'.$heading.'</h4>';
	if($popularquery)
	{
		$content.='<div class="ve-bloglist-list">';
		 foreach ( $popularquery as $post ) : 
			
			 $content.='<div class="ve-bloglist-entry">
							 <a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a>
								<span class="ve-bloglist-entry-date">'.get_the_date('F j, Y',$post->ID).'</span>
							</div>';
		endforeach;
		 $content.='</div>';
		}
			
	 
	  
	return $content;
	}
}
add_shortcode('blog_latest_posts','return_blog_latest_post');
/** End latest post shortocde */

/** Start Faq shortcode */ 
if(!function_exists('return_ve_faq_post'))
{
	function return_ve_faq_post($attr)
	{
	$faqcontent='';
	$postLimit = isset($attr['limit']) ? $attr['limit'] : '-1';
	$heading = isset($attr['heading']) ? $attr['heading'] : '';
	$cattitle = isset($attr['title']) ? $attr['title'] : false;
	
	/** Start single FAQ category page * */ 
	
			$args = array(
			'post_type'  	 => 've_faq',
			'posts_per_page' => $postLimit,
			'orderby'    	 => 'menu_order',
			'order'      	 => 'ASC',
			);
		
		$faqcontent.='<div class="clearfix"></div><div class="ve_faq_section">';
		
		if(isset($attr['cat_slug']) && $attr['cat_slug']!='all')
			{
				  $args['tax_query'] = 
					array(
						array(
							'taxonomy' => 've_faq_term',
							'field'    => 'slug',
							'terms'    => $attr['cat_slug'],
							'operator' => 'IN'
						)
					);
				
				
				$term = get_term_by('slug', $attr['cat_slug'], 've_faq_term');
				
				$term_meta = get_option( "taxonomy_term_$term->term_id"); // Do the check
				$term_image		= $term_meta['ve_custom_term_image'] ? $term_meta['ve_custom_term_image'] : '';
									
				if($cattitle):
				$faqcontent.='<h2><span class="catimg"><img width="25px;" height="25px;" src="'.$term_image	.'"></span>'.$term->name.'</h2>';
				endif;
				
				if($heading!=''):
				$faqcontent.='<h2>'.$heading.'</h2><hr class="stick">';
			    endif;

				$faqquery = new WP_Query( $args);
				$jj=1;
				if ($faqquery->have_posts())
				{	
					$faqcontent.='<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
					
					 while ( $faqquery->have_posts() ): $faqquery->the_post();
					 if($jj==1)
					 { 
						 $firstdivid=get_the_ID(); 
						 $class='in';$collapsed='';
						 $jj++;
						 }else{
							 $collapsed='collapsed';
							  $class='';
							 }
						$faqcontent.='<div class="panel panel-default">';
						$faqcontent.='<div class="panel-heading" role="tab" id="heading'.get_the_ID().'">
												<h4 class="panel-title">
												<a class="'.$collapsed.'" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.get_the_ID().'" aria-expanded="false" aria-controls="collapse'.get_the_ID().'">'.get_the_title().'</a>
												</h4>
											</div>
											<div id="collapse'.get_the_ID().'" class="panel-collapse collapse '.$class.'" role="tabpanel" aria-labelledby="heading'.get_the_ID().'">
											  <div class="panel-body">'.get_the_content().'
											</div>
										</div>
									'; 
					 $faqcontent .='</div>';
					endwhile;
				 $faqcontent .='</div>';	 
				 }
				$faqcontent .='</div>';
		  }
	
	/** End single FAQ category page * */ 

	/**  Start All FAQ category page * */

			if(isset($attr['cat_slug']) && $attr['cat_slug']=='all')
						{		 
								$post_type='ve_faq';	
								$term_type='ve_faq_term';	
							
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
														'hide_empty' => false
														)
													);
								$newfilterAry = array();
								
								
								foreach($terms as $term) 
								{
									
									$updated_term 			= array();
									$term_meta 						    = get_option( "taxonomy_term_$term->term_id"); // Do the check
									$updated_term['id']			= $term->term_id;
									$updated_term['name']			= $term->name;
									$updated_term['slug']			= $term->slug;
									$updated_term['video_count']			= $term->count;
									$updated_term['order']			= $term_meta['ve_custom_term_sort_order'] ? (int) $term_meta['ve_custom_term_sort_order'] : 0;
									$updated_term['term_image']			= $term_meta['ve_custom_term_image'] ? $term_meta['ve_custom_term_image'] : '';
									//if($updated_term['video_count'] > 0){
										
									$postsList=get_posts(array(
													'post_type' 	=> $post_type,
													'post_status'   => 'publish',
													'posts_per_page'=> -1,
													'orderby'       =>'menu_order',
													'tax_query'     => array(
																		array(
																		'taxonomy' 	=> $term_type,
																		'field' 	=> 'term_id',
																		'terms' 	=> $term->term_id)
																		)
													)
												); 
										$updated_term['posts']=$postsList;
										//}
									$newfilterAry[] = $updated_term;
								
								}
							/** sorting category array */	
								$sortArray = array();
								foreach($newfilterAry as $person){
									foreach($person as $key=>$value){
										if(!isset($sortArray[$key])){
											$sortArray[$key] = array();
										}
										$sortArray[$key][] = $value;
									}
								}
								$orderby = "price"; //change this to whatever key you want from the array
								array_multisort($sortArray['order'],SORT_ASC,$newfilterAry);
						   /** end sorting category array */
					
					  
					  
					  $faqcontent.='<div class="frequently_asked">';
					  
					  $faqcontent.='<div class="faqs-sec-list">';
					  if($heading!=''){
					   $faqcontent.='<h3>'.$heading.'</h3><hr class="stick">';
			        	}
					  
					   $faqcontent.='<ul class="faqs-scrollspy">';
					   	foreach($terms as $termlist) 
								{
								$faqcontent.='<li><a class="scroll"  data-id="heading'.$termlist->slug.'"><i class="dots"></i>'.$termlist->name.'</a></li>';
								}
																					
						$faqcontent.='</ul><script>
											function scrollToAnchor(aid){
												 var aTag = $("div[name=\'"+ aid +"\']");
												jQuery("html,body").animate({scrollTop: aTag.offset().top},"slow");
											}
											jQuery(".scroll").click(function() {
											var dataid=jQuery(this).attr("data-id");
											   scrollToAnchor(dataid);
											});
											</script>';
									
					    $faqcontent.='</div>'; 
								
						   foreach($newfilterAry as $faqpostval)
						   {
							   
							  $jj=1;
							  $faqcontent.='<div class="'.$faqpostval['slug'].'" id="'.$faqpostval['id'].'" name="heading'.$faqpostval['slug'].'">';
							  $faqcontent.='<h3><span class="catimg"><img width="25px;" height="25px;" src="'.$faqpostval['term_image'].'"></span>'.$faqpostval['name'].'</h3>';
							  $faqcontent.='<div class="panel-group" id="accordion'.$faqpostval['slug'].'" role="tablist" aria-multiselectable="true">';
								/** start post section */
								foreach($faqpostval['posts'] as $postval ):
						        $postid=$postval->ID;
								if($jj==1)
									 { 
										 $firstdivid=get_the_ID(); 
										 $class='in';$collapsed='';
										 $jj++;
										 }else{
											 $collapsed='collapsed';
											  $class='';
											 }
											 
							$faqcontent.='<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="whowe-heading'.$postid.'">
								  <h4 class="panel-title">
									<a class="'.$collapsed.'" role="button" data-toggle="collapse" data-parent="#accordion'.$faqpostval['slug'].'" href="#whowe-collapse'.$postid.'" aria-expanded="false" aria-controls="whowe-collapse'.$postid.'">'.$postval->post_title.'
									</a>
								  </h4>
								</div>
								<div id="whowe-collapse'.$postid.'" class="panel-collapse collapse '.$class.'" role="tabpanel" aria-labelledby="whowe-heading'.$postid.'">
								  <div class="panel-body">'.$postval->post_content.'</div>
								</div>
							  </div>';
											 
			                     endforeach;
			                    /** end post section */
			                  
                            $faqcontent.='</div></div>';
							}
 
						$faqcontent.='</div></div>';

					 }
					 $faqcontent.='</div>';

			/** End single FAQ category page * */ 

  return $faqcontent;
 }
}
add_shortcode('ve_faq','return_ve_faq_post');
/** End Faq shortcode */


/** Start Faq shortcode */ 
if(!function_exists('return_ve_team_post'))
{
	function return_ve_team_post($attr)
	{
	$teamcontent='';
	$postLimit = isset($attr['limit']) ? $attr['limit'] : '-1';
	$heading = isset($attr['heading']) ? $attr['heading'] : '';
		
	$teampostsList=get_posts(array(
								'post_type' 	=> 've_team',
								'post_status'   => 'publish',
								'orderby'       => 'menu_order',
								'order'       => 'ASC',
								'posts_per_page'=> $postLimit,
							));
							 
	if(!empty($teampostsList)):
	
	$teamcontent ='<div class="ve_team"><ul class="row">';
	foreach($teampostsList as $teampostsval)
	{
		/** Start social links */
		$sociallinks=array();
		$fblink = get_post_meta($teampostsval->ID,'ve_team_facebook',true);
		
		if($fblink){
		$sociallinks['facebook-1']=$fblink ;}
		
		$twlink = get_post_meta($teampostsval->ID,'ve_team_twitter',true);
		if($twlink){
		$sociallinks['twitter']=$twlink;}
		
		$lilink = get_post_meta($teampostsval->ID,'ve_team_linkdin',true);
		if($lilink){
		$sociallinks['linkedin']=$lilink;}
		
		$gplink = get_post_meta($teampostsval->ID,'ve_team_google_plus',true);
		if($gplink){
		$sociallinks['gplus']=$gplink;}
		
		$pinitlink = get_post_meta($teampostsval->ID,'ve_team_pinit',true);
		if($pinitlink){
		$sociallinks['pinterest']=$pinitlink;}
		
		$ytlink = get_post_meta($teampostsval->ID,'ve_team_youtube',true);
		if($ytlink){
		$sociallinks['youtube']=$ytlink;}
		
		$skypelink = get_post_meta($teampostsval->ID,'ve_team_skype',true);
		if($skypelink){
		$sociallinks['skype']=$skypelink;}
		
		$maillink = get_post_meta($teampostsval->ID,'ve_team_social_link_email',true);
		if($maillink){
		$sociallinks['email']=$maillink;}
		
		/** End social links */

		$teamcontent.='<li class="col-sm-3">
		<figure><img class="img-responsive" width="220" height="218" alt="Narinder-Singh-Mahil" src="'.get_post_meta($teampostsval->ID,'ve_team_profile_pic',true).'"></figure>
		<article>
		<h4>'.$teampostsval->post_title.'</h4>
		<span><em>'.get_post_meta($teampostsval->ID,'ve_team_job_title',true).'</em></span>
		<p>'.get_post_meta($teampostsval->ID,'ve_team_text',true).'</p>';
		
		if(!empty($sociallinks))
		{
		 $teamcontent.='<ul class="share_ve">';
		 foreach($sociallinks as $key => $val)
		 {
		   $teamcontent.='<li class="'.$key.'"><a target="_blank" href="'.$val.'"><i class="icon2-'.$key.'"></i></a></li>';
	     }
		$teamcontent.='</ul>';
	    }
		
		$teamcontent.='</article>
		</li>';
		
		}
	$teamcontent .='</div></ul>';
	endif;
											
    return $teamcontent;
   }
 
}
add_shortcode('ve_team','return_ve_team_post');
/** End Faq shortcode */

add_action( 'wp_ajax_nopriv_get_ve_vidoes_post', 'get_ve_vidoes_post' );
add_action( 'wp_ajax_get_ve_vidoes_post', 'get_ve_vidoes_post' );
if(!function_exists('get_ve_vidoes_post')){
	function get_ve_vidoes_post() {
		 if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) 
		 { 
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
			exit;
			 }
	   }
	die();
	}
}

/** Start Video shortode */
if(!function_exists('return_ve_video_content')):
 function return_ve_video_content($attr)
 {  
	$hide_empty = isset($attr['hide_empty']) ? $attr['hide_empty']:'1';
	$exclude = isset($attr['exclude']) ? $attr['exclude']:'';
	$external = isset($attr['external']) ? $attr['external']:'';
	$playlist = isset($attr['playlist']) ? (int) $attr['playlist']: 0;

	 
	$content = '<!-- start video section --><section id="videoContainer"  ng-cloak ng-app="videoApp" ng-controller="videoCTRL">
	<div class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0 vido_main_cont '.($playlist ? 'playlist_custom_wd' : 'videocont_custom_wd' ).'">'; 
	
	$content .= '<!-- left panel --> ';
	$content .= '		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">{{categories}}
			<ul class="vido_ul web_show">
				
				<li ng-click="onClickTab(false)"> 
					<a href="#" ng-class="{active:isActiveTab(\'\')}"><i class="icon2-iphone-home"></i>All Videos</a> 
				</li>
				<li  ng-repeat="category in categories | orderBy: \'term_order\'" ng-click="onClickTab(category)"> 
					<a ng-href="{{category.external_link ? category.external_link : \'#\' + category.slug}}" ng-class="{active:isActiveTab(category.slug)}"><i class="{{category.icon}}"></i>{{category.name}}</a> 
				</li>
			</ul>
			
			<select class="form-control device_show" ng-model="currentCat" ng-change="switchTab()">
				<option value="">All Videos</option>
				<option value="{{category}}" ng-repeat="category in categories | orderBy: \'term_order\'" ng-selected="isActiveTab(category.slug)">{{category.name}}</option>
			</select>
		
		</div>';
	$content .= '<!-- end left panel --> ';
	
	$content .= '<!-- right panel --> ';
	/*  ALL Display */	
	$content .= '<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 vido_bdr_lft vido_cont_rgt over_hidden_sec "  ng-hide="\'\' != currentTab">
				<!-- Start row 2nd news video-->	
				<div ng-repeat="x in categories | filter : currentTab | orderBy: \'term_order\':false" ng-class="{\'row testi_media_lg bdr-tp-pdm\':$index==0,\'row bdr-tp-pdm\':$index!=0}">
					<div class="">
						<div class="col-md-12">
						<h1 class="vido_title rel_div ">
						{{x.name}}
						<span class="btns_all_Sec"><b class="vido_all_txt">{{x.video_count}} Video{{x.video_count == 1 ? \'\' : \'s\'}}</b><a ng-href="{{x.external_link ? x.external_link : \'#\' + x.slug}}" ng-click="onClickTab(x)" class="vido_all_btn" ng-show="x.video_count > limitVideos">View All</a></span>
						<span  class="tstmonls_btns_all_Sec" ng-show="x.slug == currentTab && x.sub_category.length > 0"> 
							<span class="rel_div">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-init="first_level=x.sub_category[0]" ng-change="setSubcategory(first_level)" ng-model="first_level"  ng-options="c as c.name for c in x.sub_category | orderBy:\'menu_order\':true track by c.id">
							   </select>
							</span>
							<span class="rel_div" ng-show="first_level.sub_category.length > 0">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-model="second_level"  ng-options="c as c.name for c in first_level.sub_category track by c.id">
							   </select>
							</span>							
						</span>						
						</h1>
						</div>
					</div>
					<div class="clearfix"></div>
					 <div ng-init="currentBox=second_level ? second_level : (first_level ? first_level : x)" ng-repeat="y in videos | filter : { catID: second_level ? second_level.id : (first_level ? first_level.id : x.id) }:true  | limitTo:limit = categories[0].slug==x.slug ? 2 : limitVideos | orderBy: \'order\':false" ng-class="{\'col-lg-4 col-md-4 col-sm-6 col-xs-12 sml_mrg_btm10 \': (currentBox.type == \'video\' && (categories[0].slug != x.slug || x.slug == currentTab) && currentBox.video_count > 2),\'col-lg-6 col-md-4 col-sm-6 col-xs-12 sml_mrg_btm10 text_tstmonls_cont\':(currentBox.type == \'text\'  || (categories[0].slug == x.slug && x.slug != currentTab) || currentBox.video_count < 3)}">  
						<!-- Video Starts -->
						<div class="tstmnls_card card-shadow  sub_vdo_hight wow fadeInUp min_ht_tstmnls" ng-if="y.videoLink">
							<div class="tstmnls_thumb_sec img_loader rel_div">
							<div ng-show={{y.rank}} class="sprites-icon tstmnls_wng_badge{{y.rank}}"></div>
							<div class="tstmnls_flag" ng-if="y.country!=\'\'"> <i class="flag flag-{{y.country|lowercase|spaceless}}"></i></div>
							<a  ng-href="https://www.youtube.com/watch?v={{y.videoLink}}" class="reldiv vido_playbtn video">
							<span class="play_div sml_play_div"> <i class="icon-play-circled"> </i></span>
							<img ng-src="{{y.image}}" alt="vido_1"/>
							</a>
							</div>
							<div class="tstmonls_cont_sec text-left">
								<div class="insec rel_div">
									<p class="tstmnls_client_name" ng-bind-html="y.title"></p>									
								</div>
							</div>
						</div>
						<!-- Video ENDS -->
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- End row 2nd news video-->
			<div class="clearfix"></div>
		</div>';
		
	if($playlist == 1){	
	/*  Category Display PLAYLIST */	
$content .= '<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 vido_bdr_lft vido_cont_rgt over_hidden_sec "  ng-show="\'\' != currentTab">
				<!-- Start row 2nd news video-->	
				<div class="row testi_media_lg bdr-tp-pdm" ng-repeat="x in categories | filter : currentTab | orderBy: \'term_order\':false">
					<div class="">
						<div class="col-md-12">
						<h1 class="vido_title rel_div ">
						{{x.name}}
						<span class="btns_all_Sec" ng-hide="(x.sub_category.length > 0)"><b class="vido_all_txt">{{x.video_count}} Video{{x.video_count == 1 ? \'\' : \'s\'}}</b></span>
						<span  class="tstmonls_btns_all_Sec" ng-show="x.sub_category.length > 0"> 
							<span class="rel_div">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-init="first_level=x.sub_category[0]" ng-change="setSubcategory(first_level)" ng-model="first_level"  ng-options="c as c.name for c in x.sub_category | orderBy:\'menu_order\':true track by c.id">
							   </select>
							</span>
							<span class="rel_div" ng-show="first_level.sub_category.length > 0">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-model="second_level"  ng-options="c as c.name for c in first_level.sub_category track by c.id">
							   </select>
							</span>							
						</span>
						</h1>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div ng-if="\'\' != currentTab" ng-init="currentBox=second_level ? second_level : (first_level ? first_level : x)">	
					<div  class="col-sm-8" ng-if="second_level ? second_level.type : (first_level ? first_level.type : x.type) == \'video\'">
						<div class="tstmnls_card card-shadow  sub_vdo_hight min_ht_tstmnls" ng-if="currentVideo.videoLink">
							<div class="tstmnls_thumb_sec img_loader rel_div">
							<div ng-show={{currentVideo.rank}} class="sprites-icon tstmnls_wng_badge{{currentVideo.rank}}"></div>
							<div class="tstmnls_flag"  ng-if="currentVideo.country==\'khkjh kjlh jkh kjhjkh kjh\'"> <i class="flag flag-{{currentVideo.country|lowercase}}"></i></div>
								<div class="iframeContainer"><iframe ng-src={{currentVideo.youtubeIframe()}}></iframe></iframe></div>
							</div>
							<div class="tstmonls_cont_sec text-left">
								<div class="insec rel_div">
									<p class="tstmnls_client_name" ng-bind-html="currentVideo.title"></p>
									<p class="tstmnls_client_info" ng-bind-html="currentVideo.company_name"></p>
									<div class="tstmnls_title" ng-show="currentVideo.content!=\'\'" ng-bind-html="currentVideo.content|nl2br"></div>
								</div>
							</div>
						</div>					
					</div>
					<div ng-scrollbars class="col-sm-4 custom_video_scrl_br" ng-if="second_level ? second_level.type : (first_level ? first_level.type : x.type) == \'video\'">
					<div ng-repeat="y in videos | filter : { catID: second_level ? second_level.id : (first_level ? first_level.id : x.id) }:true  | limitTo:limit = \'Infinity\'| orderBy: \'order\':false" ng-class="{\'col-sm-12 custom_video_scrl_hov active\':y.videoLink == currentVideo.videoLink,\'col-sm-12 custom_video_scrl_hov\':y.videoLink != currentVideo.videoLink}">
						<!-- Video Starts -->
						<div ng-if="$index == 0" ng-init="changeCurrentVideo(y)"></div>
						<div class="tstmnls_card com_tp_bt_5 sub_vdo_hight min_ht_tstmnls custom_video_scrl_hov_inside" ng-if="y.videoLink">
							<div class="tstmnls_thumb_sec img_loader rel_div custom_wd_40">
							<div ng-show={{y.rank}} class="sprites-icon tstmnls_wng_badge{{y.rank}}"></div>
							<div class="tstmnls_flag"  ng-if="y.country!=\'\'"> <i class="flag flag-{{y.country|lowercase|spaceless}}"></i></div>  
							<a  href="javascript:void(0);" ng-click="changeCurrentVideo(y)" class="reldiv vido_playbtn">
							<span class="play_div sml_play_div"> <i class="icon-play-circled"> </i></span>
							<img ng-src="{{y.image}}" alt="vido_1"/>
							</a>
							</div>
							<div class="tstmonls_cont_sec text-left  custom_wd_60">
								<div class="insec rel_div">
									<p class="tstmnls_client_name" ng-bind-html="y.title"></p>
								</div>
							</div>
						</div>
						<!-- Video ENDS -->
						<div class="clearfix"></div>
					</div>
					</div>
					<!-- Text Testimonials STARTS HERE -->
					<div class="text_tstmnls_masonry" ng-if="second_level ? second_level.type : (first_level ? first_level.type : x.type) == \'text\'">	
					 <div ng-repeat="y in videos | filter : { catID: second_level ? second_level.id : (first_level ? first_level.id : x.id) }:true  | limitTo:limit = \'Infinity\'| orderBy: \'order\':false" class="text_tstmonls_cont text_tstmnls_item">  
						<div class="tstmnls_card card-shadow  sub_vdo_hight wow fadeInUp min_ht_tstmnls text_tstmonls_gry_bg"  ng-if="!y.videoLink">
							<div class="tstmnls_thumb_sec  rel_div">
							<div class="tstmnls_flag"  ng-if="y.country!=\'\'"> <i class="flag flag-{{y.country|lowercase|spaceless}}"></i></div>
							 <p class="txt_quote"><i class="icon2-quote-left"></i></p>
							 </div>
							 <div class="text-left">
								<div class="insec ">
									<div class="tstmnls_title" ng-bind-html="y.content|nl2br"></div>
									<div class="reldiv_wd_pd text-center">
										 <p class="tstmnls_client_name" ng-bind-html="y.title"></p>
										 <p class="tstmnls_client_info" ng-bind-html="y.company_name"></p>
									</div>
								</div>
							</div>
						</div>						
						<div class="clearfix"></div>
					</div>
					</div>					
					<!-- Text Testimonials ENDS Here -->
					</div>
					
				</div>
				<!-- End row 2nd news video-->
			<div class="clearfix"></div>
		</div>';	
	} else {
	/*  Category Display DEFAULT */	
	$content .= '<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 vido_bdr_lft vido_cont_rgt over_hidden_sec "  ng-show="\'\' != currentTab">
				<!-- Start row 2nd news video-->	
				<div class="row testi_media_lg bdr-tp-pdm" ng-repeat="x in categories | filter : currentTab | orderBy: \'term_order\':false">
					<div class="">
						<div class="col-md-12">
						<h1 class="vido_title rel_div ">
						{{x.name}}
						<span class="btns_all_Sec" ng-hide="(x.sub_category.length > 0)"><b class="vido_all_txt">{{x.video_count}} Video{{x.video_count == 1 ? \'\' : \'s\'}}</b></span>
						<span  class="tstmonls_btns_all_Sec" ng-show="x.sub_category.length > 0"> 
							<span class="rel_div">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-init="first_level=x.sub_category[0]" ng-change="setSubcategory(first_level)" ng-model="first_level"  ng-options="c as c.name for c in x.sub_category | orderBy:\'menu_order\':true track by c.id">
							   </select>
							</span>
							<span class="rel_div" ng-show="first_level.sub_category.length > 0">
							   <span class="arrow" ></span> 
							   <select class="menulist active" ng-model="second_level"  ng-options="c as c.name for c in first_level.sub_category track by c.id">
							   </select>
							</span>							
						</span>
						</h1>
						</div>
					</div>
					<div class="clearfix"></div>
					<div ng-class="{\'video_inner_layout_all \': (second_level ? second_level.type : (first_level ? first_level.type : x.type) == \'video\'),\'text_tstmnls_masonry \': (second_level ? second_level.type : (first_level ? first_level.type : x.type) == \'text\')">	
					 <div ng-init="currentBox=second_level ? second_level : (first_level ? first_level : x)" ng-repeat="y in videos | filter : { catID: second_level ? second_level.id : (first_level ? first_level.id : x.id) }:true  | limitTo:limit = \'Infinity\'| orderBy: \'order\':false" ng-class="{\'col-lg-4 col-md-4 col-sm-6 col-xs-12 sml_mrg_btm10 \': (currentBox.type == \'video\') && currentBox.video_count > 2,\' text_tstmonls_cont text_tstmnls_item\':(currentBox.type == \'text\'),\'col-lg-6 col-md-4 col-sm-6 col-xs-12 sml_mrg_btm10\':(currentBox.video_count < 3)}">  
						<!-- Video Starts -->
						<div class="card-shadow  sub_vdo_hight wow fadeInUp min_ht_tstmnls" ng-if="y.videoLink">
							<div class="tstmnls_thumb_sec img_loader rel_div">
							<div ng-show={{y.rank}} class="sprites-icon tstmnls_wng_badge{{y.rank}}"></div>
							<div class="tstmnls_flag"  ng-if="y.country!=\'\'"> <i class="flag flag-{{y.country|lowercase|spaceless}}"></i></div>
							<a  ng-href="https://www.youtube.com/watch?v={{y.videoLink}}" class="reldiv vido_playbtn video">
							<span class="play_div sml_play_div"> <i class="icon-play-circled"> </i></span>
							<img ng-src="{{y.image}}" alt="vido_1"/>
							</a>
							</div>
							<div class="tstmonls_cont_sec text-left">
								<div class="insec rel_div">
									<p class="tstmnls_client_name" ng-bind-html="y.title"></p>
									<p class="tstmnls_client_info" ng-bind-html="y.company_name"></p>
									<div class="tstmnls_title" ng-show="y.content!=\'\'" ng-bind-html="y.content|nl2br"></div>
								</div>
							</div>
						</div>
						<!-- Video ENDS -->
						
						<!-- TEXT StARTS HERE -->
						<div class="tstmnls_card card-shadow  sub_vdo_hight wow fadeInUp min_ht_tstmnls text_tstmonls_gry_bg"  ng-if="!y.videoLink">
							<div class="tstmnls_thumb_sec  rel_div">
							<div class="tstmnls_flag"  ng-if="y.country!=\'\'"> <i class="flag flag-{{y.country|lowercase|spaceless}}"></i></div>
							 <p class="txt_quote"><i class="icon2-quote-left"></i></p>
							 </div>
							 <div class="text-left">
								<div class="insec ">
									<div class="tstmnls_title" ng-bind-html="y.content|nl2br"></div>
									<div class="reldiv_wd_pd text-center">
										 <p class="tstmnls_client_name" ng-bind-html="y.title"></p>
										 <p class="tstmnls_client_info" ng-bind-html="y.company_name"></p>
									</div>
								</div>
							</div>
						</div>						
						<!-- TEXT ENDS HERE -->
						
						<div class="clearfix"></div>
					</div>
					</div>
				</div>
				<!-- End row 2nd news video-->
			<div class="clearfix"></div>
		</div>';	
	}
	$content .= '<!-- end right panel --> ';
	
	$content .= '</div></section><!-- End video section -->';
	$content .= '<script src="'.get_template_directory_uri().'/js/jquery.mCustomScrollbar.concat.min.js"></script><script src="'.get_template_directory_uri().'/js/scrollbars.js"></script>';
	$content .= '<script>
			var app = angular.module(\'videoApp\', ["ngSanitize","ngScrollbars"]);
			app.filter(\'spaceless\',function() {
				return function(input) {
					if (input) {
						return input.replace(/\s+/g, \'-\');    
					}
				}
			});
			app.filter(\'nl2br\',function() {
				return function(input) {
					if (input) {
						return input.replace(/\n\r?/g, \'<br />\');   
					}
				}
			});			
			app.config(function (ScrollBarsProvider) {
			// scrollbar defaults
			ScrollBarsProvider.defaults = {
				autoHideScrollbar: false,
				setHeight: 600,
				scrollInertia: 500,
                theme: \'dark\',
				axis: \'yx\',
				advanced: {
					updateOnContentResize: true
				},
				scrollButtons: {
					scrollAmount: \'auto\', // scroll amount when button pressed
					enable: true // enable scrolling buttons by default
				}
			};
		});
	
			app.controller(\'videoCTRL\', function($scope, $http, $sce) {
			$scope.currentCat   = "";
			$scope.currentVideo = false;
			$scope.playlist   	= "'.$playlist.'";		  
			$scope.first_level  = "";
			$scope.second_level = "";
			$scope.limitVideos  = 3;
			$scope.categories   = [];
		  //console.log($scope.categories);
/*		  
$scope.$watch(function(){ 
    return window.innerWidth;
}, function(value) { console.log(value);
    if(value > 1000) {
		$scope.limitVideos = 3;
	} else {
		$scope.limitVideos = 2;
	}
});*/ 

		$scope.changeCurrentVideo = function(video){ 
			$scope.currentVideo = video;
			$scope.currentVideo.youtubeIframe = function(){  
				return $sce.trustAsResourceUrl("https://www.youtube.com/embed/" + $scope.currentVideo.videoLink + "?rel=0&enablejsapi=1&autoplay=1"); 
			}
		}

		function listToTree(data, options) {
		  options = options || {};
		  var ID_KEY = options.idKey || "id";
		  var PARENT_KEY = options.parentKey || "parent";
		  var CHILDREN_KEY = options.childrenKey || "children";

		  var tree = [],
			childrenOf = {};
		  var item, id, parentId;

		  for (var i = 0, length = data.length; i < length; i++) {
			item = data[i];
			id = item[ID_KEY];
			parentId = item[PARENT_KEY] || 0;
			// every item may have children
			childrenOf[id] = childrenOf[id] || [];
			// init its children
			item[CHILDREN_KEY] = childrenOf[id];
			if (parentId != 0) {
			  // init its parents children object
			  childrenOf[parentId] = childrenOf[parentId] || [];
			  // push it into its parents children object	  
			  childrenOf[parentId].push(item);
			} else {
			  tree.push(item);
			}
		  };
		  return tree;
		}
			
		$scope.currentTab = decodeURIComponent(window.location.hash.substr(1));
		  
		var responseInitPosts = $http.get("'.admin_url('admin-ajax.php').'?action=get_ve_vidoes_post&type=ve_videos&term_type=ve_videos_term&hide_empty='.$hide_empty.'&exclude='.$exclude.'&external='.$external.'&init=1");
		  
		function count_child(item,init_count){
			for(var j = 0; j < item.sub_category.length; j++){				
				if(item.sub_category[j].sub_category.length > 0) {
					item.sub_category[j].video_count = count_child(item.sub_category[j], item.sub_category[j].video_count);					
				}		
				if(item.sub_category[j].type == \'video\') {
					init_count += item.sub_category[j].video_count;
				}				
				
			}
			return init_count;
		}		
		  
		responseInitPosts.success(function(data) { 
			console.log("Server returned Init Data");
			console.log(data);
			data.terms.sort(function(a, b){return a.term_order-b.term_order});
			console.log("ORDERED CAT");
			console.log(data.terms);
			var tree = listToTree(data.terms, {
					  idKey: "id",
					  parentKey: "parent",
					  childrenKey: "sub_category"
					});
			console.log("HIERARCHICAL CAT");
			
			for(var i = 0; i < tree.length; i++) {
				
				if(tree[i].sub_category.length) {
					console.log("Before");
					console.log(tree[i]);
					tree[i].video_count = count_child(tree[i], tree[i].video_count);					
					console.log("Before");
					console.log(tree[i]);
				}
				
				
			}
			
			console.log(tree);			
			$scope.categories = tree;
			$scope.videos = data.posts;
			var responsePosts = $http.get("'.admin_url('admin-ajax.php').'?action=get_ve_vidoes_post&type=ve_videos&term_type=ve_videos_term&hide_empty='.$hide_empty.'&exclude='.$exclude.'&external='.$external.'&init=0");						  
			
			responsePosts.success(function(data) { 
				console.log(data);
				angular.forEach(data.posts, function(value, key) {
					$scope.videos.push(value);
				});
				//$scope.videos = data.posts;
			});
			responsePosts.error(function(data) {
				alert("AJAX failed!");
			});		  			
		});
		responseInitPosts.error(function(data) {
			alert("AJAX failed!");
		});		  
		
		$scope.refreshFilterVars = function(){
			$scope.first_level  = "";
			$scope.second_level = "";			
		}
		
			$scope.onClickTab = function (category) { 				
				$scope.refreshFilterVars();
				if(!category) 
				{
					category = {name:"",external_link:false,slug:\'\'};
					console.log(" CurrentVideo to false As All Videos link got clicked");
					$scope.currentVideo = false;
				}
				
				if(!category.external_link)
				{
										
					var scrollTop     = $(window).scrollTop(),
					elementOffset = $(".vido_title").offset().top,
					distance      = (elementOffset - scrollTop); 
					
					if(distance < 110){ 
						
						var offsetTop = $(window).width() > 767 ? 130 : 50;
						$("html,body").animate({scrollTop: $("#videoContainer").offset().top - offsetTop},800);						
						
					}

					$scope.currentTab = category.slug;					
				} 
			} 
			
			$scope.setSubcategory = function (firstLevel) {  console.log(firstLevel);
				$scope.second_level = firstLevel.sub_category[0];
			} 			
			
			$scope.switchTab = function () {
				$scope.refreshFilterVars();
				category = $scope.currentCat != "" ? JSON.parse($scope.currentCat) : $scope.currentCat;
				
				if(!category) 
				{
					category = {name:"",external_link:false,slug:\'\'};
				} 
				
				if(!category.external_link)
				{
					$scope.currentTab = category.slug;					
				} 
				else 
				{
					document.location.href = category.external_link; 
				} 				
			}			

			$scope.isActiveTab = function(tabUrl) {
			return tabUrl == $scope.currentTab;
			}		  
		});
		</script>';
	// As P tag is auto added on old site used this hack		
	return $content;
 }
endif;
add_shortcode('ve_videos','return_ve_video_content');
/**------------------------------------------------------
				End Video shortcode
------------------------------------------------------**/

/**------------------------------------------------------
				Start Twitter shortcode
------------------------------------------------------**/
if(!function_exists('ts_add_link_on_url_func')):
function ts_add_link_on_url_func($content) {   
    return preg_replace('![^\'"=](((f|ht)tp(s)?://)[-a-zA-ZÐ°-ÑÐ-Ð¯()0-9@:%_+.~#?&;//=]+)!i', ' <a href="$1" target="_blank">$1</a> ', $content);
} 
endif;

if(!function_exists('getConnectionWithAccessToken')):
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
return $connection;
}
endif;

if(!function_exists('ve_get_tweets_func')):
	function ve_get_tweets_func( $attr ) 
	{
		require_once get_template_directory() . '/inc/classes/lib/twitteroauth.php'; // include twitter lib file	
		/** Define twitter access details  */
		$twitteruser  		= 'virtualemp';
		$notweets 			= 5;
		$consumerkey 		= 'nVHyMmupy3iqkjeuoT9cQHg4r';
		$consumersecret 	= '5i04LM8zyPyf5pTUZSj9icoYnTDekueAtJjhvrk2Q8szRSPDQc';
		$accesstoken 		= '42588805-yoYjRhA11PwXPCUVQladom1VVITvAfgnxuA5ROPjB';
		$accesstokensecret 	= 'rTn10gLUQKRjUUbUJ0u0WcDIaIBb6eRVt7gUnUYqP8Nmz'; 
		$connection 		= getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		$tweets 			= $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
		
		$veTweetscontent='';
		$heading = isset($attr['heading']) ? $attr['heading'] :'';
		
		if($tweets)
			{
				$veTweetscontent.='<div class="col-md-12 bdr-top ">';
				if($heading!='')$veTweetscontent.='<h3 class="ve_tweets_heading">'.$heading.'</h3>';
				$veTweetscontent.='<ul class="ve_tweets">';
				//echo '<pre>'; print_r($tweets):
				 foreach ( $tweets as $tweet ) : 
				  /* $mediaArypath=$tweet->entities->media;
				 
				     $imgPath= isset($mediaArypath[0]->media_url) ? $mediaArypath[0]->media_url:''; */
				 
					 $updatedcontent=ts_add_link_on_url_func($tweet->text);	
					 $veTweetscontent.='<li>';
									$veTweetscontent.='	<div class="post-holder">'.$updatedcontent.'</div>
									    <span class="ts-slide-date">'.date('F jS Y h:m:s',strtotime($tweet->created_at)).'</span>
										
									</li>';
				endforeach;
				 $veTweetscontent.='</ul></div>';
				}
				
		return $veTweetscontent;
	}
endif;
add_shortcode( 've_tweets', 've_get_tweets_func' );

/**------------------------------------------------------
				END Twitter shortcode
------------------------------------------------------**/

/**------------------------------------------------------
				Start Lightbox Contact Form
------------------------------------------------------**/
if(!function_exists('ve_get_lightbox_form_func')):
	function ve_get_lightbox_form_func( $attr ) 
	{	
$lightboxFormHtml='<div class="remodal-overlay overlay_1"></div>
	<div class="remodal-wrapper remodal-box2">
    <div class="openfrm_box remodal remodal-is-initialized " tabindex="-1">
        <button aria-label="Close" class="remodal-close" data-remodal-action="close"></button>
        <div class="remodal_pd" id="lightbox_form_div">
            <h2 id="modal1Title">REQUEST A CALL BACK</h2>
            <p class="highlightBlue">Share your details to get a Call Back from us</p>
            <div id="modal1Desc">
                '.do_shortcode('[contact-form-7 id="29405" title="Lightbox Form"]').'
            </div>
        </div>
    </div>
</div>
<div id="ve_lb_country_list_val">
<option value="+1-" selected="selected"> US&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;United States </option>
<option value="+61-"> AU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Australia </option>
<option value="+44-"> GB&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;United Kingdom </option>
<option value="+91-"> IN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;India </option>
<option value="+966-"> SA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saudi Arabia </option>
<option value="+971-"> AE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;United Arab Emirates </option>
<option value="+1-"> CA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Canada </option>
<option value="+65-"> SG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Singapore </option>
<option value="+41-"> CH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Switzerland </option>
<option value="+27-"> ZA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;South Africa </option>
<option value="+358-"> AX&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Aland Islands </option>
<option value="+355-"> AL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Albania </option>
<option value="+213-"> DZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Algeria </option>
<option value="+1684-"> AS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;American Samoa </option>
<option value="+376-"> AD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Andorra </option>
<option value="+244-"> AO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Angola </option>
<option value="+1264-"> AI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Anguilla </option>
<option value="+672-"> AQ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Antarctica </option>
<option value="+1268-"> AG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Antigua and Barbuda </option>
<option value="+54-"> AR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Argentina </option>
<option value="+374-"> AM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Armenia </option>
<option value="+297-"> AW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Aruba </option>
<option value="+43-"> AT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Austria </option>
<option value="+994-"> AZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Azerbaijan </option>
<option value="+1242-"> BS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bahamas </option>
<option value="+973-"> BH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bahrain </option>
<option value="+880-"> BD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bangladesh </option>
<option value="+1246-"> BB&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Barbados </option>
<option value="+32-"> BE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Belgium </option>
<option value="+501-"> BZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Belize </option>
<option value="+229-"> BJ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Benin </option>
<option value="+1441-"> BM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bermuda </option>
<option value="+975-"> BT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bhutan </option>
<option value="+591-"> BO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bolivia </option>
<option value="+387-"> BA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bosnia and Herzegovina </option>
<option value="+267-"> BW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Botswana </option>
<option value="+47-"> BV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bouvet Island </option>
<option value="+55-"> BR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Brazil </option>
<option value="+246-"> IO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;British Indian Ocean Territory </option>
<option value="+673-"> BN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Brunei Darussalam </option>
<option value="+359-"> BG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bulgaria </option>
<option value="+226-"> BF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Burkina Faso </option>
<option value="+257-"> BI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Burundi </option>
<option value="+855-"> KH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cambodia </option>
<option value="+237-"> CM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cameroon </option>
<option value="+238-"> CV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cape Verde </option>
<option value="+599-"> BQ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Caribbean Netherlands </option>
<option value="+1345-"> KY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cayman Islands </option>
<option value="+236-"> CF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Central African Republic </option>
<option value="+235-"> TD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Chad </option>
<option value="+56-"> CL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Chile </option>
<option value="+86-"> CN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;China </option>
<option value="+61-"> CX&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Christmas Island </option>
<option value="+61-"> CC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cocos (Keeling) Islands </option>
<option value="+57-"> CO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Colombia </option>
<option value="+269-"> KM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Comoros </option>
<option value="+242-"> CG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Congo </option>
<option value="+243-"> CD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Congo, Democratic Republic of </option>
<option value="+682-"> CK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cook Islands </option>
<option value="+506-"> CR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Costa Rica </option>
<option value="+225-"> CI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cote d\'Ivoire </option>
<option value="+385-"> HR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Croatia </option>
<option value="+599-"> CW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Curacao </option>
<option value="+357-"> CY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Cyprus </option>
<option value="+420-"> CZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Czech Republic </option>
<option value="+45-"> DK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Denmark </option>
<option value="+253-"> DJ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Djibouti </option>
<option value="+1767-"> DM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Dominica </option>
<option value="+1809-"> DO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Dominican Republic </option>
<option value="+593-"> EC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Ecuador </option>
<option value="+20-"> EG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Egypt </option>
<option value="+503-"> SV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;El Salvador </option>
<option value="+240-"> GQ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Equatorial Guinea </option>
<option value="+291-"> ER&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Eritrea </option>
<option value="+372-"> EE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Estonia </option>
<option value="+251-"> ET&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Ethiopia </option>
<option value="+500-"> FK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Falkland Islands </option>
<option value="+298-"> FO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Faroe Islands </option>
<option value="+679-"> FJ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Fiji </option>
<option value="+358-"> FI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Finland </option>
<option value="+33-"> FR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;France </option>
<option value="+594-"> GF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;French Guiana </option>
<option value="+689-"> PF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;French Polynesia </option>
<option value="+262-"> TF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;French Southern Territories </option>
<option value="+241-"> GA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Gabon </option>
<option value="+220-"> GM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Gambia </option>
<option value="+995-"> GE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Georgia </option>
<option value="+49-"> DE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Germany </option>
<option value="+233-"> GH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Ghana </option>
<option value="+350-"> GI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Gibraltar </option>
<option value="+30-"> GR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Greece </option>
<option value="+299-"> GL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Greenland </option>
<option value="+1473-"> GD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Grenada </option>
<option value="+590-"> GP&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guadeloupe </option>
<option value="+1671-"> GU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guam </option>
<option value="+502-"> GT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guatemala </option>
<option value="+44-"> GG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guernsey </option>
<option value="+224-"> GN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guinea </option>
<option value="+245-"> GW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guinea-Bissau </option>
<option value="+592-"> GY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Guyana </option>
<option value="+509-"> HT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Haiti </option>
<option value="+-"> HM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Heard and McDonald Islands </option>
<option value="+504-"> HN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Honduras </option>
<option value="+852-"> HK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Hong Kong </option>
<option value="+36-"> HU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Hungary </option>
<option value="+354-"> IS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Iceland </option>
<option value="+62-"> ID&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Indonesia </option>
<option value="+964-"> IQ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Iraq </option>
<option value="+353-"> IE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Ireland </option>
<option value="+44-"> IM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Isle of Man </option>
<option value="+972-"> IL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Israel </option>
<option value="+39-"> IT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Italy </option>
<option value="+1876-"> JM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Jamaica </option>
<option value="+81-"> JP&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Japan </option>
<option value="+44-"> JE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Jersey </option>
<option value="+962-"> JO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Jordan </option>
<option value="+7-"> KZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kazakhstan </option>
<option value="+254-"> KE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kenya </option>
<option value="+686-"> KI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kiribati </option>
<option value="+965-"> KW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kuwait </option>
<option value="+996-"> KG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kyrgyzstan </option>
<option value="+856-"> LA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lao People\'s Democratic Republic </option>
<option value="+371-"> LV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Latvia </option>
<option value="+961-"> LB&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lebanon </option>
<option value="+266-"> LS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lesotho </option>
<option value="+231-"> LR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Liberia </option>
<option value="+218-"> LY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Libya </option>
<option value="+423-"> LI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Liechtenstein </option>
<option value="+370-"> LT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lithuania </option>
<option value="+352-"> LU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Luxembourg </option>
<option value="+853-"> MO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Macau </option>
<option value="+389-"> MK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Macedonia </option>
<option value="+261-"> MG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Madagascar </option>
<option value="+265-"> MW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Malawi </option>
<option value="+60-"> MY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Malaysia </option>
<option value="+960-"> MV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Maldives </option>
<option value="+223-"> ML&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mali </option>
<option value="+356-"> MT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Malta </option>
<option value="+692-"> MH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Marshall Islands </option>
<option value="+596-"> MQ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Martinique </option>
<option value="+222-"> MR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mauritania </option>
<option value="+230-"> MU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mauritius </option>
<option value="+262-"> YT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mayotte </option>
<option value="+52-"> MX&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mexico </option>
<option value="+691-"> FM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Micronesia, Federated States of </option>
<option value="+373-"> MD&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Moldova </option>
<option value="+377-"> MC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Monaco </option>
<option value="+976-"> MN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mongolia </option>
<option value="+382-"> ME&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Montenegro </option>
<option value="+1664-"> MS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Montserrat </option>
<option value="+212-"> MA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Morocco </option>
<option value="+258-"> MZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Mozambique </option>
<option value="+264-"> NA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Namibia </option>
<option value="+674-"> NR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nauru </option>
<option value="+977-"> NP&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nepal </option>
<option value="+687-"> NC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;New Caledonia </option>
<option value="+64-"> NZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;New Zealand </option>
<option value="+505-"> NI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nicaragua </option>
<option value="+227-"> NE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Niger </option>
<option value="+234-"> NG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nigeria </option>
<option value="+683-"> NU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Niue </option>
<option value="+672-"> NF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Norfolk Island </option>
<option value="+1670-"> MP&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Northern Mariana Islands </option>
<option value="+47-"> NO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Norway </option>
<option value="+968-"> OM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Oman </option>
<option value="+92-"> PK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Pakistan </option>
<option value="+680-"> PW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Palau </option>
<option value="+970-"> PS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Palestinian Territory, Occupied </option>
<option value="+507-"> PA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Panama </option>
<option value="+675-"> PG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Papua New Guinea </option>
<option value="+595-"> PY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Paraguay </option>
<option value="+51-"> PE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Peru </option>
<option value="+63-"> PH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Philippines </option>
<option value="+870-"> PN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Pitcairn </option>
<option value="+48-"> PL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Poland </option>
<option value="+351-"> PT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Portugal </option>
<option value="+1-"> PR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Puerto Rico </option>
<option value="+974-"> QA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Qatar </option>
<option value="+262-"> RE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Reunion </option>
<option value="+40-"> RO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Romania </option>
<option value="+7-"> RU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Russian Federation </option>
<option value="+250-"> RW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Rwanda </option>
<option value="+590-"> BL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint Barthelemy </option>
<option value="+290-"> SH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint Helena </option>
<option value="+1869-"> KN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint Kitts and Nevis </option>
<option value="+1758-"> LC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint Lucia </option>
<option value="+1784-"> VC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint Vincent and the Grenadines </option>
<option value="+1599-"> MF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint-Martin (France) </option>
<option value="+1721-"> SX&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Saint-Martin (Pays-Bas) </option>
<option value="+685-"> WS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Samoa </option>
<option value="+378-"> SM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;San Marino </option>
<option value="+239-"> ST&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Sao Tome and Principe </option>
<option value="+221-"> SN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Senegal </option>
<option value="+381-"> RS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Serbia </option>
<option value="+248-"> SC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Seychelles </option>
<option value="+232-"> SL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Sierra Leone </option>
<option value="+421-"> SK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Slovakia (Slovak Republic) </option>
<option value="+386-"> SI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Slovenia </option>
<option value="+677-"> SB&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Solomon Islands </option>
<option value="+252-"> SO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Somalia </option>
<option value="+500-"> GS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;South Georgia and the South Sandwich Islands </option>
<option value="+82-"> KR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;South Korea </option>
<option value="+211-"> SS&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;South Sudan </option>
<option value="+34-"> ES&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Spain </option>
<option value="+94-"> LK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Sri Lanka </option>
<option value="+508-"> PM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;St. Pierre and Miquelon </option>
<option value="+597-"> SR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Suriname </option>
<option value="+47-"> SJ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Svalbard and Jan Mayen Islands </option>
<option value="+268-"> SZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Swaziland </option>
<option value="+46-"> SE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Sweden </option>
<option value="+886-"> TW&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Taiwan </option>
<option value="+992-"> TJ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tajikistan </option>
<option value="+255-"> TZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tanzania </option>
<option value="+66-"> TH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Thailand </option>
<option value="+31-"> NL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;The Netherlands </option>
<option value="+670-"> TL&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Timor-Leste </option>
<option value="+228-"> TG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Togo </option>
<option value="+690-"> TK&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tokelau </option>
<option value="+676-"> TO&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tonga </option>
<option value="+1868-"> TT&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Trinidad and Tobago </option>
<option value="+216-"> TN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tunisia </option>
<option value="+90-"> TR&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Turkey </option>
<option value="+993-"> TM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Turkmenistan </option>
<option value="+1649-"> TC&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Turks and Caicos Islands </option>
<option value="+688-"> TV&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tuvalu </option>
<option value="+256-"> UG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Uganda </option>
<option value="+380-"> UA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Ukraine </option>
<option value="+699-"> UM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;United States Minor Outlying Islands </option>
<option value="+598-"> UY&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Uruguay </option>
<option value="+998-"> UZ&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Uzbekistan </option>
<option value="+678-"> VU&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Vanuatu </option>
<option value="+39-"> VA&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Vatican </option>
<option value="+58-"> VE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Venezuela </option>
<option value="+84-"> VN&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Vietnam </option>
<option value="+1284-"> VG&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Virgin Islands (British) </option>
<option value="+1340-"> VI&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Virgin Islands (U.S.) </option>
<option value="+681-"> WF&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Wallis and Futuna Islands </option>
<option value="+212-"> EH&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Western Sahara </option>
<option value="+967-"> YE&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Yemen </option>
<option value="+260-"> ZM&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Zambia </option>
</div>
<style type="text/css">
#modal1Title { font-weight: bold; padding: 16px 0; background: #000; color: #fff; font-size: 17px; margin: 0px; } .highlightBlue{margin: 13px 0px; font-size: 16px; padding: 0px; color: rgb(0, 174, 239);} textarea#message-lb { height: auto; }  .cntr_tx { text-align: center; }  .xdsoft_datetimepicker { z-index: 10000 !important; }  select#select_country_lb { width: 12%; padding: 0px; display: inline-block;margin-right: 4px; }.country_code_span { display: inline-block; height: 40px; line-height: 40px; padding: 0; position: absolute; text-align: center; width: 14%; z-index:9;}  #phone-lb { display: inline-block; padding-left: 15%; width: 86.2%; }  .custom_button, .remodal, .remodal-wrapper:after { vertical-align: middle }  .custom_fgroup { font: 400 14px arial; text-align: left }  .custom_button, .custom_fgroup .form-group .form-control { font-size: 14px; background-color: #fff }  .custom_fgroup .form-group { margin-bottom: 15px }  .custom_fgroup .form-group label { display: inline-block; font-weight: 700; margin-bottom: 5px; max-width: 100% }  .custom_fgroup .form-group .form-control { border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 1px 1px rgba(0, 0, 0, .075) inset; color: #555; display: block; height: 40px; line-height: 1.42857; padding: 6px 12px; transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s; width: 100% }  .custom_fgroup .form-group .checkbox, .custom_fgroup .form-group .radio { display: block; margin-top: 10px; position: relative; cursor: pointer; font-weight: 400; margin-bottom: 0; min-height: 20px; padding-left: 20px }  .custom_fgroup .form-group .checkbox input[type=checkbox], .custom_fgroup .form-group .checkbox-inline input[type=checkbox], .custom_fgroup .form-group .radio input[type=radio], .custom_fgroup .form-group .radio-inline input[type=radio] { margin-left: -20px; position: absolute }  .custom_fgroup .form-group input[type=checkbox], .custom_fgroup .form-group input[type=radio] { line-height: normal; margin: 4px 0 0 }  .custom_button { -moz-user-select: none; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; display: inline-block; font-weight: 400; line-height: 1.42857; margin-bottom: 0; padding: 6px 12px; text-align: center; white-space: nowrap; color: #333 }  .custom_button:hover { background-color: #e6e6e6; border-color: #adadad }  .custom_fgroup .form-control:focus { border-color: #66afe9; box-shadow: 0 1px 1px rgba(0, 0, 0, .075) inset, 0 0 8px rgba(102, 175, 233, .6); outline: 0 }  html.remodal-is-locked { overflow: hidden; -ms-touch-action: none; touch-action: none }  .remodal, [data-remodal-id] { display: none }  .remodal-overlay { position: fixed; z-index: 10000; top: -5000px; right: -5000px; bottom: -5000px; left: -5000px; display: none; background: rgba(43, 46, 56, .9) }  .remodal-wrapper { position: fixed; z-index: 10000; top: 0; right: 0; bottom: 0; left: 0; display: none; overflow: auto; text-align: center; -webkit-overflow-scrolling: touch; padding: 10px 10px 0 }  .remodal-wrapper:after { display: inline-block; height: 100%; margin-left: -.05em; content: "" }  .remodal-overlay, .remodal-wrapper { -webkit-backface-visibility: hidden; backface-visibility: hidden }  .remodal { position: relative; outline: 0; -webkit-text-size-adjust: 100%; -moz-text-size-adjust: 100%; -ms-text-size-adjust: 100%; text-size-adjust: 100%; -webkit-box-sizing: border-box; box-sizing: border-box; width: 100%; margin-bottom: 10px; padding:0px; -webkit-transform: translate3d(0, 0, 0); transform: translate3d(0, 0, 0); color: #2b2e38; background: #fff }  .remodal-cancel, .remodal-close, .remodal-confirm { overflow: visible; margin: 0; cursor: pointer; text-decoration: none; outline: 0; border: 0 }  .remodal-is-initialized { display: inline-block }  .remodal-close, .remodal-close:before { position: absolute; top: 0; right: 0; display: block; width: 24px; }  .remodal-bg.remodal-is-opened, .remodal-bg.remodal-is-opening { -webkit-filter: blur(3px); filter: blur(3px) }  .remodal-overlay.remodal-is-closing, .remodal-overlay.remodal-is-opening { -webkit-animation-duration: .3s; animation-duration: .3s; -webkit-animation-fill-mode: forwards; animation-fill-mode: forwards }  .remodal-overlay.remodal-is-opening { -webkit-animation-name: remodal-overlay-opening-keyframes; animation-name: remodal-overlay-opening-keyframes }  .remodal-overlay.remodal-is-closing { -webkit-animation-name: remodal-overlay-closing-keyframes; animation-name: remodal-overlay-closing-keyframes }  .remodal.remodal-is-closing, .remodal.remodal-is-opening { -webkit-animation-duration: .3s; animation-duration: .3s; -webkit-animation-fill-mode: forwards; animation-fill-mode: forwards }  .remodal.remodal-is-opening { -webkit-animation-name: remodal-opening-keyframes; animation-name: remodal-opening-keyframes }  .remodal.remodal-is-closing { -webkit-animation-name: remodal-closing-keyframes; animation-name: remodal-closing-keyframes }  .remodal-close { height: 24px; padding: 0; -webkit-transition: color .2s; transition: color .2s; color: #fff; border-radius: 0; background: transparent; }  .remodal-close:focus, .remodal-close:hover { background: #c0c0c0; color: #fff; border-radius: 0; }  .remodal-close:before { font-family: Arial, "Helvetica CY", "Nimbus Sans L", sans-serif!important; font-size: 23px; line-height: 24px; content: "\00d7"; text-align: center }  .remodal-cancel, .remodal-confirm { font: inherit; display: inline-block; min-width: 110px; padding: 12px 0; -webkit-transition: background .2s; transition: background .2s; text-align: center; vertical-align: middle }  .remodal-confirm { color: #fff; background: #81c784 }  .remodal-confirm:focus, .remodal-confirm:hover { background: #66bb6a }  .remodal-cancel { color: #fff; background: #e57373 }  .remodal-cancel:focus, .remodal-cancel:hover { background: #ef5350 }  .remodal-cancel::-moz-focus-inner, .remodal-close::-moz-focus-inner, .remodal-confirm::-moz-focus-inner { padding: 0; border: 0 }  @-webkit-keyframes remodal-opening-keyframes { from { -webkit-transform: scale(1.05); transform: scale(1.05); opacity: 0 } to { -webkit-transform: none; transform: none; opacity: 1 } }  @keyframes remodal-opening-keyframes { from { -webkit-transform: scale(1.05); transform: scale(1.05); opacity: 0 } to { -webkit-transform: none; transform: none; opacity: 1 } }  @-webkit-keyframes remodal-closing-keyframes { from { -webkit-transform: scale(1); transform: scale(1); opacity: 1 } to { -webkit-transform: scale(.95); transform: scale(.95); opacity: 0 } }  @keyframes remodal-closing-keyframes { from { -webkit-transform: scale(1); transform: scale(1); opacity: 1 } to { -webkit-transform: scale(.95); transform: scale(.95); opacity: 0 } }  @-webkit-keyframes remodal-overlay-opening-keyframes { from { opacity: 0 } to { opacity: 1 } }  @keyframes remodal-overlay-opening-keyframes { from { opacity: 0 } to { opacity: 1 } }  @-webkit-keyframes remodal-overlay-closing-keyframes { from { opacity: 1 } to { opacity: 0 } }  @keyframes remodal-overlay-closing-keyframes { from { opacity: 1 } to { opacity: 0 } }  @media only screen and (min-width:641px) { .remodal { max-width: 700px } .openfrm_box.remodal { max-width: 400px } }  .lt-ie9 .remodal-overlay { background: #2b2e38 }  .lt-ie9 .remodal { width: 700px }  .rel_dv_country { position: relative; }  .error-msg-lb { border-bottom: 1px solid red; border-radius: 2px; margin: 0 0 13px; color: red; }  .success-msg-lb { border-bottom: 1px solid #88ca34; border-radius: 2px; margin: 0 0 13px; color: #88ca34; } #modal1Desc{padding:0 25px 25px;}
</style>
<script>
jQuery(document).ready(function(){
jQuery(".ve_lb_country_list").html("");jQuery(".ve_lb_country_list").append(jQuery("#ve_lb_country_list_val").html());jQuery("#ve_lb_country_list_val").html("");
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(";");
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==" ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

var leave_msg_for_urls = ["/services/it-outsourcing/hire-php-developer", "/service/dot-net-developer-india", "/service/asp-dot-net-developer", "/service/c-sharp-developer", "/service/sharepoint-developer", "/service/umbraco-developer", "/service/vb-dot-net-developer", "/services/it-outsourcing/hire-ajax-developers", "/services/it-outsourcing/cms-programmer", "/services/it-outsourcing/database-programmer", "/services/it-outsourcing/magento-developers", "/services/it-outsourcing/drupal-developers", "/services/software-developers", "/services/it-outsourcing/wordpress-developer", "/services/it-outsourcing/zend-developers",
	"/services/python-developers", "/services/xamarin-developers", "/services/internet-marketing", "/services/seo-service", "/services/pay-per-click", "/services/content-marketing", "/services/social-media-marketing", "/services/video-marketing", "/services/content-writers", "/services/mobile-apps-development", "/services/mobile-apps-development/hire-android-developer", "/services/mobile-apps-development/hire-ios-app-developer", "/services/mobile-apps-development/hire-windows-mobile-app-developers", "/services/mobile-apps-development/hire-mobile-game-developer", "/services/hire-dedicated-designers/hire-web-designer", "/services/front-end-developers", "/services/hire-dedicated-designers/hire-logo-designers", "/services/hire-dedicated-designers/hire-graphic-designer", "/services/hire-dedicated-designers/hire-photoshop-artist", "/services/hire-dedicated-designers/hire-indesign-expert", "/services/hire-dedicated-designers/hire-business-card-designers", "/services/hire-dedicated-designers/hire-illustrator-online", "/services/engineers-architects/hire-cad-designer", "/services/multimedia-animation", "/services/engineers-architects/hire-embedded-hardware-developer", "/services/data-entry", "/services/microsoft-office-specialists", "/services/assistant","/services/it-support", "/services/medical-process-outsourcing/hire-dedicated-medical-image-editors", "/services/patent"];
	
jQuery("body").append("<style>.img_pop_closer{position:absolute;right:0px;top:0px;background:#ccc;}.remodal-box1{display:none; text-align:center; z-index:10001; position:fixed;top:25%; right:0;left:0;bottom:0;}.remodal-box1:after{height:100%;display:inline-block; content:\"\";vertical-align:middle;}</style><div class=\"remodal-overlay overlay_2\"></div><div class=\"remodal-box1\" style=\"\"><div style=\"position:relative;display:inline-block;\"> <button aria-label=\"Close\" class=\"remodal-close img_pop_closer\"  data-remodal-action=\"close\"></button> <a style=\"display:block;\" href=\"/free-trial\"><img src=\"/wp-content/uploads/ve_assets/common/get-free-trial.jpg\" alt=\"Free Trail\" title=\"Get Free Trial\"></a></div>");	

jQuery( "body" ).mousemove(function( event ) {
	if(getCookie("shown_pop_up_exit") == 1) {
		return false;
	}
	var show_leave_msg = leave_msg_for_urls.indexOf(document.location.pathname); 
	
	if(show_leave_msg >= 0){  
		if(event.pageY - jQuery(window).scrollTop() < 10) { 
			setCookie("shown_pop_up_exit",1,1);
			jQuery(".overlay_2").show();
			jQuery(".remodal-box1").show();		
		}
	}	

});

	jQuery(".img_pop_closer").click(function(){
				jQuery(".overlay_2").hide();
				jQuery(".remodal-box1").hide();	
	});
	jQuery(".remodal-close").click(function(){ 
		jQuery(".overlay_1").hide();jQuery(".remodal-box2").hide(); 
	}); 
	jQuery("#request_a_call_back_top").click(function(){
		jQuery(".overlay_1").show();jQuery(".remodal-box2").show();
	});	
	jQuery("#select_country_lb").on("change",function()
	{
		jQuery(".country_code_span").text(jQuery(this).val());
		jQuery(".country_code_span").val(jQuery(this).val());
	});
	
})


</script>';


$lightboxFormHtml.='';
				
		return $lightboxFormHtml;
	}
endif;
add_shortcode( 've_request_a_callback', 've_get_lightbox_form_func' );

add_action('wp_footer', 'add_footer_request_a_call_modal');
function add_footer_request_a_call_modal() {
  echo do_shortcode('[ve_request_a_callback]');
}

/**------------------------------------------------------
				END Lightbox contact form shortcode
------------------------------------------------------**/
