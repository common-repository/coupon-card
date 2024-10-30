<?php 

/**
* List All Coupons & Discounts
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_all_cards(){
	?>
	<div class="cc-wraper">
		<div class="cc-body">
			<div class="cc-form postbox">
				<h2 class="cc-heading cc-no-border">
					<span><?php _e( 'All Coupons &amp; Discounts', 'coupon-card' ); ?></span>
				</h2>
				
				<table class="wp-list-table widefat fixed striped posts">
				    <thead>
				        <tr>
				            <th><?php _e( 'Title', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Page', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Background', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Type', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Date', 'coupon-card' ); ?></th>
				        </tr>
				    </thead>
				    <tbody>
				    <?php
				    	global $wpdb;
				    	$table_name = $wpdb->prefix . 'coupon_card';
						$results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY time DESC" );
						if( ! empty( $results ) ):
							foreach ( $results as $key ) :
								$id = $key->page_id;
								$background = $key->bg_img;
								$title = $key->title;
								$btn_title = $key->button_text;
								$aff_url = $key->aff_url;
								$type = $key->offer_type;
								$time = $key->time;
					    ?>
					        <tr id="card-<?php echo esc_attr( $id ); ?>">
					            <td class="title">
					                <strong><?php echo esc_attr( $title ); ?></strong>
					                <div class="row-actions">
					                	<span class="trash"><a href="" class="cc-delete" data-id="<?php echo esc_attr( $id ); ?>"><?php _e( 'Delete', 'coupon-card' ); ?></a> | </span>
					                	<span class="view"><a href="<?php echo esc_url( get_the_permalink( $id ) ); ?>" rel="permalink"><?php _e( 'View', 'coupon-card' ); ?></a></span>
					                </div>
					            </td>
					            <td><?php echo esc_attr( get_the_title( $id ) ); ?></td>
					            <td>
					            	<?php if( ! empty( $background ) ): ?>
					            	<img class="cc-list-img" src="<?php echo esc_url( $background );?>">
					            	<?php endif; ?>
					            </td>
					            <td><span class="cc-type"><?php echo esc_attr( $type ); ?></span></td>
					            <td><?php echo esc_attr( $time ); ?><br><abbr title="<?php echo esc_attr( $time ); ?>"></abbr></td>
					        </tr>

					    	<?php 
					    		endforeach; 
					    		else: echo '<td><h3>' . __( 'No posts found', 'coupon-card' ) . '</h3></td>';
					    	endif;
					    	?>
				    </tbody>
				    <tfoot>
				        <tr>
				            <th><?php _e( 'Title', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Page', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Background', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Type', 'coupon-card' ); ?></th>
				            <th><?php _e( 'Date', 'coupon-card' ); ?></th>
				        </tr>
				    </tfoot>
				</table>
			</div>
			<div class="cc-donate">
				<div class="cc-opacity">
					<h1 class="cc-don-title"><?php _e( 'Development Support', 'coupon-card' ); ?></h1>
					<p class="cc-don-desc"><?php _e( 'If you think this plugin is helpful then you can donate.', 'coupon-card' ); ?></p>
					<a class="cc-don-link" href="http://paypal.me/ayan9" target="_blank"><?php _e( 'Donate', 'coupon-card' ); ?></a>
				</div>
			</div>
		</div>
	</div> 
	
	<?php
}