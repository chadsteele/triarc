<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/creative.min.css" type="text/css" media="screen" />

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" type="text/css" media="screen" />

	<!-- fonts -->
	<link href="<?php echo get_stylesheet_directory_uri(); ?>/genericons/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,400i,500,500i,700,700i|Raleway:400,400i,600,600i,800,800i,900,900i" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/blog-style.css" type="text/css" media="screen" />

  
    


	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page-top">

	<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
       
            <?php wp_nav_menu( array( 'theme_location' => 'main-nav',
			'menu_class' => 'menu navbar-nav ml-auto'  ) ); ?>
    

        </div>
      </div>
    </nav>
</div>
<!-- .sidebar -->

   <!-- <header id="headerInner">  /* Suppress the search bar in the Header - by JHazelwood 11Oct2017 */
    <div class="Explore_input">

      <form method="get" id="searchform" class="search-form" action="<?php echo get_permalink(WAZEE_SITE_TEMPLATE_SEARCH_RESULTS); ?>">
          <label for="s" class="assistive-text">
          <span class="screen-reader-text"><?php _e( 'Search', 'twentyfifteen' ); ?></span>
          <input type="search" class="field search-field" name="q" id="s" placeholder="<?php esc_attr_e( 'Explore TRIARC now…', 'twentyfifteen' ); ?>" />
          </label>

          <input type="submit" class="submit search-submit screen-reader-text" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyfifteen' ); ?>" />
      </form>

     
    </div>
	</header> -->

