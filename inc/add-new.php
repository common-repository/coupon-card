<?php 

/**
* Add New Coupon & Discount fields
*
* @since 		1.0.0
* @package   	Coupon Card
* @author    	Ayan Chakraborty
*
*/

function coupon_card_add_new(){
	?>
	<div class="cc-wraper">
		<div class="cc-body">
			<div class="cc-form postbox">
				<h2 class="cc-heading">
					<span><?php _e( 'Add New Coupon &amp; Discount', 'coupon-card' ); ?></span>
				</h2>
				<form action="" method="">
					<h4 class="cc-form-title"><?php _e( 'Choose page:', 'coupon-card' ); ?></h4>
					<select name="pagelist" form="pagelist" class="regular-text" id="cc-page">
						<?php echo cc_get_page(); ?>
					</select>
					<h4 class="cc-form-title"><?php _e( 'Offer title:', 'coupon-card' ); ?></h4>
					<input type="text" class="regular-text" name="title" id="cc-title">
					<h4 class="cc-form-title"><?php _e( 'Button title:', 'coupon-card' ); ?></h4>
					<input type="text" class="regular-text" name="button-title" id="cc-btn-title">
					<h4 class="cc-form-title"><?php _e( 'Affiliate URL:', 'coupon-card' ); ?></h4>
					<input type="url" class="regular-text" name="aff-url" id="aff-url">
					<h4 class="cc-form-title"><?php _e( 'Choose background:', 'coupon-card' ); ?></h4>
					<input class="button button-secondary" type="button" name="btn-background" id="cc-btn-background" value="Upload">
					<input type="text" class="regular-text" name="background" id="cc-background-url">
					<p class="cc-radio">
						<span><?php _e( 'It\'s Discount:', 'coupon-card' ); ?></span>
						<input type="radio" name="offer-type" value="discount" id="cc-discount">
						<span><?php _e( 'It\'s Coupon:', 'coupon-card' ); ?></span>
						<input type="radio" name="offer-type" value="coupon" id="cc-coupon">
					</p>
					<div class="cc-coupon-box">
						<h4 class="cc-form-title"><?php _e( 'Coupon code:', 'coupon-card' ); ?></h4>
						<input type="text" name="coupon" class="regular-text" id="cc-coupon-code">
					</div>
					<input type="submit" id="cc-publish" class="button button-primary button-large" value="<?php _e( 'Publish', 'coupon-card' ); ?>">
				</form>
				<div id="reply"></div>
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