<?php
/**
 * Page Template
 *
 * This is the start page for Fyndhyllan.
 * Fyndhyllan is a buy and sell market aka "min blocket"
 *
 * @author Kristain Erendi
 * @package Smakformat
 * @subpackage Template
 */
get_header();
?>
<div id="content" class="col-full">
  <div id="main-sidebar-container">    
    <div id="main">                     
      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          ?>
          <div <?php post_class(); ?> >
            <div class="entry">
              <div id="chef">
                <div id="chef-text" class="">
                  <?php the_content(); ?>
                </div>
                <div class="clear"></div>
                <div id="chef-buttons"><input type="button" id="sell-button" value="Jag vill sälja" class="chef-button" /><input type="button" id="buy-button" value="Jag vill köpa" class="chef-button" /></div>
              </div>
            </div><!-- /.entry -->
          </div><!-- /.post -->
          <?php
        }
      }
      ?>     
    </div><!-- /#main -->
    <?php woo_main_after(); ?>

    <div id="sidebar">
      <?php include_once 'snippet_list_fynd.php'; ?>
      <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("fyndhyllan")) : endif; ?>    
    </div>






  </div><!-- /#main-sidebar-container -->         
  <?php get_sidebar('alt'); ?>
</div><!-- /#content -->
<?php woo_content_after(); ?>
<?php get_footer(); ?>