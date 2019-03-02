<?php
/**
 * The template for displaying the footer
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage fictionaluniversity
 * @since 1.0.0
 */

?>


    <?php wp_footer(); ?>
    <footer class="site-footer">

    <div class="site-footer__inner container container--narrow">

      <div class="group">

        <div class="site-footer__col-one">
          <h1 class="school-logo-text school-logo-text--alt-color"><a href="<?php echo site_url('/'); ?>"><strong>Fictional</strong> University</a></h1>
          <p><a class="site-footer__link" href="<?php echo site_url('/'); ?>">555.555.5555</a></p>
        </div>

        <div class="site-footer__col-two-three-group">
          <div class="site-footer__col-two">
            <h3 class="headline headline--small">Explore</h3>
            <nav class="nav-list">
              <ul>
                <li><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
                <li><a href="<?php echo site_url('/programs'); ?>">Programs</a></li>
                <li><a href="<?php echo site_url('/events'); ?>">Events</a></li>
                <li><a href="<?php echo site_url('/campuses'); ?>">Campuses</a></li>
              </ul>
            </nav>
          </div>

          <div class="site-footer__col-three">
            <h3 class="headline headline--small">Learn</h3>
            <nav class="nav-list">
              <ul>
                <li><a href="<?php echo site_url('universitys-privacy-policy/cookie-policy') ?>">Legal</a></li>
                <li><a href="<?php echo site_url('/universitys-privacy-policy') ?>">Privacy</a></li>
                <li><a href="<?php echo site_url('/programs') ?>">Careers</a></li>
              </ul>
            </nav>
          </div>
        </div>

        <div class="site-footer__col-four">
          <h3 class="headline headline--small">Connect With Us</h3>
          <nav>
            <ul class="min-list social-icons-list group">
              <li><a href="https://facebook.com/" class="social-color-facebook"><i class="fab fa-facebook"></i></a></li>
              <li><a href="https://twitter.com/" class="social-color-twitter"><i class="fab fa-twitter"></i></a></li>
              <li><a href="https://youtube.com/" class="social-color-youtube"><i class="fab fa-youtube"></i></a></li>
              <li><a href="https://linkedin.com/" class="social-color-linkedin"><i class="fab fa-linkedin"></i></a></li>
              <li><a href="https://instagram.com/" class="social-color-instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </footer>


  <?php wp_footer() ?>
</body>
</html>
