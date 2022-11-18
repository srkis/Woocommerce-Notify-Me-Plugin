<?php

class WC_Notifyme_Render_Html {

  public $url, $db, $table_name;
  function __construct($url)
  {
    $this->url = $url;
    global $wpdb;
	$this->db =& $wpdb;
    $this->table_name = $wpdb->prefix . 'notifyme_wc_email_template';
  }


  public function render_setting_page()
  {

   
    echo ' <div style="background-color: cadetblue; margin-top: 30px;" class="container text-center"><img class="" src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'"></div>';
    
    $woo_notifyme_setting_page = '<!DOCTYPE html>
      <html lang="en">
      <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">

      <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

      </head>

      <body>

      <div class="container" style="border-top: 1px solid #eee; margin-top: 20px;"></div>

    <div style="background:#FCFCFC; box-shadow: 0 5px 15px rgb(0 0 0 / 5%); opacity:1; margin-top: 20px;padding: 20px;" class="container">

  
      <h2>Notify Me - Settings</h2>
      <p>When you change certain product price users who subscribed for that product will get email notification about that</p>


      <div class="button-settings-pannel col-lg-12  ">
      <div class="panel panel-default panel-shadow">
        <div class="panel-heading course-heading show-button-panel-heading">
          <h4 class="show-button-panel-header-h4">Show Notify Me button options</h4></div>
        <div class="panel-body match-heights">
    
        <div class="form-group">
        <label class="container-checkbox">
        Show button on single product page. 
        <input id="notifyme_single" type="checkbox" checked="checked" required>
        <span class="checkmark-box"></span>
        </label>
        </div>
       
        <div class="form-group">
          <label class="container-checkbox">
          Show button on main shop page
          <input id="notifyme_main" type="checkbox">
          <span class="checkmark-box"></span>
          </label>
       </div>

    </div>

        <div class="panel-footer course-footer">
          <a href="#">Learn more</a>
        </div>
        </div>
        
    </div>


    <div class="button-settings-pannel col-lg-12  ">
    <div class="panel panel-default panel-shadow">
      <div class="panel-heading course-heading show-button-panel-heading">
        <h4 class="show-button-panel-header-h4">Change button style</h4></div>
      <div class="panel-body match-heights">
  
      <div class="form-group">

      <p>You can add additional style to the button using <b>.woo-notifyme-button{}</b> css class.</p>

      

      <p>Change button background color using color picker:</p>

      <label for="changeButtonBgColor">Button background color:</label>
      <input type="color" id="changeButtonBgColor">


      <div style="display:inline-block;" id="notifyme_demoButton" type="button" class="woo-notifyme-button btn-secondary"><span id="demoButtonTextColor">Notify me</span></div>  
     
     
      <p>Change button text color using color picker:</p>

      <label for="changeButtonTxt">Button text color:</label>
      <input type="color" id="changeButtonTxt">

    </div>

 

    <div class="form-group">

    <div class="form-group materail_input_block">
    <p>Enter new button text below:</p>
    <input id="notifymeButtonText" type="text" value="Notify Me" class="form-control materail_input" placeholder="Button Text">
  </div>

    </div>

    <div class="form-group">
    <div id="showSubmitMsg" style="float:left; color:green;"></div>
     <div style="display:inline-block; float:right;" id="submitSettingsBtn" type="button" class="submitSettingsButton"><span id="">Save Button Settings</span></div>  

  </div>



   

  </div>

     
      </div>
      
  </div>

      

  <div class="button-settings-pannel col-lg-12  ">
  <div class="panel panel-default panel-shadow">
    <div class="panel-heading course-heading show-button-panel-heading">
      <h4 class="show-button-panel-header-h4">Change email template text & style</h4></div>
    <div class="panel-body match-heights">

    <div class="form-group col-lg-4 ">

    <label for="changeHeaderBgColor">Change header background color:</label>
    <input type="color" id="changeHeaderBgColor">

    <p>Enter new header text below:</p>
    <div class="form-group materail_input_block">
   
    <input id="notifymeHeaderText" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_header_text_1\')" class="form-control materail_input" placeholder="Header Text">
  </div>

    <label for="changeLinksColor">Change links color:</label>
    <input type="color" id="changeLinksColor">

    <p>Enter new product links text below:</p>
    <div class="form-group materail_input_block">
    
    <input id="notifymeProductLinksText" type="text" value="" onkeyUp="changeTextWhileTyping(\'.productLinksText\')" class="form-control materail_input" placeholder="Check now">
  </div>

  <h5>Enter new social text below:</h5>
  <div class="form-group materail_input_block">
  
  <input id="notifymeSocialText" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_change_social_text\')" class="form-control materail_input" placeholder="Connect with us">
</div>

    <div id="wc_social_inputs">
    <h5>Enter social links below:</h5>
    <small>Leave empty if you dont want to show social icon</small>
    <div class="form-group materail_input_block">
   
    <input id="notifymeFBText" type="text" value="" class="form-control materail_input" placeholder="https:://facebook.com">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymeTWText" type="text" value="" class="form-control materail_input" placeholder="https:://twitter.com">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymeYTText" type="text" value="" class="form-control materail_input" placeholder="https:://youtube.com">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymeLNText" type="text" value="" class="form-control materail_input" placeholder="https:://linkedin.com">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymeINText" type="text" value="" class="form-control materail_input" placeholder="https:://instagram.com">
    </div>

    </div>


    <div class="form-group materail_input_block">
    <h5>Enter new footer text 1 bellow:</h5>
    <input id="notifymefooter_txt1" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_footer_text_1\')" class="form-control materail_input" placeholder="Footer text 1">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymefooter_txt2" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_footer_text_2\')" class="form-control materail_input" placeholder="Footer text 2">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymefooter_txt3" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_footer_text_3\')" class="form-control materail_input" placeholder="Footer text 3">
    </div>

    <div class="form-group materail_input_block">
    <input id="notifymefooter_txt4" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_footer_text_4\')" class="form-control materail_input" placeholder="Footer text 4">
    </div>

    <div class="form-group materail_input_block">
    <h5>Enter new Unsubscribe text below:</h5>
    <input id="notifymeUnsubscribeText" type="text" value="" onkeyUp="changeTextWhileTyping(\'.wc_html_unsubscribe_text\')" class="form-control materail_input" placeholder="UNSUBSCRIBE">
    </div>


    </div>

    <div class="form-group col-md-8 ">
    

    <div id="wc_product_email_template" class="wc_nootifyme_preview_email_template">
    '.$this->render_html_template().'
    </div>


    
    </div>




    <div class="button-settings-pannel col-lg-12  ">
    <div class="form-group">
    <div id="showSubmitMsg" style="float:left; color:green;"></div>
     <div style="display:inline-block; float:right;" id="submitHtmlSettings" type="button" class="submitSettingsButton"><span id="">Save HTML Settings</span></div>  

  </div>

</div>





</div>

   
    </div>
    
</div>
        
 
     
    
        


        
        



      
    </div>


    </body>
    </html>';

return $woo_notifyme_setting_page;


  }


  public function render_html_template()
  {


    $template_data = $this->db->get_results("SELECT * FROM $this->table_name ");

    $social = json_decode($template_data[0]->wc_notifyme_template_social, true);

    $fb = empty($social['fb']) ? '' : '<img src="'.plugins_url('/images/white-facebook.png', __DIR__).'" width="30" alt="facebook" style="border:0;">';
    $tw = empty($social['tw']) ? '' : '<img src="'.plugins_url('/images/white-twitter.png', __DIR__).'" width="30" alt="twitter" style="border:0;">';
    $yt = empty($social['yt']) ? '' : '<img src="'.plugins_url('/images/white-youtube.png', __DIR__).'" width="30" alt="youtube" style="border:0;">';
    $ln = empty($social['ln']) ? '' : '<img src="'.plugins_url('/images/white-linkedin.png', __DIR__).'" width="30" alt="linkedin" style="border:0;">';
    $in = empty($social['in']) ? '' : '<img src="'.plugins_url('/images/white-instagram.png', __DIR__).'" width="30" alt="instagram" style="border:0;">';

    $html_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      
    </head>
    <body>
   
            <table class="outer" align="center" style="margin:0 auto;width:100%;max-width:600px;border-spacing:0;font-family:sans-serif;color:#4a4a4a;">
                <tr>
                    <td style="padding:0;">
                        <table width="100%" style="border-spacing:0;border-spacing: 0;">
                            <tr>
                                <!--Logo-->
                                <td id="wc_notifyme_html_header" style="padding:0;background-color:'.$template_data[0]->wc_notifyme_template_header.'; padding: 10px; text-align: center;"><a href="#" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_header.';font-size:16px;"><img id="wc_notifyme_template_logo" src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'" width="180" alt="" style="border:0;"></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td  style="padding:0; text-align: center;"><h4 class="wc_html_header_text_1">'.$template_data[0]->wc_notifyme_template_header_txt .'</h4></td>
                </tr>
                <tr>
                    <td style="padding:0;">
                        <table width="100%" style="border-spacing:0;border-spacing: 0;">
                            <tr>
                                <td class="three-columns" style="padding:0;text-align:center;font-size:0;padding-top:40px;padding-bottom:30px;">
                                    <table class="column" style="border-spacing:0;width:100%;max-width:200px;display:inline-block;vertical-align:top;">
                                        <tr>
                                            <td class="padding" style="padding:0;padding:15px;">
                                                <table class="content" style="border-spacing:0;font-size:15px;line-height:20px;">
                                                    <tr>
                                                        <td style="padding:0;"><a href="#" style="text-decoration:none;color:#388cda;font-size:16px;"><img class="third-img" src="https://i.ibb.co/py7R6Gd/380x280.jpg" width="150" style="border:0;max-width:150px;" alt=""></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;padding:10px; ;">
                                                            <p style="font-size:17px; font-weight: bold;">APPLE WATCH</p>
    
                                                            <p>Responsive HTML Email Templates that you can build around to master email development.</p>
                                                            <a href="#" class="productColorLinks productLinksText" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color  .'; font-size:16px;">Check Now</a><br>
                                                            <span><small>(Product Links)<small></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="column" style="border-spacing:0;width:100%;max-width:200px;display:inline-block;vertical-align:top;">
                                        <tr>
                                            <td class="padding" style="padding:0;padding:15px;">
                                                <table class="content" style="border-spacing:0;font-size:15px;line-height:20px;">
                                                    <tr>
                                                        <td style="padding:0;"><a href="#" style="text-decoration:none;color:#388cda;font-size:16px;"><img class="third-img" src="https://i.ibb.co/3zCPddN/380x280-2.jpg" width="150" style="border:0;max-width:150px;" alt=""></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;padding:10px; ;">
                                                            <p style="font-size:17px; font-weight: bold;">APPLE AirPods</p>
    
                                                            <p>Responsive HTML Email Templates that you can build around to master email development.</p>
                                                            <a href="#" class="productColorLinks productLinksText" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color.'; font-size:16px;">Check Now</a><br>
                                                            <span><small>(Product Links)<small></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="column" style="border-spacing:0;width:100%;max-width:200px;display:inline-block;vertical-align:top;">
                                        <tr>
                                            <td class="padding" style="padding:0;padding:15px;">
                                                <table class="content" style="border-spacing:0;font-size:15px;line-height:20px;">
                                                    <tr>
                                                        <td style="padding:0;"><a href="#" style="text-decoration:none;color:#388cda;font-size:16px;"><img class="third-img-last" src="https://i.ibb.co/9ZGnrWK/380x280-3.jpg" width="150" style="border:0;max-width:150px;" alt=""></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:0;padding:10px; ;">
                                                            <p style="font-size:17px; font-weight: bold;">WATCH BANDS</p>
    
                                                            <p>Responsive HTML Email Templates that you can build around to master email development.</p>
                                                            <a href="#" class="productColorLinks productLinksText" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color.'; font-size:16px;">Check Now</a><br>
                                                            <span><small>(Product Links)<small></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0;">
                                    <table width="100%" style="border-spacing:0;border-spacing: 0;">
                                        <tr>
                                            <td id="wc_notifyme_html_header_bottom" style="padding:0;background-color: '.$template_data[0]->wc_notifyme_template_header.'; padding: 15px; text-align: center;">
                                                <p class="wc_change_social_text" style="font-size:18px; color: #ffffff; margin-bottom: 13px;">'.$template_data[0]->wc_notifyme_template_social_txt .'</p>

                                                <a id="wc_social_fb_icon" href="#" style="text-decoration:none;color:#388cda;font-size:16px;">'.$fb.'</a>
                                                <a id="wc_social_tw_icon" href="#" style="text-decoration:none;color:#388cda;font-size:16px;">'.$tw.'</a>
                                                <a id="wc_social_yt_icon" href="#" style="text-decoration:none;color:#388cda;font-size:16px;">'.$yt.'</a>
                                                <a id="wc_social_ln_icon" href="#" style="text-decoration:none;color:#388cda;font-size:16px;">'.$ln.'</a>
                                                <a id="wc_social_in_icon" href="#" style="text-decoration:none;color:#388cda;font-size:16px;">'.$in.'</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0;background-color: #efefef;">
                        <table width="100%" style="border-spacing:0;border-spacing: 0;">
                            <tr>
                                <td style="padding:0;padding: 20px; text-align: center; padding-bottom:10px ;">
                                    <a href="" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_header.';font-size:16px;"><img src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'" width="160" alt="" style="border:0;"></a>
                                    <p class="wc_html_footer_text_1" style="font-size: 16px; margin-top: 18px; margin-bottom: 10px;">'.$template_data[0]->wc_notifyme_template_footer_txt1 .' <small><b>(Footer text 1)</b></small> </p>
                                    <p class="wc_html_footer_text_2" style="font-size: 16px; margin-bottom: 10px;">'.$template_data[0]->wc_notifyme_template_footer_txt2 .' <small><b>(Footer text 2)</b></small> </p>
                                    <p><a  class="productColorLinks wc_html_footer_text_3" href="mailto:email@example.com" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color .' ;font-size:16px;">'.$template_data[0]->wc_notifyme_template_footer_txt3 .' </a> <small><b>(Footer text 3)</b></small> </p>
                                    <p><a class="productColorLinks wc_html_footer_text_4" href="tel:180088888888" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color .';font-size:16px;">'.$template_data[0]->wc_notifyme_template_footer_txt4 .'</a> <small><b>(Footer text 4)</b></small> </p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding:0;padding-bottom: 25px; text-align: center;">
                                    <a href="" style="text-decoration:none;color:#388cda;font-size:16px;"><img src="#" width="160" alt="" style="border:0;"></a>
                                    <p><a  class="productColorLinks wc_html_unsubscribe_text" href="#" style="text-decoration:none;color:'.$template_data[0]->wc_notifyme_template_link_color .';font-size:16px;font-size: 13px;">'.$template_data[0]->wc_notifyme_template_unsubscribe_txt .'</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td id="wc_last_footer_head" height="20" style="padding:0;background-color: '.$template_data[0]->wc_notifyme_template_header.';"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
     
    </body>
    </html>';

    return $html_template;
  }


  public function render_bridtv_admin_page()
  {

    echo '  <div style="background-color: cadetblue; margin-top: 30px;" class="container text-center"><img class="" src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'"></div>';
    
    $bridtv_admin_page = '<!DOCTYPE html>
      <html lang="en">
      <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">

      <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

      </head>

      <body>

    <div style="background:#ffffff; box-shadow: 0 5px 15px rgb(0 0 0 / 5%); opacity:1; margin-top: 20px;padding: 20px;" class="container">

      <h2>Woo Notify Me - Subscribers list</h2>
      <p>When you change certain product price users who subscribed for that product will get email notification about that</p>

      <table id="wc_notify_me_subscribers_table" class="table row-border hover stripe order-column nowrap">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Product</th>
                  <th>Status</th>
                  <th>Date</th>

                </tr>
              </thead>
            </table>
    </div>


    </body>
    </html>';

return $bridtv_admin_page;

  }


  public function render_bridtv_upload_html_page()
  {
    
    echo '  <div style="background-color: cadetblue; margin-top: 30px;" class="container text-center"><img class="" src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'"></div>';
    
    $woo_notifyme_setting_page = '<!DOCTYPE html>
      <html lang="en">
      <head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">

      <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

      </head>

      <body>

    <div style="background:#ffffff; box-shadow: 0 5px 15px rgb(0 0 0 / 5%); opacity:1; margin-top: 20px;padding: 20px;" class="container">

    <p>
    You can either redirect the color preview:
    <input data-jscolor="{value:\'#a36597\', previewElement:\'#pr1\'}">
  </p>
  <div id="pr1" style="display:inline-block; padding:1em;">previewElement</div>

      <h2>Notify Me - Subscribers list</h2>
      <p>When you change certain product price users who subscribed for that product will get email notification about that</p>

      <table id="wc_notify_me_subscribers_table" class="table row-border hover stripe order-column nowrap">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Product</th>
                  <th>Status</th>
                  <th>Date</th>

                </tr>
              </thead>
            </table>
    </div>


    </body>
    </html>';

return $woo_notifyme_setting_page;

   
    

  }


	public function render_verify_email_template($username, $url)
	{
		$verifyEmail ='
		<html xmlns="http://www.w3.org/1999/xhtml"><head>
	    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet">
	    <meta http-equiv="content-type" content="text/html; charset=utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
	    <meta name="format-detection" content="telephone=no">
	    <style>
 
        body { margin: 0; padding: 0; min-width: 100%; width: 100% !important; height: 100% !important;}
        body, table, td, div, p, a { -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse !important; border-spacing: 0; }
        img { border: 0; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        #outlook a { padding: 0; }
        .ReadMsgBody { width: 100%; } .ExternalClass { width: 100%; }
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
        @media all and (min-width: 520px) {
            .container { border-radius: 8px; -webkit-border-radius: 8px; -moz-border-radius: 8px; -khtml-border-radius: 8px; }
        }
        a, a:hover {
            color: #FFFFFF;
        }
        .footer a, .footer a:hover {
            color: #828999;
        }
        .heading{
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 6.25%;
            padding-right: 6.25%;
            width: 87.5%;
            font-size: 26px;
            font-weight: bold;
            line-height: 130%;
            padding-top: 5px;
            color: #000000;
            font-family: sans-serif;
            letter-spacing: -.5px;
        }
    </style>
    <!-- MESSAGE SUBJECT -->
    <title>Responsive HTML email templates</title>
</head>

<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse;border-spacing: 0;margin: 0;padding: 0;background: #f1f5f9;width: 100%;height: 100%;-webkit-font-smoothing: antialiased;text-size-adjust: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;line-height: 100%;font-family: serif;">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;border-spacing: 0;margin: 0;padding: 0;width: 100%;padding: 80px;" class="">
    <tbody>
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse;border-spacing: 0;margin: 0;padding: 0;background: #f1f5f9;">
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
            padding-top: 40px;
            padding-bottom: 40px;">
           
            <a target="_blank" style="text-decoration: none;" href="https://github.com/srkis"><img border="0" vspace="0" hspace="0" src="https://s3-us-east-2.amazonaws.com/powderkeg-prod-wp-upload/wp-content/uploads/2019/06/25222010/active-campaign-logo.png" height="48" alt="Logo" title="Logo" style="
              color: #000000;
              font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;"></a>
        </td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="
      border-collapse: collapse;
      border-spacing: 0;
      padding: 0;
      width: inherit;
      max-width: 520px;
      background: #fff;
      border-radius: 8px;
      padding: 20px 0px;
      " class="wrapper">
    <tbody>

    <tr style="
          margin-top: 12px;
          ">
        <td align="left" valign="top" style="
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
            padding-top: 40px;
            " class="hero">
            <a target="_blank" style="text-decoration: none;" href="https://github.com/srkis/">
            </a>
        </td>
    </tr>
 
    <tr>

    </tr>
 
    <tr>
        <td align="left" valign="top" style="
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 6.25%;
            padding-right: 6.25%;
            width: 87.5%;
            font-size: 22px;
            font-weight: 900;
            line-height: 130%;
            color: #000000;
            font-family: sans-serif;
            " class="header">
            '.ucwords($username).', Welcome!
        </td>
    </tr><tr>
        <td align="left" valign="top" style="
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 6.25%;
            padding-right: 6.25%;
            width: 87.5%;
            font-size: 15px;

            line-height: 130%;
            padding-top: 16px;
            color: #2d3958;
            font-family: sans-serif;
            " class="header">Please verify your email address clicking on the button bellow </td>
    </tr>
   
    <tr>
        <td align="left" valign="top" style="
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            padding-left: 6.25%;
            padding-right: 6.25%;
            width: 87.5%;
            padding-top: 20px;
            padding-bottom: 10px;
            " class="button">
            <a href="/app/job/review?jobId=undefined" target="_blank" style="text-decoration: none;">
                <table border="0" cellpadding="0" cellspacing="0" align="center" style="max-width: 360px; min-width: 120px; border-collapse: collapse; border-spacing: 0; padding: 0;">
                    <tbody>
                    <tr>
                        <td align="center" valign="middle" >
                            <div style="
                        padding: 14px 40px;
                        margin: 0;
                        text-decoration: none;
                        font-weight: 500;
                        border-collapse: collapse;
                        border-spacing: 0;
                        border-radius: 4px;
                        background: #5f7aff;
                        border-bottom: 2px solid #3c5dff;
                        ">
                                <a target="_blank" style="
                            font-weight: 600 !important;
                            text-decoration: none;
                            color: #FFFFFF; font-family: sans-serif; font-size: 17px; font-weight: 400; line-height: 120%;" href="'.$url.'">Verify Your Email</a>
                        </td></tr></tbody></table></a>
            </div>

        </td>
    </tr>


    <tr>
        <td align="left" valign="top" style="
              border-collapse: collapse;
              border-spacing: 0;
              margin: 0;
              padding: 0;
              padding-left: 6.25%;
              padding-right: 6.25%;
              width: 87.5%;
              font-size: 13px;
              font-weight: 400;
              line-height: 160%;
              padding-top: 5px;
              text-align: center    ;
              color: #242424;
              font-family: "DM Sans",sans-serif;
              "class="paragraph">

            Need help? <u style="color: #213dc6; cursor: pointer; font-weight: bold;">Open https://github.com/srkis</u> </td>
    </tr>

    <tr>
        <td align="left" valign="top" style="
              border-collapse: collapse;
              border-spacing: 0;
              margin: 0;
              padding: 0;
              padding-left: 6.25%;
              padding-right: 6.25%;
              width: 87.5%;
              font-size: 14px;
              font-weight: 400;
              line-height: 160%;
              padding-top: 15px;
              padding-bottom: 45px;
              color: #242424;
              font-family: sans-serif;
              " class="paragraph">

            <strong>Never heard of WP Custom Newsletter?</strong> Its a custom build WP Plugin which help you to get subscibers for your bussiness. You can create test in few mins. Find out more in the WP Newsletter Tour.<br/>

            Good luck!<br/><br/>

            The WP Custom Newsletter Team

        </td>
    </tr>
    </tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" align="center" width="500" style="
      border-collapse: collapse;
      border-spacing: 0;
      padding: 0;
      width: inherit;
      max-width: 520px;
      background: #fff;
      border-radius: 8px;
      padding: 20px 0px;
      margin-top: 40px;
      "class="wrapper">
    <tbody>

    <tr>
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;  padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
            font-size: 18px; font-weight: bold; line-height: 130%;
            padding-top: 40px;
            color: #000000;
            font-family:sans-serif;" class="header">
            For support, feedback or help ☎️
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
            font-size: 13px; font-weight: 400; line-height: 160%;
            padding-top: 15px;
            color: #000000;
            font-family: sans-serif;" class="paragraph">
            If you need anything, we can help. And we also want your feedback – good and bad, we want it all :) Get in touch at feedback@wpnewsletter.com<br/>
            I ll be happy to schedule one on one call with you.
        </td>
    </tr>
    <tr style=" padding-bottom: 0px;">
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
            padding-top: 15px;
            color: #000000;
            font-family: sans-serif;" class="paragraph">
	WP Newsletter
	</td>
    </tr>
    <tr style=" padding-bottom: 10px;">
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; font-weight: 400; line-height: 160%;
            color: #000000;
            padding-bottom: 20px;
            font-family: sans-serif;" class="paragraph">
	+91-7296823551 <br> feedback@wpnewsletter.dev
	</td>
    </tr>


    <tr style=" padding-bottom: 40px;">
        <td align="left" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 14px; font-weight: 400; line-height: 160%;
      color: #000000;
      padding-bottom: 40px;
      font-family: sans-serif;" class="paragraph">
	p.s. Once you get in there, You can create and send campaign in a minute<br/>


        </td>
    </tr>
    </tbody>
</table>
<table width="550" align="center">
    <tbody>
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
            padding-top: 30px;" class="line">
            <hr color="#b6bbc6" align="center" width="100%" size="1" noshade="" style="margin: 0; padding: 0;">
        </td>
    </tr>
    <tr>
        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%;
            padding-top: 10px;
            padding-bottom: 20px;
            color: #828999;
            font-family: sans-serif;" class="footer">You are receiving this becuase you ve registered at wp newsletter.<br> Check <a href="https://github.com/srkis/" target="_blank" style="text-decoration: underline; color: #828999; font-family: sans-serif; font-size: 13px; font-weight: 400; line-height: 150%;">subscription settings</a>.
        </td>
    </tr>
    </tbody>
</table>

</body></html>';


		return $verifyEmail;
		
	}



}
