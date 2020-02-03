<?php
/**
 * Plugin Name: Woo Cart Customizer
 * Plugin URI: http://www.addwebsolution.com
 * Description: Woo Cart Customizer plugin is used for change the cart name, message and notice text and also the button text of product by its type..
 * Version: 1.0
 * Author: AddWeb Solution Pvt. Ltd.
 * Author URI: http://www.addwebsolution.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: customized cart
 */
if ( in_array( 'woocommerce/woocommerce.php' , apply_filters( 'active_plugins', get_option( 'active_plugins' )))) { 
	if ( ! class_exists( 'Addweb_Cart_Customizer' )) :
		class Addweb_Cart_Customizer {
			/**
			* Plugin version
			*/
			const ADDWEB_CC_VERSION = '1.0';

			/**
			* Construct the plugin.
			*/
			public function __construct() {
				if ( is_admin() ) {
					add_action( 'plugins_loaded', array( $this, 'init' ) );
				}
			}

			/**
			* Initialize the plugin.
			*/
			public function init() {
				// Checks if WooCommerce is installed.
				if ( class_exists( 'WC_Integration' ) ) {
					// Include our integration class.     
					include_once plugin_dir_path( __FILE__ ) . 'woo_integration_cart.php';

					// Register the integration.
					add_filter( 'woocommerce_integrations', array( $this, 'addweb_add_integration' ) );

					// Set the plugin slug
					define( 'ADDWEB_WOO_CART_CUSTOMIZER_PLUGIN_SLUG', 'wc-settings' );

					// Setting action for plugin
					add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'addweb_customize_cart_action_links' );
				}
			}

			/**
			* Add a new integration to WooCommerce.
			*/
			public function addweb_add_integration( $integrations ) {
				$integrations[] = 'Woo_Integration_Cart';
				return $integrations;
			}
		}

		$Addweb_Cart_Customizer = new Addweb_Cart_Customizer();    

		function addweb_customize_cart_action_links( $links ) {
			$links[] = '<a href="'. menu_page_url( ADDWEB_WOO_CART_CUSTOMIZER_PLUGIN_SLUG, false ) .'&tab=integration">Settings</a>';
			return $links;
		}

		/*
		* Returns the array of custom names
		*/
		function addweb_custom_cart_name() {
			$customArr = get_option('woocommerce_cart-customizer_settings');
			return $customArr;
		}

		/*
		* Change cart Button for shop and single page
		*/
		add_filter( 'woocommerce_product_single_add_to_cart_text', 'addweb_custom_cart_button_text' );
		add_filter( 'woocommerce_product_add_to_cart_text', 'addweb_custom_cart_button_text' ); 

		function addweb_custom_cart_button_text() {
			$customArr = addweb_custom_cart_name();
			$_product = wc_get_product( get_the_ID() );      
			if( $_product->is_type( 'simple' ) ) {
				$finalText = ( empty( $customArr['add_to_cart_text'] )) ? 'Add to Cart' : $customArr['add_to_cart_text'];
				return __( $finalText, 'Addweb-woo-cart-customizer' );
			} 
			if($_product->is_type( 'grouped' ) ) {
				$finalText = ( empty( $customArr['grouped_product_text'] )) ? 'View Products' : $customArr['grouped_product_text'];
				return __( $finalText, 'Addweb-woo-cart-customizer' );
			}
			if($_product->is_type( 'variable' ) ) {
				if(doing_filter('woocommerce_product_single_add_to_cart_text')){
					$finalText = (empty( $customArr['add_to_cart_text'] )) ? 'Add to Cart' : $customArr['add_to_cart_text'];
				} else {
					$finalText = (empty( $customArr['variable_product_text'] )) ? 'Read more' : $customArr['variable_product_text'];
				}				
				return __( $finalText, 'Addweb-woo-cart-customizer' );
			}
			if($_product->is_type( 'external' ) && $customArr['external_product_checkbox'] == "yes") {
				$finalText = (empty( $customArr['external_product_text'] )) ? 'Buy Product' : $customArr['external_product_text'];
				return __( $finalText, 'Addweb-woo-cart-customizer');
			}
			if($_product->is_type( 'external' ) && $customArr['external_product_checkbox'] == "no") {
				$finalExternalText = (empty( $customArr['external_product_text'] )) ? 'Buy Product' : $customArr['external_product_text'];
				$finalText = $_product->button_text ? $_product->button_text : $finalExternalText;
				return __( $finalText, 'Addweb-woo-cart-customizer' );
			}
		}

		/*
		* Change view cart button
		*/
		add_filter( 'woocommerce_add_message'	,	'addweb_custom_message_text', 10, 1 );
		add_filter( 'woocommerce_add_error'	,	'addweb_custom_message_text', 10, 1 );
		add_filter( 'woocommerce_add_notice'	,	'addweb_custom_message_text', 10, 1 );
		function addweb_custom_message_text( $message ) {
			$customArr = addweb_custom_cart_name();
			$finalMessageText = ( empty( $customArr['message_and_notice_text'] )) ? 'Cart' : $customArr['message_and_notice_text'];
			$message = str_replace( 'your cart','your '.$finalMessageText, $message );
			return $message;
		}

		/**
		* change some WooCommerce labels
		* @param string $translation
		* @param string $text
		* @param string $domain
		* @return string
		*/

		error_reporting(E_ALL);
		add_filter('gettext', 'addweb_custom_update_cart_message', 10, 3);
		function addweb_custom_update_cart_message($translation, $text, $domain) {
			if ($domain == 'woocommerce') {
				$customArr = addweb_custom_cart_name();
				if ($text == 'Cart updated.') {
						$finalText = (empty($customArr['message_and_notice_text'])) ? 'Cart' : $customArr['message_and_notice_text'];
						$translation =  $finalText.' updated.';
				}
				if($text == "View cart") {
					
					 $finalText = (empty($customArr['view_cart_text'])) ? 'View cart' : $customArr['view_cart_text'];
					 $translation = $finalText;
				}
				if($text == "Cart Totals") {
					 $finalText = (empty($customArr['message_and_notice_text'])) ? 'Cart' : $customArr['message_and_notice_text'];
					 $translation = $finalText . ' Totals';
				}
				if($text == "Your cart is currently empty.") {
					 $finalText = (empty($customArr['message_and_notice_text'])) ? 'cart' : $customArr['message_and_notice_text'];
					 $translation = 'Your '. $finalText .' is currently empty.';
				}
				if($text == "Update cart") {
					 $finalText = (empty($customArr['update_cart_text'])) ? 'Update cart' : $customArr['update_cart_text'];
					 $translation = strtoupper($finalText);
				}
			}
			return $translation;
		}
	endif;
}
?>