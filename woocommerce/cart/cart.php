<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();
do_action( 'woocommerce_before_cart' ); ?>

<div class="cart-container">
	<div class="row">
		<div class="col-sm-12 update-cart-button-container top-button-container">
			<a class="btn btn-black btn-md call-to-action" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'home' ) ) ); ?>">Continue Shopping</a>
			<a class="btn btn-warning btn-md call-to-action proceed-small-button" href="<?php echo esc_url( wc_get_checkout_url() ) ;?>">Proceed to Checkout</a>
		</div>
	</div>
	<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<div class="row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
							}
						?>
					</div>

					<div class="col-xs-9 col-sm-3 col-md-4 col-lg-4">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}
							echo '<span class="product-sku-label">SKU: ' . $_product->get_sku() . '</span>';

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</div>

					<div class="product-quantity col-xs-12 col-sm-4 col-md-3 col-lg-2" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</div>

					<div class="product-price col-xs-6 col-sm-3 col-md-2 col-lg-2" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . ' Each';
						?>
					</div>

					<div class="product-subtotal col-xs-6 col-sm-12 col-md-2 col-lg-3" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
						<?php
							echo 'Total: ' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</div>

				</div>
				<?php
			}
		}
		do_action( 'woocommerce_cart_contents' );

	?>

	<div class="row">
		<div class="col-sm-12 update-cart-button-container">
			<input type="submit" class="btn btn-primary btn-md call-to-action" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />
		</div>
	</div>

	<?php do_action( 'woocommerce_cart_actions' ); ?>

	<?php wp_nonce_field( 'woocommerce-cart' ); ?>

	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	</form>

	<div class="row cart-totals">

		<div class="col-md-6 col-sm-12">
			<div class="cart-cross-sells">
				<?php do_action( 'mailboxworks_cart_cross_sells' ); ?>
			</div>
			<form class="checkout_coupon" method="post">

				<div class="row">
					<p class="col-sm-9 col-xs-12">
						<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
					</p>
					<p class="col-sm-3 col-xs-12">
						<input type="submit" class="btn btn-primary btn-md call-to-action" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />
					</p>
				</div>

			</form>
			<div class="alert alert-info call-to-action" role="alert">
				PLEASE NOTE: All orders shipped via Fedex Ground or UPS Ground unless otherwise noted. Contact us for AK, HI, international or express shipping.
			</div>
		</div>

		<div class="col-md-6 col-sm-12">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>

	</div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
