<?php get_header(); ?> 
    <div class="content clearfix">
        <div class="panelLeft">
            <?php while ( have_posts() ) : the_post(); ?>                                  
                <section>
                    <div class="details">
                        <h1><?php the_title();?></h1>
                        <?php the_content();?>
                    </div>
                </section>
                <div class="clearfix"></div>
            <?php endwhile;?>  
            <?php wp_reset_query(); ?>               
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>        
    </div>
<?php get_footer();?>