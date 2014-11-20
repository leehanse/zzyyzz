<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );
?>

<?php if ( $heading ): ?>
  <h2><?php echo $heading; ?></h2>
<?php endif; ?>
<div class="images-wrapper col-md-4 pull-right">
    <?php woocommerce_show_product_images(); ?>
</div>
<?php the_content(); ?>
