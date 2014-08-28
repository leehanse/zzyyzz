<?php setPostViews(get_the_ID()); ?>

<?php get_header(); ?> 
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Evnts-Promotions"/>
    	<div class="panelLeft">
            <?php while ( have_posts() ) : the_post(); ?>                   
                <section>
                    <ul class="breadcrumb clearfix">
                        <li><a href="#">Events & Promotions</a></li>
                        <li><span><?php the_title();?></span></li>
                    </ul>
                </section>
                <section>
                    <div class="details">
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
                                    <?php echo $str_time;?>
                                    <?php if($time):?> <?php echo $arr[$time];?><?php endif;?>, 
                                    <?php echo get_field('city',get_the_ID())?>, <?php echo get_field('state',get_the_ID())?>
                                </span>
                            </h1>                                                
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
            <?php endwhile;?>  
            <?php wp_reset_query(); ?>               
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>