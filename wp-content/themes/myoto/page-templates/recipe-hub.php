<?php
/**
 * Template Name: Recipe Hub
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">        
        <div class="panelLeft">        
            <?php
                $recipe_category_id     = get_queried_object()->term_id;    
                $recipe_category_slug   = get_queried_object()->slug;                
            ?>            
            <?php if($recipe_category_id): ?>
            <section>
                <ul class="breadcrumb clearfix">
                    <li><a href="<?php echo get_permalink(get_page_by_title('Recipes'));?>">RECIPES</a></li>
                    <?php if($recipe_category_id){
                            $h_cat           = $recipe_category_id;
                            $tax_name        = 'recipe-category';
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
            <?php endif;?>
            
        <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            $wp_query = new WP_Query();

            $meta_query = array();
            $tax_query  = array();
            
            if($recipe_category_id){
                $tax_query[] = array(
                    'taxonomy'  => 'recipe-category',
                    'field'     => 'id',
                    'terms'     => $recipe_category_id
                );
            }
            
            $args = array(
                        'post_type'   => 'recipe',
                        'post_status' => 'publish',
                        'meta_query'  => $meta_query, 
                        'tax_query'   => $tax_query,
                        'paged'       => $paged,
                        'posts_per_page'   =>  8
                    );
            $wp_query -> query( $args);    
            $base_query_params  = array('recipe-category' => $recipe_category_slug );        
        ?>
        <style>
                .blockList section .thumb{ height: auto !important; }
        </style>    
        <?php if ( $wp_query->have_posts() ) : ?>
            <div class = "blockList">
                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
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
                            ?>
                            <nobr><?php echo the_time('F d, Y'); ?></nobr>
                        </div>
                        <?php the_excerpt();?>
                        <a href="<?php the_permalink();?>">Read More &raquo;</a>
                    </div>
                </section>
                <?php endwhile;?>  
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
        <?php endif;?>
            
        <?php wp_reset_query(); ?>
        <?php do_shortcode('[editor_pick]');?>                
    
    
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>
