<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<!-- default "variations" woocommerce auto filter with select attribute -->
		<ul class="cart-list-field variations-list">
			<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
				<?php
					if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
						$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
					} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
						$selected_value = $selected_attributes[ sanitize_title( $name ) ];
					} else {
						$selected_value = '';
					}
				?>				
				<li class="attribute_field <?php if($options == end($attributes)) echo 'last_attribute_field';?>">
					<label class="field-title" for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label>
						<select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>">
						<!--<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>-->
						<?php
							if ( is_array( $options ) ) {
								// Get terms if this is a taxonomy - ordered
								if ( taxonomy_exists( sanitize_title( $name ) ) ) {

									$orderby = wc_attribute_orderby( sanitize_title( $name ) );

									switch ( $orderby ) {
										case 'name' :
											$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
										break;
										case 'id' :
											$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
										break;
										case 'menu_order' :
											$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
										break;
									}

									$terms = get_terms( sanitize_title( $name ), $args );

									foreach ( $terms as $term ) {
										//if ( ! in_array( $term->slug, $options ) ) continue;
										echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
									}
								} else {
									foreach ( $options as $option ) {
										echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
									}

								}
							}
						?>
					</select>					
				</li>
			<?php endforeach;?>
			<!-- Product Addons fields -->
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
			<!-- End Product Addons fields -->
			<li class="qty-field">
				<?php woocommerce_quantity_input(); ?>
			</li>	
                        <li class="upload">
                            <?php echo do_shortcode('[wp-multi-file-uploader]'); ?>
                        </li>
		</ul>
                <input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
                <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
                <input type="hidden"   name="variation_id" value=""/>
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php else : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>