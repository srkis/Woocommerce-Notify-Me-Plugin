<?php

/**
 * Fired during plugin activation
 *
 * @link       https://srdjan.icodes.rocks
 * @since      1.0.0
 *
 * @package    wc_notifyme
 * @subpackage wc_notifyme/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wc_notifyme
 * @subpackage WC_NotifyMe/includes
 * @author     Srdjan Stojanovic <stojanovicsrdjan27@gmail.com>
 */
class WC_Notifyme_Activator {

	 private $db, $plugin_name;
	 private static $version = WC_NOTIFYME_VERSION;

	public function __construct() {

		global $wpdb;

		$this->plugin_name = 'wc-notifyme';
		
		$this->db =& $wpdb;
		
	}


	public static function activate() {

	global $wpdb;

	$table_name = $wpdb->prefix . 'notifyme_wc_product_data';
	$version = self::$version;
	$charset_collate = $wpdb->get_charset_collate();

	$sql = [];

	
	 if( $wpdb->get_var("show tables like '". $table_name . "'") !== $table_name ) { 

		$sql[] = "CREATE TABLE ". $table_name . "     (
			WcID int(11) NOT NULL AUTO_INCREMENT,
			wc_notifyme_customer_subscribed_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			wc_notifyme_customer_email  VARCHAR(255) NOT NULL,
			wc_notifyme_customer_status VARCHAR(20) NOT NULL,
			wc_notifyme_product_id bigint(20) NOT NULL,
			wc_notifyme_version VARCHAR(100) DEFAULT '$version',
			PRIMARY KEY  (WcID)
			)$charset_collate; ";
	 }
 
	 $settings_table_name = $wpdb->prefix . 'notifyme_wc_button_settings';
	 
	 if( $wpdb->get_var("show tables like '". $settings_table_name . "'") !== $settings_table_name ) { 

		$sql[] = "CREATE TABLE ". $settings_table_name . "(
			woo_notifyme_id int(11) NOT NULL AUTO_INCREMENT,
			wc_notifyme_btn_class VARCHAR(100) DEFAULT 'woo-notifyme-button',
			wc_notifyme_btn_bg_color VARCHAR(255) DEFAULT '#AA66CC',
			wc_notifyme_btn_text VARCHAR(20) DEFAULT 'Notify Me',
			wc_notifyme_btn_text_color VARCHAR(255) DEFAULT '#FFF',
			wc_notifyme_show_btn_single_page VARCHAR(20) DEFAULT 'yes',
			wc_notifyme_show_btn_main_page VARCHAR(20) DEFAULT 'no',
			PRIMARY KEY (woo_notifyme_id)
			)$charset_collate; ";
 
	 }

		
	// {"social":{"fb":"https://facebook.com", "tw":"https://twitter.com", "yt":"https://youtube.com", "yt":"https://youtube.com", "ln":"https://linkedin.com", "in":"https://instagram.com"}}


	 	$wc_notifyme_email_template_table = $wpdb->prefix . 'notifyme_wc_email_template';

	 	//Create wc_notifyme email tamplate table
	 if( $wpdb->get_var("show tables like '". $wc_notifyme_email_template_table . "'") !== $wc_notifyme_email_template_table ) { 

		$sql[] = "CREATE TABLE ". $wc_notifyme_email_template_table . "(
			woo_notifyme_template_id int(11) NOT NULL AUTO_INCREMENT,
			wc_notifyme_template_logo VARCHAR(255) DEFAULT NULL,
			wc_notifyme_template_header VARCHAR(255) DEFAULT '#388cda',
			wc_notifyme_template_header_txt VARCHAR(255) DEFAULT 'Prices of your saved products are on sales!',
			wc_notifyme_template_link_color VARCHAR(255) DEFAULT '#388cda',
			wc_notifyme_template_social_txt VARCHAR(255) DEFAULT 'Connect with us',
			wc_notifyme_template_social VARCHAR(255) DEFAULT NULL,
			wc_notifyme_template_footer_txt1 VARCHAR(255) DEFAULT 'Woo Notify Me HTML Email',
			wc_notifyme_template_footer_txt2 VARCHAR(255) DEFAULT '123 Street Road, City, State 55555',
			wc_notifyme_template_footer_txt3 VARCHAR(255) DEFAULT 'email@example.com',
			wc_notifyme_template_footer_txt4 VARCHAR(255) DEFAULT '1-800-888-8888',
			wc_notifyme_template_unsubscribe_txt VARCHAR(255) DEFAULT 'UNSUBSCRIBE',
			PRIMARY KEY (woo_notifyme_template_id)
			)$charset_collate; ";
 
	 }
 
	 if ( !empty($sql) ) {
 
		 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
 
		 dbDelta($sql);
		 
	 }
	 //Insert default values into notifyme_wc_button_settings table

	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}notifyme_wc_button_settings");

	 if(count($results) == 0) {

	 $wpdb->insert(

    	$settings_table_name,
  		array(
  			'wc_notifyme_btn_class' => 'woo-notifyme-button',
  			'wc_notifyme_btn_bg_color' => 'woo-notifyme-button',
  			'wc_notifyme_btn_bg_color' => '#AA66CC',
  			'wc_notifyme_btn_text' => 'Notify Me',
  			'wc_notifyme_show_btn_single_page' => 'yes',
  			'wc_notifyme_show_btn_main_page' => 'no',
  		  )
  		);

	}

	// Insert default html template data
	$template = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}notifyme_wc_email_template");

	if(count($template) == 0) {

	$wpdb->insert(

	   $wc_notifyme_email_template_table,
		 array(
		
			'wc_notifyme_template_logo' => '<img class="" src="'.plugins_url('/images/notifyme_logo.png', __DIR__).'">',
			'wc_notifyme_template_header' => '#388cda',
			'wc_notifyme_template_header_txt' => 'Prices of your saved products are on sales!',
			'wc_notifyme_template_link_color' => '#388cda',
			'wc_notifyme_template_social_txt' => 'Connect with us',
			'wc_notifyme_template_social' => '{"social":{"fb":"https://facebook.com", "tw":"https://twitter.com", "yt":"https://youtube.com", "yt":"https://youtube.com", "ln":"https://linkedin.com", "in":"https://instagram.com"}}',
			'wc_notifyme_template_footer_txt1' => 'Woo Notify Me HTML Email',
			'wc_notifyme_template_footer_txt2' => '123 Street Road, City, State 55555',
			'wc_notifyme_template_footer_txt3' => 'email@example.com',
			'wc_notifyme_template_footer_txt4' => '1-800-888-8888',
			'wc_notifyme_template_unsubscribe_txt' => 'UNSUBSCRIBE',
		   )
		 );

   }




	}

}
