<?php setPostViews(get_the_ID()); ?>
<?php get_header(); ?> 
    <div class="content clearfix">
    	<div class="panelLeft">
            <?php while ( have_posts() ) : the_post(); ?>              
                <section>
                    <ul class="breadcrumb clearfix">
                        <li><a href="<?php echo get_permalink(get_page_by_title('Articles'));?>">ARTICLES</a></li>
                        <?php
                            $tax_name   = 'article-category';
                            $categories = get_the_terms(null,$tax_name);
                            $h_cat      = null;                            
                            // find exists child category
                            if(count($categories)){                                
                                foreach($categories as $cat){
                                    if($cat->parent){
                                        $h_cat = $cat->term_id;
                                    }
                                }
                                if(!$h_cat){
                                    $first_obj = reset($categories);
                                    $h_cat     = $first_obj->term_id;
                                }
                            }                            
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
                                    echo '<li>';
                                    echo '<img src="'.home_url().'/wp-content/themes/imbibe/images/xarrowRed.png.pagespeed.ic.73k6-TKJ-q.png">';
                                    echo '<a href="'.$item_link.'">';
                                    echo strtoupper($arr_link_titles[$key]);
                                    echo '</a>';
                                    echo '</li>';
                                }
                            }                            
                        ?>  
                        <li><span><?php the_title();?></span></li>
                    </ul>
                </section>                        
                <section>
                    <div class="details">
                        <h1><?php the_title();?>
                            <span class="date" style="font-weight:bold;"><?php echo get_field('article_sub_header');?></span>
                        </h1>                       
                        <?php get_template_part('pages/partial','image_slideshow');?>                        

                        <?php if(get_field('url_hardcopy')):?>
                            <p>
                                <a href="<?php echo get_field('url_hardcopy');?>">Get the Hardcopy &raquo;</a>
                            </p>    
                        <?php endif;?>                        
                        <section id="social_sharing_2">
                            <?php 
                                $social_sharing_toolkit = new MR_Social_Sharing_Toolkit(); 
                                echo $social_sharing_toolkit->create_bookmarks(get_permalink(), get_the_title());
                            ?>
                        </section>                        
                    </div>
                </section>
            
                <section class="tags">                    
                    <aside>
                        <?php the_tags(); ?>                        
                    </aside>
                </section>
                <div class="clearfix"></div>
                
                <section>                              
                    <ul class="next-previous-post">                        
                        <li class="previous-post"><?php previous_post("&laquo;%","");?></li>
                        <li class="next-post"><?php next_post("% &raquo;",""); ?></li>
                    </ul>
                    <div class="clearfix"></div>
                </section>                   
                    <?php                
                        $tags = wp_get_post_tags($post->ID);
                        if ($tags):
                            $tag_ids = array();  
                            foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
                            $args=array(  
                                'tag__in'           => $tag_ids,  
                                'post__not_in'      => array($post->ID),  
                                'showposts'         => 5,  // Number of related posts that will be shown.  
                                'caller_get_posts'  => 1,
                                'post_type'         => "article"
                            );  
                            $my_query = new wp_query($args);  
                            if( $my_query->have_posts() ):                            
                    ?>                   
                        <section>
                            <article>
                            <h1>Related Articles</h1>                
                            <ul class="list">
                                <?php while ($my_query->have_posts()): $my_query->the_post();?>
                                <li>
                                    <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </li>
                                <?php endwhile;
                                    $post = $backup;  
                                    wp_reset_query();
                                ?>
                            </ul>    
                            </article>
                        </section>                
                        <?php endif;?>
                    <?php endif;?> 
                            
                <?php do_shortcode('[editor_pick]');?>
            <?php endwhile;?>  
            <?php wp_reset_query(); ?>               
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>