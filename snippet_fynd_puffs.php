<div id="fynd-puff">
  <h3>Ännu mer på Fyndhyllan</h3>
  <ul>
    <?php
    $count = 3;
    $exclude_id = get_the_ID();
    $i = 0;
    $fynds = getFyndArray($count, $exclude_id);
    foreach ($fynds as $fynd) {
      $i++;
      if($i == 3){
        $class = 'li-last-child';
      } else {
        $class = '';
      }
      echo '<a href="' . $fynd->guid . '?fyndtype=' . $fynd->fynd_type . '"><li class="' . $class . '">' . get_the_post_thumbnail($fynd->ID, array(174, 174)) . '<div class="fynd-puff-heading">' . $fynd->post_title . '</div></li></a>';
    }
    ?>        
  </ul>   
</div>