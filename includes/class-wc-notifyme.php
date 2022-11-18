<?php


class WC_Notifyme {


	protected $loader;
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	protected $version;

	public function __construct() {
		if ( defined( 'WC_NOTIFYME_VERSION' ) ) {
			$this->version = WC_NOTIFYME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wc-notifyme';

		$this->load_dependencies();
	//	$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-notifyme-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
	//	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-notifyme-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-notifyme-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc-notifyme-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-notifyme-render-html.php';

		$this->loader = new WC_Notifyme_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 */
	
	// private function set_locale() {
  //
	// 	$plugin_i18n = new Plugin_Name_i18n();
  //
	// 	$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
  //
	// }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	
	private function define_admin_hooks() {

		$plugin_admin = new WC_Notifyme_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'woocommerce_single_product_summary', $plugin_admin, 'wc_notifyme_product_page_button', 30 );
      
		
		$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_admin, 'wc_notifyme_main_product_page_button', 30 );

		
		$this->loader->add_action( 'wp_ajax_wc_notifyme_get_subscribers', $plugin_admin, 'wc_notifyme_get_subscribers', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_get_subscribers', $plugin_admin, 'wc_notifyme_get_subscribers', 1);

		$this->loader->add_action( 'wp_ajax_wc_notifyme_update_button_settings', $plugin_admin, 'wc_notifyme_update_button_settings', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_update_button_settings', $plugin_admin, 'wc_notifyme_update_button_settings', 1);

		$this->loader->add_action( 'wp_ajax_wc_notifyme_get_json_button_settings', $plugin_admin, 'wc_notifyme_get_json_button_settings', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_get_json_button_settings', $plugin_admin, 'wc_notifyme_get_json_button_settings', 1);
	

		$this->loader->add_action( 'wp_ajax_wc_notifyme_update_html_template_settings', $plugin_admin, 'wc_notifyme_update_html_template_settings', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_update_html_template_settings', $plugin_admin, 'wc_notifyme_update_html_template_settings', 1);

		$this->loader->add_action( 'wp_ajax_wc_notifyme_get_json_html_settings', $plugin_admin, 'wc_notifyme_get_json_html_settings', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_get_json_html_settings', $plugin_admin, 'wc_notifyme_get_json_html_settings', 1);
		
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WC_Notifyme_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        $this->loader->add_action( 'save_post_product', $plugin_public, 'wc_notifyme_main', 10, 3 );

	  // $this->loader->add_action('post_updated', $plugin_public, 'wc_notifyme_main', 10, 3);
	  // $this->loader->add_action('pre_post_update', $plugin_public, 'wc_notifyme_main', 10, 2);

	//    add_action( 'pre_post_update', array( $this, 'wc_notifyme_main' ), 1, 1 );
	//    $this->loader->add_action('post_updated', 'wc_notifyme_main', 10, 3);
		
		$this->loader->add_action( 'wp_ajax_wc_notifyme_ajax', $plugin_public, 'wc_notifyme_ajax', 1);
		$this->loader->add_action( 'wp_ajax_nopriv_wc_notifyme_ajax', $plugin_public, 'wc_notifyme_ajax', 1);
		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WC_Notifyme_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
