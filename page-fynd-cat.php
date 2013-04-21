<?php
/**
 * Template Name: Fynd kategori sida
 *
 * This is the category list page for Fyndhyllan.
 * Fyndhyllan is a buy and sell market aka "mini blocket"
 *
 * @author Kristain Erendi
 * @package Smakformat
 * @subpackage Template
 */
$cat = $_REQUEST['cat'];
$type = $_REQUEST['type'];
$cat_name = getFyndNiceName($cat);
$type_name = getFyndNiceName($type);
$fynds = getFyndArray(100, 0, $cat);



global $woo_options;
get_header();
?>
<?php woo_content_before(); ?>
<div id="content" class="col-full">
  <div id="main-sidebar-container">    
    <?php woo_main_before(); ?>
    <div id="main"> 
      <div style="width:97%">

        <?php the_content(); ?>
        <div id="fynd-cat-list">
          <div class="fynd-cat-list-head fynd-list-head" >
            Just nu visas <span><?php echo $type; ?><?php echo $cat . ' ' . $type; ?></span>
            <select>kakak</select>
          </div>

          <?php
          //echo $cat . ' ' . $type;
          //print_r($fynds);
          echo $type_name;
          
          
          $i = 0;
          foreach ($fynds as $fynd) {
            if ($fynd->fynd_type == $type) {
              $out .= '<div class="fynd-cat-list-obj">';
              $out .= '  <a href="' . $fynd->guid . '">';
              $out .= get_the_post_thumbnail($fynd->ID, array(230, 230));
              //$out .=     '<div class="fynd-puff-heading">' . $fynd->post_title . '</div>';
              $out .= '<p>' . substr($fynd->post_content, 0, 70) . '</p>';
              $out .= '<div class="obj-price">Pris: ' . $fynd->price . '</div>';
              $out .= '<div class="obj-info">MER INFO</div>';
              $out .= '  </a>';
              $out .= '</div>';
              $i++;
              if ($i % 2 == 0) {
                $out .= '<div class="clear"></div><hr/>';
              }
            }
          }
          echo $out;
          ?>

        </div>
      </div>


    </div><!-- /#main -->
    <?php woo_main_after(); ?>
    <?php //get_sidebar();   ?>
  </div><!-- /#main-sidebar-container -->         
  <div id="sidebar">
    <?php include_once 'snippet_list_fynd.php'; ?>
    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("fyndhyllan")) : endif; ?>    
  </div>  
</div><!-- /#content -->
<?php woo_content_after(); ?>
<?php get_footer(); ?>