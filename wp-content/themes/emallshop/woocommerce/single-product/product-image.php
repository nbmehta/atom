<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version 3.3.2
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


if(is_rtl())
	$slider_attr = 'data-slick=\'{"slidesToShow": 1, "slidesToScroll": 1, "asNavFor": ".product-thumbnails", "fade":true, "rtl":true}\'';
else
	$slider_attr = 'data-slick=\'{"slidesToShow": 1, "slidesToScroll": 1, "asNavFor": ".product-thumbnails", "fade":true}\'';


//$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	//'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
	$page_layout, //Emallshop
) );

?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
	<figure class="woocommerce-product-gallery__wrapper">
		<div id="product-image" class="emallshop-slick-carousel" <?php echo wp_kses_post( $slider_attr ); ?>>
			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => $full_size_image[0],
				'data-large_image'        => $full_size_image[0],
				'data-large_image_width'  => $full_size_image[1],
				'data-large_image_height' => $full_size_image[2],
			);

			if ( has_post_thumbnail() ) {
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image es-image-zoom"><a class="zoom" href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
				$html .= '</a></div>';
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
			
			$attachment_ids = $product->get_gallery_image_ids(); // Start EmallShop 2.0

			if ( $attachment_ids && has_post_thumbnail() ) {
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

					$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image es-image-zoom"><a class="zoom" href="' . esc_url( $full_size_image[0] ) . '">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</a></div>';

					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
				}
			}//End EmallShop ?>
			
		</div>
		<?php do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>
	<div class="pl-loading"></div>
</div>
