<?php 
!empty($_REQUEST['fyndtype']) ? $fyndtype = $_REQUEST['fyndtype'] : $fyndtype = '';
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
  default:
    break;
}
?>

<div id="fynd-list-all">
  <div class="fynd-list-head" >
    <a href="#" class="fynd-list-selector <?php echo $buyClass ?>" id="fynd-list-buy">KÖP</a>
    <a href="#"  class="fynd-list-selector <?php echo $sellClass ?>"  id="fynd-list-sell">SÄLJ</a>
  </div>
  <ul id="list-buy" class="fynd-list <?php echo $buyClassHide; ?>">
    <?php getFyndList(false); ?>            
    <li><a href="#">Stekpanna</a></li>
    <li><a href="#">Wookpanna</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Kastrull</a></li>
    <li><a href="#">Mixer</a></li>
    <li><a href="#">Stekpanna</a></li>
    <li><a href="#">Wookpanna</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Kastrull</a></li>
    <li><a href="#">Mixer</a></li>
    <li><a href="#">Stekpanna</a></li>
    <li><a href="#">Wookpanna</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Kastrull</a></li>
    <li><a href="#">Mixer</a></li>
    <li><a href="#">Stekpanna</a></li>
    <li><a href="#">Wookpanna</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
    <li><a href="#">Kastrull</a></li>
    <li><a href="#">Mixer</a></li>
    <li><a href="#">Stekpanna</a></li>
    <li><a href="#">Wookpanna</a></li>
    <li><a href="#">Vinglas i kristall</a></li>
  </ul>
  <ul id="list-sell" class="fynd-list <?php echo $sellClassHide; ?>">
    <?php getFyndList(true); ?>     

  </ul>          
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){
    
    
    $('#fynd-list-buy').click(function(event) {
      $('#list-buy').show('slow');
      $('#list-sell').hide('slow');      
      $('#fynd-list-buy').addClass('fynd-list-selected');
      $('#fynd-list-sell').removeClass('fynd-list-selected');
    });    

    $('#fynd-list-sell').click(function(event) {
      $('#list-buy').hide('slow');
      $('#list-sell').show('slow');
      $('#fynd-list-buy').removeClass('fynd-list-selected');
      $('#fynd-list-sell').addClass('fynd-list-selected');      
    });    
    
    //$("#ss-progress").show();
    $('#no-city').hide();
    $('.choose-areas').hide(); 
    var kommun_id = $('#kommun-id').val();
    if(kommun_id == ''){
      $('.choose-areas').hide();
      $('#no-city').show();
    } else{
      $('.choose-areas').show();
      getPutsschema(kommun_id);
    }
    
    /**
     * Ajax call to get all areas and schedule id's 
     */
    function getPutsschema(kommun_id){
      var data = {
        action : 'get_putsschema',
        kommun_id: kommun_id
      };
      $.post('/wp-admin/admin-ajax.php', data, function(response) {
        var rows = '';
        var city = '';
        $(response).each(function( index, row ) {
          var li = '<input type="radio" id="id-'+row.id+'" name="area" class="area" value="'+row.schedule+'"><label for="id-'+row.id+'">'+row.area+' ('+row.schedule+')</label><br />';
          rows += li;
          city = row.city;
        });
        $('#area-list').append(rows);
        $('#city').html(city);        
      });  
    }
    
    function hideAllPutsschema(){
      $('#schedule-1').hide('slow');
      $('#schedule-2').hide('slow');
      $('#schedule-3').hide('slow');
      $('#schedule-4').hide('slow');
      $('#schedule-5').hide('slow');
      $('#schedule-6').hide('slow');
      $('#schedule-7').hide('slow');      
    } 
 

    $('.overlay').click(function(event) {
      hideAllPutsschema();
    });

 
    $('.area').live('click', function(e){
      hideAllPutsschema();
      var schedule_id = $(this).attr('value');    
      $('#schedule-'+schedule_id).show();
    });

  });  
</script>      
