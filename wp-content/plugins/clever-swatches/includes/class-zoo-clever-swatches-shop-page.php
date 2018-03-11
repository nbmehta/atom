<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * class for managing gallery images per variation.
 *
 * @class    Zoo_Clever_Swatch_Admin_Variation_Gallery
 *
 * @version  2.0.0
 * @package  clever-swatches/includes
 * @category Class
 * @author   cleversoft.co <hello.cleversoft@gmail.com>
 * @since    1.0.0
 */

if (!class_exists('Zoo_Clever_Swatch_Shop_Page')) {

    class Zoo_Clever_Swatch_Shop_Page
    {

        public function __construct()
        {
            $this->hook_action();
        }

        public function hook_action()
        {
            $general_settings = get_option('zoo-cw-settings', true);

            if ($general_settings['display_shop_page'] == 1) {
                if ($general_settings['display_shop_page_hook'] == 'before') {
                    add_action('woocommerce_before_shop_loop_item_title', array($this, 'zoo_cw_shop_page_add_swatch'), 15, 3);
                } else if ($general_settings['display_shop_page_hook'] == 'after') {
                    add_action('woocommerce_after_shop_loop_item_title', array($this, 'zoo_cw_shop_page_add_swatch'), 15, 3);
                } else if ($general_settings['display_shop_page_hook'] == 'shortcode') {
                    add_shortcode('zoo_cw_shop_swatch', array($this, 'zoo_cw_shop_page_add_swatch'));
                }
                add_action( 'wp_loaded', array($this, 'zoo_cw_overide_woocommerce_functions') );
            }
        }

        public function zoo_cw_overide_woocommerce_functions() {
            $zoo_cw_helper =  new Zoo_Clever_Swatch_Helper();

            if ($zoo_cw_helper->zoo_cw_check_hook_exits('woocommerce_before_shop_loop_item')&&$zoo_cw_helper->zoo_cw_check_hook_exits('woocommerce_template_loop_product_link_close')) {
                remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
                remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );

                add_action( 'woocommerce_before_shop_loop_item', array($this, 'zoo_cw_template_loop_product_link_open'), 10 );
                add_action( 'woocommerce_after_shop_loop_item', array($this, 'zoo_cw_template_loop_product_link_close'), 5 );
            }
        }

        /**
         * Insert the opening anchor tag for products in the loop.
         */
        public function zoo_cw_template_loop_product_link_open() {
            echo '<div href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
        }
        /**
         * Insert the opening anchor tag for products in the loop.
         */
        public function zoo_cw_template_loop_product_link_close() {
            echo '</div>';
        }

        public function zoo_cw_shop_page_add_swatch()
        {
            $zoo_cw_helper =  new Zoo_Clever_Swatch_Helper();
            $post_id = get_the_ID();
            $product_swatch_data_array = get_post_meta($post_id, 'zoo_cw_product_swatch_data', true);
            //Emallshop Condition
            if ($product_swatch_data_array != '' && $product_swatch_data_array['pa_size']['display_type'] !='default') {
                $product = wc_get_product($post_id);
                if ($product->get_type() == 'variable') {
                    $attributes = $zoo_cw_helper->zoo_cw_get_all_options_data_by_attribute_name($product);
                    $product_swatch_data_array = $this->prepare_single_page_data($product, $attributes, $product_swatch_data_array);

                    $general_settings = get_option('zoo-cw-settings',true);
                    $allow_add_to_cart = $general_settings['display_shop_page_add_to_cart'];
                    require(ZOO_CW_TEMPLATES_PATH . 'shop-page-swatch-image.php');
                    require_once(ZOO_CW_TEMPLATES_PATH . 'add-to-cart-button.php');
                }
            }
        }

        public function prepare_single_page_data($product, $attributes, $product_swatch_data_array)
        {
            $temp_attribute = [];

            foreach ($attributes as $attribute_name => $value) {
                $temp_attribute[sanitize_title($attribute_name)] = $value;
            }

            $attributes = $temp_attribute;

            $general_settings = get_option('zoo-cw-settings', true);
            if ($product_swatch_data_array != '') {
                foreach ($product_swatch_data_array as $attribute_slug => $data) {
                    if (isset($attributes[$attribute_slug])) {
                        $attribute_enabled_options = $attributes[$attribute_slug];
                        $terms = wc_get_product_terms($product->get_id(), $attribute_slug, array('fields' => 'all'));
                        $options_data = $data['options_data'];

                        if (taxonomy_exists($attribute_slug)) {
                            foreach ($terms as $term) {
                                if (in_array($term->slug, $attribute_enabled_options)) {
                                    $options_data[$term->slug]['name'] = $term->name;
                                    $options_data[$term->slug]['value'] = $term->slug;
                                } else {
                                    unset($options_data[$term->slug]);
                                }
                            }
                        } else {
                            foreach ($options_data as $key => $value) {
                                $options_data[$key]['name'] = $key;
                                $options_data[$key]['value'] = $key;
                            }
                        }


                        $product_swatch_data_array[$attribute_slug]['options_data'] = $options_data;

                        //render class
                        $class_attribute = '';
                        if ($data['display_type'] != 'default') {
                            $class_attribute .= ' zoo-cw-active zoo-cw-type-' . $data['display_type'];
                        }
                        $product_swatch_data_array[$attribute_slug]['class_attribute'] = $class_attribute;

                        $product_swatch_display_size = isset($data['product_swatch_display_size']) ? $data['product_swatch_display_size'] : 'default';
                        if ($product_swatch_display_size == 'default') {
                            $product_swatch_display_size = $general_settings['shop_swatch_display_size'];
                        }
                        if ($product_swatch_display_size == 'custom') {
                            $custom_style = 'style="min-width: ' . $general_settings['shop_swatch_display_size_width'] . 'px;height: ' . $general_settings['shop_swatch_display_size_height'] . 'px;"';
                            $product_swatch_data_array[$attribute_slug]['custom_style'] = $custom_style;
                        }
                        $product_swatch_display_shape = isset($data['product_swatch_display_shape']) ? $data['product_swatch_display_shape'] : 'default';
                        if ($product_swatch_display_shape == 'default') {
                            $product_swatch_display_shape = $general_settings['shop_swatch_display_shape'];
                            $product_swatch_data_array[$attribute_slug]['product_swatch_display_shape'] = $product_swatch_display_shape;
                        }

                        $class_options = 'zoo-cw-option-display-size-' . $product_swatch_display_size;
                        $class_options .= ' zoo-cw-option-display-shape-' . $product_swatch_display_shape;
                        $product_swatch_data_array[$attribute_slug]['class_options'] = $class_options;
                    }
                }
            }
            return $product_swatch_data_array;
        }
    }
}

$zoo_clever_swatch_shop_page = new Zoo_Clever_Swatch_Shop_Page();
