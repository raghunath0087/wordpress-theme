<!DOCTYPE html> 
 <html class="not-ie no-js" dir="ltr" lang="en-US" prefix="og: http://ogp.me/ns#">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="msvalidate.01" content="931660CADD5D12A9859FAD74C0C00E59"/>
	<meta name="p:domain_verify" content="5f814898d171720f1054d0f43ce2c5db"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php 
	/** START favicon */
	$favicon = get_option( 've_favicon' );?>
	<?php if($favicon==''){$favicon_path=get_template_directory_uri().'/images/fav-icon.png';}else{$favicon_path=$favicon;}?>
	<link rel="icon" href="<?php echo $favicon_path; ?>/images/fav-icon.png">
	<?php 
	/** END favicon */ ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">	
	<link rel="alternate" hreflang="en-us" href="http://localhost/ve/">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="publisher" href="https://plus.google.com/+Virtualemployee"/>
     
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style-ie8.min.css">
    <script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js"></script>
	<![endif]-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script> 
	<![endif]-->
	<?php wp_head(); ?>
 </head>
<body <?php body_class(); ?>>
<!-- Start Header Section -->
<header> 
<div class="container pd_tb_8">
	<ul class="row_sales text-center">
		<li><a href="skype:narinderve?call"><i class="icon-skype bl_col"/></i>Video Call Us </a></li>
		<li><a href="mailto:sales@virtualemployee.com"><i class="icon-mail bl_col"></i>sales@virtualemployee.com</a></li>  
		<li><a alt="Request a Call Back" href="javascript:;" id="request_a_call_back_top"><span class="office-time"><i class="sprites-icon office-help"></i>Request a Call Back</span></a></li>    
		<li><a href="tel:+18776978006" onclick="ga('send', 'event', 'skypecallUSA', 'callclick', '8776978006', 1);"><span title="VE US Phone Number to Contact Us" class="sprites-icon usa"></span>(+1)&nbsp;8776978006</a></li>
		<li><a class="country-phone-no" href="tel:+14169158941" onclick="ga('send', 'event', 'skypecallCAN', 'callclick', '4169158941', 1);"><span title="VE Canada Phone Number to Contact Us" class="sprites-icon canada"></span>(+1)&nbsp;4169158941</a></li>
		<li><a class="country-phone-no" href="tel:+442034785941" onclick="ga('send', 'event', 'skypecallUK', 'callclick', '2034785941', 1);"><span title="VE UK Phone Number to Contact Us" class="sprites-icon uk"></span>(+44)&nbsp;2034785941</a></li>
		<li><a class="country-phone-no" href="tel:+61280733418" onclick="ga('send', 'event', 'skypecallAUS', 'callclick', '280733418', 1);"><span title="VE Australia Phone Number to Contact Us" class="sprites-icon au"></span>(+61)&nbsp;280733418</a></li>
	</ul>
</div> 
</header>
<div class="header">
  <div class="container-fluid">
    <div class="col-md-3">
	<?php /** START LOGO */
		$logo = get_option( 've_logo' );?>
	<?php if($logo==''){$logo_path=get_template_directory_uri().'/images/logo.png';}else{$logo_path=$logo;}?>
		<a class="navbar-brand" href="<?php echo home_url();?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $logo_path; ?>" class="img-responsive" width="233" height="49" alt="<?php bloginfo('name'); ?>"/></a>
   <?php /** END LOGO */ ?>
	</div>
    <div class="col-md-9">
    <div class="menu-bar snd_req">
        <div id="get-started">
            <ul class="menu pull-left">
                <li class="">
               	 <a class="header_cta" title="Click here to get started with VirtualEmployee.com" href="<?php echo get_site_url(); ?>/get-started" onclick="ga('send', 'event', 'getstarted', 'gotoform', {'page': '/get-started'});">Send Us Your Requirement</a> 
                </li>
            </ul>
        </div>
    </div>		
	<div class="menu-bar"> <a id="menu-toggle" href="javascript:void(0);"><i class="icon-menu"></i></a>
        <nav>
		<?php 
			wp_nav_menu( array(
				'menu' => 'Top Nav',
				'container' => '',
				'link_after'    => '<span class="sub-arrow"><i class="icon-down-open-1"></i></span>',
				'items_wrap' => '<ul id="%1$s" class="%2$s reset" role="navigation">%3$s</ul>'
			) );
		?>	
		</nav>
      </div>
    </div>
  </div>
</div>
 <!-- End Header Section -->
