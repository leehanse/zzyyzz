<?php
/**
 * Template Name: Article Hub New Template
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">
    	<div class="panelLeft">
            <?php
                $article_category_id    = get_field('article_category_select');
            ?>                        
            <section>
                <ul class="breadcrumb clearfix">
                    <li><a href="<?php echo get_permalink(get_page_by_title('Articles'));?>">ARTICLES</a></li>
                    <?php if($article_category_id){
                            $h_cat           = $article_category_id;
                            $tax_name        = 'article-category';
                            $arr_links       = array();
                            $arr_link_titles = array();
                            if($h_cat){
                                while($h_cat != 0){                                    
                                    $cat               = get_term($h_cat,$tax_name);
                                    $arr_links[]       = get_term_link($cat,$tax_name);                                    
                                    $arr_link_titles[] = $cat->name;
                                    $h_cat = $cat->parent;
                                }                                
                                $arr_links       = array_reverse($arr_links);
                                $arr_link_titles = array_reverse($arr_link_titles);
                                
                                foreach($arr_links as $key => $item_link){
                                    if($key == count($arr_links)-1){                                        
                                        echo '<li>';                                        
                                        echo '<span>';
                                        echo strtoupper($arr_link_titles[$key]);
                                        echo '</span>';
                                        echo '</li>';
                                    }else{
                                        echo '<li>';
                                        echo '<img src="'.home_url().'/wp-content/themes/imbibe/images/xarrowRed.png.pagespeed.ic.73k6-TKJ-q.png">';
                                        echo '<a href="'.$item_link.'">';
                                        echo strtoupper($arr_link_titles[$key]);
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                }
                            }    
                          }
                        ?>                    
                </ul>
            </section>
            
            <?php 
                $widgets = array();
                if(get_field('widgets')){
                    while(has_sub_field('widgets')){
                        $title   = get_sub_field('title');
                        $objects = get_sub_field('objects');
                        $status  = get_sub_field('status');
                        if($status == 'active' && count($objects) > 0){
                            $widgets[] = array(
                                "title" => $title,
                                "objects" => $objects,
                                "status"  => $status  
                            );
                        }
                    }
                }              
            ?>
                
            <?php if(count($widgets)):?>    
                <?php foreach($widgets as $slide_index => $widget):?>
                    <?php                        
                        $title   = $widget["title"];
                        $objects = $widget["objects"];                        
                    ?>
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
                        <section id="SwiperSlice-<?php echo $slide_index;?>" class="sliderThumb">
                            <a class="arrow-left" href="#"></a> 
                            <a class="arrow-right" href="#"></a>
                                <div class="swiper-container thumbs-container">
                                    <div class="swiper-wrapper">
                                        <?php foreach($objects as $object):?>
                                                <div class="swiper-slide">
                                                    <div onclick="window.location=$(this).attr('data-url');" class="thumbImg" data-url="<?php echo get_permalink($object->ID);?>" style="background-image:url(<?php echo custom_post_thumbnail_img($object->ID);?>)"></div>
                                                    <a href="<?php echo get_permalink($object->ID);?>"><h4><?php echo $object->post_title;?></h4></a>
                                                </div>
                                        <?php endforeach;?>
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
                <?php endforeach;?>
            <?php endif;?>
                    
                    
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $wp_query = new WP_Query();
            $meta_query = array();
            $tax_query  = array();
            
            if($article_category_id){
                $tax_query[] = array(
                    'taxonomy'  => 'article-category',
                    'field'     => 'id',
                    'terms'     => $article_category_id
                );
            }
            $args = array(
                        'post_type'   => 'article',
                        'post_status' => 'publish',
                        'meta_query'  => $meta_query, 
                        'tax_query'   => $tax_query,                
                        'paged'       => $paged,
                        'posts_per_page'   => 8
                    );		
            $wp_query -> query( $args);    
            $base_query_params  = array();              
            ?>
            <style>
                .blockList section .thumb{ height: auto !important; }
            </style>
            <?php if ($wp_query -> have_posts() ) : ?>            
                <div class = "blockList">
                <?php while($wp_query ->have_posts()): $wp_query ->the_post(); ?>
                    <section class="clearfix">
                        <div class="thumb">
                            <a href="<?php the_permalink();?>">
                                <?php custom_post_thubnail_no_caption(null,220,9999);?>
                            </a>
                        </div>
                        <div class="description">
                            <a href="<?php the_permalink();?>">
                                <h3><?php the_title();?></h3>
                            </a>
                            <div class="lineItemGroup">
                                <?php
                                    $recipe_categories = wp_get_post_terms(get_the_ID(),'recipe-category');
                                    if($recipe_categories){
                                        echo '<strong><a href="'.get_term_link($recipe_categories[0]).'">'.$recipe_categories[0]->name.'</a></strong> | ';
                                    }
                                    //print_r($recipe_categories);
                                ?>
                                <nobr><?php echo the_time('F d, Y'); ?></nobr>
                            </div>
                            <?php the_excerpt();?>
                            <a href="<?php the_permalink();?>">Read More &raquo;</a>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                    
                    <!--
                        <section>
                            <div class="details">            
                                <a href="<?php the_permalink();?>">
                                    <h1><?php the_title(); ?>
                                        <span class="date"><?php echo get_field('article_sub_header',  get_the_ID());?></span>
                                    </h1>
                                </a>
                                <?php get_template_part('pages/partial','image_slideshow_no_thumbnail');?>
                                <div class="clearfix"></div>
                            </div>
                        </section>
                    -->
                    <!--
                    <?php 
                        $tags = wp_get_post_tags(get_the_ID());                                
                    ?>
                    <?php if(count($tags)):?>
                    <section class="tags">
                        <aside>                            
                            <?php the_tags(); ?>            
                        </aside>
                    </section>
                    <?php endif;?>
                    -->
                <?php endwhile;?>
                </div>    
            <?php endif;?>

            <script type="text/javascript">
                function modifyThumbnail(){
                    jQuery(".thumb-wrapper").each(function(){
                       width = jQuery(this).find("img").width();
                       if(width > 307)
                           jQuery(this).find(".thumb").addClass("thumbCenter").removeClass("thumb");
                    });
                }
                jQuery(document).ready(function(){
                    interv = window.setInterval("modifyThumbnail();",1000);
                });
            </script>
            
                <?php if($wp_query->found_posts > 0): ?>                    
                    <?php if($wp_query->max_num_pages > 1):?>
                        <section>
                            <ul class="paging">
                                <li class="first"><a href="<?php $base_query_params['paged'] = 1; echo add_query_arg( $base_query_params);?>">&lang;&lang;</a></li>
                                <?php if($paged > 1):?>
                                    <li class="prev"><a href="<?php $base_query_params['paged'] = $paged -1; echo add_query_arg( $base_query_params);?>">&lang;</a></li>
                                <?php endif;?>          
                                <?php
                                    $p_min  = $paged;
                                    $p_max    = $paged;									
                                    $count = 1;									
                                    while(true){
                                        if($p_min -1 >= 1){ $p_min --; $count++;}
                                        if($count >= 5) break;                                        
                                        if($p_max + 1 <= $wp_query->max_num_pages) {$p_max++; $count++;}
                                        if($count >= 5) break;
                                        if($p_min <= 1 && $p_max >= $wp_query->max_num_pages) break;
                                    }
                                ?>
                                <?php for($p = $p_min; $p <= $p_max; $p++):?>
                                    <li class="num <?php if($p == $paged) echo 'active';?>"><a href="<?php $base_query_params['paged'] = $p; echo add_query_arg( $base_query_params);?>"><?php echo $p;?></a></li>
                                <?php endfor;?>

                                <?php if($paged < $wp_query->max_num_pages): ?>
                                    <li class="next"><a href="<?php $base_query_params['paged'] = $paged + 1; echo add_query_arg( $base_query_params);?>">&rang;</a></li>
                                <?php endif;?>
                                <li class="last"><a href="<?php $base_query_params['paged'] = $wp_query->max_num_pages; echo add_query_arg( $base_query_params);?>">&rang;&rang;</a></li>
                            </ul>
                        </section>              
                    <?php endif;?>
                <?php endif;?>
            
        </div>        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>
