<?php
/**
 * Template Name: Promotions
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Events-Promotions"/>
    	<div class="panelLeft">
            <section>
            	<ul class="breadcrumb">
                    <li><a href="<?php echo home_url();?>">Home</a></li>
                    <li><span>Promotions</span></li>
                </ul>
            </section>                        
            <?php
                $paged      = get_query_var('paged');
                if(!$paged) $paged = 1;
                $pageSize   = get_option('posts_per_page');
                $wp_query   = new WP_Query();
                $meta_query = array();
                $meta_query[] = array();
                
                $args = array(
                            'post_type'   => 'promotion',
                            'post_status' => 'publish',
                            'paged'       => $paged,
                            'meta_query'  => $meta_query,
                            'posts_per_page'   => $pageSize,
                            'orderby' => 'date',
                            'meta_key' => 'date',
                            'order' => 'DESC'
                    );
                $wp_query -> query( $args); 
            ?>
            <style>
                .details img{
                    max-height: none !important;
                }
            </style>    
            
            <?php if ( $wp_query->have_posts() ) : ?>            
                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                    <section class="featuredList">
                        <div class="blockDate">
                           <?php 
                                $event_date     = get_field('date',get_the_ID()); 
                                $event_date_end = get_field('date_end',get_the_ID()); 
                                
                                $event_date = new DateTime($event_date);        
                                if($event_date_end){
                                    $event_date_end = new DateTime($event_date_end);                                
                                    if($event_date->format('Y-m') == $event_date_end->format('Y-m')){
                                        $str_time = $event_date->format('F d') . '-' .$event_date_end->format('d,Y');
                                    }else{
                                        $str_time = $event_date->format('F d, Y') . '-' .$event_date_end->format('F d, Y');
                                    }
                                }else{
                                    $str_time = $event_date->format('F d, Y');
                                }
                            ?>                           
                            <div class="bgRed" style="font-size:12px;"><?php echo $str_time;?></div>
                            <div class="address" style="margin-top:-6px;"><?php echo get_field('city',get_the_ID())?>, <?php echo get_field('state',get_the_ID())?></div>
                            
                            <?php 
                                $arr = array();
                                for($i=0; $i<=23;$i++){
                                    if($i<=12){
                                        $arr['' . $i]        = $i . ':00 AM';
                                        $arr['' .($i + 0.5)]  = $i . ':30 AM';
                                    }else{
                                        $arr[''. $i]        = ($i - 12) . ':00 PM';
                                        $arr[''. ($i + 0.5)]  = ($i - 12) . ':30 PM';
                                    }
                                }
                                $time = get_field('time',get_the_ID());                                                            
                            ?>
                            <?php if($time):?>
                            <div class="time"><?php echo $arr[$time];?></div>
                            <?php endif;?>
                        </div>
                        <div class="details">                             
                            <a href="javascript:void(0);">
                                <h1><?php the_title(); ?></h1>
                            </a>                            
                            <?php if(get_field('article_type',get_the_ID())=='slideshow'):?>
                            <section class="widget" style="background:none !important;padding-bottom:0px !important;margin-bottom:0px !important;">
                                <div id='articleSlider<?php echo get_the_ID();?>' class='swipe'>
                                    <div class='swipe-wrap'>                        
                                        <?php while(has_sub_field('article_slideshow',get_the_ID())): ?>
                                        <div>
                                            <div class="imgArticle" style="height:auto !important;"><img src="<?php echo get_sub_field("article_slideshow_image",get_the_ID());?>"></div>
                                            <div class="descriptionArticle">
                                                <?php echo get_sub_field('Content Slideshow',get_the_ID());?>
                                            </div>
                                        </div>    
                                        <?php endwhile;?>
                                    </div>
                                    <div class="control">
                                        <div onclick='promotionSwipe<?php echo get_the_ID();?>.prev()' class="controlPrev">prev</div>
                                        <ul class="position" id="promotionPosition<?php echo get_the_ID();?>">
                                        <?php $index_banner = 0; while(has_sub_field('article_slideshow')): $index_banner++;?>
                                            <li <?php if($index_banner == 1) echo 'class="on"';?>><?php echo $index_banner;?></li>
                                        <?php endwhile;?>  
                                        </ul>                                        
                                        <div onclick='promotionSwipe<?php echo get_the_ID();?>.next()' class="controlNext">next</div>
                                    </div>
                                </div>
                            </section> 
                            <script>
                                // pure JS
                                var promotion_bullets<?php echo get_the_ID();?> = document.getElementById('promotionPosition<?php echo get_the_ID();?>').getElementsByTagName('li');
                                var elem<?php echo get_the_ID();?> = document.getElementById('articleSlider<?php echo get_the_ID();?>');
                                window.promotionSwipe<?php echo get_the_ID();?> = Swipe(elem<?php echo get_the_ID();?>, {
                                    //startSlide: 4,
                                    //auto: 3000,
                                    continuous: false,
                                    disableScroll: false,
                                    stopPropagation: false,
                                    callback: function(pos) {
                                        var i = promotion_bullets<?php echo get_the_ID();?>.length;
                                        while (i--) {
                                            promotion_bullets<?php echo get_the_ID();?>[i].className = ' ';
                                        }
                                        promotion_bullets<?php echo get_the_ID();?>[pos].className = 'on';                        
                                    }
                                });
                                $('#promotionPosition<?php echo get_the_ID();?> li').click(function() {
                                        idx=( $(this).index() );
                                        promotionSwipe<?php echo get_the_ID();?>.slide(idx, 800);
                                });        

                                
                            </script>                                
                            <?php else:?>                            
                                <div class="thumb-wrapper">
                                    <div class="thumb">
                                        <a href="javascript:void(0);">
                                            <?php if(get_field('article_image',get_the_ID())):?>
                                                <img src="<?php echo get_field('article_image',get_the_ID());?>"/>
                                            <?php else:?>
                                                <?php the_post_thumbnail("full");?>
                                            <?php endif;?>
                                        </a>
                                    </div>
                                </div>                                                                                    
                                <?php the_content();?>
                                <div class="clearfix"></div>
                            <?php endif;?>                            
                            
                            <section id="social_sharing_1">
                                <?php 
                                    $social_sharing_toolkit = new MR_Social_Sharing_Toolkit(); 
                                    echo $social_sharing_toolkit->create_bookmarks(get_permalink(), get_the_title());
                                ?>
                            </section>
                            
                            <?php 
                                $tags = wp_get_post_tags(get_the_ID());                                
                            ?>
                            <?php if(count($tags)):?>
                            <div class="tags">
                                <aside>
                                    <?php the_tags(); ?>            
                                </aside>
                            </div>
                            <?php endif;?>   
                        </div>
                    </section>
                    
            
                <?php endwhile;?>
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
                    $(".thumb-wrapper img").attr("width","auto").attr("height","auto");
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