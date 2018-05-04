<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$docs = rwmb_meta( 'mbw_product_docs_file' );
if (empty($docs)) return '';
?>
<div class="col-md-6 col-sm-12">
	<h3>Downloads</h3>
	<ul class="no-bullets">
    <?php foreach ($docs as $d) { ?>
		<li><a href="<?php echo $d['url']; ?>" title="<?php echo $d['title']; ?>" target="_blank"><?php echo $d['title']; ?></a></li>
    <?php } ?>
	</ul>
</div>
