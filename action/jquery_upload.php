<?php
require_once(__DIR__ . '/../../../../wp-config.php');

$response = array(
    'success' => 0,
    'error' => '0',
    'error_msg' => '',    
    'filename' => ''
);
$uploads = wp_upload_dir( date('Y/m') );
$path = $uploads['path'] . '/';

$valid_formats = array("jpg", "png", "gif", "jpeg");
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
  $name = $_FILES['photoimg']['name'];
  $size = $_FILES['photoimg']['size'];
  if (strlen($name)) {
    list($txt, $ext) = explode(".", $name);
    $ext = strtolower($ext);
    if (in_array($ext, $valid_formats)) {
      if ($size < (1024 * 1024 * 5)) { // Image size max 5 MB
        $actual_image_name = 'fynd_' . date("Y-m-d_His") . "." . $ext;
        $tmp = $_FILES['photoimg']['tmp_name'];
        if (move_uploaded_file($tmp, $path . $actual_image_name)) {
          $response['success'] = 1;
          $response['filename'] = $actual_image_name;
        } else {
          $response['success'] = 0;
          $response['error'] = '1';
          $response['error_msg'] = 'Could not save image';
        }
      } else {
        $response['success'] = 0;
        $response['error'] = '2';
        $response['error_msg'] = 'Too large image';
      }
    } else {
      $response['success'] = 0;
      $response['error'] = '3';
      $response['error_msg'] = 'Invalid file format';
    }
  } else {
    $response['success'] = 0;
    $response['error'] = '4';
    $response['error_msg'] = 'Please select image';
  }
}

$response = json_encode($response);
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo $response;
die(); // this is required to return a proper result



/*


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


*/

