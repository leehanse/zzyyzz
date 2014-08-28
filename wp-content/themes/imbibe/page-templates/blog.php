<?php
/**
 * Template Name: Blog Template
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Blog"/>
    	<div class="panelLeft">
            <section class="title">
            	<h1 style="margin:0px;">Imbibe Unfiltered</h1>
                <p>Welcome to Imbibe Magazine's between-issues look at liquid culture with drink recipes, news and more. From coffee to cocktails, Imbibe celebrates your world in a glass.</p>
            </section>
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            $wp_query = new WP_Query();

            $args = array(
                        'post_type'   => 'post',
                        'post_status' => 'publish',
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
                                <nobr><?php echo the_time('F d, Y'); ?></nobr>
                            </div>
                            <?php the_excerpt();?>
                            <a href="<?php the_permalink();?>">Read More &raquo;</a>
                            <div class="clearfix"></div>
                        </div>
                    </section>            
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
                    <div class="clearfix"></div>
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
