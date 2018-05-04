<?php
/**
 * Single Product Dimensions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$opts = rwmb_meta( 'mbw_product-opts-up' );
$link_text = rwmb_meta( 'mbw_additional_options_text' );
$content = rwmb_meta( 'mbw_additional_options_content' );
if (empty($opts)) return '';
$max = sizeOf($opts);
?>
<section class="col-lg-8 col-md-8 col-sm-12 product-options product-detail-section" id="product-options">
    <h2>Product Options</h2>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-12 col-md-5">
            <div class="list-group"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 sidebar-offcanvas product-options-panels">
            <a href="#" class="product-option-close hidden-lg hidden-md" data-toggle="offcanvas" data-target="option-address-plaque">Back</a>
            <?php foreach ( $opts as $o) { ?>
                <section id="<?php echo mbw_get_spinal_case($o['title']); ?>" class="product-option" data-title="<?php echo $o['title']; ?>">
                    <h3><?php echo $o['title']; ?></h3>
                    <div class="image-container">
                        <figure class="modal-image">
                            <img src="<?php echo $o['full_url']; ?>" alt="<?php echo $o['alt']; ?>" />
                        </figure>
                    </div>
                </section>

            <?php } ?>

        </div>
    </div>
	<?php if (!empty($content)) { ?>
		<div class="row additional-prod-options">
			<div class="col-sm-12 col-md-5">
				<div class="list-group">
					<a href="#additional-product-options" class="list-group-item"><?php echo $link_text; ?></a>
				</div>
			</div>
		</div>
	<?php } ?>
</section>
