<?php
// Direct access security
if (!defined('TM_EPO_PLUGIN_SECURITY')){
	die();
}
?>
<div
data-epo-id="<?php echo $epo_internal_counter;?>"
data-cart-id="<?php echo $forcart;?>"
data-product-id="<?php echo $product_id;?>"
class="tc-extra-product-options tm-extra-product-options tm-custom-prices tc-clearfix tm-product-id-<?php echo $product_id;?> <?php echo $classcart;?><?php echo $isfromshortcode;?>" 
id="tm-extra-product-options<?php echo $form_prefix;?>">
    <div class="tm-extra-product-options-inner">
        <ul id="tm-extra-product-options-fields" class="tm-extra-product-options-fields">
