<?php
/**
 * Template Name: Home Template
 */
?>
<?php     
?>
<?php get_header(); ?> 
    <div class="content clearfix">
        <script type="text/javascript">
            $(document).ready(function(){
               $("#menu-header-menu li:eq(0) > a").addClass('active');
            });
        </script>
        <input type="hidden" id="PAGE" value="Subscribe"/>
    	<div class="panelLeft">
    <?php if(get_field('repeating_banners')):?>
            <section class="widget">
                <div id='mySwipe' class='swipe'>
                    <div class='swipe-wrap'>
                        <?php while(has_sub_field('repeating_banners')): ?>
                            <?php 
                                $alt_text  = get_sub_field("alt_text");
                                $page_link = get_sub_field("link");
                                
                                $url       = get_sub_field("url");
                                $final_link = "";
                                
                                if($page_link) $final_link = $page_link;
                                elseif($url) $final_link = $url;
                                
                                if($final_link){
                                    $html_link = 'onclick="window.location=\''.$final_link.'\'"';
                                }else $html_link = '';
                            ?>                            
                            <div <?php echo $html_link;?> style="background:url(<?php echo get_sub_field("image");?>) 50% no-repeat; background-size:cover;"></div>                        
                        <?php endwhile;?>
                    </div>
                    <div class="control">                                                
                        <div onclick='mySwipe.prev()' class="controlPrev">prev</div>
                        <ul id="position">
                          <?php $index_banner = 0; while(has_sub_field('repeating_banners')): $index_banner++;?>
                            <li <?php if($index_banner == 1) echo 'class="on"';?>><?php echo $index_banner;?></li>
                          <?php endwhile;?>  
                        </ul>
                        <div onclick='mySwipe.next()' class="controlNext">next</div>
                    </div>
                </div>
            </section>       
   <?php endif;?>
            
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
            
    <?php //echo do_shortcode('[featured_not_recipe]');?>         
        <?php
            $feed_posts = array();
            
            $blog_posts =  get_posts(array(
                "post_type" => "post",
                "posts_per_page" => 10,                
            ));
            $recipe_posts =  get_posts(array(
                "post_type" => "recipe",
                "posts_per_page" => 10,                
            ));
            $article_posts =  get_posts(array(
                "post_type" => "article",
                "posts_per_page" => 10,                
            ));
            $d1 = 0; $d2 = 0; $d3 = 0; $count = 0;
            while($d1 < count($blog_posts) || $d2 < count($recipe_posts) || $d3 < count($article_posts)){
                if($d1 < count($blog_posts)){
                    $time1 = $blog_posts[$d1]->post_date;
                    $obj1  = $blog_posts[$d1];
                }else{
                    $time1 = '0000-00-00 00:00:00';
                    $obj1  = null;
                }
                
                if($d2 < count($recipe_posts)){
                    $time2 = $recipe_posts[$d2]->post_date;
                    $obj2  = $recipe_posts[$d2];
                }else{
                    $time2 = '0000-00-00 00:00:00';
                    $obj2  = null;
                }
                
                if($d3 < count($article_posts)){
                    $time3 = $article_posts[$d3]->post_date;
                    $obj3  = $article_posts[$d3];
                }else{
                    $time3 = '0000-00-00 00:00:00';
                    $obj3  = null;
                }
                // get max time1 , time2, time3
                $max_time    = '0000-00-00 00:00:00';
                $handle_post = null;
                if($time1 > $time2 && $time1 > $time3 ){
                    $max_time = $time1;
                    $handle_post = $obj1;
                    $d1++;
                }elseif($time2 > $time1 && $time2 > $time3 ){
                    $max_time = $time2;
                    $handle_post = $obj2;
                    $d2++;
                }else{
                    $max_time = $time3;
                    $handle_post = $obj3;
                    $d3++;
                }                                             
                if($handle_post){
                    $feed_posts[] = $handle_post;                    
                    $count++;                    
                    if($count >= 7) break;
                }else{
                    break;
                }
            }
        ?>
        <?php if ( count($feed_posts) ) : ?>
            <div class="blockList">
                <?php foreach($feed_posts as $post): setup_postdata($post); $post_type = $post->post_type; ?>
                <section class="clearfix">
                    <div class="thumb">
                        <?php custom_post_thubnail_no_caption(null,220,9999);?>
                    </div>
                    <div class="description">
                        <h3><?php the_title();?></h3>
                        <div class="lineItemGroup">
                            <?php
                                if($post_type == 'recipe'){
                                    $recipe_categories = wp_get_post_terms(get_the_ID(),'recipe-category');
                                    if($recipe_categories){
                                        echo '<strong><a href="'.get_term_link($recipe_categories[0]).'">'.$recipe_categories[0]->name.'</a></strong> | ';
                                    }
                                }elseif($post_type == 'post'){                                    
                                    echo '<strong><a href="'.  get_permalink(get_page_by_title('blog')->ID).'">BLOG</a></strong> | ';
                                }elseif($post_type == 'article'){    
                                    $article_categories = wp_get_post_terms(get_the_ID(),'article-category');
                                    if($article_categories){
                                        echo '<strong><a href="'.get_term_link($article_categories[0]).'">'.$article_categories[0]->name.'</a></strong> | ';
                                    }else{
                                        echo '<strong><a href="'.  get_permalink(get_page_by_title('Articles')->ID).'">ARTICLE</a></strong> | ';
                                    }
                                }
                                //print_r($recipe_categories);
                            ?>
                            <nobr><?php echo the_time('F d, Y'); ?></nobr>
                        </div>
                        <?php the_excerpt();?>
                        <a href="<?php the_permalink();?>">Read More &raquo;</a>
                    </div>
                </section>
                <?php endforeach;?>                  
            </div>
        <?php endif;?>
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>
