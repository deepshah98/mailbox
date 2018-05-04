<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Register custom navigation walker
require_once('includes/wp_bootstrap_navwalker.php');

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}


function shortcode_empty_paragraph_fix($content)
{
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

    return $content;
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');

/*------------------------------------*\
	Ninja Forms
\*------------------------------------*/
function register_ninja_form_fields() {
	$argsSku = array(
		'name' => 'Product Sku',
		'display_function' => 'collect_product_sku',
		'sidebar' => 'template_fields',
		'display_label' => true,
		'display_wrap' => true,
	);

	$argsProductName = array(
		'name' => 'Product Name',
		'display_function' => 'collect_product_name',
		'sidebar' => 'template_fields',
		'display_label' => true,
		'display_wrap' => true,
	);

	if( function_exists( 'ninja_forms_register_field' ) )
	{
		ninja_forms_register_field('product_sku', $argsSku);
		ninja_forms_register_field('product_name', $argsProductName);
	}
}

function collect_product_sku( $field_id, $data )
{
	global $post;

	$sku = $_GET["prod_sku"];

	if(!empty($post))
	{
		if (isset($sku))
		{
		?>
			<input type="text" name="ninja_forms_field_<?php echo $field_id;?>" value="<?php echo htmlspecialchars($sku);?>" readonly />
		<?php
		}
	}

    if(is_admin())
	{
		?>
			<div class="field-wrap text-wrap label-above">
				<label for="ninja_forms_field_<?php echo $field_id;?>">Product Sku</label>
				<input type="text" name="ninja_forms_field_<?php echo $field_id;?>" value="<?php echo $data['default_value'];?>">
				<p><a href="http://whois.domaintools.com/<?php echo $data['default_value'];?>" target="_blank">Display the Sku param</a></p>
			</div>
		<?php
	}
}

function collect_product_name( $field_id, $data )
{
	global $post;

	$name = $_GET["prod_name"];

	if(!empty($post))
	{
		if (isset($name))
		{
		?>
			<input type="text" name="ninja_forms_field_<?php echo $field_id;?>" value="<?php echo htmlspecialchars($name);?>" readonly />
		<?php
		}
	}

    if(is_admin())
	{
		?>
			<div class="field-wrap text-wrap label-above">
				<label for="ninja_forms_field_<?php echo $field_id;?>">Product Name</label>
				<input type="text" name="ninja_forms_field_<?php echo $field_id;?>" value="<?php echo $data['default_value'];?>">
				<p><a href="http://whois.domaintools.com/<?php echo $data['default_value'];?>" target="_blank">Display the Name param</a></p>
			</div>
		<?php
	}
}

add_action( 'init', 'register_ninja_form_fields' );

/*------------------------------------*\
	WooCommerce
\*------------------------------------*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

if ( is_woocommerce_activated() ) {

    add_action( 'init', 'wpm_product_cat_register_meta' );
    /**
     * Register details product_cat meta.
     *
     * Register the details metabox for WooCommerce product categories.
     *
     */
    function wpm_product_cat_register_meta() {
    	register_meta( 'term', 'details', 'wpm_sanitize_details' );
    }
    /**
     * Sanitize the details custom meta field.
     *
     * @param  string $details The existing details field.
     * @return string          The sanitized details field
     */
    function wpm_sanitize_details( $details ) {
    	return wp_kses_post( $details );
    }

    /**
     * Adding support for WYSIWYG on product categories
     */
    add_action( 'product_cat_add_form_fields', 'wpm_product_cat_add_details_meta' );
    add_action( 'product_cat_edit_form_fields', 'wpm_product_cat_edit_details_meta' );
    add_action( 'create_product_cat', 'wpm_product_cat_details_meta_save' );
    add_action( 'edit_product_cat', 'wpm_product_cat_details_meta_save' );
    add_action( 'woocommerce_after_shop_loop', 'wpm_product_cat_display_details_meta' );

    /**
     * Add a details metabox to the Add New Product Category page.
     *
     * For adding a details metabox to the WordPress admin when
     * creating new product categories in WooCommerce.
     *
     */
    function wpm_product_cat_add_details_meta() {
    	wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_details_nonce' );
    	?>
    	<div class="form-field">
    		<label for="wpm-product-cat-details"><?php esc_html_e( 'Category Content', 'wpm' ); ?></label>
            <?php wp_editor( wpm_sanitize_details( $product_cat_details ), 'product_cat_details', $settings ); ?>
    		<p class="description"><?php esc_html_e( 'Detailed category info to appear below the product list', 'wpm' ); ?></p>
    	</div>
    	<?php
    }

    /**
     * Add a details metabox to the Edit Product Category page.
     *
     * For adding a details metabox to the WordPress admin when
     * editing an existing product category in WooCommerce.
     *
     * @param  object $term The existing term object.
     */
    function wpm_product_cat_edit_details_meta( $term ) {
    	$product_cat_details = get_term_meta( $term->term_id, 'details', true );
    	if ( ! $product_cat_details ) {
    		$product_cat_details = '';
    	}
    	$settings = array( 'textarea_name' => 'wpm-product-cat-details' );
    	?>
    	<tr class="form-field">
    		<th scope="row" valign="top"><label for="wpm-product-cat-details"><?php esc_html_e( 'Category Content', 'wpm' ); ?></label></th>
    		<td>
    			<?php wp_nonce_field( basename( __FILE__ ), 'wpm_product_cat_details_nonce' ); ?>
    			<?php wp_editor( wpm_sanitize_details( $product_cat_details ), 'product_cat_details', $settings ); ?>
    			<p class="description"><?php esc_html_e( 'Category content info to appear below the product list','wpm' ); ?></p>
    		</td>
    	</tr>
    	<?php
    }

    /**
     * Save Product Category details meta.
     *
     * Save the product_cat details meta POSTed from the
     * edit product_cat page or the add product_cat page.
     *
     * @param  int $term_id The term ID of the term to update.
     */
    function wpm_product_cat_details_meta_save( $term_id ) {
    	if ( ! isset( $_POST['wpm_product_cat_details_nonce'] ) || ! wp_verify_nonce( $_POST['wpm_product_cat_details_nonce'], basename( __FILE__ ) ) ) {
    		return;
    	}
    	$old_details = get_term_meta( $term_id, 'details', true );
    	$new_details = isset( $_POST['wpm-product-cat-details'] ) ? $_POST['wpm-product-cat-details'] : '';
    	if ( $old_details && '' === $new_details ) {
    		delete_term_meta( $term_id, 'details' );
    	} else if ( $old_details !== $new_details ) {
    		update_term_meta(
    			$term_id,
    			'details',
    			wpm_sanitize_details( $new_details )
    		);
    	}
    }

    /**
     * Display details meta on Product Category archives.
     *
     */
    function wpm_product_cat_display_details_meta() {
    	if ( ! is_tax( 'product_cat' ) ) {
    		return;
    	}
        $obj  = get_queried_object();
    	$t_id = $obj->term_id;
    	$details = get_term_meta( $t_id, 'details', true );
    	if ( '' !== $details ) {
            $cat = get_the_category( $t_id );
            echo '<section class="product-cat-details row">' .
                '<h2 class="col-sm-12 more-about-title">More About ' . $obj->name .'</h2>' .
                '<div class="col-sm-12">' .
                    apply_filters( 'the_content', wp_kses_post( $details ) ) .
                '</div>' .
            '</section>';
    	}
    }

	function wc_dropdown_variation_attribute_options( $args = array() ) {
		$args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
			'options'          => false,
			'attribute'        => false,
			'product'          => false,
			'selected' 	       => false,
			'name'             => '',
			'id'               => '',
			'class'            => 'form-control',
			'show_option_none' => __( '-- Please Select --', 'woocommerce' )
		) );

		$options   = $args['options'];
		$product   = $args['product'];
		$attribute = $args['attribute'];
		$name      = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id        = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class     = $args['class'];
        $prices    = [];

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '">';

		if ( $args['show_option_none'] ) {
			$html .= '<option value="">' . esc_html( $args['show_option_none'] ) . '</option>';
		}

        if ( ! empty($product) && array_key_exists('children', $product)) {
            if (array_key_exists('visible', $product->children)) {
                foreach ($product->children['visible'] as $var) {
                    $wcp = new WC_Product($var);
                    $prices[] = $wcp->price;
                }
            }
        }

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->id, $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						$html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $idx=>$option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					if (strcmp($prices[$idx], "") !== 0 && $prices[$idx] !== "0.00") {
						$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . ' ($' . $prices[$idx] . ')</option>';
					} else {
						$html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
					}
				}
			}
		}

		$html .= '</select>';

		echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
	}

	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );
    add_filter( 'woocommerce_breadcrumb_defaults', 'alter_breadcrumb_defaults' );
    function alter_breadcrumb_defaults( $defaults ) {
        return array_merge( $defaults, array(
            'delimiter'     => '&nbsp;&gt;&nbsp;',
            'wrap_before'   => '<section class="container breadcrumb"><div class="row"><div class="col-lg-12">',
            'wrap_after'    => '</div></div></section>'
        ) );
    };

    add_filter( 'woocommerce_get_price_html', 'alter_saleprice_defaults', 100, 2 );
    function alter_saleprice_defaults( $price, $product ) {
        // WC is sort of dumb about this. Need to actually get prices from string...;
        $matches = array();
        preg_match_all('/>([0-9\.,-]+)/', $price, $matches);

        $category_ids = $product->category_ids;

        $noDecimals = [197, 158, 320];
        $hasNoDecimals = false;

        foreach ($category_ids as $cid) {
            $isInNoDecimalsArray = array_search($cid, $noDecimals);

            if ($isInNoDecimalsArray !== false) {
                $hasNoDecimals = true;
                break;
            }
        }

        if ($hasNoDecimals) {
            if (sizeof($matches[1]) > 3) {
                $retail_price = '<li class="retail">Retail Price: <span class="retail-price"><span class="dollar-sign">$</span>' . substr( str_replace(',', '', $matches[1][0] ), 0, -3) . ' - $' . substr( str_replace(',', '', $matches[1][1] ), 0, -3) . '</span></li>';
                $sale_price = '<li class="our-price">Our Price: <span class="price"><span class="dollar-sign">$</span>' . substr( str_replace(',', '', $matches[1][2] ), 0, -3) . ' - $' . substr( str_replace(',', '', $matches[1][3] ), 0, -3) . '</span></li>';

                return $retail_price . $sale_price;
            }

            $retail_price = '<li class="retail">Retail Price: <span class="retail-price"><span class="dollar-sign">$</span>' . substr( str_replace(',', '', $matches[1][0] ), 0, -3). '</span></li>';
            $sale_price = '<li class="our-price">Our Price: <span class="price"><span class="dollar-sign">$</span>' . substr( str_replace(',', '', $matches[1][1] ), 0, -3) . '</span></li>';

            return $retail_price . $sale_price;
        } else {
            if (sizeof($matches[1]) > 3) {
                $retail_price = '<li class="retail">Retail Price: <span class="retail-price"><span class="dollar-sign">$</span>' . $matches[1][0] . ' - $' . $matches[1][1] . '</span></li>';
                $sale_price = '<li class="our-price">Our Price: <span class="price"><span class="dollar-sign">$</span>' . $matches[1][2] . ' - $' . $matches[1][3] . '</span></li>';

                return $retail_price . $sale_price;
            }

            $retail_price = '<li class="retail">Retail Price: <span class="retail-price"><span class="dollar-sign">$</span>' . $matches[1][0] . '</span></li>';
            $sale_price = '<li class="our-price">Our Price: <span class="price"><span class="dollar-sign">$</span>' . $matches[1][1] . '</span></li>';

            return $retail_price . $sale_price;
        }
    };

    function woocommerce_taxonomy_archive_description() {
		if ( is_tax( array( 'product_cat', 'product_tag' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
			$description = wc_format_content( term_description() );

			if ( $description ) {
				echo '<div class="separator-bar"></div>' . $description;
			}
		}
	}

    if ( ! function_exists( 'mailboxworks_get_product_availability' ) ) {

    	/**
    	 * Output the product title.
    	 *
    	 * @subpackage	Product
    	 */
    	function mailboxworks_get_product_availability() {
    		wc_get_template( 'single-product/product-availability.php' );
    	}
    }

    if ( ! function_exists( 'mailboxworks_get_product_ratings' ) ) {

        /**
         * Output the product title.
         *
         * @subpackage	Product
         */
        function mailboxworks_get_product_ratings() {
            wc_get_template( 'single-product/product-rating.php' );
        }
    }

    if ( ! function_exists( 'mailboxworks_additional_information' ) ) {

        /**
         * Output the product title.
         *
         * @subpackage	Product
         */
        function mailboxworks_additional_information() {
            wc_get_template( 'single-product/additional-information.php' );
        }
    }

    if ( ! function_exists( 'mailboxworks_get_quantity_field' ) ) {

        /**
         * Output the product title.
         *
         * @subpackage	Product
         */
        function mailboxworks_get_quantity_field() {
            wc_get_template( 'single-product/add-to-cart/quantity.php' );
        }
    }

    if ( ! function_exists( 'get_product_variations') ) {

        function get_product_variations() {
            wc_get_template( 'single-product/product-variants.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_dimensions') ) {

        function mbw_get_product_dimensions() {
            wc_get_template( 'single-product/product-dimensions.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_details') ) {

        function mbw_get_product_details() {
            wc_get_template( 'single-product/product-details.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_badges') ) {

        function mbw_get_product_badges() {
            wc_get_template( 'single-product/product-badges.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_specs') ) {

        function mbw_get_product_specs() {
            wc_get_template( 'single-product/product-specs.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_docs') ) {

        function mbw_get_product_docs() {
            wc_get_template( 'single-product/product-docs.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_options') ) {

        function mbw_get_product_options() {
            wc_get_template( 'single-product/product-options.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_videos') ) {

        function mbw_get_product_videos() {
            wc_get_template( 'single-product/product-videos.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_addtl_images') ) {

        function mbw_get_product_addtl_images() {
            wc_get_template( 'single-product/additional-images.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_addtl_options') ) {

        function mbw_get_product_addtl_options() {
            wc_get_template( 'single-product/additional-options.php' );

        };

    };

    if ( ! function_exists( 'mbw_get_product_reviews') ) {

        function mbw_get_product_reviews () {
            wc_get_template( 'single-product/product-reviews.php' );

        };

    };

    add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_add_to_cart_form', 'woocommerce_template_single_add_to_cart', 5 );
    add_action( 'woocommerce_single_product_summary', 'mailboxworks_get_product_availability', 15 );
    add_action( 'woocommerce_single_product_summary', 'mailboxworks_get_product_ratings', 15 );
    add_action( 'woocommerce_single_product_summary', 'mailboxworks_additional_information', 15 );
    add_action( 'woocommerce_before_variations_form', 'mailboxworks_get_quantity_field', 5 );
    add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 40 );
    add_action( 'mbw_get_product_bages', 'mbw_get_product_badges', 5 );
    add_action( 'mailboxworks_get_variations', 'get_product_variations', 5 );
    add_action( 'mailboxworks_product-details', 'mbw_get_product_dimensions', 5 );
    add_action( 'mailboxworks_product-details', 'mbw_get_product_details', 10 );
    add_action( 'mailboxworks_product-files', 'mbw_get_product_specs', 5 );
    add_action( 'mailboxworks_product-files', 'mbw_get_product_docs', 10 );
    add_action( 'mailboxworks_get_product_options', 'mbw_get_product_options', 10 );
    add_action( 'mailboxworks_product-media', 'mbw_get_product_videos', 10 );
    add_action( 'mailboxworks_product-media', 'mbw_get_product_addtl_images', 15 );
    add_action( 'mailboxworks_product-media', 'mbw_get_product_addtl_options', 20 );
    add_action( 'mailboxworks_product-media', 'mbw_get_product_reviews', 25 );
    add_action( 'mailboxworks_cart_cross_sells', 'woocommerce_cross_sell_display' );

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

    /**
	 * Outputs a checkout/address form field.
	 *
	 * @subpackage	Forms
	 * @param string $key
	 * @param mixed $args
	 * @param string $value (default: null)
	 * @todo This function needs to be broken up in smaller pieces
	 */
	function woocommerce_form_field( $key, $args, $value = null ) {
		$defaults = array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'placeholder'       => '',
			'maxlength'         => false,
			'required'          => false,
			'autocomplete'      => false,
			'id'                => $key,
			'class'             => array(),
			'label_class'       => array(),
			'input_class'       => array(),
			'return'            => false,
			'options'           => array(),
			'custom_attributes' => array(),
			'validate'          => array(),
			'default'           => '',
		);

		$args = wp_parse_args( $args, $defaults );
		$args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

		if ( $args['required'] ) {
			$args['class'][] = 'validate-required';
			$required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
		} else {
			$required = '';
		}

		$args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

		$args['autocomplete'] = ( $args['autocomplete'] ) ? 'autocomplete="' . esc_attr( $args['autocomplete'] ) . '"' : '';

		if ( is_string( $args['label_class'] ) ) {
			$args['label_class'] = array( $args['label_class'] );
		}

        if ( $args['required'] ) {
            $args['label_class'][] = 'required';
        }

		if ( is_null( $value ) ) {
			$value = $args['default'];
		}

		// Custom attribute handling
		$custom_attributes = array();

		if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
			foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
			}
		}

		if ( ! empty( $args['validate'] ) ) {
			foreach( $args['validate'] as $validate ) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field = '';
		$label_id = $args['id'];
		$field_container = '<p class="form-group %1$s" id="%2$s">%3$s</p>';

		switch ( $args['type'] ) {
			case 'country' :

				$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

				if ( 1 === sizeof( $countries ) ) {

					$field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

					$field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys($countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state form-control" />';

				} else {

					$field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . $args['autocomplete'] . ' class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . '>'
							. '<option value="">'.__( 'Select a country&hellip;', 'woocommerce' ) .'</option>';

					foreach ( $countries as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" '. selected( $value, $ckey, false ) . '>'. __( $cvalue, 'woocommerce' ) .'</option>';
					}

					$field .= '</select>';

					$field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '" /></noscript>';

				}

				break;
			case 'state' :

				/* Get Country */
				$country_key = 'billing_state' === $key ? 'billing_country' : 'shipping_country';
				$current_cc  = WC()->checkout->get_value( $country_key );
				$states      = WC()->countries->get_states( $current_cc );

				if ( is_array( $states ) && empty( $states ) ) {

					$field_container = '<p class="form-row form-group %1$s" id="%2$s" style="display: none">%3$s</p>';

					$field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key )  . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" />';

				} elseif ( is_array( $states ) ) {

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . '>
						<option value="">'.__( 'Select a state&hellip;', 'woocommerce' ) .'</option>';

					foreach ( $states as $ckey => $cvalue ) {
						$field .= '<option value="' . esc_attr( $ckey ) . '" '.selected( $value, $ckey, false ) .'>'.__( $cvalue, 'woocommerce' ) .'</option>';
					}

					$field .= '</select>';

				} else {

					$field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . ' name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				}

				break;
			case 'textarea' :

				$field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>'. esc_textarea( $value  ) .'</textarea>';

				break;
			case 'checkbox' :

				$field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) .'" ' . implode( ' ', $custom_attributes ) . '>
						<input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" '.checked( $value, 1, false ) .' /> '
						 . $args['label'] . '</label>';

				break;
			case 'password' :
			case 'text' :
			case 'email' :
			case 'tel' :
			case 'number' :

				$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';

				break;
			case 'select' :

				$options = $field = '';

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						if ( '' === $option_key ) {
							// If we have a blank option, select2 needs a placeholder
							if ( empty( $args['placeholder'] ) ) {
								$args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}
						$options .= '<option value="' . esc_attr( $option_key ) . '" '. selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) .'</option>';
					}

					$field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select form-control '. esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['autocomplete'] . '>
							' . $options . '
						</select>';
				}

				break;
			case 'radio' :

				$label_id = current( array_keys( $args['options'] ) );

				if ( ! empty( $args['options'] ) ) {
					foreach ( $args['options'] as $option_key => $option_text ) {
						$field .= '<input type="radio" class="input-radio form-control ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
						$field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) .'">' . $option_text . '</label>';
					}
				}

				break;
		}

		if ( ! empty( $field ) ) {
			$field_html = '';

			if ( $args['label'] && 'checkbox' != $args['type'] ) {
				$field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . '</label>';
			}

			$field_html .= $field;

			if ( $args['description'] ) {
				$field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
			}

			$container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
			$container_id = esc_attr( $args['id'] ) . '_field';

			$after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

			$field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
		}

		$field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

		if ( $args['return'] ) {
			return $field;
		} else {
			echo $field;
		}
	}
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => false,
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'nav navbar-nav',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="nav navbar-nav">%3$s</ul>',
		'depth'           => 2,
		'walker'          => new wp_bootstrap_navwalker()
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('html5shiv', get_template_directory_uri() . '/js/lib/html5shiv.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('html5shiv'); // Enqueue it!

    	wp_register_script('jquery', get_template_directory_uri() . '/js/lib/jquery-1.11.2.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('jquery'); // Enqueue it!

        wp_register_script('bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('bootstrap'); // Enqueue it!

        wp_register_script('slick', get_template_directory_uri() . '/js/lib/slick.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('slick'); // Enqueue it!

        wp_register_script('main', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('main'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.min.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); // Enqueue it!

    wp_register_style('bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-theme'); // Enqueue it!

    wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1.0', 'all');
    wp_enqueue_style('font-awesome'); // Enqueue it!

    wp_register_style('slick', get_template_directory_uri() . '/css/slick.css', array(), '1.0', 'all');
    wp_enqueue_style('slick'); // Enqueue it!

    wp_register_style('slick-theme', get_template_directory_uri() . '/css/slick.css', array(), '1.0', 'all');
    wp_enqueue_style('slick-theme'); // Enqueue it!

    wp_register_style('main', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('main'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
	 // Define Sidebar Widget Area 3
    register_sidebar(array(
        'name' => __('Product Details Area', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-3',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'mid_size' => 5,
        'total' => $wp_query->max_num_pages,
        'type' => 'list'
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
// add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
// add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
// add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.
add_shortcode('mbw_categories', 'mailboxworks_category_list');
add_shortcode('mbw_category', 'mailboxworks_category');
add_shortcode('mbw_moreinfo', 'mailboxworks_moreinfo');
add_shortcode('mbw_moreinfo_panel', 'mailboxworks_moreinfo_panel');

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
// function create_post_type_html5()
// {
//     register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
//     register_taxonomy_for_object_type('post_tag', 'html5-blank');
//     register_post_type('html5-blank', // Register Custom Post Type
//         array(
//         'labels' => array(
//             'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
//             'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
//             'add_new' => __('Add New', 'html5blank'),
//             'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
//             'edit' => __('Edit', 'html5blank'),
//             'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
//             'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
//             'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
//             'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
//             'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
//             'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
//             'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
//         ),
//         'public' => true,
//         'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
//         'has_archive' => true,
//         'supports' => array(
//             'title',
//             'editor',
//             'excerpt',
//             'thumbnail'
//         ), // Go to Dashboard Custom HTML5 Blank post for supports
//         'can_export' => true, // Allows export in Tools > Export
//         'taxonomies' => array(
//             'post_tag',
//             'category'
//         ) // Add Category and Post Tags support
//     ));
// }

/*------------------------------------*\
	Meta Box
\*------------------------------------*/
add_filter( 'rwmb_meta_boxes', 'mbw_register_meta_boxes' );
function mbw_register_meta_boxes( $meta_boxes ) {
    $prefix = 'mbw_';

    $meta_boxes[] = array(
        'title'  => __( 'Product Options' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-opts',
        'fields' => array(
            array(
                'name'             => esc_html__( 'Product Options', 'mbw' ),
                'id'               => "mbw_product-opts-up",
                'type'             => 'image_advanced',
                // Delete image from Media Library when remove it from post meta?
                // Note: it might affect other posts if you use same image for multiple posts
                'force_delete'     => false
            )
        ),
    );

    $meta_boxes[] = array(
        'title'  => __( 'Reviews' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-reviews',
        'fields' => array(
            array(
                'name' => esc_html__( 'Name', 'mbw' ),
                'id'   => "mbw_review_name",
                'desc' => esc_html__( 'TrustPilot Review Name', 'mbw' ),
                'type'   => 'text',
            ),
            array(
                'name' => esc_html__( 'Sku', 'mbw' ),
                'id'   => "mbw_review_sku",
                'desc' => esc_html__( 'TrustPilot Review Sku', 'mbw' ),
                'type'   => 'text',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'  => __( 'Additional Options' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-more-prod-options',
        'fields' => array(
            array(
                'name'   => 'Link Text',
                'id'     => "mbw_additional_options_text",
                // Group field
                'type'   => 'text',
                'std'    => 'More product options',
                'desc'  => esc_html__( 'The text to be displayed as the link', 'mbw' )
            ),
            array(
                'name'   => 'Additional Product Details',
                'id'     => "mbw_additional_options_content",
                // Group field
                'type'   => 'wysiwyg',
                'raw'    => false,
                'desc'  => esc_html__( 'Additional information about the product.', 'mbw' )
            ),
        ),
    );

	$meta_boxes[] = array(
		'title'  => __( 'Dimensions' ),
        'post_types' => array( 'product' ),
		'fields' => array(
			array(
				'id'     => 'dimensions',
				// Group field
				'type'   => 'group',
				// Clone whole group?
				'clone'  => true,
				// Drag and drop clones to reorder them?
				'sort_clone' => true,
				// Sub-fields
				'fields' => array(
					array(
						'name' => __( 'Name', 'mbw' ),
						'id'   => 'd_name',
						'type' => 'text',
					),
					array(
						'name' => __( 'Height', 'mbw' ),
						'id'   => 'd_height',
						'type' => 'text',
					),
                    array(
						'name' => __( 'Width', 'mbw' ),
						'id'   => 'd_width',
						'type' => 'text',
					),
                    array(
						'name' => __( 'Depth', 'mbw' ),
						'id'   => 'd_depth',
						'type' => 'text',
					)
				),
			),
		),
	);

    $meta_boxes[] = array(
		'title'  => __( 'Details' ),
        'post_types' => array( 'product' ),
        'id' => 'details',
		'fields' => array(
			array(
                'name'   => 'Item Numbers',
				'id'     => "details_item_numbers",
				// Group field
				'type'   => 'group',
				// Clone whole group?
				'clone'  => true,
				// Drag and drop clones to reorder them?
				'sort_clone' => true,
				// Sub-fields
				'fields' => array(
					array(
						'name' => __( 'Product', 'mbw' ),
						'id'   => "details_product_name",
						'type' => 'text',
					),
					array(
						'name' => __( 'Item Number', 'mbw' ),
						'id'   => "details_product_number",
						'type' => 'text',
					)
				),
			),
            array(
                'name'   => 'Includes',
				'id'     => "details_includes",
				// Group field
				'type'   => 'text',
				// Clone whole group?
				'clone'  => false,
                'desc'  => esc_html__( 'What is included?', 'mbw' )
            ),
			 array(
                'name'   => 'Manufacturer-sku',
				'id'     => "details_manufacturer_sku",
				// Group field
				'type'   => 'text',
				// Clone whole group?
				'clone'  => false,
                'desc'  => esc_html__( 'Add Manufacturer Sku', 'mbw' )
            ),
            array(
                'name'   => 'Manufacturer',
				'id'     => "details_manufacturer",
				// Group field
				'type'   => 'text',
				// Clone whole group?
				'clone'  => false,
                'desc'  => esc_html__( 'Who makes it?', 'mbw' )
            ),
            array(
                'name' => esc_html__( 'Non-locking', 'mbw' ),
				'id'   => "details_non-locking",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
            ),
            array(
                'name' => esc_html__( 'Locking', 'mbw' ),
				'id'   => "details_locking",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 0,
            ),
            array(
                'name'   => 'Replacement Parts',
				'id'     => "details_parts",
				// Group field
				'type'   => 'text',
				// Clone whole group?
				'clone'  => false,
                'desc'  => esc_html__( 'URL to parts page.', 'mbw' )
            ),
            array(
				'name' => esc_html__( 'Not Stocked', 'mbw' ),
				'id'   => "mbw_product-not-stocked",
                'type' => 'checkbox',
                // Value can be 0 or 1
                'std'  => 0,
			),
		),
	);

    $meta_boxes[] = array(
		'title'  => __( 'Badges' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-badges',
		'fields' => array(
            array(
				'name'             => esc_html__( 'Badges', 'mbw' ),
				'id'               => "mbw_product-badges-adv",
				'type'             => 'image_advanced',
				// Delete image from Media Library when remove it from post meta?
				// Note: it might affect other posts if you use same image for multiple posts
				'force_delete'     => false
			)
		),
	);

    $meta_boxes[] = array(
		'title'  => __( 'Specs' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-specs',
		'fields' => array(
            array(
				'name'             => esc_html__( 'Specs', 'mbw' ),
				'id'               => "mbw_product-specs-adv",
				'type'             => 'image_advanced',
				// Delete image from Media Library when remove it from post meta?
				// Note: it might affect other posts if you use same image for multiple posts
				'force_delete'     => false
			)
		),
	);

    $meta_boxes[] = array(
		'title'  => __( 'Documents' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-docs',
		'fields' => array(
            array(
				'name'             => esc_html__( 'Documents', 'mbw' ),
				'id'               => "mbw_product_docs_file",
				'type'             => 'file_advanced',
			),
		),
	);

    $meta_boxes[] = array(
		'title'  => __( 'Videos' ),
        'post_types' => array( 'product' ),
        'id' => 'mbw-product-documents',
		'fields' => array(
            array(
				'name' => esc_html__( 'Videos', 'mbw' ),
				'id'   => "mbw_product_vids",
				'desc' => esc_html__( 'Video Embed URL', 'mbw' ),
				'type' => 'oembed',
                'clone' => true,
			),
		),
	);

	return $meta_boxes;
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/
function mbw_get_spinal_case ($string) {
    return preg_replace("/[\s_]/", "-",
        preg_replace("/[\s-]+/", " ",
            preg_replace("/[^a-z0-9_\s-]/", "", strtolower($string))
        )
    );
};

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

function mailboxworks_category_list ( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'title' => '',
        'slug' => '#',
    ), $atts );

    return '<section class=row>'
             . '<div class="col-lg-12 section-heading">'
                 . '<div class="section-heading-container">'
                     . '<div class="section-heading-accent-box">'
                         . '<h2>' . $a['title'] . '</h2>'
                     . '</div>'
                     . '<div class="section-view-all--home">'
                        . '<a href="/type/' . $a['slug'] . '" title="View all ' . $a['title'] . '">view all <i class="fa fa-angle-double-right"></i></a>'
                     . '</div>'
                 . '</div>'
             . '</div>'
             . '<div>'
                 . '<div data-widget="carousel" data-opts=\'{"breakpoints": {"lg": null, "md": null, "sm": null, "xs": 3, "xxs": 1}, "centerPadding": "45px"}\'>'
                    . do_shortcode($content)
                 . '</div>'
             . '</div>'
         . '</section>';
};

function mailboxworks_category ( $atts, $content = null ) {

    if ( !array_key_exists( "cat_id", $atts ) ) return '';

    $term = get_term_by( 'id', intval($atts['cat_id']), 'product_cat' );

    if ( isset( $term ) && !empty( $term ) ) {
        $url = mbw_get_category_url( $term );

        $wc_thumb = wp_get_attachment_image_src( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ), 'shop_catalog' );
        $wc_slug = $term->slug;
        if ( !empty( $wc_thumb ) ) {
            $thumb = '<a href="/type' . $url . '"><img src="' . $wc_thumb[0] . '" alt="' . $term->name . '" /></a>';
        } else {
            $thumb = '<a href="/type' . $url . '"></a>';
        }

        $card = '<div class="col-md-3 col-sm-3 col-xs-12 col--home" data-carousel="card">' .
                    '<div class="category-card category-card--home">' .
                        $thumb .
                        '<h2><a href="/type' . $url . '" title="' . $content . '">' . $content . '</a></h2>' .
                    '</div>' .
                '</div>';

        return $card;
    };

};

function mbw_get_category_url ( $term ) {
    $url = '/';
    $parents = array_reverse( get_ancestors( $term->term_id, 'product_cat' ) );

    foreach ( $parents as $parent ) {
        $p = get_term_by( 'id', $parent, 'product_cat' );
        $url = $url . $p->slug . '/';
    }

    $url = $url . $term->slug . '/';

    return $url;
}

function mailboxworks_moreinfo ( $atts, $content = null) {
    $a = shortcode_atts( array(
        'active' => 0
    ), $atts );

    return do_shortcode($content);
};

function mailboxworks_moreinfo_panel ( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'title' => uniqid()
    ), $atts );

    $id = mbw_get_spinal_case($a['title']);

    return '<section id="' . $id . '" data-title="' . $a['title'] . '"><h2>' . $a['title'] . '</h2>' . $content . '</section>';
};
function zoho_form() { 

$zoho = "<div id='zohoSupportWebToCase' align='center'>";
$zoho .= '<div class="form-cnt">';
    
    $zoho .= "  <form name='zsWebToCase_17986000033653025' id='zsWebToCase_17986000033653025' action='https://desk.zoho.com/support/WebToCase' method='POST' onSubmit='return zsValidateMandatoryFields()' enctype='multipart/form-data'>";
       $zoho .= "  <input type='hidden' name='xnQsjsdp' value='VWJOA8NJmaI$' />  ";
        $zoho .= " <input type='hidden' name='xmIwtLD' value='zNrbEPPDxgC-8SxqWje61gc02FKxDWrG' /> ";
        $zoho .= "<input type='hidden' name='xJdfEaS' value='' />";
        $zoho .= "  <input type='hidden' name='actionType' value='Q2FzZXM=' />         <input type='hidden' id='property(module)' value='Cases' />";
        $zoho .= ' <input type="hidden" id="dependent_field_values_Cases" value="&#x7b;&quot;JSON_VALUES&quot;&#x3a;&#x7b;&quot;Category&quot;&#x3a;&#x7b;&quot;Sub&#x20;Category&quot;&#x3a;&#x7b;&quot;Customer&#x20;Relations&quot;&#x3a;&#x5b;&quot;General&#x20;Call&#x20;Back&quot;,&quot;Category-B&#x20;-&#x20;customer&#x20;choice&quot;,&quot;Category-A&#x20;-&#x20;non-customer&#x20;choice&quot;,&quot;-&quot;&#x5d;,&quot;Customer&#x20;Care&quot;&#x3a;&#x5b;&quot;Resend&#x20;Tracking&quot;,&quot;Quote&#x20;Resend&quot;,&quot;Order&#x20;Status&#x20;-&#x20;Pre-ETA&quot;,&quot;Order&#x20;Status&#x20;-&#x20;Post&#x20;ETA&quot;,&quot;Lien&#x20;Waver&#x20;Request&quot;,&quot;Invoice&#x20;Needed&quot;,&quot;Invoice&#x20;for&#x20;Payment&quot;,&quot;General&#x20;Product&#x20;Info&quot;,&quot;-&quot;&#x5d;,&quot;Billing&#x20;Dept&quot;&#x3a;&#x5b;&quot;-&quot;&#x5d;,&quot;Direct&#x20;Message&#x20;-&#x20;to&#x20;individual&quot;&#x3a;&#x5b;&quot;-&quot;&#x5d;,&quot;-&quot;&#x3a;&#x5b;&quot;-&quot;&#x5d;,&quot;Order&#x20;Processing&#x20;Dept&quot;&#x3a;&#x5b;&quot;-&quot;&#x5d;&#x7d;&#x7d;&#x7d;,&quot;JSON_SELECT_VALUES&quot;&#x3a;&#x7b;&quot;Status&quot;&#x3a;&#x5b;&quot;Pending&#x20;Review&quot;,&quot;Pending&#x20;Follow-up&quot;,&quot;Open&#x20;-&#x20;Locked&quot;,&quot;Open&quot;,&quot;On&#x20;Hold&#x20;-&#x20;Pending&#x20;Refund&quot;,&quot;On&#x20;Hold&#x20;-&#x20;Pending&#x20;Customer&#x20;Reply&quot;,&quot;In&#x20;Progress&quot;,&quot;Closed&quot;&#x5d;,&quot;Category&quot;&#x3a;&#x5b;&quot;-&quot;,&quot;Customer&#x20;Care&quot;,&quot;Customer&#x20;Relations&quot;,&quot;Order&#x20;Processing&#x20;Dept&quot;,&quot;Order&#x20;Tracking&quot;,&quot;Billing&#x20;Dept&quot;,&quot;Direct&#x20;Message&#x20;-&#x20;to&#x20;individual&quot;,&quot;VP&#x20;-&#x20;Mailbox&#x20;Support&quot;,&quot;VP&#x20;-&#x20;Lighting&#x20;Support&quot;,&quot;VP&#x20;-&#x20;Returns&#x20;Department&quot;,&quot;VP&#x20;-&#x20;Suppliers&quot;&#x5d;,&quot;Priority&quot;&#x3a;&#x5b;&quot;-None-&quot;,&quot;High&quot;,&quot;Medium&quot;,&quot;Low&quot;&#x5d;,&quot;Classification&quot;&#x3a;&#x5b;&quot;-None-&quot;,&quot;Question&quot;,&quot;Problem&quot;,&quot;Feature&quot;,&quot;Others&quot;&#x5d;,&quot;Mode&quot;&#x3a;&#x5b;&quot;Twitter&quot;,&quot;Phone&quot;,&quot;Email&quot;,&quot;Facebook&quot;,&quot;Web&quot;,&quot;Chat&quot;,&quot;Forums&quot;,&quot;Feedback&#x20;Widget&quot;&#x5d;,&quot;CASECF9&quot;&#x3a;&#x5b;&quot;-None-&quot;,&quot;BudgetMailboxes.com&quot;,&quot;BestPriceintheUniverse.com&quot;,&quot;LowPriceClusterMailboxes.com&quot;,&quot;BudgetLockers.com&quot;,&quot;Gotitwholesale.com&quot;,&quot;USVetProducts.com&quot;,&quot;MailboxWorks.com&quot;,&quot;-&quot;&#x5d;,&quot;Sub&#x20;Category&quot;&#x3a;&#x5b;&quot;Vendor&#x20;Correspondence&quot;,&quot;Resend&#x20;Tracking&quot;,&quot;Quote&#x20;Resend&quot;,&quot;Quote&#x20;-&#x20;Request&quot;,&quot;Quote&#x20;-&#x20;Prep&quot;,&quot;Quote&#x20;-&#x20;Follow-up&quot;,&quot;Pending&#x20;-&#x20;Refund&quot;,&quot;Order&#x20;Status&#x20;-&#x20;Pre-ETA&quot;,&quot;Order&#x20;Status&#x20;-&#x20;Post&#x20;ETA&quot;,&quot;Order&#x20;-&#x20;Question&#x20;Pre&#x20;Order&quot;,&quot;Order&#x20;-&#x20;Question&#x20;Post&#x20;Order&quot;,&quot;Order&#x20;-&#x20;Place&#x20;an&#x20;Order&quot;,&quot;Lien&#x20;Waver&#x20;Request&quot;,&quot;Invoice&#x20;Needed&quot;,&quot;Invoice&#x20;for&#x20;Payment&quot;,&quot;General&#x20;Product&#x20;Info&quot;,&quot;General&#x20;Call&#x20;Back&quot;,&quot;Check&#x20;Received&quot;,&quot;Category-B&#x20;-&#x20;customer&#x20;choice&quot;,&quot;Category-A&#x20;-&#x20;non-customer&#x20;choice&quot;,&quot;-&quot;&#x5d;,&quot;CASECF7&quot;&#x3a;&#x5b;&quot;-None-&quot;,&quot;Customer&#x20;Service&quot;,&quot;Sales&#x20;and&#x20;Marketing&quot;,&quot;Human&#x20;Resources&quot;,&quot;Product&#x20;Management&quot;,&quot;Category&#x20;Management&quot;&#x5d;,&quot;CASECF5&quot;&#x3a;&#x5b;&quot;-None-&quot;,&quot;I&#x20;want&#x20;to&#x20;exchange&#x20;for&#x20;a&#x20;different&#x20;item&quot;,&quot;Return&#x20;only,&#x20;I&#x20;do&#x20;not&#x20;need&#x20;to&#x20;exchange&quot;&#x5d;&#x7d;,&quot;JSON_MAP_DEP_LABELS&quot;&#x3a;&#x5b;&quot;Category&quot;&#x5d;&#x7d;" />';
       $zoho .= "<input type='hidden' name='returnURL' value='https://www.mailboxworks.com/faq/' />";
	  $zoho .= "<div class='field-row'><h3>Contact Our Customer Support</h3></div>";
       $zoho .= "<div class='field-row'><label>First Name<i>*</i></label><input type='text' maxlength='120' name='First Name' value='' class='manfieldbdr' /></div>";
       $zoho .= "<div class='field-row'><label>Last Name <i>*</i></label><input type='text' maxlength='120' name='Contact Name' class='manfieldbdr' /></div>";
       $zoho .= "<div class='field-row'><label>Email <i>*</i></label><input type='text' maxlength='120' name='Email' value='' class='manfieldbdr' /></div>";
	     $zoho .= "<div class='field-row'><label>Phone </label><input type='text' maxlength='120' name='Phone' value='' /></div>";
       $zoho .= "<div class='field-row'><label>Subject <i>*</i></label><input type='text' maxlength='255' name='Subject' value='' class='manfieldbdr' /></div>";
       $zoho .= "<div class='field-row'><label>Issue details <i>*</i></label><textarea name='Description' maxlength='3000' width='250' height='250' class='manfieldbdr'></textarea></div>";
 $zoho .= "<div class='field-row field-row2'><label>Your Order Number<br>(if applicable)  </label><input type='text' maxlength='120' name='Your Order Number?' value='' /> </div>";    
       $zoho .= "<div class='field-row'><label>Captcha <i>*</i></label>  <div class='captcha-row'><img src='#' id='zsCaptchaUrl' name='zsCaptchaImage'><a href='javascript:;' style='color:#00a3fe; cursor:pointer; margin-left:10px; vertical-align:middle;text-decoration: none;' class='zsFontClass' onclick='zsRegenerateCaptcha()'>Refresh</a></div>
                    <div class='captcha-input'><input type='text' name='zsWebFormCaptchaWord' /><input type='hidden' name='zsCaptchaSrc' value='' /></div></div>";
	 
	  $zoho .= "<div class='field-row sub-buttons'><input type='submit' id='zsSubmitButton_17986000033653025' class='zsFontClass' value='Submit'> &nbsp; &nbsp; </div>";
    $zoho .= "</form></div></div>";
return $zoho;
}

add_shortcode( 'zoho-form', 'zoho_form' );
?>
