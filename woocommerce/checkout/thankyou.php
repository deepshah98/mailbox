<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
		<!-- Google Code for Purchase/Sale Conversion Page -->
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 1072658868;
			var google_conversion_language = "en";
			var google_conversion_format = "3";
			var google_conversion_color = "666666";
			var google_conversion_label = "ATSYCJ3FPRC0873_Aw";
			var google_conversion_value = <?php echo $order->get_total(); ?>;
			var google_conversion_currency = "USD";
			var google_remarketing_only = false;
			/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
		<script type="text/javascript"> function onKeyMetricComplete() { if (window.location.pathname == "/order-received/") { if (typeof km_LogData === 'function') km_LogData('101'); } } </script>
		<noscript>
			<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1072658868/?value=1.00&amp;currency_code=USD&amp;label=ATSYCJ3FPRC0873_Aw&amp;guid=ON&amp;script=0"/>
			</div>
		</noscript>

		<!-- HitsLink.com tracking script -->
		<script type="text/javascript" id="wa_u" defer></script>
		<script type="text/javascript" async>//<![CDATA[
			var wa_pageName=location.pathname;    // customize the page name here;
			wa_account="B29E96939D9087A8908D948C"; wa_location=11;
			wa_MultivariateKey = '';    //  Set this variable to perform multivariate testing
			ec_Orders_orderID='<?php echo $order->get_order_number(); ?>';      //  Enter the Orders unique ID
			ec_Orders_orderAmt='<?php echo $order->get_total(); ?>';  //  Enter the amount of the Orders
			var wa_c=new RegExp('__wa_v=([^;]+)').exec(document.cookie),wa_tz=new Date(),
			wa_rf=document.referrer,wa_sr=location.search,wa_hp='http'+(location.protocol=='https:'?'s':'');
			if(top!==self){wa_rf=top.document.referrer;wa_sr=top.location.search}
			if(wa_c!=null){wa_c=wa_c[1]}else{wa_c=wa_tz.getTime();
			document.cookie='__wa_v='+wa_c+';path=/;expires=1/1/'+(wa_tz.getUTCFullYear()+2);}wa_img=new Image();
			wa_img.src=wa_hp+'://counter.hitslink.com/statistics.asp?v=1&s=11&eacct='+wa_account+'&an='+
			escape(navigator.appName)+'&sr='+escape(wa_sr)+'&rf='+escape(wa_rf)+'&mvk='+escape(wa_MultivariateKey)+
			'&sl='+escape(navigator.systemLanguage)+'&l='+escape(navigator.language)+
			'&pf='+escape(navigator.platform)+'&pg='+escape(wa_pageName)+'&cd='+screen.colorDepth+'&rs='+escape(screen.width+
			' x '+screen.height)+'&je='+navigator.javaEnabled()+'&c='+wa_c+'&tks='+wa_tz.getTime()
			+'&ec_type=566&ec_uniqueId='+ec_Orders_orderID+'&ec_orderAmount='+ec_Orders_orderAmt
			;document.getElementById('wa_u').src=wa_hp+'://counter.hitslink.com/track.js';//]]>
		</script>

		<script>
			 function GetRevenueValue()
			   {
			      return 6;
			    }
		</script>
		<script>
			window.uetq = window.uetq || [];
			window.uetq.push({ 'gv': '<?php echo $order->get_total(); ?>', 'gc': 'USD'});
		</script>


		<h2 class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></h2>

		<ul class="woocommerce-thankyou-order-details order_details">
			<li class="order">
				<?php _e( 'Order Number:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<?php _e( 'Payment Method:', 'woocommerce' ); ?>
				<strong><?php echo $order->payment_method_title; ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<h2 class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></h2>

<?php endif; ?>
