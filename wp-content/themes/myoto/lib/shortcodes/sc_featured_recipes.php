<?php
    add_shortcode('featured_recipes', 'sc_featured_recipes');
    function sc_featured_recipes($atts){	
        $arr_widget  = array('','By Spirit','Classic Recipes','Contemporary Recipes','Seasonal Recipes');        
        $title       = isset($atts['title']) ? $atts['title'] : "";
        $widget      = isset($atts['widget']) ? $atts['widget'] : "";
        $recipe_cat  = isset($atts['recipe_cat']) ? $atts['recipe_cat'] : null;
        $featured    =  isset($atts['featured']) ? $atts['featured'] : null;
        
        $slide_index = rand(1,1000);
        $slide_index = md5($slide_index);
        
        if($widget){
            $txt_widget  = $arr_widget[$widget];
        }else 
            $txt_widget  = '';        
        
        $meta_query = array();
        $tax_query  = array();
        if($widget){
            $meta_query[] = array(
                'key'     => 'recipe_group',
                'value'   => $widget,
                'compare' => 'LIKE'
            );
        }
        if($recipe_cat){
            $tax_query[] = array(
                'taxonomy'  => 'recipe-category',
                'field'     => 'id',
                'terms'     => $recipe_cat
            );
        }
        
        if($featured){
            $meta_query[] = array(
                'key'     => 'featured',
                'value'   => 1,
                'compare' => '='
            );
        }
        
        $query = new WP_Query();
        $args  = array(
                    'post_type'   => array("recipe"),
                    'post_status' => 'publish',
                    'meta_query'  => $meta_query, 
                    'tax_query'   => $tax_query,            
                    'paged'       => 1,
                    'posts_per_page' => 999999999
                );
        $query -> query( $args);        
        ?>
        <?php if( $query->have_posts() ): ?>
        <style>
            .thumbImg{
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                cursor: pointer;
                display: inline-block;
                height: 188px;
                width: 131px;
                border: 1px solid #cccccc;
                background-repeat: no-repeat;
            }
        </style>
        <section class="widget">
            <?php if($title) : ?><h1><?php echo $title;?></h1> <?php endif;?>            
            <?php if($txt_widget) : ?><h1><?php echo $txt_widget;?></h1> <?php endif;?>            
            <section id="SwiperSlice-<?php echo $slide_index;?>" class="sliderThumb">
                <a class="arrow-left" href="#"></a> 
                <a class="arrow-right" href="#"></a>
                    <div class="swiper-container thumbs-container">
                        <div class="swiper-wrapper">
                            <?php while( $query->have_posts() ) : $query->the_post(); ?>
                                    <div class="swiper-slide">
                                        <div onclick="window.location=$(this).attr('data-url');" class="thumbImg" data-url="<?php the_permalink();?>" style="background-image:url(<?php echo custom_post_thumbnail_img(get_the_ID());?>)"></div>
                                        <a href="<?php the_permalink();?>"><h4><?php the_title();?></h4></a>
                                    </div>
                            <?php endwhile;?>
                        </div>
                    </div>
            </section>
        </section> 
        <script type="text/javascript">
            $(document).ready(function(){
                var myswipe_<?php echo $slide_index;?> = new Swiper('#SwiperSlice-<?php echo $slide_index;?> .thumbs-container',{
                        slidesPerView:'auto',
                        offsetPxBefore:0,
                        offsetPxAfter:0,
                        calculateHeight: true
                });
                
                $('#SwiperSlice-<?php echo $slide_index;?> .arrow-left').on('click', function(e){
                        e.preventDefault()
                        myswipe_<?php echo $slide_index;?>.swipePrev()
                })
                $('#SwiperSlice-<?php echo $slide_index;?> .arrow-right').on('click', function(e){
                        e.preventDefault()
                        myswipe_<?php echo $slide_index;?>.swipeNext()
                })
                
            });
        </script>    
        <?php endif;?>
<?php }?>