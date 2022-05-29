<?php
/**
 * Cart
 *
 * @package ctwp
 */
$cart_toggle_button = get_field('cart_toggle_button','option') ? get_field('cart_toggle_button','option'):'';
$count = WC()->cart->cart_contents_count;

//ob_start();
//woocommerce_mini_cart();
//$mini_cart = ob_get_clean();
//do_action( 'wpml_add_language_selector' )
?>
	<div class="cct-icon-cart">
		<a class="cart_toggle_button" href="<?php echo esc_url(wc_get_cart_url()) ?>">
			<?php if ($cart_toggle_button): ?>
				<img src="<?php echo esc_url( matthewruddy_image_resize(wp_get_attachment_url($cart_toggle_button), 19, 19, false, false)['url'] ) ?>" alt="<?php echo esc_html(bloginfo('title')) ?>">
			<?php endif ?>
			<span class="cart-count"><?php echo esc_html($count) ?></span>
		</a>
	</div>

