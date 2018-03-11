<?php global $product; ?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	
	<div class="product-image">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo $product->get_image(); ?>
		</a>
	</div>
	<div class="product-details">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<span class="product-title"><?php echo $product->get_name(); ?></span>
		</a>
		<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
		<span class="product-price">
		<?php echo $product->get_price_html(); ?>
		</span>
	</div>
	
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
	
</li>