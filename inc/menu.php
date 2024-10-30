<?php 

/**
* Creating menu and submenu
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_menu(){
	add_menu_page( __( 'Coupon card', 'coupon-card' ), __( 'Coupon Card', 'coupon-card' ), 'manage_options', 'coupon-card', 'coupon_card_all_cards', plugins_url( '../images/icon-tag.png', __FILE__ ), 58 );
	add_submenu_page( 'coupon-card', __( 'All Cards', 'coupon-card' ), __( 'All Cards', 'coupon-card' ), 'manage_options', 'coupon-card', 'coupon_card_all_cards' );
	add_submenu_page( 'coupon-card', __( 'Add New Coupon &amp; Discount Card', 'coupon-card' ), __( 'Add New', 'coupon-card' ), 'manage_options', 'add-new-coupon-card', 'coupon_card_add_new' );
}
add_action( 'admin_menu', 'coupon_card_menu' );