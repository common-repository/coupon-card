<?php
/*
Plugin Name: Coupon Card
Description: Promote Various Coupon And Discount Offers.
Version:     1.0.0
Author:      Ayan Chakraborty
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: coupon-card
*/

// Direct access not permitted
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Create database table
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_create_db(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'coupon_card';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
	  id int(10) NOT NULL AUTO_INCREMENT,
	  page_id varchar(255) DEFAULT '0' NOT NULL,
	  title varchar(255) DEFAULT '' NOT NULL,
	  button_text varchar(50) DEFAULT '' NOT NULL,
	  aff_url text DEFAULT '' NOT NULL,
	  bg_img text DEFAULT '' NOT NULL,
	  offer_type varchar(50) DEFAULT '' NOT NULL,
	  coupon_code varchar(50) DEFAULT '' NOT NULL,
	  time timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
register_activation_hook( __FILE__, 'coupon_card_create_db' );

// Calling plugin important files
require_once( plugin_dir_path( __FILE__ ) . '/inc/menu.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/all-cards.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/add-new.php' );
require_once( plugin_dir_path( __FILE__ ) . '/inc/functions.php' );
