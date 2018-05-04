<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<div class="cart-container">
	<div class="row">
		<p class="cart-empty col-sm-12" style="text-align:center;">
			<?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?>
		</p>

		<?php do_action( 'woocommerce_cart_is_empty' ); ?>

		<p class="return-to-shop cart-empty col-sm-12" style="text-align:center;">
			<a class="btn btn-warning btn-lg call-to-action" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'home' ) ) ); ?>">
				<?php _e( 'Keep Shopping', 'woocommerce' ) ?>
			</a>
		</p>
	</div>

</div>
