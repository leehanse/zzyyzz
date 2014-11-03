<?php     
    $term_id = get_queried_object()->term_id;       
    $paged    = get_query_var('paged') ? get_query_var('paged') : 1;
    $wp_query = new WP_Query();
    $args = array(
                'post_type'   => array('recipe','article','event','promotion'),
                'post_status' => 'publish',
                'tag__in'     => $term_id,
                'paged'       => $paged,
                'posts_per_page'   => get_option('posts_per_page')
            );
    $wp_query -> query( $args);
    $base_query_params = array();
?>
<?php get_header(); ?> 
    <div class="content clearfix">
    	<div class="panelLeft">
            <section class="title">
            	<h1><?php printf( __( 'Tag Archives: "%s"', 'imbibe' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
                <?php if ( tag_description() ) : // Show an optional tag description ?>
                    <p><?php echo tag_description(); ?></p>
                <?php endif; ?>                
            </section>
            
            <?php if ( $wp_query->have_posts() ) : ?>            
                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                    <section>
                        <div class="details">            
                            <a href="<?php the_permalink();?>">
                                <h1><?php the_title(); ?>
                                    <span class="date">
                                        <strong>
                                            <?php 
                                                $post_type = get_post_type(get_the_ID());
                                                switch($post_type){
                                                    case 'recipe': echo 'RECIPE'; break;
                                                    case 'article': echo 'ARTICLE'; break;
                                                    case 'event': echo 'EVENT'; break;
                                                    case 'promotion': echo 'PROMOTION'; break;                                                        
                                                }
                                            ?>                                
                                        </strong>  |  
                                        <?php the_time("F d, Y");?>
                                    </span>
                                </h1>
                            </a>                            
                            <div class="thumb">
                                <a href="<?php the_permalink();?>">
                                    <?php custom_post_thumbnail();?>
                                </a>
                            </div>
                            <?php the_excerpt();?>
                            <div class="clearfix"></div>
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
                                    $p_min  = $paged-5;
                                    if($p_min < 1) $p_min = 1;
                                    
                                    $p_max  = $p_min + 10;
                                    if($p_max >= $wp_query->max_num_pages) $p_max = $wp_query->max_num_pages - 1;
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
            
            <?php endif;?>
        </div>        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>