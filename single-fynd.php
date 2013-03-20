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
/*
!empty($_REQUEST['fyndtype']) ? $fyndtype = $_REQUEST['fyndtype'] : $fyndtype = '';
switch ($fyndtype) {
  case 'kop':
    $fyndtype_txt = 'Köpes';
    break;
  case 'salj':
    $fyndtype_txt = 'Säljes';
    break;
  default:
    $fyndtype_txt = '';
    break;
}
*/

$fyndObject = getFyndObject(get_the_ID());
$fyndtype = $fyndObject->fynd_type;
$fyndtype_txt = $fyndObject->fynd_type_name;

if(isset($_SESSION['views']))
    $_SESSION['views'] = $_SESSION['views']+ 1;
else
    $_SESSION['views'] = 1;

echo "views = ". $_SESSION['views']; 
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
      <div class="fynd-list-head margin"  ><div class="fynd-list-head-text"><a href="/fyndhyllan/">Fyndhyllan</a> &nbsp;&nbsp; just nu visas <?php echo $fyndtype_txt ?>: </div><div class="fynd-list-head-title"><?php echo getFyndDropdown(get_the_ID(), $fyndtype); ?></div></div>
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
        <div id="" class="fynd-img">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail(array(300, 300));
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