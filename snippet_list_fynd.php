<?php
!empty($_REQUEST['cat']) ? $cat = $_REQUEST['cat'] : $cat = '';
!empty($_REQUEST['type']) ? $type = $_REQUEST['type'] : $type = 'salj';
if($type == 'salj'){
  $sellClass = 'fynd-list-selected';
  $buyClass = 'fynd-list-disabled';
} else {
  $buyClass = 'fynd-list-selected';
  $sellClass = 'fynd-list-disabled';
}

$catsHide = '';
if (get_page(get_the_ID())->post_name == 'fyndhyllan') {
  $catsHide = 'hidden';
  $sellClass = 'fynd-list-selected';
  $buyClass = 'fynd-list-selected';
} 
?>

<div id="fynd-list-all">
  <div class="fynd-list-head" >
    <a href="/fyndhyllan-kategorier/?type=salj&cat=all"  class="fynd-list-selector <?php echo $sellClass ?>"  id="fynd-list-sell">SÄLJ</a>
    <a href="/fyndhyllan-kategorier/?type=kop&cat=all" class="fynd-list-selector-buy <?php echo $buyClass ?>" id="fynd-list-buy">KÖP</a>
  </div>
  <ul id="list-buy" class="fynd-list <?php echo $catsHide; ?>">
    <?php echo getfyndCategoriesLi($type); ?>
  </ul>
</div>
