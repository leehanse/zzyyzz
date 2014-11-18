<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<div class="site-content container" id="content">
    <?php do_action( 'woocommerce_sidebar' ); ?>
    <div id="primary" class="content-area col-sm-12 col-md-9 <?php echo of_get_option( 'site_layout', 'no entry' ); ?>">
        <?php woocommerce_breadcrumb(); ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; // end of the loop. ?>            
    </div>
</div>
<?php get_footer( 'shop' ); ?>