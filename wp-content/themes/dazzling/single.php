<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dazzling
 */

get_header(); ?>
<div id="content" class="site-content container">
    <?php get_sidebar(); ?>
    <div id="primary" class="content-area col-sm-12 col-md-9 <?php echo of_get_option( 'site_layout', 'no entry' ); ?>">
            <main id="main" class="site-main" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'single' ); ?>

                    <?php dazzling_post_nav(); ?>

                    <?php
                            // If comments are open or we have at least one comment, load up the comment template
                            if ( comments_open() || '0' != get_comments_number() ) :
                                    comments_template();
                            endif;
                    ?>

            <?php endwhile; // end of the loop. ?>

            </main><!-- #main -->
    </div><!-- #primary -->
</div>
<?php get_footer(); ?>