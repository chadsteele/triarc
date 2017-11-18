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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<!-- Custom scripts for this template -->
<script xsrc="http://demo.rockriverdev3.com/wp-content/themes/triarc/js/creative.min.js"></script>



  </body>



  <script type="text/javascript">

   $(document).ready(function () {

        var $body = $('body'), $window = $(window);

        //enable dropdowns
        $body.on('click', 'nav.main-menu li.menu-item-has-children a', function (event) {
            event.stopPropagation();
            var $this = $(this).next();
            $('nav.main-menu ul.sub-menu').not($this).hide();
            $this.toggle();
            return false;
        });

        $body.on('mouseenter', 'nav.main-menu li.menu-item-has-children', function (event) {
            event.stopPropagation();
            var $this = $(this).find('ul.sub-menu');
            $('nav.main-menu ul.sub-menu').not($this).hide();
            $this.show();
            return false;
        });

        $body.on('mouseleave', 'nav.main-menu ul.sub-menu', function (event) {
            event.stopPropagation();
            var $this = $(this);
            $this.hide();
            return false;
        });


        $body.on('click', 'nav.main-menu button.navbar-toggler', function (event) {
            $('nav.main-menu div.menu-main-navigation-container').toggle();
        });

        // change nav on scroll on home screen only
        if ($body.hasClass('home')) {
            $window.scroll(function (event) {
                var scroll = $window.scrollTop();
                var $nav = $('nav.main-menu');
                var $navSearch = $('div.search-row');
                // Do something
                if (scroll <= 500) {
                    $nav.addClass('transparent');
                    $navSearch.hide();
                } else {
                    $nav.removeClass('transparent');
                    $navSearch.show();
                }
            });

            //make home menu transparent on initial load
            $(window).trigger('scroll');
        }


    });

  </script>



<?php wp_footer(); ?>



</body>

</html>

