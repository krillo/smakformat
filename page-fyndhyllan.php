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
      <div id="fynd-list-all">
        <div class="fynd-list-head" ><a href="#" class="fynd-list-selector  fynd-list-selected" >KÖP</a><a href="#"  class="fynd-list-selector" >SÄLJ</a></div>
          <ul id="list-buy" class="fynd-list">
            <?php getFyndList(false); ?>            
            <li><a href="/fynd/raclettejarn/">Kastrull</a></li>
            <li><a href="7fynd/kaffekvarn/">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
          </ul>
          <ul id="list-sell" class="fynd-list hidden">
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Vinglas i kristall</a></li>
            <li><a href="#">Kastrull</a></li>
            <li><a href="#">Mixer</a></li>
            <li><a href="#">Stekpanna</a></li>
            <li><a href="#">Wookpanna</a></li>
            <li><a href="#">Vinglas i kristall</a></li>          </ul>          
      </div>
      <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("fyndhyllan")) : endif; ?>    
    </div>






  </div><!-- /#main-sidebar-container -->         
  <?php get_sidebar('alt'); ?>
</div><!-- /#content -->
<?php woo_content_after(); ?>
<?php get_footer(); ?>