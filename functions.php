<?php
// Add header container
add_action('woo_header_before', 'header_container_start');

function header_container_start() {
  ?>
  <!--#header-container-->
  <div id="header-container">
    <?php
  }

  add_action('woo_header_after', 'header_container_end', 8);

  function header_container_end() {
    ?>
  </div><!--/#header-container-->
  <?php
}

// Add navigation container
add_action('woo_nav_before', 'nav_container_start');

function nav_container_start() {
  ?>
  <!--#nav-container-->
  <div id="nav-container">
    <?php
  }

  add_action('woo_nav_after', 'nav_container_end');

  function nav_container_end() {
    ?>
  </div><!--/#nav-container-->
  <?php
}

// Add footer widget container
add_action('woo_footer_top', 'footer_widgets_container_start', 8);

function footer_widgets_container_start() {
  ?>
  <!--#footer-widgets-container-->
  <div id="footer-widgets-container">
    <?php
  }

  add_action('woo_footer_before', 'footer_widgets_container_end');

  function footer_widgets_container_end() {
    ?>
  </div><!--/#footer_widgets_container_end-->
  <?php
}

// Add footer container
add_action('woo_footer_before', 'footer_container_start');

function footer_container_start() {
  ?>
  <!--#footer_container_start-->
  <div id="footer-container">
    <?php
  }

  add_action('woo_footer_after', 'footer_container_end');

  function footer_container_end() {
    ?>
  </div><!--/#footer_container_end-->
  <?php
}
?>
<?php
register_sidebar(array(
    'name' => __('Puff fyndhyllan'),
    'id' => 'puff-fyndhyllan',
    'description' => __('Puff eller annan kommer att visas högst upp i sidebaren'),
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));

register_sidebar(array(
    'name' => __('Fyndhyllan'),
    'id' => 'fyndhyllan',
    'description' => __('Widgets som kommer att visas på fyndhyllansidorna'),
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));

register_sidebar(array(
    'name' => __('Annons featured'),
    'id' => 'annons-featured',
    'description' => __('Widgets eller "annonser" kommer att visas under featured artikel'),
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));

register_sidebar(array(
    'name' => __('Annons footer'),
    'id' => 'annons-footer',
    'description' => __('Widgets eller "annonser" kommer att visas ovanför footern'),
    'before_title' => '<h1>',
    'after_title' => '</h1>'
));

/**
 * The post type Fyndhyllan 
 * 
 */
function create_fyndhyllan() {
  $labels = array(
      'name' => 'Fynd',
      'singular_name' => 'Fynd',
      'add_new' => 'Lägg till nytt fynd',
      'add_new_item' => 'Lägg till nytt fynd',
      'edit_item' => 'Redigera fynd',
      'new_item' => 'Nytt fynd',
      'all_items' => 'Alla fynd',
      'view_item' => 'Visa fynd',
      'search_items' => 'Sök på fyndhyllan',
      'not_found' => 'Inga fynd hittade',
      'not_found_in_trash' => 'Inga fynd hittade i soptunnan',
      'parent_item_colon' => '',
      'menu_name' => 'Fyndhyllan'
  );

  $args = array(
      'labels' => $labels,
      'public' => true,
      'publicly_queryable' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'fynd'),
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt') //, 'comments' )
  );
  register_post_type('fynd', $args);
}

add_action('init', 'create_fyndhyllan');

/**
 *  Add a new taxonomy for post type  "Fyndhyllan" make it hierarchical (like categories)
 */
function create_fynd_taxonomie() {
  $labels = array(
      'name' => _x('Fyndkategori', 'taxonomy general name'),
      'singular_name' => _x('Fyndkategori', 'taxonomy singular name'),
      'search_items' => __('Sök fyndkategorier'),
      'all_items' => __('Alla fyndkategorier'),
      'parent_item' => __('Fyndkategorier förälder'),
      'parent_item_colon' => __('Fyndkategorier förälder:'),
      'edit_item' => __('Redigera fyndkategorier'),
      'update_item' => __('Uppdatera fyndkategori'),
      'add_new_item' => __('Lägg till ny fyndkategori'),
      'new_item_name' => __('Nytt fyndkategori name'),
      'menu_name' => __('Fyndhyllans kategorier')
  );

  $args = array(
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'fyndkategorier')
  );
  register_taxonomy('fyndkategori', array('fynd'), $args);
}

add_action('init', 'create_fynd_taxonomie', 0);




/**
 * Get a list of fynd objects
 * @param type $sell 
 */
function getFyndList($sell = true) {
  $arg = 'salj';
  if (!$sell) {
    $arg = 'kop';
  }
  $fyndQuery = new WP_Query(array('post_type' => array('fynd'),'tax_query' => array(array('taxonomy' => 'fyndkategori', 'field' => 'slug', 'terms' => $arg))));

  while ($fyndQuery->have_posts()) : $fyndQuery->the_post();
    echo '<li><a href="' . get_permalink() . '?fyndtype=' . $arg . '">' .get_the_title() .'</a></li>';
  endwhile;
  wp_reset_query();
}

/**
 * add debug info if on localhost
 */
function mu_debug_info() {
  if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    echo '<!-- Server Debug Info from mu-debug-info plugin.';
    echo "\n\$_SERVER: ";
    var_dump($_SERVER);
    echo "\n\$_GET: ";
    var_dump($_GET);
    echo "\n\$_POST: ";
    var_dump($_POST);
    echo "\n\$_SESSION: ";
    var_dump($_SESSION);
    echo ' -->', "\n";
  }
}

add_action('wp_head', 'mu_debug_info');