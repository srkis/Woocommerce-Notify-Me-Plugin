<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class WC_Notifyme_Admin {


	private $version, $html_render, $url, $plugin_name, $table_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		global $wpdb;
		$this->db =& $wpdb;

		$this->url = home_url() . "/" . "wp-admin/admin-post.php";
		$this->html_render = new WC_Notifyme_Render_Html($this->url);
		

		if ( defined( 'WC_NOTIFYME_TABLE_NAME' ) ) {
			$this->table_name = WC_NOTIFYME_TABLE_NAME;
		} else {
			$this->table_name = $wpdb->prefix . 'notifyme_wc_product_data';
		}



		$this->init_wc_notifyme_admin_page();

	}


	public function enqueue_styles() {

	
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-notifyme-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-notifyme-admin.js', array( 'jquery' ), $this->version, false );
		
		//wp_enqueue_script('jscolor', plugin_dir_url( __FILE__ ) . 'js/jscolor.min.js', array( 'jquery' ), '2.4.8', false );


	}

  public function wc_notifyme_product_page_button()
  {
      global $product;
      // Ignore for Variable and Group products
      if( $product->is_type('variable') || $product->is_type('grouped') ) return;
      // Display the custom button
	  $buttonSettings = $this->wc_notifyme_get_button_settings();

		  //Default Values

		$backgroundColor = '#AA66CC';
		$buttonText = 'Notify Me';
		$buttonTextColor = '#FFF';
		$buttonDisplay = 'block';


	  if(count($buttonSettings) > 0 ) {
		
		$backgroundColor = $buttonSettings[0]->wc_notifyme_btn_bg_color;
		$buttonText = $buttonSettings[0]->wc_notifyme_btn_text; 
		$buttonTextColor = $buttonSettings[0]->wc_notifyme_btn_text_color;
		$buttonDisplay = 'block';
  
	  }

	  //Proveriti da li je stavljeno za display na single page ili main shop page ili oba
	if($buttonSettings[0]->wc_notifyme_show_btn_single_page == 'yes') {
		echo '<div style="display:'.__($buttonDisplay) .'" class="woo-notifyme-button-wrapper"><a style="background-color:'.__($backgroundColor) .'; color:'.__($buttonTextColor).'" data-notify-me="'.$product->get_id().'" id="'.$product->get_id().'" class="woo-notifyme-button" href="#">' . __($buttonText) . '</a></div>';
     }

  }


  /**
* @snippet Add ‘View Product’ button before ‘Add to Cart’ in WooCommerce
* @source https://www.wptechnic.com/?p=6692
* @compatible WC 6.3.1
*/

function wc_notifyme_main_product_page_button() {
    global $product;
    // Ignore for Variable and Group products
    if( $product->is_type('variable') || $product->is_type('grouped') ) return;
    // Display the custom button

	$buttonSettings = $this->wc_notifyme_get_button_settings();

		//Default Values

	$backgroundColor = '#AA66CC';
	$buttonText = 'Notify Me';
	$buttonTextColor = '#FFF';
	$buttonDisplay = 'block';


	if(count($buttonSettings) > 0 ) {
	
	$backgroundColor = $buttonSettings[0]->wc_notifyme_btn_bg_color;
	$buttonText = $buttonSettings[0]->wc_notifyme_btn_text; 
	$buttonTextColor = $buttonSettings[0]->wc_notifyme_btn_text_color;
	$buttonDisplay = 'block';

	}
	if($buttonSettings[0]->wc_notifyme_show_btn_main_page == 'yes') {
		//echo '<a style="margin-left:5px" class="button woo-notifyme-button" href="' . esc_attr( $product->get_permalink() ) . '">' . __('View product') . '</a>';

		echo '<a style="background-color:'.__($backgroundColor) .'; color:'.__($buttonTextColor).'" data-notify-me="'.$product->get_id().'" id="'.$product->get_id().'" class="woo-notifyme-button" href="#">' . __($buttonText) . '</a>';
	}
}


  public function init_wc_notifyme_admin_page()
  {
	add_action('admin_menu', array($this, 'wc_notifyme_admin_page' ) );
  }


  public function wc_notifyme_admin_page(){

	$icon_base64 = 'PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB3aWR0aD0iMTc1LjAwMDAwMHB0IiBoZWlnaHQ9IjE2NS4wMDAwMDBwdCIgdmlld0JveD0iMCAwIDE3NS4wMDAwMDAgMTY1LjAwMDAwMCIKIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiPgoKPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsMTY1LjAwMDAwMCkgc2NhbGUoMC4xMDAwMDAsLTAuMTAwMDAwKSIKZmlsbD0iIzAwMDAwMCIgc3Ryb2tlPSJub25lIj4KPHBhdGggZD0iTTExOSAxNTEzIGMtNTkgLTM2IC03MyAtMTA4IC00NSAtMjIxIDQ0IC0xNzQgNTAgLTI0NyA1MSAtNjE3IDAKLTMyNSAyIC0zNjMgMTggLTM4NiAzMyAtNDkgOTggLTYwIDIzMSAtNDAgNjggMTEgMjIxIDI4IDMzNyAzNyA3NCA3IDc3IDYgODQKLTE3IDQgLTEzIDEzIC0yOCAxOSAtMzQgNiAtNyAyMiAtMjYgMzUgLTQ0IDI1IC0zMiA5NiAtODcgMTU4IC0xMjIgNDQgLTI1IDUxCi0yNCAyNiA0IC0zOCA0MSAtNjMgOTggLTcwIDE1OCBsLTYgNTkgMTA0IDAgYzU3IDAgMTQ5IC03IDIwNCAtMTQgMTg3IC0yNgoyNTggLTI5IDI5NyAtMTMgNTkgMjUgNjIgNDAgNjMgMjU3IDEgMjM2IDMzIDU0NSA3MSA2ODcgOCAyOCAxNCA3MiAxNCA5OCAwCjQ4IC0yNSAxMDUgLTQ2IDEwNSAtNyAwIC0xNCA1IC0xNiAxMSAtMyA4IC0xMDcgMTAgLTM0OCA5IC0zMzggLTEgLTUwNCA3Ci03MDUgMzUgLTI0MCAzMyAtMjczIDM4IC0zMTkgNTEgLTY2IDE4IC0xMjUgMTcgLTE1NyAtM3ogbTgxMiAtMTc1IGMwIC0xMCAyCi0xMCA2IDAgMiA2IDExIDEyIDE4IDEyIDE3IDAgNzUgLTY2IDc1IC04NSAwIC04IDUgLTE1IDEwIC0xNSA2IDAgMTAgOSAxMCAxOQowIDExIDEyIDMzIDI2IDUwIDI2IDMyIDU0IDQxIDU0IDE5IDAgLTkgMyAtOCAxMCAyIDggMTMgMTMgMTMgMzcgLTIgMzYgLTIyCjYzIC03MyA2MyAtMTIxIDAgLTEwNSAtMTUyIC0xMzUgLTE4OSAtMzcgbC05IDI1IC0xMCAtMjYgYy0zMyAtODQgLTE2OCAtNzUKLTE4NyAxMiAtMTAgNDQgMiA5NCAzMSAxMjkgMjYgMzEgNTMgNDAgNTUgMTh6IG0tMTExIC04IGMxMiAtOCA4IC0yNCAtMjYKLTEwNyAtMzQgLTgzIC00NCAtOTggLTYzIC05OSAtMTcgLTEgLTI3IDcgLTM2IDI5IGwtMTMgMzEgLTE2IC0zMiBjLTEyIC0yNAotMjIgLTMxIC0zOSAtMjggLTE4IDIgLTI4IDIwIC01NSA5MSAtMTggNDkgLTMwIDk1IC0yNyAxMDIgMTAgMjYgMzggOSA1MCAtMzIKNyAtMjIgMTggLTUzIDI1IC03MCBsMTIgLTMwIDE0IDMwIGM3IDE3IDEwIDQwIDggNTEgLTQgMTUgMCAyMyAxNSAyNyAxNSA0IDIyCi0yIDMxIC0yNyAzMyAtODkgMjkgLTg4IDY0IC00IDE3IDQzIDMzIDc4IDM2IDc4IDMgMCAxMiAtNSAyMCAtMTB6IG02NiAtNDAyCmMtMSAtNDYgMyAtOTEgOCAtMTAwIDcgLTE1IDMgLTE4IC0yNSAtMTggbC0zNCAwIDAgMTAwIDAgMTAwIDI2IDAgYzI1IDAgMjUgMAoyNSAtODJ6IG0xMzQgNjIgYzAgLTE1IC03IC0yMCAtMjUgLTIwIC0zNCAwIC01OSAtNDAgLTUwIC04MCA3IC0zNCAzMiAtNTIgNjIKLTQ0IDMxIDkgMzggLTI0IDggLTM4IC00MCAtMTggLTgxIDUgLTEwMSA1OCAtMTkgNTEgLTEzIDg2IDIxIDEyMCAzMSAzMSA4NQozNCA4NSA0eiBtMTc4IC0yIGMtMyAtMjAgLTEwIC0yMyAtNTAgLTI2IC00NCAtMyAtNDggLTUgLTQ4IC0yOCAwIC0yNCAyIC0yNQozOSAtMTkgMzMgNSAzOSA0IDQ0IC0xNCA0IC0xNyAtMSAtMjEgLTM5IC0yNyAtMjkgLTQgLTQ0IC0xMSAtNDQgLTIxIDAgLTExCjExIC0xNCA0NyAtMTIgMzIgMiA0OCAtMSA1MSAtMTAgNyAtMjEgLTE4IC0zMSAtODAgLTMxIGwtNTggMCAwIDgwIGMwIDUwIC00CjgwIC0xMSA4MCAtNiAwIC05IDggLTcgMTggMiAxMyAxNyAxOCA2OCAyMyAzNiAzIDcxIDYgNzggNyA4IDEgMTIgLTYgMTAgLTIwegptLTUzNyAtMTcgYzI5IC0yOSAyOSAtMjkgMjkgLTYgMCA1MCAxMDIgMzMgMTE2IC0xOSA2IC0yNSAtMTAgLTY2IC0yNiAtNjYKLTE5IDAgLTEwIC0xNyAxNSAtMzAgMTQgLTcgMjUgLTE5IDI1IC0yNiAwIC0yNCAtMjIgLTI2IC01MSAtNSAtMzMgMjUgLTQwIDI2Ci0zMyA2IDQgLTEwIDAgLTE1IC0xNCAtMTUgLTI0IDAgLTMyIDE4IC0zMiA3MiBsMCA0MSAtMjAgLTI2IGMtMTEgLTE0IC0yOQotMjkgLTQwIC0zMiAtMTMgLTQgLTIwIC0xNSAtMjAgLTMxIDAgLTE3IC01IC0yNCAtMjAgLTI0IC0xOSAwIC0yMCA3IC0yMCA4OQowIDc3IDIgOTAgMTggOTQgMzUgOSA0NCA2IDczIC0yMnogbS0xNDAgLTI4MyBjMCAtMTAgMiAtMTAgNiAwIDggMjEgMzAgMTMgNjEKLTIyIDc0IC04NCA0MSAtMTk2IC01OCAtMTk2IC03MCAwIC0xMTAgNTcgLTk2IDEzNSAxMSA1NyA4NCAxMjYgODcgODN6IG0zMDgKLTUgYzYgLTEwIDExIC0xMiAxMSAtNSAwIDYgMTIgMTIgMjggMTIgbDI4IDAgMCAtODIgYzAgLTQ2IDQgLTk1IDggLTExMCA4Ci0yNyA3IC0yOCAtMjcgLTI4IGwtMzQgMCA1IDg5IGM0IDgzIDMgODkgLTE2IDk1IC0xMSA0IC0zMiA0IC00NiAwIC0yNiAtNgotMjYgLTggLTI2IC05NSAwIC04MCAtMiAtODkgLTE5IC04OSAtMTYgMCAtMTkgMTEgLTI1IDkwIGwtOCA5MCAtMzkgMCBjLTMyIDAKLTM5IDMgLTM5IDIwIDAgMTYgOCAyMCA1OCAyMyAxMjggOCAxMzEgOCAxNDEgLTEweiBtLTQ5OSAtNDEgbDM1IC00NyAzIDQ4IGMzCjQyIDYgNDcgMjcgNDcgMjMgMCAyNCAtMiAyNyAtMTEwIDMgLTEwMSAyIC0xMDkgLTE3IC0xMTQgLTIyIC02IC0zNSA5IC0zNSA0MAowIDExIC0xNiAzNiAtMzYgNTUgbC0zNiAzNCA0IC02MiBjMyAtNTUgMSAtNjMgLTE3IC02NyAtMjkgLTggLTM1IDEwIC0zNSAxMjIKMCA5OSAxIDEwMiAyMyAxMDIgMTQgLTEgMzQgLTE3IDU3IC00OHogbTgzMiAtNDEgYy0zIC02MCAtMSAtOTAgNyAtOTUgMjQgLTE1CjExIC0zNiAtMjMgLTM2IGwtMzMgMCAxIDYzIGMwIDM0IC0zIDgzIC03IDExMCBsLTggNDcgMzQgMCAzNCAwIC01IC04OXogbTE5OAo3MCBjMCAtMjMgLTE5IC0zMSAtNzEgLTMxIC0zNyAwIC0zOSAtMiAtMzkgLTMxIGwwIC0zMCA0NiA3IGM0NCA2IDQ2IDYgNDIKLTE3IC0yIC0yMCAtOSAtMjQgLTQ1IC0yNyAtMzYgLTMgLTQzIC03IC00MyAtMjQgMCAtMTkgNCAtMjAgNDkgLTE0IDQwIDUgNTAKMyA1NSAtMTEgMTAgLTI0IC0xMSAtMzMgLTg1IC0zMyBsLTY2IDAgMSA5MCBjMSA2NiAtMiA5MCAtMTEgOTAgLTcgMCAtMTMgOQotMTMgMjAgMCAxNiA4IDIwIDYzIDIzIDM0IDIgNzQgNCA5MCA1IDIwIDIgMjcgLTIgMjcgLTE3eiBtLTI3MCAtMTAgYzAgLTIzCi0xOSAtMzEgLTcxIC0zMSAtMzUgMCAtMzkgLTIgLTM5IC0yNiAwIC0yNSAyIC0yNiA0NCAtMjAgMzggNiA0NCA0IDQ5IC0xMyA3Ci0yNyAxIC0zMSAtNTAgLTMxIGwtNDQgMCAzIC0zNyBjMyAtMzMgMCAtMzggLTE5IC00MSAtMjEgLTMgLTIzIDEgLTI1IDQwIC0xCjI0IC0xIDYyIDEgODYgMSAyNCAtMiA0MiAtOCA0MiAtNiAwIC0xMSA5IC0xMSAxOSAwIDE3IDggMjEgNTMgMjQgMTE5IDggMTE3CjggMTE3IC0xMnogbTM3OSAtNyBjMzcgLTMwIDQwIC02MSA5IC05NCBsLTIxIC0yMyAzMCAtMjYgYzUwIC00MiAyMiAtNzEgLTMwCi0zMSAtMzAgMjQgLTM3IDI1IC0zNyA0IDAgLTEwIC03IC0xNCAtMjIgLTEyIC0yMiAzIC0yMyA4IC0yNiAxMDAgLTMgOTQgLTIKOTcgMjAgMTAxIDQyIDggNDYgNyA3NyAtMTl6Ii8+CjxwYXRoIGQ9Ik05MDYgMTI4OCBjLTIyIC0zNiAtMjcgLTYzIC0xNyAtOTEgMTIgLTMxIDUwIC00NCA4MCAtMjcgMjkgMTUgMjkKNzggMCAxMTQgLTI1IDMyIC00NCAzMyAtNjMgNHoiLz4KPHBhdGggZD0iTTExMDYgMTI4OCBjLTIxIC0yOSAtMjAgLTkyIDAgLTExMiAzOCAtMzggMTAxIDIgOTAgNTcgLTcgMzQgLTQyIDc3Ci02MiA3NyAtNyAwIC0yMCAtMTAgLTI4IC0yMnoiLz4KPHBhdGggZD0iTTYxMCA5MzAgYzAgLTIyIDQgLTI4IDE1IC0yNCA4IDQgMTUgMTQgMTUgMjQgMCAxMCAtNyAyMCAtMTUgMjQgLTExCjQgLTE1IC0yIC0xNSAtMjR6Ii8+CjxwYXRoIGQ9Ik03MzAgOTMwIGMwIC0yOCAyIC0zMCAyMCAtMjAgMTEgNiAyMCAxNSAyMCAyMCAwIDUgLTkgMTQgLTIwIDIwIC0xOAoxMCAtMjAgOCAtMjAgLTIweiIvPgo8cGF0aCBkPSJNNDk2IDYzOCBjLTIyIC0zNiAtMjcgLTYzIC0xNyAtOTEgMTIgLTMxIDUwIC00NCA4MCAtMjcgMjkgMTUgMjkgNzgKMCAxMTQgLTI1IDMyIC00NCAzMyAtNjMgNHoiLz4KPHBhdGggZD0iTTE0MTAgNjA1IGMwIC0zNiAxIC0zNyAyMSAtMjQgMjggMTkgMjggMjkgMiA0NyAtMjIgMTQgLTIzIDE0IC0yMwotMjN6Ii8+CjwvZz4KPC9zdmc+Cg==';
	$icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;



	add_menu_page(
		'Woo Notify Me', 
		'Woo Notify Me ', 
		'manage_options',
		'woo-notifyme-options',
		 array($this, 'wc_notifyme_subscribers_page'), 
		// plugins_url('/images/woo_price_notifier_icon_small.png', __DIR__) 
		$icon_data_uri
	);
    
	add_submenu_page(
		'woo-notifyme-options', 
		'WC Notify Me', 
		'Subscribers List', 
		'manage_options', 
		'woo-notifyme-options' 
	);
    
	add_submenu_page(
      'woo-notifyme-options',
      'Subscribers List', //page title
      'Settings', //menu title
      'edit_themes', //capability,
      'woo_notifyme_setting_page',//menu slug
      array($this, 'woo_notifyme_setting_page')
  );


}


	public function wc_notifyme_subscribers_page() 
	{

		echo $this->html_render->render_bridtv_admin_page();
	}

	public function woo_notifyme_setting_page()
	{
		
	  echo $this->html_render->render_setting_page();
	}


	public function wc_notifyme_get_subscribers()
	{

	  $subscribers = array();
	  $members = array(
		'email' => '',
		'status' => '',
	  );
  
	  $results = $this->db->get_results( "SELECT * FROM $this->table_name");
  
	  foreach( $results as $member )
	  {

		$product_data = $this->_wc_notifyme_getProductData( $member->wc_notifyme_product_id );

		$product_name = ($product_data['product_name']) ? $product_data['product_name'] : "Product not exist";
		$product_image = ($product_data['product_image']) ? ' <img style="width:40px; height:40px;" src="'.$product_data['product_image'].'">' : "";

		$members['email'] = $member->wc_notifyme_customer_email;
		$members['status'] = $member->wc_notifyme_customer_status;

		$members['product_id'] = '<a target="_blank" href="'.$product_data['product_url'].'">'. $product_image . " " . $product_name . '</a>'; //$member->wc_notifyme_product_id;
	
		$members['date'] = $member->wc_notifyme_customer_subscribed_at;
  
		array_push($subscribers, $members);
	  }

	  header( "Content-Type: application/json" );
	  echo json_encode( $subscribers );
	  wp_die();
  
	}


	private function _wc_notifyme_getProductData( $product_id )
	{

		$product_data = ["product_name" => "", "product_image" => "", "product_url" => "" ];

	    $product_name  = get_the_title( $product_id );
		$product_meta  = get_post_meta( $product_id );
		$product_url   = get_permalink( $product_id );

	if(is_array($product_meta) && array_key_exists('_thumbnail_id', $product_meta)) {
			
		$product_image = wp_get_attachment_image_src( $product_meta['_thumbnail_id'][0], 'thumbnail', null );
		$product_data['product_name'] = $product_name;
		$product_data['product_image'] = $product_image[0];
		$product_data['product_url'] = $product_url;
	}

	return $product_data;

   }


   public function wc_notifyme_get_button_settings()
   {
	global $wpdb;

	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}notifyme_wc_button_settings");

	return $results;

	}


	public function wc_notifyme_get_json_button_settings()
	{
	 global $wpdb;
	 
	 $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}notifyme_wc_button_settings ");
 
	 header( "Content-Type: application/json" );
	 echo json_encode( $results );
     wp_die();
 
	 }


	 public function wc_notifyme_get_json_html_settings()
	 {
		global $wpdb;
 
		$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}notifyme_wc_email_template");

		$social = json_decode($results[0]->wc_notifyme_template_social, true);

		//var_dump("<pre>",$social);
		//array_push($results, $social);
		$results[0]->social = $social;
		//var_dump("<pre>",$results);die;


	
		header( "Content-Type: application/json" );
		echo json_encode( $results );
		wp_die();
	 }


	public function wc_notifyme_update_button_settings()
	{
		global $wpdb;
		$table_name = $wpdb->prefix.'notifyme_wc_button_settings';
		
		$wc_notifyme_btn_bg_color    = $_POST['wc_notifyme_btn_bg_color'];
		$wc_notifyme_btn_text   	 = $_POST['wc_notifyme_btn_text'];
		$wc_notifyme_btn_text_color  = $_POST['wc_notifyme_btn_text_color'];
		$wc_notifyme_show_btn_single_page  = $_POST['wc_notifyme_single'];
		$wc_notifyme_show_btn_main_page    = $_POST['wc_notifyme_main'];

		
		$sql = $wpdb->prepare("UPDATE $table_name SET
			wc_notifyme_btn_bg_color = '%s',
			wc_notifyme_btn_text = '%s',
			wc_notifyme_btn_text_color = '%s',
			wc_notifyme_show_btn_single_page = '%s',
			wc_notifyme_show_btn_main_page = '%s'",
			
			$wc_notifyme_btn_bg_color , $wc_notifyme_btn_text, $wc_notifyme_btn_text_color, $wc_notifyme_show_btn_single_page, $wc_notifyme_show_btn_main_page
		);

		$updated = $wpdb->query($sql);


		$msg = ["success" => "Changes saved successfully."];
		// if($updated) {
		// 	$msg = ["success" => "Changes saved successfully."];
		// }else{
		// 	$msg = ["fail" => "Something went wrong. Please contact our support"];
		// }
		$this->jsonResponse($msg, []);
	}

	public function wc_notifyme_update_html_template_settings()
	{

		global $wpdb;
		$table_name = $wpdb->prefix.'notifyme_wc_email_template';
		
		$headersBgColor    		 = $_POST['headersBgColor'];
		$notifymeHeaderText   	 = $_POST['notifymeHeaderText'];
		$linksColor  			 = $_POST['linksColor'];
		$notifymeSocialText      = $_POST['notifymeSocialText'];
		$notifymefooter_txt1     = $_POST['notifymefooter_txt1'];
		$notifymefooter_txt2     = $_POST['notifymefooter_txt2'];
		$notifymefooter_txt3     = $_POST['notifymefooter_txt3'];
		$notifymefooter_txt4     = $_POST['notifymefooter_txt4'];
		$notifymeUnsubscribeText = $_POST['notifymeUnsubscribeText'];
		
		$notifymeFBText = $_POST['notifymeFBText'];
		$notifymeTWText = $_POST['notifymeTWText'];
		$notifymeYTText = $_POST['notifymeYTText'];
		$notifymeLNText = $_POST['notifymeLNText'];
		$notifymeINText = $_POST['notifymeINText'];

		$social = array(
				'fb' => $notifymeFBText,
				'tw' => $notifymeTWText,
				'yt' => $notifymeYTText,
				'ln' => $notifymeLNText,
				'in' => $notifymeINText,
		);

		$social_json = json_encode($social);

		
		$sql = $wpdb->prepare("UPDATE $table_name SET
			wc_notifyme_template_header  = '%s',
			wc_notifyme_template_header_txt  = '%s',
			wc_notifyme_template_link_color  = '%s',
			wc_notifyme_template_social_txt  = '%s',
			wc_notifyme_template_social  = '%s',
			wc_notifyme_template_footer_txt1  = '%s',
			wc_notifyme_template_footer_txt2  = '%s',
			wc_notifyme_template_footer_txt3  = '%s',
			wc_notifyme_template_footer_txt4  = '%s',
			wc_notifyme_template_unsubscribe_txt  = '%s'",
			
			$headersBgColor, 
			$notifymeHeaderText,
			$linksColor, 
			$notifymeSocialText, 
			$social_json, 
			$notifymefooter_txt1, 
			$notifymefooter_txt2, 
			$notifymefooter_txt3, 
			$notifymefooter_txt4, 
			$notifymeUnsubscribeText
		);

	

		$updated = $wpdb->query($sql);
		$msg = ["success" => "Changes saved successfully."];
		$this->jsonResponse($msg, []);

	}


	private function jsonResponse($msg, $result)
	{
		  echo json_encode(array($msg, 'result' => $result));
		  die;
	}


	function get_custom_logo_url()
{
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

	if(!$image) {
			
		return plugins_url('/images/notifyme_logo.png', __DIR__);
	}

    return $image[0];
}
 

}
