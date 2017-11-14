<?php
/**
 * The template for displaying the top-of-page search bar
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>

<header id="headerInner">
    <div class="Explore_input">

      <form method="get" id="searchform" class="search-form" action="<?php echo get_permalink(WAZEE_SITE_TEMPLATE_SEARCH_RESULTS); ?>">
          <label for="s" class="assistive-text">
          <span class="screen-reader-text"><?php _e( 'Search', 'twentyfifteen' ); ?></span>
          <input <?php echo (isset($_REQUEST['q']) ? 'value="' . $_REQUEST['q'] . '"' : ''); ?> type="search" class="field search-field" name="q" id="s" placeholder="<?php esc_attr_e( 'Explore TRIARC now…', 'twentyfifteen' ); ?>" />
          </label>

          <input type="submit" class="submit search-submit screen-reader-text" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'twentyfifteen' ); ?>" />
      </form>

     
    </div>
	</header>