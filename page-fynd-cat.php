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
!empty($_REQUEST['cat']) ? $cat = $_REQUEST['cat'] : $cat = '';
!empty($_REQUEST['type']) ? $type = $_REQUEST['type'] : $type = 'salj';
$cat_obj = getFyndTaxonomy($cat);
if ($type == 'kop') {
  $type_name = 'Köp';
} else {
  $type_name = 'Sälj';
}
$fynds = getFyndArray(1000, 0, $cat, $type);
//print_r($fynds);

global $woo_options;
get_header();
?>
<script type="text/javascript">
  jQuery(document).ready(function($){   

    $('#fynd-cat-drop').change(function() {
      var cat = $('#fynd-cat-drop').val();
      var type =  $('#fyndtype').val();
      window.location.href = "/fyndhyllan-kategorier/?type=" + type + "&cat=" + cat;        
    });

  });
</script>
<?php woo_content_before(); ?>
<div id="content" class="col-full">
  <div id="main-sidebar-container">    
    <?php woo_main_before(); ?>
    <div id="main"> 
      <div style="width:97%">

        <input id="fyndtype" type="hidden" value="<?php echo $type; ?>" />
        <h1>Välkommen till Fyndhyllan - <?php echo $type_name; ?></h1>
        <div id="fynd-cat-list">
          <div class="fynd-cat-list-head fynd-list-head" >
            Just nu visas 
            <?php echo getFyndCategoriesDropdown($cat); ?>
          </div>

          <?php
          //echo 'cat: '. $cat . ' type:' . $type;
          //print_r($fynds);
          //print_r($cat_obj);
          $i = 0;
          foreach ($fynds as $fynd) {
            $excerp = mb_substr($fynd->post_content, 0, 70). '...';
            if ($fynd->fynd_type == $type) {
              $out .= '<div class="fynd-cat-list-obj">';
              $out .= '  <a href="' . $fynd->guid . '">';
              $out .= get_the_post_thumbnail($fynd->ID, array(230, 230));
              //$out .=     '<div class="fynd-puff-heading">' . $fynd->post_title . '</div>';
              $out .= '<p>' . $excerp . '</p>';
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