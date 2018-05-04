<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$dimensions = rwmb_meta( 'dimensions' );

if (empty($dimensions)) return '';
?>
<h3>Dimensions</h3>
<table class="table table-striped">
    <colgroup>
        <col class="bold">
        <col span="3">
    </colgroup>
    <thead>
        <tr>
            <th>Item</th>
            <th>Height (inches)</th>
            <th>Width (inches)</th>
            <th>Depth (inches)</th>
        </tr>
    </thead>
    <tfoot></tfoot>
    <tbody>
        <?php foreach ($dimensions as $prod) { ?>
            <tr>
                <td><?php echo $prod['d_name']; ?></td>
                <td><?php echo $prod['d_height']; ?></td>
                <td><?php echo $prod['d_width']; ?></td>
                <td><?php echo $prod['d_depth']; ?></td>
            </tr>
        <?php } ?>
    <tbody>
</table>
