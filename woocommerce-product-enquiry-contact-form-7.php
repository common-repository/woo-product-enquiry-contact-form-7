<?php
/**
 * Plugin Name: Woo Product Enquiry Contact Form 7
 * Description: This plugin allows you to Create Enquiry Form for product using Contact Form 7.
 * Version: 1.0
 * Author: Ocean Infotech
 * Author URI: https://www.xeeshop.com
 * Copyright: 2019 
 */
if (!defined('ABSPATH')) {
  die('-1');
}
if (!defined('WPECF7_PLUGIN_NAME')) {
  define('WPECF7_PLUGIN_NAME', 'Woo Product Enquiry Contact Form 7');
}
if (!defined('WPECF7_PLUGIN_VERSION')) {
  define('WPECF7_PLUGIN_VERSION', '1.0.0');
}
if (!defined('WPECF7_PLUGIN_FILE')) {
  define('WPECF7_PLUGIN_FILE', __FILE__);
}
if (!defined('WPECF7_PLUGIN_DIR')) {
  define('WPECF7_PLUGIN_DIR',plugins_url('', __FILE__));
}

if (!defined('WPECF7_DOMAIN')) {
  define('WPECF7_DOMAIN', 'wpecf7');
}

//Main class
//Load required js,css and other files

if (!class_exists('WPECF7')) {

  class WPECF7 {

    protected static $WPECF7_instance;

           /**
       * Constructor.
       *
       * @version 3.2.3
       */
      function __construct() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        //check plugin activted or not
        add_action('admin_init', array($this, 'WPECF7_check_plugin_state'));
      }

    //Add JS and CSS on Backend
    function WPECF7_load_admin_script_style() {
      wp_enqueue_style( 'WPECF7_admin_css', WPECF7_PLUGIN_DIR . '/css/wpecf7_admin_style.css', false, '1.0.0' );
      wp_enqueue_script( 'WPECF7_admin_js', WPECF7_PLUGIN_DIR . '/js/wpecf7_admin_js.js', false, '1.0.0' );

    }

    function WPECF7_load_script_style() {
      wp_enqueue_style( 'WPECF7_front_css', WPECF7_PLUGIN_DIR . '/css/wpecf7_front_style.css', false, '1.0.0' );
      wp_enqueue_script( 'WPECF7_front_js', WPECF7_PLUGIN_DIR . '/js/wpecf7_front_js.js', false, '1.0.0' );
      wp_localize_script( 'WPECF7_front_js', 'ajax_url', admin_url('admin-ajax.php?action=popup_create') );
    }

    function WPECF7_show_notice() {

        if ( get_transient( get_current_user_id() . 'wpecf7error' ) ) {

          deactivate_plugins( plugin_basename( __FILE__ ) );

          delete_transient( get_current_user_id() . 'wpecf7error' );

          echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';

        }

    }

    function WPECF7_check_plugin_state(){
      if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
        set_transient( get_current_user_id() . 'wpecf7error', 'message' );
      }
    }

    function init() {
      add_action('admin_notices', array($this, 'WPECF7_show_notice'));
      add_action('admin_enqueue_scripts', array($this, 'WPECF7_load_admin_script_style'));
      add_action('wp_enqueue_scripts',  array($this, 'WPECF7_load_script_style'));
    }

    //Load all includes files
    function includes() {
      include_once('includes/wpecf7_backend.php');
      include_once('includes/wpecf7_front.php');
    }

    //Plugin Rating
    public static function WPECF7_do_activation() {
      set_transient('wfc-first-rating', true, MONTH_IN_SECONDS);
    }

    public static function WPECF7_instance() {
      if (!isset(self::$WPECF7_instance)) {
        self::$WPECF7_instance = new self();
        self::$WPECF7_instance->init();
        self::$WPECF7_instance->includes();
      }
      return self::$WPECF7_instance;
    }

  }

  add_action('plugins_loaded', array('WPECF7', 'WPECF7_instance'));

  register_activation_hook(WPECF7_PLUGIN_FILE, array('WPECF7', 'WPECF7_do_activation'));
}


