<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<section class="footer">
        <div class="container">
            <div class="row footer-menu">
                <div class="col-lg-2 text-center">
                    <?php  wp_nav_menu( array( 'theme_location' => 'footer_1', 'container_class' =>'footer_menu' ) ); ?>
                </div>
                <div class="col-lg-2 text-center">
                    <?php  wp_nav_menu( array( 'theme_location' => 'footer_2', 'container_class' =>'footer_menu' ) ); ?>
                </div>
                <div class="col-lg-2 text-center">
                    <?php  wp_nav_menu( array( 'theme_location' => 'footer_3', 'container_class' =>'footer_menu' ) ); ?>
                </div>
                <div class="col-lg-2 text-center">
                    <?php  wp_nav_menu( array( 'theme_location' => 'footer_4', 'container_class' =>'footer_menu' ) ); ?>
                </div>
                <div class="col-lg-2 text-center">
                    <!-- <?php  wp_nav_menu( array( 'theme_location' => 'footer_5', 'container_class' =>'footer_menu' ) ); ?> -->
                </div>
                <div class="col-lg-2 text-center">
                    <!-- <?php  wp_nav_menu( array( 'theme_location' => 'footer_6', 'container_class' =>'footer_menu' ) ); ?> -->
                </div>
            </div>
            <div class="row footer-section">
                <div class="col-md-6 col-sm-12 col-xl-8">
                    <div class="footer-logo">
                        <a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/footer_logo.png"></a>
                    </div>
                    <div>
                        <a target="_blank" href="https://www.facebook.com/firehorsearc/"><span class="fa fa-facebook-square fa-2x"></span></a>
                        <a target="_blank" href="https://twitter.com/firehorse_arc"><span class="fa fa-twitter-square fa-2x"></span></a>
                        <a target="_blank" href="https://www.linkedin.com/company/6431799/"><span class="fa fa-linkedin-square fa-2x"></span></a>
                        <a target="_blank" href="https://www.instagram.com/firehorse_arc/"><span class="fa fa-instagram fa-2x"></span></a>
                    </div>

                    <div class="col-lg-12">
                    <div class="sub-footer">
                        <a href="#">Privacy Policy</a> |
                        <a href="#">Terms of Use</a> |
                        <span>©2017 TRIARC S.A.L.</span>
                    </div>
                </div>

                </div>
                <div class="col-md-6 col-sm-12 col-xl-4">
                    <div class="subscribe_box">
                        <h5>Subscribe to Our Mailing List</h5>
                        <p>Get news delivered directly to your email.</p>
                  <div class="email_box">
					<?php echo do_shortcode('[mc4wp_form]'); ?>
            		</div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-lg-12">
                    <div class="sub-footer">
                        <a href="#">Privacy Policy</a> |
                        <a href="#">Terms of Use</a> |
                        <span>©2017 TRIARC S.A.L.</span>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Bootstrap core JavaScript --><!--Removed so that these are added properly and jquery isn't doubled up - see functions.php - rmmadden 20171015-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/creative.min.js"></script>

  </body>

  <script type="text/javascript">


    $( document ).ready(function() {
	  if ($('body').hasClass('home')) {
	  	    $(window).scroll(function (event) {
		        var scroll = $(window).scrollTop();
		        // Do something
		        if (scroll >= 100) {
		          $('.home #mainNav').addClass('fixed-top');
		        }else{
		          $('.home #mainNav').removeClass('fixed-top');
		        }
		    });
	  }else{
		$('#mainNav').addClass('fixed-top');
	  }

	});


    


  </script>

<?php wp_footer(); ?>

</body>
</html>
