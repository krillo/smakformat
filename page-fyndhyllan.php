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



    <div id="overlay">
      <div id="fynd_pop">
        <h2>Lägg in en annons:</h2>
        <form action="#" id="fynd_form" mothod="post">
          <ul>
            <fieldset class="annons-form">
              <li>
                <label for="name">Namn <span class="mandatory">*</span></label>
                <input name="name" id="name" value="" type="text" />
              </li>
              <li>
                <label for="mobile">Mobiltelefon <span class="mandatory">*</span></label>
                <input name="mobile" id="mobile" value="" type="text" class="tel"/>
              </li>		
              <li>
                <label for="email">E-post <span class="mandatory">*</span></label>
                <input name="email" id="email" value="" type="text"/>
              </li>
              <li>
                <label for="category">Kategori</label>
                <input name="category" id="category" value="" type=""/>
              </li>
              <li>
                <label for="rubrik">Rubrik <span class="mandatory">*</span></label>
                <input name="rubrik" id="rubrik" value="" type="text"/>
              </li>
              <li>
                <label for="content">Annonstext <span class="mandatory">*</span></label>
                <input name="content" id="content" value="" type="textfield"/>
              </li>
              <li>          
                <label for="terms">Ja jag har läst och godkänner villkoren <span class="mandatory">*</span></label>
                <input name="terms" id="terms" type="checkbox" style="float:left;" value ="Ja"/>
              </li>
            </fieldset>
          </ul>        
          <input name="skicka" id="skicka" type="submit" style="float:right;" value ="Skicka"/>
        </form>
      </div>    
    </div>

    <style>
      #fynd_pop{padding:10px 20px;width:280px;height:380px;border-radius: 10px 10px;border: 2px solid #E2E2E2;float:left;}
      #fynd_pop h2{float:left;}
      #fynd_form{color:#fff;background-color: blue;width:90%;height:90%;padding:15px 20px;float:left;border-radius: 5px 5px;}
      #fynd_form INPUT{background-color: lightblue;}
      
      
      #fynd_form INPUT.invalid {border-color: red;border-style: solid;border-width: 1px;}
      #overlay{}
    </style>    


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
          //success: function() {
          //  addFynd(event);
          //},
          errorPlacement: function (error, element) {
            error.insertBefore(element);
          }         
        });
        
    
        /**
         * Ajax call to add the "fynd"
         */
        function addFynd(event){
          event.preventDefault();
          $("#zip-button-button").show();            
          var data = {
            action : 'add_fynd',
            name: $("#name").val(),
            mobile: $("#mobile").val(),
            email: $("#email").val(),
            title: $("#title").val(),
            content: $("#content").val(),
            terms: $("#terms").val()
          };
          $.post('/wp-admin/admin-ajax.php', data, function(response) {
            if(response.success == 1){
              $("#zip-ok").removeClass("hidden");
              $("#zip-ok span").html(response.city);
              $("#ss-container").removeClass("hidden");
              $("#zip-nok").addClass("hidden");
            }else{
              $("#zip-nok").removeClass("hidden");
              $("#zip-ok").addClass("hidden");
              $("#ss-container").addClass("hidden");
            }        
          });  
        }


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