<?php

include_once( WP_PLUGIN_DIR . '/wc-notifyme/admin/class-wc-notifyme-render-html.php' );

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class WC_Notifyme_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $db, $table_name, $render_html;
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		global $wpdb;
		$this->db =& $wpdb;
		$this->render_html = new WC_Notifyme_Render_Html($this->plugin_name);

		if ( defined( 'WC_NOTIFYME_TABLE_NAME' ) ) {
			$this->table_name = WC_NOTIFYME_TABLE_NAME;
		} else {
			$this->table_name = $wpdb->prefix . 'notifyme_wc_product_data';
		}
	  

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-notifyme-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-notifyme-public.js', array( 'jquery' ), $this->version, false );

	}


  public function wc_notifyme_main($post_id, $post, $update)
  {

	if ( $post->post_type !== 'product' && $post->post_status !== "publish" && $post->action !== "editpost") return; // Only products

	if(isset($_POST['product-type']) && $_POST['product-type'] == "simple") {

		global $product;
		$product = wc_get_product( $post_id );
        $productData = $product->get_data();


		if(!empty($productData['regular_price']) && !empty($_POST['_regular_price'])) {

			//check if current price $_POST['_regular_price'] smaller then price in database $productData['regular_price']
			$currentPrice = (int) $_POST['_regular_price'];
			$dbPrice = (int) $productData['regular_price'];

			if( $currentPrice < $dbPrice ) {
				//Notify customers that price is changed and its lower

				$this->send_email_woocommerce_style('your_email', 'test subject', 'heading', 'test message');

			}
		}

	}
	

    

	
    // Ignore for Variable and Group products
    //if( $product->is_type('variable') || $product->is_type('grouped') ) return;

	

      //var_dump("<pre>",$_POST['_regular_price']);die;
     

    //  echo "---------------------------------------------------";

    //  $post_meta = get_post_meta($post_id);

    //  var_dump("<pre>",$post_meta);die("ovde");



  }


  public function wc_notifyme_ajax()
  {

	
		if(!$this->_isAjax()) die("Silence is golden!");

		//$result = ["msg" => "You are successfully subscribed"];

		if(!$this->_checkValidEmail($_GET['email'])) $this->jsonResponse(["fail" => "Not valid email address"], []);
		
		//$result = ["msg" => "You are successfully subscribed"];

	 
		if(isset($_GET['action']) && $_GET['action'] == 'wc_notifyme_ajax' && isset($_GET['type'])){

			$get = $this->_sanitize($_GET);

			$inserted = $this->{$get['type']}($get);
			if($inserted) {
				$msg = ["success" => "You are successfully subscribed."];
			}else{
				$msg = ["fail" => "Something went wrong. Please contact our support"];
			}
			$this->jsonResponse($msg, []);	
		}

  }



  private function _isAjax()
  {
	
	return 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
	
  }


  private function _checkValidEmail($email)
  {
	
	 $clean_email = filter_var($email,FILTER_SANITIZE_EMAIL);

	 return filter_var($clean_email,FILTER_VALIDATE_EMAIL) ? true : false;
	 
  }


  private function jsonResponse($msg, $result)
  {
		echo json_encode(array($msg, 'result' => $result));
		die;
  }


 private function _sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var => $val) {
            $output[$var] = $this->_sanitize($val);
        }
    }
    else {
       
		$output = trim($input);
		$output = stripcslashes($input);
		$output = htmlspecialchars($input);
		$output = htmlentities($input, ENT_QUOTES, 'UTF-8');
		  
    }
    return $output;
}


public function wc_notifyme_insert($data)
{

	$this->send_email_woocommerce_style('your_email@gmail.com', 'test subject', 'heading', 'test message');die;

	$type = sanitize_text_field($data['type']);
	$email = sanitize_text_field($data['email']);
	$product_id = sanitize_text_field($data['product_id']);
	$product_id = (int) $data['product_id'];

	$dateTime = date('Y-m-d H:i:s');

	$checkIfExists = $this->db->get_var("SELECT ID FROM $this->table_name WHERE wc_notifyme_customer_email  = '$email' AND wc_notifyme_product_id = $product_id ");


	if ($checkIfExists == null) {

		$check =  $this->db->insert(
		$this->table_name,
		array(
		'wc_notifyme_customer_email' => $email,
		'wc_notifyme_product_id' => $product_id,
		'wc_notifyme_customer_status' => 'subscribed',
		'wc_notifyme_customer_subscribed_at' => $dateTime,
		)
	  );
	  
	  return ($check) ? true : false;

	}

}


	

	// @email - Email address of the reciever
	// @subject - Subject of the email
	// @heading - Heading to place inside of the woocommerce template
	// @message - Body content (can be HTML)
	function send_email_woocommerce_style($email, $subject, $heading, $message) {

		// Define a constant to use with html emails
	define("HTML_EMAIL_HEADERS", array('Content-Type: text/html; charset=UTF-8'));
	
	  // Get woocommerce mailer from instance
	  $mailer = WC()->mailer();
	
	  // Wrap message using woocommerce html email template
	  $wrapped_message = $mailer->wrap_message($heading, $message);
	
	  // Create new WC_Email instance
	  $wc_email = new WC_Email;
	
	  // Style the wrapped message with woocommerce inline styles
	  $html_message = $wc_email->style_inline($wrapped_message);

	  //Get Motifyme html template
	  $html_message = '';
	  $html_message = $this->render_html->render_html_template();
	
	  // Send the email using wordpress mail function
	  $mailer->send( $email, $subject, $html_message, HTML_EMAIL_HEADERS );
	
	}


}
