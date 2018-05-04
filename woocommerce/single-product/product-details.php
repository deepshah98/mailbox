<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$details_item_numbers = rwmb_meta( 'details_item_numbers' );
$details_includes = rwmb_meta( 'details_includes' );
$details_manufacturer_sku = rwmb_meta( 'details_manufacturer_sku' );
$details_manufacturer = rwmb_meta( 'details_manufacturer' );
$details_non_locking = rwmb_meta( 'details_non-locking' );
$details_locking = rwmb_meta( 'details_locking' );
$details_parts = rwmb_meta( 'details_parts' );
?>
<h3>Details</h3>
<ul class="display-table no-bullets product-details">
    <?php
        if (!empty($details_item_numbers)) {
            foreach ($details_item_numbers as $item) { ?>
                <li class="table-row">
                    <span class="data-label table-cell"><?php echo $item['details_product_name']; ?> Item Number:</span>
                    <span class="data-value table-cell"><?php echo $item['details_product_number']; ?></span>
                </li>

            <?php } ?>
        <?php } ?>

    <?php if (!empty($details_includes)) { ?>
        <li class="table-row">
            <span class="data-label table-cell">Includes:</span>
            <span class="data-value table-cell"><?php echo $details_includes; ?></span>
        </li>
    <?php } ?>

	 <?php //if (!empty($details_manufacturer_sku)) { ?>
      <!--  <li class="table-row">
            <span class="data-label table-cell">Manufacturer - sku:</span>
            <span class="data-value table-cell"><?php echo $details_manufacturer_sku; ?></span>
        </li> -->
    <?php //} ?>
	
    <?php if (!empty($details_manufacturer)) { ?>
        <li class="table-row">
            <span class="data-label table-cell">Manufacturer:</span>
            <span class="data-value table-cell"><?php echo $details_manufacturer; ?></span>
        </li>
    <?php } ?>

	<?php if ( $product->has_weight() ) { ?>
        <li class="table-row">
            <span class="data-label table-cell">Shipping Weight:</span>
            <span class="data-value table-cell"><?php echo $product->get_weight(); ?> lbs.</span>
        </li>
    <?php } ?>

    <?php if ( !( $details_non_locking == 0 && $details_locking == 0 ) ) { ?>
        <li class="table-row">
            <span class="data-label table-cell">Locking:</span>
            <span class="data-value table-cell">
                <?php
                    if ( $details_non_locking == 1 && $details_locking == 1 ) {
                        echo "Locking and non-locking model available.";
                    } else if ( $details_locking == 1 ) {
                        echo "Locking mailbox.";
                    } else {
                        echo "Non-locking mailbox.";
                    }
                ?>
            </span>
        </li>
    <?php } ?>

    <?php if (!empty($details_parts)) { ?>
        <li class="table-row">
            <span class="data-label table-cell">Parts:</span>
            <span class="data-value table-cell">
                <span class="replacements">We sell <a href="<?php echo $details_parts; ?>">replacement parts</a> for this product.</span>
            </span>
        </li>
    <?php } ?>
</ul>
