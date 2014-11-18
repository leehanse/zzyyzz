<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

//if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
	
	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>    
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                i=4;
                jQuery('form.cart .simple-addon-field .product-addon:last').hide();
                while(jQuery('form.cart .cart-list-field li:visible').slice(i).size()){
                    jQuery('form.cart .cart-list-field li:visible').slice(i).first().css('clear','left');
                    i+=4;
                }                
            })
        </script>
	<form class="cart" method="post" enctype='multipart/form-data'>
		<ul class="cart-list-field simple-addon-field">
                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
                    <li class="qty-field">
                        <?php
                            if ( ! $product->is_sold_individually() ){
                                woocommerce_quantity_input( array(
                                    'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                                    'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
                                ));
                            }
                        ?>                        
                    </li>
                    <li class="upload">
                        <?php echo do_shortcode('[wp-multi-file-uploader]'); ?>
                    </li>
	 	</ul>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

	 	<!--<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>-->

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>