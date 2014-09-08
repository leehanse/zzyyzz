<?php
    add_shortcode('featured_not_recipe', 'sc_featured_not_recipe');
    function sc_featured_not_recipe($atts){       
        $show_title = isset($atts['show_title']) ? $atts['show_title'] : 1;
        $query = new WP_Query();
        $args  = array(
                    'post_type'   => array("article"),
                    'post_status' => 'publish',
                    'paged'       => 1,
                    'posts_per_page' => 999999999            
                );
        $query -> query( $args);    
        ?>
        <?php if( $query->have_posts() ): ?>
        <section class="widget">
            <?php if($show_title) : ?><h1>Featured Article</h1> <?php endif;?>            
            <section id="SwiperSlice-02" class="sliderThumb">
                <a class="arrow-left" href="#"></a> 
                <a class="arrow-right" href="#"></a>
                    <div class="swiper-container thumbs-container">
                        <div class="swiper-wrapper">
                            <?php while( $query->have_posts() ) : $query->the_post(); ?>
                                <?php if(get_field('featured',get_the_ID())): ?>
                                    <div class="swiper-slide">
                                        <a href="<?php the_permalink();?>"> 
                                            <?php custom_post_thumbnail(null,133,9999);?>
                                        </a>
                                        <a href="<?php the_permalink();?>"><h4><?php the_title();?></h4></a>
                                        <p>
                                            <?php 
                                                $excerpt = strip_tags(get_the_excerpt());
                                                echo wp_trim_words($excerpt,10);
                                            ?>
                                        </p>
                                    </div>
                                <?php endif;?>
                            <?php endwhile;?>
                        </div>
                    </div>
            </section>
        </section> 
        <?php endif;?>
<?php }?>