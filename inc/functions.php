<?php 

/**
* Enqueue scripts
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_enqueue(){
	wp_enqueue_style( 'card-font', 'https://fonts.googleapis.com/css?family=Montserrat:400,600,700' );
	wp_enqueue_style( 'card-animate', plugins_url( '../css/animate.css', __FILE__ ) );
	wp_enqueue_style( 'card-style', plugins_url( '../css/style.css', __FILE__ ) );

	wp_enqueue_script( 'card-script', plugins_url( '../js/script.js', __FILE__ ), array( 'jquery' ), null, true );
}
add_action( 'wp_enqueue_scripts', 'coupon_card_enqueue' );

/**
* Enqueue admin scripts
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_admin_enqueue( $hook ){
	if( $hook === 'toplevel_page_coupon-card' || $hook === 'coupon-card_page_add-new-coupon-card' ):
		
		wp_enqueue_style( 'card-admin-style', plugins_url( '../css/admin-style.css', __FILE__ ) );

		wp_enqueue_media();

		wp_enqueue_script( 'card-admin-script', plugins_url( '../js/admin-script.js', __FILE__ ), array( 'jquery' ), null, true );
		wp_localize_script( 'card-admin-script', 'CC', array(
			'security'	=> wp_create_nonce( 'coupon-nonce' ),
			'delete'	=> __( 'Are you sure you want to delete?', 'coupon-card' )
		) );

	endif;
}
add_action( 'admin_enqueue_scripts', 'coupon_card_admin_enqueue' );

/**
* Recognising frontend page id
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function cc_page_id() {
	global $cc_page_id;
	$cc_page_id = get_queried_object_id();
}
add_action( 'template_redirect', 'cc_page_id' );

/**
* Displaying coupon card
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card(){
	global $cc_page_id, $wpdb;
	$table_name = $wpdb->prefix . 'coupon_card';
	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE page_id = $cc_page_id" );
	
	if( ! empty( $results ) ):
		$background = $results[0]->bg_img;
		$title = $results[0]->title;
		$btn_title = $results[0]->button_text;
		$aff_url = $results[0]->aff_url;
		$type = $results[0]->offer_type;
		$coupon = $results[0]->coupon_code;
	?>
	<div class="coupon-card animated bounceInRight" style="background-image: url(<?php echo esc_url( $background ); ?>);">
		<div class="coupon-info">
			<div class="cc-closo"></div>
			<h1 class="coupon-title"><?php echo esc_attr( $title ); ?></h1>
			<a class="coupon-link" <?php if( $type === 'coupon' ){ echo 'id="cc-show-coupon"'; } ?> href="<?php echo esc_url( $aff_url ); ?>" target="_blank"><?php echo esc_attr( $btn_title ); ?></a>
			<?php if( $type === 'coupon' ): ?>
			<span class="cc-coupon"><?php echo esc_attr( $coupon ); ?></span>
			<?php endif; ?>
		</div>
	</div>
	<?php
	endif;
}
add_action( 'wp_footer', 'coupon_card' );

/**
* Data securely save database
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function cc_save_offer(){
	if( ! check_ajax_referer( 'coupon-nonce', 'security' ) ){
		return;
	}

	if( ! current_user_can( 'manage_options' ) ){
		return;
	}

	$page = esc_sql( $_POST['page'] );
	$title = sanitize_text_field( $_POST['title'] );
	$btntitle = sanitize_text_field( $_POST['btntitle'] );
	$aff_url = esc_sql( $_POST['aff_url'] );
	$bg_url = esc_sql( $_POST['bg_url'] );
	$type = sanitize_text_field( $_POST['type'] );
	$coupon = sanitize_text_field( $_POST['coupon'] );
	$response = array();
	$data = array();

	if( ! empty( $page ) ){
		$data['page_id'] = $page;
	}

	if( ! empty( $title ) ){
		$data['title'] = $title;
	}

	if( ! empty( $btntitle ) ){
		$data['button_text'] = $btntitle;
	}

	if( ! empty( $aff_url ) ){
		$data['aff_url'] = $aff_url;
	}

	if( ! empty( $bg_url ) ){
		$data['bg_img'] = $bg_url;
	}

	if( ! empty( $type ) ){
		$data['offer_type'] = $type;
	}

	if( ! empty( $coupon ) ){
		$data['coupon_code'] = $coupon;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'coupon_card';
	$get_results = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE page_id = $page" );

	if( $get_results ){
		$where = array( 'page_id' => $page );
		$result = $wpdb->update( $table_name, $data, $where );

		if( $result ){
			$response['success'] = __( 'Successfully upadted.', 'coupon-card' );
		} else {
			$response['success'] = __( 'Already saved this date.', 'coupon-card' );
		}

	} else {
		$result = $wpdb->insert( $table_name, $data);

		if( $result ){
			$response['success'] = __( 'Successfully saved.', 'coupon-card' );
		} else {
			$response['error'] = __( 'Error occurred! Please try again after sometime.', 'coupon-card' );
		}

	}
	
	wp_send_json( $response );

	die();
}
add_action( 'wp_ajax_card', 'cc_save_offer' );

/**
* Select option page list
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function cc_get_page(){
	$args = array(
		'post_type'			=> 'page',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1
	);

	$query = new WP_Query( $args );
	$page = '';

	if( $query->have_posts() ){
		while ( $query->have_posts() ) {
			$query->the_post();
			$page .= '<option value="'. esc_attr( get_the_ID() ) .'">'. esc_attr( get_the_title() ) .'</option>';
		}
	}

	return $page;

	wp_reset_query();
}

/**
* Delete coupon card
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function cc_coupon_card_delete(){
	if( ! check_ajax_referer( 'coupon-nonce', 'security' ) ){
		return;
	}

	if( ! current_user_can( 'manage_options' ) ){
		return;
	}

	$id = esc_sql( $_POST['id'] );

	if( ! empty( $id ) ){
		global $wpdb;
		$table_name = $wpdb->prefix . 'coupon_card';
		$result = $wpdb->delete( $table_name, array( 'page_id' => $id ), array( '%d' ) );
		wp_send_json_success( $result );
	}

	die();
}
add_action( 'wp_ajax_delete_card', 'cc_coupon_card_delete' );
