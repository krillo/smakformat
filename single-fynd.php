<?php
/**
 * Single Portfolio Item Template
 *
 * This template is the default portfolio item template. It is used to display content when someone is viewing a
 * singular view of a portfolio item ('portfolio' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
get_header();
global $woo_options;

/*
  $output = shell_exec('git help');
  echo "<pre>$output</pre>";
 */
$fyndObject = getFyndObject(get_the_ID());
$fyndtype = $fyndObject->fynd_type;
$type_name = $fyndObject->fynd_type_name;
//print_r($fyndObject);
?>

<!-- #content Starts -->
<?php woo_content_before(); ?>
<div id="content" class="col-full">
  <div id="main-sidebar-container">    
    <?php woo_main_before(); ?>
    <div id="main" class="">                       

      <script type="text/javascript">
        jQuery(document).ready(function($){   
    
          $('#fynd-drop').change(function() {
            var url;
            var fyndtype;
            url =  $('#fynd-drop').val();
            fyndtype =  $('#fyndtype').val();
            window.location.href = url + "?fyndtype=" + fyndtype;        
          });

        });
      </script>

      <input id="fyndtype" value="<?php echo $fyndtype; ?>"  name="fyndtype" type="hidden" />
      <div class="fynd-cat-list-head fynd-list-head" >
        Just nu visas <span><?php echo $type_name . ' : ' . $fyndObject->fynd_cat_name; ?></span>
        <?php echo getFyndDropdown(get_the_ID(), $fyndObject->fynd_cat_slug, $fyndtype); ?>
      </div>



      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
        <div id="" class="fynd-img">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
          }
          ?> 
        </div>
        <h2 class="fynd-title"><?php the_title(); ?></h2>
        <div class="fynd-text">	
          <?php the_content(); ?>
        </div>
        <div class="fynd-contact">	
          <ul>
            <li><strong>Pris: <?php the_field("price"); ?> kr</strong></li>
            <li>Namn: <?php the_field("name"); ?></li>
            <li>Tel: <a href="tel:+46<?php the_field("phone"); ?>"><?php the_field("phone"); ?></a></li>
            <li>Email: <a href="mailto:<?php the_field("email"); ?>"><?php the_field("email"); ?></a></li>
            <li>&nbsp;</li>
            <li><a href="javascript:history.go(-1);" class="back-button"><input type="button" class="chef-button" value="Tillbaka" id=""></a></li>
          </ul>
        </div>
      </div><!--/#post-->
      <?php //twentyfourEBCode();?> 
      <div class="clear"></div>
      <?php include 'snippet_fynd_puffs.php'; ?>    
      <?php woo_loop_after(); ?>     
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