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
/**
 * Description: All below is added by //krillo 
 * 1. cleanup the admin page
 * 
 * Date: 2013-01-09
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 */
add_action('wp_dashboard_setup', 'hide_wp_welcome_panel');
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

function hide_wp_welcome_panel() {
  if (current_user_can('edit_theme_options'))
    $ah_clean_up_option = update_user_meta(get_current_user_id(), 'show_welcome_panel', false);
}

function remove_dashboard_widgets() {
  // Ta bort widgets i vänsterkolumnen
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); // Inkommande länkar
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); // Tillägg
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Senaste kommentarer
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // Just nu
  // Ta bort widgets i högerkolumnen
  remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress Blogg
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // SnabbPress
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); // Senaste utkasten
  remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // Andra WordPressnyheter
}

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
 * Return the taxonomy object
 * 
 * @param type $slug
 * @return type 
 */
function getFyndTaxonomy($slug) {
  return get_term_by('slug', $slug, 'fyndkategori');
}

/**
 * Get all lists of fynd objects categorised by category and kop, salj 
 * returns ul-li list of all objects, all with class hidden
 * @param type $sell 
 */
function getAllFyndListsByType($fyndtype = 'salj') {
  $cats = getFyndCategories();
  $output_salj .= '';
  $output_kop .= '';
  foreach ($cats as $cat) {
    if ($cat->slug != "salj" && $cat->slug != "kop") {
      $output_salj .= '<li><a id="fynd-list-salj-' . $cat->slug . '" href="/fyndhyllan-kategorier/?type=salj&cat=' . $cat->slug . '" class="fynd-cat" >' . ucfirst($cat->name) . '</a></li>';
      $output_kop .= '<li><a id="fynd-list-kop-' . $cat->slug . '" href="/fyndhyllan-kategorier/?type=kop&cat=' . $cat->slug . '" class="fynd-cat" >' . ucfirst($cat->name) . '</a></li>';
      $output_salj .= '<ul id="article-salj-' . $cat->slug . '" class="article-list"  style="display:none;">';
      $output_kop .= '<ul id="article-kop-' . $cat->slug . '" class="article-list"  style="display:none;">';
      $fyndArray = getFyndArray(1000, 0, $cat->slug);
      foreach ($fyndArray as $fynd) {
        if ($fynd->fynd_type == 'salj') {
          $output_salj .= '<li class="article-list-link"><a href="' . $fynd->guid . '">' . $fynd->post_title . '</a></li>';
        } else {
          $output_kop .= '<li class="article-list-link"><a href="' . $fynd->guid . '">' . $fynd->post_title . '</a></li>';
        }
      }
      $output_salj .= '</ul>';
      $output_kop .= '</ul>';
    }
  }
  if ($fyndtype == "salj") {
    return $output_salj;
  } else {
    return $output_kop;
  }
}

/**
 * Return an array of fynd. 
 * All types and order by date
 * All fyndcategories ara there and also fynd_type
 * 
 * @param type $nbr 
 */
function getFyndArray($nbr = 3, $exclude_id = 0, $fyndCatSlug = '', $type = '') {
  if ($fyndCatSlug == 'all') {
    $fyndCatSlug = $type;
  }
  if ($fyndCatSlug != '') {
    $fyndQuery = new WP_Query(array('orderby' => 'title', 'order' => 'DESC', 'posts_per_page' => $nbr + 1, 'post_type' => array('fynd'), 'tax_query' => array(array('taxonomy' => 'fyndkategori', 'field' => 'slug', 'terms' => $fyndCatSlug))));
  } else {
    $fyndQuery = new WP_Query(array('orderby' => 'rand', 'order' => 'DESC', 'posts_per_page' => $nbr + 1, 'post_type' => array('fynd')));
  }
  $fynds = $fyndQuery->posts;
  $fyndArray = array();
  foreach ($fynds as $fynd) {
    $fynd->fyndkategori = get_the_terms($fynd->ID, 'fyndkategori');
    $meta = get_post_meta($fynd->ID);
    $fynd->name = $meta['name'][0];
    $fynd->email = $meta['email'][0];
    $fynd->price = $meta['price'][0];
    $fynd->phone = $meta['phone'][0];
    foreach ($fynd->fyndkategori as $fyndtype) {
      $fynd->fynd_type = $fyndtype->slug;
      switch ($fyndtype->slug) {
        case 'kop':
          $fynd->fynd_type_name = 'köpes';
          break;
        case 'salj':
          $fynd->fynd_type_name = 'säljes';
          break;
        default:
          break;
      }
    }
    if ($type == '' OR $fynd->fynd_type == $type) {   //add only selected type 
      if ($fynd->ID != $exclude_id) {  //exclude from id
        $fyndArray[] = $fynd;
      }
    }
    if (count($fyndArray) == $nbr) {
      break;
    }
  }
  wp_reset_query();
  //print_r($fyndArray);
  return $fyndArray;
}

/**
 * Creates a dropdown of fynd-articles by fyndtype and sell or by. It also selects the showing article 
 * 
 * @param type $selectedId
 * @param type $fyndtype
 * @return string 
 */
//krillo kolla denna
function getFyndDropdown($selectedId, $fyndcat, $type = 'kop') {
  $fynds = getFyndArray(100, 0, $fyndcat, $type);
  //print_r($fynds);
  $output = '<select class="" id="fynd-drop" name="fynd-drop">';
  if ($selectedId <= 0) {
    $output .= '<option value=""> ... </option>';
  }

  foreach ($fynds as $fynd) {
    if ($fynd->fynd_type == $type) {
      if ($fynd->ID == $selectedId) {
        $sel = ' selected="selected" ';
      } else {
        $sel = '';
      }
      $output .= '<option value="' . $fynd->guid . '"  ' . $sel . '>' . $fynd->post_title . '</option>';
    }
  }
  $output .= '</select>';
  return $output;
}

/**
 * Get a fynd object with all taxonomies populated
 * @param type $postId
 * @return type 
 */
function getFyndObject($postId) {
  $fynd = get_post($postId);
  $fynd->fyndkategori = get_the_terms($fynd->ID, 'fyndkategori');
  $meta = get_post_meta($fynd->ID);
  $fynd->name = $meta['name'][0];
  $fynd->email = $meta['email'][0];
  $fynd->price = $meta['price'][0];
  $fynd->phone = $meta['phone'][0];
  if (!empty($fynd->fyndkategori)) {
    foreach ($fynd->fyndkategori as $category) {
      $fynd->fyndkategori = get_the_terms($fynd->ID, 'fyndkategori');

      switch ($category->slug) {
        case 'kop':
          $fynd->fynd_type = 'kop';
          $fynd->fynd_type_name = 'köpes';
          break;
        case 'salj':
          $fynd->fynd_type = 'salj';
          $fynd->fynd_type_name = 'säljes';
          break;
        default:
          $fynd->fynd_cat_slug = $category->slug;
          $fynd->fynd_cat_name = $category->name;
          break;
      }
    }
    return $fynd;
  } else {
    return null;
  }
}

/**
 * Returns an array of all categories for fynd
 * "Köp" and "Sälj" are also categoriesthese are excluded
 *  
 */
function getFyndCategories() {
  $allCats = get_terms('fyndkategori', array('orderby' => 'name', 'hide_empty' => 0));
  foreach ($allCats as $cat) {
    if ($cat->slug != 'kop' && $cat->slug != 'salj') {
      $cats[] = $cat;
    }
  }
  return $cats;
}

function getfyndCategoriesLi($type){
  $cats = getFyndCategories();
  foreach ($cats as $cat) {
    $output .= '<li data-cat="'.$cat->slug.'" class=""><a href="/fyndhyllan-kategorier/?type='.$type.'&cat='.$cat->slug.'" >' . $cat->name . '</a></li>';
  }
  return $output;
}

/**
 * Returns an array of all categories for fynd
 * "Köp" and "Sälj" are also categories, these are excluded
 *  
 */
function getFyndCategoriesDropdown($selectedCat) {
  $categories = getFyndCategories();
  $output = '<select class="" id="fynd-cat-drop" name="fynd-cat">';
  $output .= '<option value="all" ' . sel('all', $selectedCat) . '>Alla</option>';
  foreach ($categories as $cat) {
    $output .= '<option value="' . $cat->slug . '" ' . sel($cat->slug, $selectedCat) . '>' . $cat->name . '</option>';
  }
  $output .= '</select>';
  return $output;
}

function sel($var1, $var2) {
  return ($var1 == $var2 ? ' selected="selected" ' : '');
}

/**
 * Returns a list of all categories for fynd
 * "Köp" and "Sälj" are also categories, these are excluded
 * 
 * output in this format:
 * <a href="koksmaskiner/kop">Köksmaskiner</a>
 * handle the href with jQuery
 */
function getFyndCategoryList($arg = 'salj') {
  $categories = getFyndCategories();
  $output = '';
  foreach ($categories as $cat) {
    if ($cat->slug != 'kop' && $cat->slug != 'salj') {
      $output .= '<li><a href="fynd-list-' . $arg . '-' . $cat->slug . '" class="fynd-cat-list ' . $arg . '">' . $cat->name . '</a></li>';
    }
  }
  return $output;
}

/**
 * Get all 
 * 
 * @param type $arg
 * @return string 
 */
function getFyndListByCategory($arg) {
  $categories = getFyndCategories();
  $output = '';
  print_r($categories);

  /*
    foreach ($categories as $cat) {
    if ($cat->slug != 'kop' && $cat->slug != 'salj') {
    $output .= '<li><a href="fynd-list-' . $arg . '-' . $cat->slug . '" class="fynd-cat-list ' . $arg . '">' . $cat->name . '</a></li>';
    }
    }
   * 
   */
  return $output;
}

add_action('wp_ajax_add_fynd', 'add_fynd_obj_callback');
add_action('wp_ajax_nopriv_add_fynd', 'add_fynd_obj_callback');

/**
 * This function is an Ajax callback.
 * 1. It gets all the data from the $_POST and creates a new fynd-object.
 * 2. Adds the image to media library
 * 3. Makes the image featured image to the post
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
  !empty($_REQUEST['filename']) ? $order->filename = $_REQUEST['filename'] : $order->filename = '';
  !empty($_REQUEST['category']) ? $order->category = $_REQUEST['category'] : $order->category = '';

  $response = array(
      'success' => 0,
      'error' => 'xxx',
      'annons_type' => $order->type
  );
  // create post
  if ($order->type == 'kop' || $order->type == 'salj') {
    $fynd_post = array(
        'post_title' => $order->title,
        'post_content' => $order->content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'fynd',
    );
    $post_id = wp_insert_post($fynd_post, true);

    //add some meta fields
    if ($post_id) {
      $success = wp_set_object_terms($post_id, array($order->type, $order->category), 'fyndkategori', true);
      add_post_meta($post_id, 'name', $order->name, true);
      add_post_meta($post_id, '_name', 'field_1', true);
      add_post_meta($post_id, 'email', $order->email, true);
      add_post_meta($post_id, '_email', 'field_2', true);
      add_post_meta($post_id, 'phone', $order->mobile, true);
      add_post_meta($post_id, '_phone', 'field_3', true);
      add_post_meta($post_id, 'price', $order->price, true);
      add_post_meta($post_id, '_price', 'field_7', true);

      //add the image to the media library
      $order->filename;
      $wp_upload_dir = wp_upload_dir(date('Y/m'));
      $file_with_path = $wp_upload_dir['path'] . '/' . $order->filename;
      $wp_filetype = wp_check_filetype(basename($file_with_path), null);

      $attachment = array(
          'guid' => $wp_upload_dir['url'] . '/' . basename($order->filename),
          'post_mime_type' => $wp_filetype['type'],
          'post_title' => preg_replace('/\.[^.]+$/', '', 'Fynd_' . $order->title),
          'post_content' => '',
          'post_status' => 'inherit'
      );
      $attach_id = wp_insert_attachment($attachment, $file_with_path, $post_id);

      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata($attach_id, $file_with_path);
      wp_update_attachment_metadata($attach_id, $attach_data);

      /*
        echo '$wp_filetype';
        print_r($wp_filetype);
        echo '$wp_upload_dir';
        print_r($wp_upload_dir);
        echo '$attachment';
        print_r($attachment);
        echo '$attach_id ' . $attach_id;
        echo '$attach_data';
        print_r($attach_data);
        die();
       */

      //make the image featured image 
      set_post_thumbnail($post_id, $attach_id);

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