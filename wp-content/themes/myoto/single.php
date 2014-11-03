<?php setPostViews(get_the_ID()); ?>

<?php get_header(); ?> 
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Blog"/>
    	<div class="panelLeft">
            <?php while ( have_posts() ) : the_post(); ?>                   
                <section>
                    <ul class="breadcrumb clearfix">
                        <li><a href="<?php echo home_url('blog');?>">Blog</a></li>
                        <li><span><?php the_title();?></span></li>
                    </ul>
                </section>
                <section>
                    <div class="details">
                        <h1><?php the_title();?></h1>
                        
                        <?php get_template_part('pages/partial','image_slideshow');?>                        
                        
                    </div>
                </section>

                <section class="tags">
                    <aside>
                        <?php the_tags(); ?>                        
                    </aside>
                </section>

                <section id="social_sharing_2">
                    <?php 
                        $social_sharing_toolkit = new MR_Social_Sharing_Toolkit(); 
                        echo $social_sharing_toolkit->create_bookmarks(get_permalink(), get_the_title());
                    ?>                    
                </section>   
                
                <div class="clearfix"></div>
                <section>                              
                    <ul class="next-previous-post">                        
                        <li class="previous-post"><?php previous_post("&laquo; %","");?></li>
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
                                'post_type'         => "post"
                            );  
                            $my_query = new wp_query($args);  
                            if( $my_query->have_posts() ):                            
                    ?>                   
                        <section>
                            <article>
                            <h1>Related Post</h1>                
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
            <?php endwhile;?>  
            <?php wp_reset_query(); ?>               
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>