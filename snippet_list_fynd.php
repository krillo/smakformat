<?php
$fyndObject = getFyndObject(get_the_ID());
$fyndtype = $fyndObject->fynd_type;
$fyndtype_txt = $fyndObject->fynd_type_name;
$fynd_cat_slug = $fyndObject->fynd_cat_slug;
$js_show_id = "'#article-" . $fyndtype . '-' . $fynd_cat_slug . "'";


$buyClass = $sellClass = $buyClassHide = $sellClassHide = '';
switch ($fyndtype) {
  case 'kop':
    $buyClass = 'fynd-list-selected';
    $sellClassHide = 'hidden';
    break;
  case 'salj':
    $sellClass = 'fynd-list-selected';
    $buyClassHide = 'hidden';
    break;
  default:  //show sell as default
    $buyClass = 'fynd-list-selected';
    $sellClassHide = 'hidden';
    break;
}
?>

<div id="fynd-list-all">
  <div class="fynd-list-head" >
    <a href="#" class="fynd-list-selector <?php echo $buyClass ?>" id="fynd-list-buy">KÖP</a>
    <a href="#"  class="fynd-list-selector <?php echo $sellClass ?>"  id="fynd-list-sell">SÄLJ</a>
  </div>
  <ul id="list-buy" class="fynd-list <?php echo $buyClassHide; ?>">
      <?php echo getAllFyndListsByType('kop'); ?>
  </ul>
  <ul id="list-sell" class="fynd-list <?php echo $sellClassHide; ?>">
      <?php echo getAllFyndListsByType('salj'); ?>
  </ul>          
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    
    //open the same category as the shown fynd post
    $(<?php echo $js_show_id; ?>).show();
    
        
    $('#fynd-list-buy').click(function(event) {
      hideAllArticleLists();
      $('#list-buy').show('slow');
      $('#list-sell').hide('slow');      
      $('#fynd-list-buy').addClass('fynd-list-selected');
      $('#fynd-list-sell').removeClass('fynd-list-selected');
    });    

    $('#fynd-list-sell').click(function(event) {
      hideAllArticleLists();      
      $('#list-buy').hide('slow');
      $('#list-sell').show('slow');
      $('#fynd-list-buy').removeClass('fynd-list-selected');
      $('#fynd-list-sell').addClass('fynd-list-selected');      
    });    
    
    function hideCategories(){
      $('#list-buy').hide('slow');
      $('#list-sell').hide('slow');  
    }        
    
    function hideAllArticleLists(){
      $('.article-list').hide('slow'); 
    }        
    

    $('.fynd-cat').click(function (event) {
      event.preventDefault();
      var showUl = $(this).attr('href');
      $('#'+showUl).slideToggle();
    });    
    
  });  
</script>      
