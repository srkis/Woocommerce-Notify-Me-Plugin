jQuery(document).ready( function () {

  var params = {};
  params.action = 'wc_notifyme_get_subscribers';

  ajaxCall(params);

  function ajaxCall(params) {

      if( typeof params.action == 'undefined') return;
    
        //Some event will trigger the ajax call, you can push whatever data to the server, simply passing it to the "data" object in ajax call
      jQuery.ajax({
        type: 'GET',
        dataType : "json",
          url: getBaseURL()+"wp-admin/admin-ajax.php", 
          data:params,  // this is the function in your functions.php that will be triggered - moze da se stavi u root od plugin-a (nba-live.php). Ja sam stavio u class-nba-live u define_public_hooks a metoda je u clas-nba-live-public
    
        success: function( response ){
    
          populateDataTable(response);
    
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



 function populateDataTable(data) {

    var table = jQuery('#wc_notify_me_subscribers_table').dataTable({
  
    });
  
    var row = 1;
    jQuery.each(data, function (index, value) {
        jQuery('#wc_notify_me_subscribers_table').dataTable().fnAddData( [
            value.email,
            value.product_id  ,
            value.status ,
            value.date,
          ]);
       row++;
    });
  
  }
  


//jscolor.trigger('input'); // triggers 'onInput' on all color pickers when they are ready

var changeButtonTxt, changeButtonBgColor;
var defaultColor = "#FFFFFF";
var defaultBgColor = "#AA66CC";


//window.addEventListener("load", buttonTextColor, false);
//window.addEventListener("load", buttonBgColor, false);

window.addEventListener("load", wc_notifyme_get_btn_settings, false);
window.addEventListener("load", wc_notifyme_get_html_template_settings, false);

function wc_notifyme_get_btn_settings(){

  var params = {};
  params.action = 'wc_notifyme_get_json_button_settings';


  jQuery.ajax({
    type: 'GET',
    dataType : "json",
      url: getBaseURL()+"wp-admin/admin-ajax.php", 
      data:params,  // this is the function in your functions.php that will be triggered - moze da se stavi u root od plugin-a (nba-live.php). Ja sam stavio u class-nba-live u define_public_hooks a metoda je u clas-nba-live-public
  
    success: function( response ){

      if(response[0].wc_notifyme_show_btn_main_page == 'yes') {
        jQuery('#notifyme_main').prop("checked", 1);
      }else{
        jQuery('#notifyme_main').prop("checked", 0);
      }

      if(response[0].wc_notifyme_show_btn_single_page == 'yes') {
        jQuery('#notifyme_single').prop("checked", 1);
      }else{
        jQuery('#notifyme_single').prop("checked", 0);
      }

      buttonTextColor(response);
      buttonBgColor(response);
  
    },
  
    error: function (request, status, error) {
    //alert(request.responseText);
    // console.log('request',request);
    // console.log('status:', status);
    // console.log('error', error);
  }
  
  });

}


function buttonTextColor(res) {
  changeButtonTxt = document.querySelector("#changeButtonTxt");
  document.getElementById("demoButtonTextColor").style.color = res[0].wc_notifyme_btn_text_color;
  document.getElementById("demoButtonTextColor").innerHTML = res[0].wc_notifyme_btn_text;
  document.getElementById("notifymeButtonText").value = res[0].wc_notifyme_btn_text;
  
  changeButtonTxt.value = res[0].wc_notifyme_btn_text_color;
  changeButtonTxt.addEventListener("input", changeButtonText, false);
  changeButtonTxt.select();
}


function buttonBgColor(res){

  console.log('res',res[0].wc_notifyme_btn_bg_color);
  document.getElementById("notifyme_demoButton").style.backgroundColor = res[0].wc_notifyme_btn_bg_color;
  changeButtonBgColor = document.querySelector("#changeButtonBgColor");
  changeButtonBgColor.value = res[0].wc_notifyme_btn_bg_color;
  changeButtonBgColor.addEventListener("input", buttonChangeBgColor, false);
  changeButtonBgColor.select();

}


function buttonChangeBgColor(event) {
  document.getElementById("notifyme_demoButton").style.backgroundColor = event.target.value;
}

function changeButtonText(event) {
  document.getElementById("demoButtonTextColor").style.color = event.target.value;
}


//Save button settings
jQuery("#submitSettingsBtn").click(function(){

    var params = {};
    var buttonTxtcolor =  document.getElementById("changeButtonTxt").value;
    var buttonBgColor =  document.getElementById("changeButtonBgColor").value;
    var buttonText =  document.getElementById("notifymeButtonText").value;


    var wc_notifyme_single = jQuery('#notifyme_single').is(':checked'); 
    var wc_notifyme_main = jQuery('#notifyme_main').is(':checked'); 


    wc_notifyme_single = (wc_notifyme_single) ? 'yes' : 'no';
    wc_notifyme_main = (wc_notifyme_main) ? 'yes' : 'no';


    params.action = 'wc_notifyme_update_button_settings';
    params.wc_notifyme_btn_text_color = buttonTxtcolor;
    params.wc_notifyme_btn_bg_color  = buttonBgColor;
    params.wc_notifyme_btn_text  = buttonText;
    params.wc_notifyme_single = wc_notifyme_single;
    params.wc_notifyme_main = wc_notifyme_main;

    jQuery.ajax({
      type: 'POST',
      dataType : "json",
        url: getBaseURL()+"wp-admin/admin-ajax.php", 
        data:params,  // this is the function in your functions.php that will be triggered - moze da se stavi u root od plugin-a (nba-live.php). Ja sam stavio u class-nba-live u define_public_hooks a metoda je u clas-nba-live-public

      success: function( response ){

        if(response[0].hasOwnProperty("success")) {

        jQuery("#showSubmitMsg").append("<span class='wc_success_subscribed'>"+response[0].success+"</span>");
        jQuery("#showSubmitMsg").fadeOut(5000, function() {
        jQuery("#showSubmitMsg").remove();

      });
    }else{

      jQuery("#showSubmitMsg").append("<span class='invalid_email'>"+response[0].fail+"</span>");
       jQuery("#showSubmitMsg").fadeOut(5000, function() {
       jQuery("#showSubmitMsg").remove();

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
});


function wc_notifyme_get_html_template_settings()
{

  var params = {};
  params.action = 'wc_notifyme_get_json_html_settings';

  jQuery.ajax({
    type: 'GET',
    dataType : "json",
      url: getBaseURL()+"wp-admin/admin-ajax.php", 
      data:params,  // this is the function in your functions.php that will be triggered - moze da se stavi u root od plugin-a (nba-live.php). Ja sam stavio u class-nba-live u define_public_hooks a metoda je u clas-nba-live-public
  
    success: function( response ){

      htmlTemplateBgColor(response);
      htmlTemplateLinksColor(response);
    },
  
    error: function (request, status, error) {
    //alert(request.responseText);
    // console.log('request',request);
    // console.log('status:', status);
    // console.log('error', error);
  }
  
  });

}



  var changeTemplateHeaderBgColor, changeTemplateLinksColor;

  function htmlTemplateBgColor(res){

    
    document.getElementById("wc_notifyme_html_header").style.backgroundColor = res[0].wc_notifyme_template_header ;
    document.getElementById("wc_notifyme_html_header_bottom").style.backgroundColor = res[0].wc_notifyme_template_header ;
    document.getElementById("wc_last_footer_head").style.backgroundColor = res[0].wc_notifyme_template_header;
    document.getElementById("notifymeHeaderText").value = res[0].wc_notifyme_template_header_txt;
    jQuery('.wc_html_header_text_1').text(res[0].wc_notifyme_template_header_txt);
    jQuery('.wc_change_social_text').text(res[0].wc_notifyme_template_social_txt);
    jQuery('#notifymeSocialText').val(res[0].wc_notifyme_template_social_txt );
    jQuery('#notifymefooter_txt1').val(res[0].wc_notifyme_template_footer_txt1);
    jQuery('#notifymefooter_txt2').val(res[0].wc_notifyme_template_footer_txt2);
    jQuery('#notifymefooter_txt3').val(res[0].wc_notifyme_template_footer_txt3);
    jQuery('#notifymefooter_txt4').val(res[0].wc_notifyme_template_footer_txt4);
    jQuery('#notifymeUnsubscribeText').val(res[0].wc_notifyme_template_unsubscribe_txt);
    jQuery('.wc_html_footer_text_1').text(res[0].wc_notifyme_template_footer_txt1);
    jQuery('.wc_html_footer_text_2').text(res[0].wc_notifyme_template_footer_txt2);
    jQuery('.wc_html_footer_text_3').text(res[0].wc_notifyme_template_footer_txt3);
    jQuery('.wc_html_footer_text_4').text(res[0].wc_notifyme_template_footer_txt4);
    jQuery('.wc_html_unsubscribe_text').text(res[0].wc_notifyme_template_unsubscribe_txt);

    //jQuery('#notifymeProductLinksText').val(res[0].wc_notifyme_template_header_txt); //link text nemam u bazi

    //Social inputs
    var notifymeFBText =  jQuery( '#notifymeFBText' );
    var notifymeTWText =  jQuery( '#notifymeTWText' );
    var notifymeYTText =  jQuery( '#notifymeYTText' );
    var notifymeLNText =  jQuery( '#notifymeLNText' );
    var notifymeINText =  jQuery( '#notifymeINText' );


       // //Check if some inputs are empty, hide icons in template header
    var fbIcon =  jQuery( '#wc_social_fb_icon' );
    var twIcon =  jQuery( '#wc_social_tw_icon' );
    var ytIcon =  jQuery( '#wc_social_yt_icon' );
    var lnIcon =  jQuery( '#wc_social_ln_icon' );
    var inIcon =  jQuery( '#wc_social_in_icon' );

    
    for( i in res[0].social){
     
      if(res[0].social[i] == ""){
          switch(i) {
              case "fb":
                fbIcon.css("display", "none");
                break;
              case "tw":
                twIcon.css("display", "none");
                break;
              case "yt":
                ytIcon.css("display", "none");
                break;
              case "ln":
                lnIcon.css("display", "none");
                break;  
              case "in":
                inIcon.css("display", "none");
                break;
          }
      }else{

          fbIcon[0].href = res[0].social.fb;
          twIcon[0].href = res[0].social.tw;
          ytIcon[0].href = res[0].social.yt;
          lnIcon[0].href = res[0].social.ln;
          inIcon[0].href = res[0].social.in;

          notifymeFBText.val( res[0].social.fb );
          notifymeTWText.val( res[0].social.tw );
          notifymeYTText.val( res[0].social.yt );
          notifymeLNText.val( res[0].social.ln );
          notifymeINText.val( res[0].social.in );
          
      }
    }
    
    
    
    //Add values from database into social inputs

    

 



    





    changeTemplateHeaderBgColor = document.querySelector("#changeHeaderBgColor");
    changeTemplateHeaderBgColor.value = res[0].wc_notifyme_template_header;
    changeTemplateHeaderBgColor.addEventListener("input", htmlTemlateChangeBgColor, false);
    changeTemplateHeaderBgColor.select();

  }


  function htmlTemlateChangeBgColor(event) {
    document.getElementById("wc_notifyme_html_header").style.backgroundColor = event.target.value;
    document.getElementById("wc_notifyme_html_header_bottom").style.backgroundColor = event.target.value;
    document.getElementById("wc_last_footer_head").style.backgroundColor = event.target.value;
  }


  function htmlTemplateLinksColor(res) 
  {

    var productLinks = document.querySelectorAll('.productColorLinks');

    productLinks.forEach( function (index, value) {
      //console.log(index, value);
      index.style.color = res[0].wc_notifyme_template_link_color;
  });
    
    changeTemplateLinksColor = document.querySelector("#changeLinksColor");
    changeTemplateLinksColor.value = res[0].wc_notifyme_template_link_color;
    changeTemplateLinksColor.addEventListener("input", htmlTemlateChangeLinksColor, false);
    changeTemplateLinksColor.select();

  }


  function htmlTemlateChangeLinksColor(event) {

    var productLinks = document.querySelectorAll('.productColorLinks');


    productLinks.forEach( function (index, value) {
      //console.log(index, value);
      index.style.color =  event.target.value;
  });
 //   document.getElementById("productColorLinks").style.color = event.target.value;
   
  }


  jQuery("#submitHtmlSettings").click(function(){

    var params = {};
    var headersBgColor =  document.getElementById("changeHeaderBgColor").value;
    var linksColor =  document.getElementById("changeLinksColor").value;
    var notifymeHeaderText =  document.getElementById("notifymeHeaderText").value;
    var notifymeLinkText =  document.getElementById("notifymeProductLinksText").value;
    var notifymeSocialText =  document.getElementById("notifymeSocialText").value;
    var notifymefooter_txt1 =  document.getElementById("notifymefooter_txt1").value;
    var notifymefooter_txt2 =  document.getElementById("notifymefooter_txt2").value;
    var notifymefooter_txt3 =  document.getElementById("notifymefooter_txt3").value;
    var notifymefooter_txt4 =  document.getElementById("notifymefooter_txt4").value;
    var notifymeUnsubscribeText =  document.getElementById("notifymeUnsubscribeText").value;
    var notifymeFBText =  document.getElementById("notifymeFBText").value;
    var notifymeTWText =  document.getElementById("notifymeTWText").value;
    var notifymeYTText =  document.getElementById("notifymeYTText").value;
    var notifymeLNText =  document.getElementById("notifymeLNText").value;
    var notifymeINText =  document.getElementById("notifymeINText").value;


    params.action = 'wc_notifyme_update_html_template_settings';
    params.headersBgColor = headersBgColor;
    params.linksColor  = linksColor;
    params.notifymeHeaderText  = notifymeHeaderText;
    params.notifymeLinkText = notifymeLinkText; // Ovo mora da se ubaci u tabelu jer ne postoji. Kada se aktivira plugin da se doda i ovo polje
    params.notifymeSocialText = notifymeSocialText;
    params.notifymefooter_txt1 = notifymefooter_txt1;
    params.notifymefooter_txt2 = notifymefooter_txt2;
    params.notifymefooter_txt3 = notifymefooter_txt3;
    params.notifymefooter_txt4 = notifymefooter_txt4;
    params.notifymeUnsubscribeText = notifymeUnsubscribeText;
    params.notifymeFBText = notifymeFBText;
    params.notifymeTWText = notifymeTWText;
    params.notifymeYTText = notifymeYTText;
    params.notifymeLNText = notifymeLNText;
    params.notifymeINText = notifymeINText;

    jQuery.ajax({
      type: 'POST',
      dataType : "json",
        url: getBaseURL()+"wp-admin/admin-ajax.php", 
        data:params,  // this is the function in your functions.php that will be triggered - moze da se stavi u root od plugin-a (nba-live.php). Ja sam stavio u class-nba-live u define_public_hooks a metoda je u clas-nba-live-public

      success: function( response ){

        if(response[0].hasOwnProperty("success")) {

        jQuery("#showSubmitMsg").append("<span class='wc_success_subscribed'>"+response[0].success+"</span>");
        jQuery("#showSubmitMsg").fadeOut(5000, function() {
        jQuery("#showSubmitMsg").remove();

      });
    }else{

      jQuery("#showSubmitMsg").append("<span class='invalid_email'>"+response[0].fail+"</span>");
       jQuery("#showSubmitMsg").fadeOut(5000, function() {
       jQuery("#showSubmitMsg").remove();

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

 });



});


function changeTextWhileTyping(className) {

  jQuery('input').keyup(function(event) {
    newText = event.target.value;
    jQuery(className).text(newText);

    if(jQuery(className).text() == ""){
      var placeholder = jQuery(this).attr('placeholder');
      jQuery(className).text(placeholder);
      className = "";
    }

    className = "";


  });  

  
}
