<?php
/**
 * Template Name: Shop Page
 *
 * Description: Shop list all product
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<div id="content" class="site-content container">
    <?php do_action( 'woocommerce_sidebar' ); ?>
    <div id="primary" class="content-area col-sm-12 col-md-9 <?php echo of_get_option( 'site_layout', 'no entry' ); ?>">
        <header class="entry-header page-header">
            <h1 class="entry-title page-title"><?php the_title(); ?></h1>
        </header>
        <ul class="products">
            <?php
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => -1
                );
                $loop = new WP_Query( $args );
                if ( $loop->have_posts() ) {
                    while ( $loop->have_posts() ) : $loop->the_post();
                        woocommerce_get_template_part( 'content', 'product' );
                    endwhile;
                } else {
                    echo __( 'No products found' );
                }
                wp_reset_postdata();
            ?>
        </ul><!--/.products-->
    </div>            
</div>    
<?php get_footer( 'shop' ); ?>