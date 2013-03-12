<?php
/**
 * Page Template
 *
 * This is the start page for Fyndhyllan.
 * Fyndhyllan is a buy and sell market aka "mini blocket"
 *
 * @author Kristain Erendi
 * @package Smakformat
 * @subpackage Template
 */
get_header();
?>
<div id="content" class="col-full">
  <div id="main-sidebar-container">    
    <div id="main">                     
      <?php
      if (have_posts()) {
        while (have_posts()) {
          the_post();
          ?>
          <div <?php post_class(); ?> >
            <div class="entry">
              <div id="chef">
                <div id="chef-text" class="">
                  <?php the_content(); ?>
                </div>
                <div class="clear"></div>
                <div id="chef-buttons"><input type="button" id="sell-button" value="Jag vill sälja" class="chef-button" /><input type="button" id="buy-button" value="Jag vill köpa" class="chef-button" /></div>
              </div>              
              <?php include 'snippet_fynd_puffs.php'; ?>    
            </div><!-- /.entry -->
          </div><!-- /.post -->
          <?php
        }
      }
      ?>     
    </div><!-- /#main -->
    <?php woo_main_after(); ?>

    <div id="sidebar">
      <?php include_once 'snippet_list_fynd.php'; ?>
      <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("fyndhyllan")) : endif; ?>    
    </div>



    <div class="overlay hidden">
      <div id="fynd_pop">
        <h2>Lägg in en annons:</h2>


        <div id="fynd_form_content">

          <form id="imageform" method="post" enctype="multipart/form-data" action='/wp-content/themes/smakformat/action/jquery_upload.php'>
            <ul>
              <li>
                <label for="price">Lägg till bild</label> <div id='preview'></div>
              </li>
              <li>
                <input type="file" name="photoimg" id="photoimg" />
              </li>
            </ul>
          </form>





          <form action="#" id="fynd_form" mothod="post">
            <input name="type" id="type" type="hidden"/>
            <input name="filename" id="filename" type="hidden"/>
            <ul>
              <fieldset class="annons-form">
                <li>
                  <label for="name">Namn <span class="mandatory">*</span></label>
                  <input name="name" id="name" value="" type="text" />
                </li>
                <li>
                  <label for="mobile">Mobil <span class="mandatory">*</span></label>
                  <input name="mobile" id="mobile" value="" type="text" class="tel"/>
                </li>		
                <li>
                  <label for="email">E-post <span class="mandatory">*</span></label>
                  <input name="email" id="email" value="" type="text"/>
                </li>
                <!--li>
                  <label for="category">Kategori</label>
                  <input name="category" id="category" value="" type=""/>
                </li-->
                <li>
                  <label for="rubrik">Rubrik <span class="mandatory">*</span></label>
                  <input name="rubrik" id="rubrik" value="" type="text"/>
                </li>
                <li>
                  <label for="content">Annonstext <span class="mandatory">*</span></label>
                  <textarea  name="content" id="annons-txt" ></textarea>
                </li>

                <li>
                  <label for="price">Pris kr</label>
                  <input name="price" id="price" value="" type=""/>
                </li>
                <li>          
                  <label for="terms" id="terms-label">Ja jag har läst och godkänner villkoren <span class="mandatory">*</span></label>
                  <input name="terms" id="terms" type="checkbox" style="float:left;" value ="Ja"/>
                </li>
              </fieldset>
            </ul>        
            <input name="skicka" id="skicka" type="submit" style="float:right;" value ="Skicka"/>
          </form>

        </div>












        <script type="text/javascript">
          jQuery(document).ready(function($) 
          { 
            $('#photoimg').live('change', function()	
            { 
              $("#preview").html('');
              $("#preview").html('<img src="/wp-content/themes/smakformat/images/ajax_loader.gif" alt="Laddar upp..."/>');
              $("#imageform").ajaxForm(
              {
                target: '#preview', 
                success: function(response){
                  if(response.success == 1){
                    $("#preview").html(response.filename);
                    $("#filename").val(response.filename);
                  } else {
                    $("#preview").html(response.error_txt);
                  }
                }
              }).submit();
            });
          }); 
        </script>







      </div>    
    </div>



    <script type="text/javascript">
      jQuery(document).ready(function($){   
    
        // validate signup form on keyup and submit
        var validator = $("#fynd_form").validate({
          errorClass: "invalid",
          validClass: "valid", 
          rules: {
            name:{
              required: true,
              minlength: 3
            },
            mobile:{
              required: true,
              minlength: 6
            },
            email:{
              required: true
            },
            rubrik:{
              required: true,
              minlength: 2
            },
            content:{
              required: true,
              minlength: 3
            },
            terms: "required"
          },
          messages:{
            name:{
              required: "",
              minlength: ""
            },
            mobile:{
              required: "",
              minlength: ""
            },
            email:{
              required: ""
            },
            rubrik:{
              required: "",
              minlength: ""
            },
            content:{
              required: "",
              minlength: ""
            },
            terms: ""
          },
          errorPlacement: function (error, element) {
            error.insertBefore(element);
          }, 
          submitHandler: function() { 
            //event.preventDefault(); 
            addFynd();
          }
        });
        
 
        /**
         * Ajax call to add the "fynd"
         */
        function addFynd(event){ 
          var url = "<?php echo site_url(); ?>";
          var data = {
            action : 'add_fynd',
            name: $("#name").val(),
            mobile: $("#mobile").val(),
            email: $("#email").val(),
            title: $("#rubrik").val(),
            content: $("#annons-txt").val(),
            terms: $("#terms").val(),
            price: $("#price").val(),
            type: $("#type").val(),
            filename: $("#filename").val()
          };
          $.post('/wp-admin/admin-ajax.php', data, function(response) {
            if(response.success == 1){
              $(".overlay").hide();
              window.location.href = url + "/?p=" + response.post_id + "&fyndtype=" + response.annons_type;
            }else{
              $(".overlay").hide();              
              alert("Något har gått fel, var vänlig prova igen.");
            }        
          });  
        }
 
 
 
 
 
 
 
 
 
        function hideAllOverlays(){
          $('#terms-overlay').hide('slow');
          $('#rut-info-overlay').hide('slow');
          $('#price-overlay').hide('slow');
        }    
    
    
        $("#sell-button").click(function(event) {
          event.preventDefault();
          $("#type").val("salj");
          $(".overlay").show();
        });     
        
        $("#buy-button").click(function(event) {
          event.preventDefault();
          $("#type").val("kop");          
          $(".overlay").show();
        });     
    
    
 

        /**
         * if enter is pressed in hte #ss input box, do the persInfo lookup
         */ 
        $('#ss').keypress(function (event) {
          if (event.which == 13 && $(this).val().length >= 10 ) {
            getPersInfo(event);
          }
        });


        /**
         * Do the persInfo lookup
         */        
        $(".ss-button").click(function(event) {
          event.preventDefault();
          getPersInfo(event);
        });        
    

        /**
         * Ajax call to get peronal info
         */        
        function getPersInfo(event){
          event.preventDefault();
          $("#ss-button-submit").hide();
          $("#ss-button-button").show();
                
          $("#ss-progress").css("display", "block");    //show progress wheel
          ss = $('#ss').val();
          var data = {
            action : 'get_pers_info',
            ss: ss
          };
          $.post('/wp-admin/admin-ajax.php', data, function(response) {
            $("#ss-progress").hide();  
            if(response.success == 1){
              $("#pers-container").removeClass("hidden");
              $("#ss-error").addClass("hidden");
              $("#firstname").val(response.fname);
              $("#firstname_show").val(response.fname);
              $("#lastname").val(response.lname);
              $("#lastname_show").val(response.lname);
              $("#street1").val(response.street1);
              $("#street1_show").val(response.street1);
              $("#street2").val(response.street2);
              $("#zip").val(response.zip);
              $("#zip_show").val(response.zip);
              $("#city").val(response.city);
              $("#city_show").val(response.city);
              $("#phone").val(response.phone);
              $("#email").val(response.email);          
            }else{
              $("#ss-error").removeClass("hidden");
              $("#pers-container").addClass("hidden");
            }        
          });
        }

      });
    </script>




  </div><!-- /#main-sidebar-container -->         
  <?php get_sidebar('alt'); ?>
</div><!-- /#content -->
<?php woo_content_after(); ?>
<?php get_footer(); ?>