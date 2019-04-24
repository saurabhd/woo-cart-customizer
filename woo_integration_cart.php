<?php
/**
 * Addweb WC_Integration class 
 *
 * @package   Woo Cart Customizer
 * @author    Addweb Solution Pvt. Ltd.
 * @license   GPL-2.0+
 * @link      http://www.addwebsolution.com
 * @copyright 2016 AddwebSolution Pvt. Ltd.
 */
if ( ! class_exists( 'Woo_Integration_Cart' ) ) :
class Woo_Integration_Cart extends WC_Integration {
	/**
	* Init and hook in the integration.
	*/
	public function __construct() {
		global $woocommerce;
		$this->id 								= 'cart-customizer';
		$this->method_title				= __( 'Woo Cart Customizer', 'Addweb-woo-cart-customizer' );
		$this->method_description = __( 'Woo Cart Customizer plugin is used for change the cart name, message and notice text and also the button text of product by its type.', 'Addweb-woo-cart-customizer' );
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	* Initialize integration settings form fields.
	*/
	public function init_form_fields() {
		$this->form_fields = array(
			'add_to_cart_text' => array(
				'title'    => __( 'Add To Cart Button', 'Addweb-woo-cart-customizer' ),
				'description' => __( 'You can replace "Add to Cart" button name from here. Add button name of your choice.'),
				'id'       => 'woo_add_to_cart_text',
				'css'      => 'width:170px;',
				'placeholder' => 'Add to Cart',
				'type'     => 'text',
			),
			'view_cart_text' => array(
				'title'    => __( 'View Cart Button', 'Addweb-woo-cart-customizer' ),
				'description' => __( 'You can replace "View Cart" button name from here. Add button name of your choice.'),
				'id'       => 'woo_view_cart_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'View Cart',
				'type'     => 'text',
			),
			'update_cart_text' => array(
				'title'    => __( 'Update Cart Button', 'Addweb-woo-cart-customizer' ),
				'description'  => __( 'You can replace "Update Cart" button name from here. Add button name of your choice.'),
				'id'       => 'woo_update_cart_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'Update Cart',
				'type'     => 'text',
			),
			'message_and_notice_text' => array(
				'title'    => __( 'Message And Notice', 'Addweb-woo-cart-customizer' ),
				'description' => __( 'You can replace "Cart" text in Message and Notice from here. Add text of your choice.'),
				'id'       => 'woo_message_and_notice_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'Cart',
				'type'     => 'text',
			),
			'grouped_product_text' => array(
				'title'    => __( 'Grouped Product', 'Addweb-woo-cart-customizer' ),
				'description' => __( "You can replace Grouped Product's button name from here. Add button name of your choice."),
				'id'       => 'woo_grouped_product_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'View Products',
				'type'     => 'text',
			),
			'variable_product_text' => array(
				'title'    => __( 'Variable Product', 'Addweb-woo-cart-customizer' ),
				'description' => __( "You can replace Variable Product's button name from here. Add button name of your choice."),
				'id'       => 'woo_variable_product_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'Read more',
				'type'     => 'text',
			),
			'external_product_text' => array(
				'title'    => __( 'External Product', 'Addweb-woo-cart-customizer' ),
				'description' => __( "You can replace External Product's button name when only Button text is not set for External Product. Add button name of your choice."),
				'id'       => 'woo_external_product_text',
				'css'      => 'width:170px;',
				'placeholder'  => 'Buy Product',
				'type'     => 'text',
			),
			'external_product_checkbox' => array(
				'title'    => __( 'Apply to All External Products', 'Addweb-woo-cart-customizer' ),
				'description' => __( "You can replace All External Product's button name from here. Add button name of your choice."),
				'id'       => 'woo_external_product_text',
				'type'     => 'checkbox',
				'label'    => __( ' ', 'Addweb-woo-cart-customizer' ),
			),
		);
	}
}
endif;