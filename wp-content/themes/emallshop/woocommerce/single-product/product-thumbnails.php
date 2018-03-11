<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$page_layout = get_post_meta ( get_the_ID(), '_emallshop_product_layout', true ); //EmallShop 2.0
if(isset($page_layout) && $page_layout!="")
	$page_layout=$page_layout;
else
	$page_layout=emallshop_get_option('single-product-page-layout','none-left');

$attachment_ids = $product->get_gallery_image_ids();
if ( $attachment_ids && has_post_thumbnail() ) {?>
	<div class="product-thumbnails emallshop-slick-carousel" data-slick='{"slidesToShow": <?php echo ( $page_layout == 'none-left' || $page_layout == 'none-right') ? "5": "4"; ?>,"slidesToScroll": 1,"asNavFor": "#product-image","arrows": true, "focusOnSelect": true, <?php if ( $page_layout == 'none-left' || $page_layout == 'none-right' ) echo '"vertical": true,'; ?> <?php if ( ( $page_layout != 'none-left' && $page_layout != 'none-right' ) && is_rtl()) echo '"rtl": true,'; ?> "responsive":[{"breakpoint": 639,"settings":{"slidesToShow": 4, "vertical":false <?php if ( is_rtl()) echo ',"rtl": true'; ?>}}]}'>
	<?php 
		$image = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ), array('title'	=> get_the_title( get_post_thumbnail_id() ) ) ); // Emallshop 2.0
		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div>%s</div>', $image ), $post->ID ); // Emallshop 2.0
		
		foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$attributes      = array(
			'title'                   => get_post_field( 'post_title', $attachment_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, $attributes );
 		$html .= '</div>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}?>
	</div>
	<?php 
}
