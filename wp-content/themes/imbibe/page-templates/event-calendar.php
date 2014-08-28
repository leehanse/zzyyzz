<?php
/**
 * Template Name: Event Calendar
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Events-Promotions"/>
    	<div class="panelLeft">
            <section>
            	<ul class="breadcrumb">
                    <li><a href="<?php echo home_url();?>">Home</a></li>                    
                    <li><span>Event Calendar</span></li>
                </ul>
            </section>        
            <style>
                .content .details .thumb{ min-height: 200px;}
                #excerpt_event_calendar p:first-child{ margin-top:0px;}                
            </style>    
            <?php
                $paged      = get_query_var('paged');
                if(!$paged) $paged = 1;
                $pageSize   = get_option('posts_per_page');
                $wp_query   = new WP_Query();
                $meta_query = array();
                $meta_query[] = array();
                
                $args = array(
                            'post_type'   => 'event',
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
                .blockList section .thumb{ height: auto !important; }
            </style>
             <?php if ($wp_query -> have_posts() ) : ?>            
                <div class = "blockList">
                <?php while($wp_query ->have_posts()): $wp_query ->the_post(); ?>                    
                    <section class="clearfix">
                        <div class="details">                                                                    
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <a href="<?php the_permalink();?>">
                                        <?php custom_post_thubnail_no_caption(null,220,9999);?>
                                    </a>
                                </div>
                            </div>                       
                            <a href="<?php the_permalink();?>">
                                <h1 style="margin-bottom:0px;"><?php the_title(); ?>
                                    <?php 
                                        $event_date     = get_field('date',get_the_ID()); 
                                        $event_date_end = get_field('date_end',get_the_ID()); 

                                        $event_date = new DateTime($event_date);        
                                        if($event_date_end){
                                            $event_date_end = new DateTime($event_date_end);                                
                                            if($event_date->format('Y-m') == $event_date_end->format('Y-m')){
                                                $str_time = $event_date->format('F d') . '-' .$event_date_end->format('d, Y');
                                            }else{
                                                $str_time = $event_date->format('F d, Y') . '-' .$event_date_end->format('F d, Y');
                                            }
                                        }else{
                                            $str_time = $event_date->format('F d, Y');
                                        }                                    
                                                                                
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
                                    <span class="date">
                                        <?php echo $str_time;?><?php if($time):?> <?php echo $arr[$time];?><?php endif;?>, <?php echo get_field('city',get_the_ID())?>, <?php echo get_field('state',get_the_ID())?>
                                    </span>
                                </h1>
                            </a>  
                            <div id="excerpt_event_calendar">
                                <?php the_excerpt();?>                                
                                <a href="<?php the_permalink();?>">Read More &raquo;</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                    <!--
                    <section id="social_sharing_1" style="border-bottom:1px dotted #858585;">
                        <?php 
                            //$social_sharing_toolkit = new MR_Social_Sharing_Toolkit(); 
                            //echo $social_sharing_toolkit->create_bookmarks(get_permalink(), get_the_title());
                        ?>
                    </section>
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