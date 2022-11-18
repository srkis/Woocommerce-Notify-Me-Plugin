// document.addEventListener('DOMContentLoaded', function GetFavColor() {
//   var wooButton = document.querySelector('.woo-notifyme-button');
//   wooButton.style.backgroundColor = "red";
// });


jQuery(document).ready( function () {

  	var appendthis = ( "<div class='modal-overlay js-modal-close'></div><div id='popup' class='modal-box'>"+"<header><a href='#' class='js-modal-close close'>×</a>"+
  		"<h3><a href='https://srdjan.icodes.rocks/'>Woo - Notify Me</a>  </h3>"+
  	"</header><div class='modal-body'><p>Enter your email address and we will notify you when product price is changed</p><label for='wc-notify-email'>Email Address:</label><input type='email' id='wc-notify-email' name='wc-notify-email'></div>"+
  	"<footer><div id='showMsg'></div><button id='wc_submit' class='wc-notify-submit-button'>Submit</button></footer></div>"+
  "<a class='js-open-modal' href='#' data-modal-id='popup'> Click me </a>");



  	// $("a[data-modal-id]").click(function(e) {
    //
    // 	e.preventDefault();
  	// 	//$("body").append(appendthis);
  	// 	$(".modal-overlay").fadeTo(500, 0.7);
  	// 	//$(".js-modalbox").fadeIn(500);
  	// 	var modalBox = $(this).attr('data-modal-id');
  	// 	$("#" + modalBox).fadeIn($(this).data());
  	// });
    //
  	// $(".js-modal-close, .modal-overlay").click(function() {
  	// 	$(".modal-box, .modal-overlay").fadeOut(500, function() {
  	// 		$(".modal-overlay").remove();
  	// 	});
  	// });
    //
  	// $(window).resize(function() {
  	// 	$(".modal-box").css({
  	// 		top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
  	// 		left: ($(window).width() - $(".modal-box").outerWidth()) / 2
  	// 	});
  	// });
    //
  	// $(window).resize();



  jQuery(".woo-notifyme-button").click(function(e) {

    jQuery("body").append(appendthis);
    e.preventDefault();
        //$("body").append(appendthis);
        jQuery(".modal-overlay").fadeTo(500, 0.7);
        //$(".js-modalbox").fadeIn(500);
        var modalBox = jQuery(this).attr('data-modal-id');
        let product_id = jQuery(this).data('notify-me');

        jQuery('#popup').attr('data-wc_notifyme_product_id', product_id);
        jQuery("#popup").fadeIn(jQuery(this).data());

     jQuery(".js-modal-close, .modal-overlay").click(function() {
         jQuery(".modal-box, .modal-overlay").fadeOut(500, function() {
         jQuery(".modal-overlay").remove();
       });
    });

    jQuery(window).resize(function() {
      jQuery(".modal-box").css({
        top: (jQuery(window).height() - jQuery(".modal-box").outerHeight()) / 2,
        left: (jQuery(window).width() - jQuery(".modal-box").outerWidth()) / 2
      });
    });

    jQuery(window).resize();

    });


 

 jQuery(document).on("click", "#wc_submit", function(){

      let emailaddress = jQuery('#wc-notify-email').val();
      let modal = document.getElementById('popup');
      let product_id = modal.getAttribute('data-wc_notifyme_product_id');
      let params = {};
    
    if( !isValidEmailAddress( emailaddress ) ) { 
            jQuery("#showMsg").append("<span class='invalid_email'>Email address is not valid!</span>");
            jQuery("#showMsg").fadeOut(5000, function() {
            jQuery("#showMsg").remove();
          });
         return;
     }

        params.type = 'wc_notifyme_insert';
				params.email = emailaddress;
				params.product_id = product_id;
     
        ajaxCall(params);

 })


 function isValidEmailAddress(emailAddress) {
  var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
  return pattern.test(emailAddress);
};



function ajaxCall(params) {

  params.action = 'wc_notifyme_ajax';

  if( typeof params.action == 'undefined') return;

     //Some event will trigger the ajax call, you can push whatever data to the server, simply passing it to the "data" object in ajax call
   jQuery.ajax({
    type: 'GET',
    dataType : "json",
      url: getBaseURL()+"wp-admin/admin-ajax.php", 
      data:params,

     success: function( response ){

      if(response[0].hasOwnProperty("success")) {

      jQuery("#showMsg").append("<span class='wc_success_subscribed'>"+response[0].success+"</span>");
            jQuery("#showMsg").fadeOut(5000, function() {
            jQuery("#showMsg").remove();

          });
        }else{

          jQuery("#showMsg").append("<span class='invalid_email'>"+response[0].fail+"</span>");
           jQuery("#showMsg").fadeOut(5000, function() {
           jQuery("#showMsg").remove();

         });
        }

     },

     error: function (request, status, error) {
    //alert(request.responseText);
    // console.log('request',request);
    // console.log('status:', status);
    // console.log('error', error);
  }

   });

 }


  function getBaseURL() {
    var url = location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));

    if (baseURL.indexOf('http://localhost') != -1) {

      var url = location.href;
      var pathname = location.pathname;
      var index1 = url.indexOf(pathname);
      var index2 = url.indexOf("/", index1 + 1);
      var baseLocalUrl = url.substr(0, index2);

      return baseLocalUrl + "/";
    }
    else {

      return baseURL + "/";
      }

    }
  
});


