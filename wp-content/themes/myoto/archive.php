<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
    <div class="content clearfix">
    	<div class="panelLeft">
            <section class="title">
            	<h1>Archives</h1>
            </section>
            <?php
                $paged       = isset($_GET['page-num']) ? $_GET['page-num'] : 1;
                $s_post_type = array('recipe','article','event','promotion','post');
                
                $pageSize   = 10;
                $wp_query   = new WP_Query();
                $args = array(
                            'post_type'   => $s_post_type,
                            'post_status' => 'publish',
                            'paged'       => $paged,
                            'posts_per_page'   => $pageSize,
                        );
                $wp_query -> query( $args); 
                                        
                $total_post = $wp_query->found_posts;
                $max_page   = $wp_query->max_num_pages;
                
                if($max_page * $pageSize < $total_post) $max_page++;    
                
            ?>
            <?php if ( $wp_query->have_posts()) : ?>            
                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                    <section>
                        <div class="details">            
                            <a href="<?php the_permalink();?>">
                                <h1> 
                                    <?php the_title(); ?>
                                    <span class="date">
                                        <b>
                                        <?php 
                                            switch(get_post_type()){
                                                case 'article': echo 'Article'; break;
                                                case 'recipe': echo 'Recipe'; break;
                                                case 'event': echo 'Event'; break;
                                                default : echo get_post_type();
                                            }
                                        ?> 
                                        </b>
                                        <?php the_time("F d, Y");?>
                                    </span>
                                </h1>
                            </a>                            
                            <div class="thumb-wrapper">
                                <div class="thumb">
                                    <a href="<?php the_permalink();?>">
                                        <?php the_post_thumbnail("full");?>
                                    </a>
                                </div>
                            </div>                            
                            <?php the_excerpt();?>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                    <?php 
                        $tags = wp_get_post_tags(get_the_ID());                                
                    ?>
                    <?php if(count($tags)):?>
                    <section class="blog-tags">
                        <aside>                            
                            <?php the_tags(); ?>            
                        </aside>
                    </section>
                    <?php endif;?>
            
                <?php endwhile;?>
                <?php wp_reset_query(); ?>
            
                <?php if($max_page >1):?>
                    <section>                        
                        <ul class="paging">
                            <li class="first"><a href="<?php echo add_query_arg(array('post_type'=>$post_type,'s'=>get_search_query(),'page-num'=>1),home_url());?>">&lang;&lang;</a></li>
                            <?php if($paged -1 > 0):?>                            
                                <li class="prev"><a href="<?php echo add_query_arg(array('post_type'=>$post_type,'s'=>get_search_query(),'page-num'=> $paged - 1),home_url());?>">&lang;</a></li>
                            <?php endif;?>
                            <?php for($p = 1; $p<=$max_page;$p++):?>
                            <li class="num <?php if($p == $paged) echo 'active';?>"><a href="<?php echo add_query_arg(array('post_type'=>$post_type,'s'=>get_search_query(),'page-num'=> $p),home_url());?>"><?php echo $p;?></a></li>
                            <?php endfor;?>

                            <?php if($paged +1 <= $max_page):?>
                                <li class="next"><a href="<?php echo add_query_arg(array('post_type'=>$post_type,'s'=>get_search_query(),'page-num'=>$paged + 1),home_url());?>">&rang;</a></li>
                            <?php endif;?>

                            <li class="last"><a href="<?php echo add_query_arg(array('post_type'=>$post_type,'s'=>get_search_query(),'page-num'=>$max_page),home_url());?>">&rang;&rang;</a></li>
                        </ul>
                    </section>                
                <?php endif;?>                
            
            <?php else:?>
                <h1>No result found. Please try again!</h1>
            <?php endif;?>
            <script type="text/javascript">
                function modifyThumbnail(){
                    jQuery(".thumb-wrapper").each(function(){
                       width = jQuery(this).find("img").width();
                       if(width > 220)
                           jQuery(this).find(".thumb").addClass("thumbCenter").removeClass("thumb");
                    });
                }
                jQuery(document).ready(function(){
                    interv = window.setInterval("modifyThumbnail();",1000);
                });
            </script>              
            
        </div>
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>