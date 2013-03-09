<div id="fynd-puff">
  <h3>Ännu mer på fyndhyllan</h3>
  <ul>
    <?php
    $fynds = getFyndArray();
    foreach ($fynds as $fynd) {
      echo '<a href="' . $fynd->guid . '?fyndtype=' . $fynd->fynd_type . '"><li>' . get_the_post_thumbnail($fynd->ID, array(170, 170)) . '<div class="fynd-puff-heading">' . $fynd->post_title . '</div></li></a>';
    }
    ?>        
  </ul>   
</div>