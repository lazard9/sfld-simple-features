jQuery(document).ready( function() {
   ppp = 2; // Post per page
   var pageNumber = 2;


   function load_more_posts() {
      pageNumber++;
      var str = '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=sfld_ajax_load_more_posts';
      jQuery.ajax({
         type: "POST",
         dataType: "html",
         url: myAjax.ajaxurl,
         // url: ajax_posts.ajaxurl,
         data: str,
         success: function(data) {
            var $data = jQuery(data);
            if($data.length) {
               jQuery("#ajax-posts").append($data);
               jQuery("#more_posts").attr("disabled",false);
            } else {
               jQuery("#more_posts").hide();
            }
         },
         error : function(jqXHR, textStatus, errorThrown) {
            $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
         }

      });
      return false;
   }

   jQuery("#more_posts").on("click",function() { // When btn is pressed.

      jQuery("#more_posts").attr("disabled",true); // Disable the button, temp.
      load_more_posts();

   });
});