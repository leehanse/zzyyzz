<?php
/**
 * Template Name: CMS Template
 */
?>

<?php get_header(); ?>
<div id="main_content" class="main_content ">
    <?php get_sidebar();?>
    <div class="main_small">                            
        <div class="item-page">            
            <?php while ( have_posts() ) : the_post(); ?>
                    <h1><?php the_title();?></h1>
                    <?php get_template_part( 'content', 'page' ); ?>
                    <?php comments_template( '', true ); ?>
            <?php endwhile; // end of the loop. ?>            
        </div>
    </div>
    <br style="clear:both;">
</div>
<?php get_footer();?>