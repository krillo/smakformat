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
function create_fynd_taxonomy() {
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
      'show_tagcloud' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array('slug' => 'fyndkategorier'),
      'capabilities' => array(
          'manage_terms' => 'manage_options', //by default only admin
          'edit_terms' => 'manage_options',
          'delete_terms' => 'manage_options',
          'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
      )
  );
  register_taxonomy('fyndkategori', array('fynd'), $args);
}

add_action('init', 'create_fynd_taxonomy', 0);

/**
 * Get a list of fynd objects
 * @param type $sell 
 */
function getFyndList($sell = true) {
  $arg = 'salj';
  if (!$sell) {
    $arg = 'kop';
  }
  $fyndQuery = new WP_Query(array('orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => '-1', 'post_type' => array('fynd'), 'tax_query' => array(array('taxonomy' => 'fyndkategori', 'field' => 'slug', 'terms' => $arg))));

  while ($fyndQuery->have_posts()) : $fyndQuery->the_post();
    echo '<li><a href="' . get_permalink() . '?fyndtype=' . $arg . '">' . get_the_title() . '</a></li>';
  endwhile;
  wp_reset_query();
}

/**
 * Creates a dropdown of fynd-articles by fyndtype and sell or by. It also selects the showing article 
 * 
 * @param type $selectedId
 * @param type $fyndtype
 * @return string 
 */
function getFyndDropdown($selectedId, $fyndtype) {
  $fyndQuery = new WP_Query(array('orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => '-1', 'post_type' => array('fynd'), 'tax_query' => array(array('taxonomy' => 'fyndkategori', 'field' => 'slug', 'terms' => $fyndtype))));
  $output = '<select class="" id="fynd-drop" name="fynd-drop">';
  while ($fyndQuery->have_posts()) : $fyndQuery->the_post();
    if ($selectedId == get_the_ID()) {
      $sel = ' selected="selected" ';
    } else {
      $sel = '';
    }
    $output .= '<option value="' . get_permalink() . '"  ' . $sel . '>' . get_the_title() . '</option>';
  endwhile;
  $output .= '</select>';
  wp_reset_query();
  return $output;
}

//createFyndObject();
function createFyndObject() {


  $fynd_post = array(
      'post_title' => "Apa Coca-cola flaska",
      'post_content' => "Tjoho säljer en Coca-cola flaska",
      'post_status' => 'publish',
      'post_author' => 1,
      //'post_category' => array( 10,14 ),
      'post_type' => 'fynd',
          //'tax_input' => array('fyndkategori' => array('kop')),
  );

  $post_id = wp_insert_post($fynd_post, true);
  //print_r($post_id);
//wp_set_post_terms( $post_id, array( '14', '10' ), 'fyndkategorier', $append );

  if ($post_id) {
    $success = wp_set_object_terms($post_id, array('kop', 'glas'), 'fyndkategori', true);
    print_r($success);

    //wp_set_post_terms( $post_id, array( 'kop', 'glas' ), 'fyndkategori' );
    //wp_set_post_terms( $post_id, array( 17 ), 'fyndkategori' );

    add_post_meta($post_id, 'name', 'Kaptenen', true);
    add_post_meta($post_id, '_name', 'field_1', true);
    add_post_meta($post_id, 'email', 'Krillo@gmail.com', true);
    add_post_meta($post_id, '_email', 'field_2', true);
    add_post_meta($post_id, 'phone', '0701-11111', true);
    add_post_meta($post_id, '_phone', 'field_3', true);
    add_post_meta($post_id, 'price', '200', true);
    add_post_meta($post_id, '_price', 'field_7', true);
  }
}

add_action('wp_ajax_add_fynd', 'add_fynd_obj_callback');
add_action('wp_ajax_nopriv_add_fynd', 'add_fynd_obj_callback');

/**
 * This function is an Ajax callback.
 * It gets all the data from the post and creates a new fynd-object
 */
function add_fynd_obj_callback() {
  $order = new stdClass;
  !empty($_REQUEST['name']) ? $order->name = $_REQUEST['name'] : $order->name = '';
  !empty($_REQUEST['mobile']) ? $order->mobile = $_REQUEST['mobile'] : $order->mobile = '';
  !empty($_REQUEST['email']) ? $order->email = $_REQUEST['email'] : $order->email = '';
  !empty($_REQUEST['title']) ? $order->title = $_REQUEST['title'] : $order->title = '';
  !empty($_REQUEST['content']) ? $order->content = $_REQUEST['content'] : $order->content = '';
  !empty($_REQUEST['price']) ? $order->price = $_REQUEST['price'] : $order->price = '';
  !empty($_REQUEST['terms']) ? $order->terms = $_REQUEST['terms'] : $order->terms = '';
  !empty($_REQUEST['type']) ? $order->type = $_REQUEST['type'] : $order->type = '';

  $response = array(
      'success' => 0,
      'error' => 'xxx',
      'annons_type' => $order->type      
  );  
  
  if ($order->type == 'kop' || $order->type == 'salj') {
    $fynd_post = array(
        'post_title' => $order->title,
        'post_content' => $order->content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'fynd',
    );
    $post_id = wp_insert_post($fynd_post, true);

    if ($post_id) {
      $success = wp_set_object_terms($post_id, array($order->type, 'glas'), 'fyndkategori', true);

      add_post_meta($post_id, 'name', $order->name, true);
      add_post_meta($post_id, '_name', 'field_1', true);
      add_post_meta($post_id, 'email', $order->email, true);
      add_post_meta($post_id, '_email', 'field_2', true);
      add_post_meta($post_id, 'phone', $order->mobile, true);
      add_post_meta($post_id, '_phone', 'field_3', true);
      add_post_meta($post_id, 'price', $order->price, true);
      add_post_meta($post_id, '_price', 'field_7', true);
      $response = array(
          'success' => 1,
          'post_id' => $post_id,
          'annons_type' => $order->type
      );
    }
  } else {
     $response['error'] = 'Wrong category! No buy or sell.';
     $response['annons_type'] = $order->type;
  } 
  

  $response = json_encode($response);
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo $response;
  die(); // this is required to return a proper result
}

include_once 'reptilo_utils.php';