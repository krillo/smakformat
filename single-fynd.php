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


?>

<!-- #content Starts -->
<?php woo_content_before(); ?>
<div id="content" class="col-full">

  <div id="main-sidebar-container">    

    <?php woo_main_before(); ?>
    <div id="main">                       
      <!--div><h1>Välkommen till "bra att ha lådan"</h1></div-->
      
      
      <div class="fynd-list-head margin"  ><div class="fynd-list-head-text">Fyndhyllan, just nu visas: </div><div class="fynd-list-head-title"><?php the_title(); ?></div></div>
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
        <div id="" class="fynd-img">
        <?php
        if (has_post_thumbnail()) {
          the_post_thumbnail();
        }
        ?> 
        </div>
        <h2 class="fynd-title"><?php the_title(); ?></h2>
        <div class="fynd-text">	
            <?php the_content(); ?>
        </div>
        <div class="fynd-contact">	
          <ul>
            <li>Pris: 100 kr</li>
            <li>Kontakt</li>
            <li>Namn: Krillo Dillo</li>
            <li>Tel: 0761-393855</li>
            <li>Email: krillo@gmail.com</li>
          </ul>
        </div>
      </div><!--/#post-->
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