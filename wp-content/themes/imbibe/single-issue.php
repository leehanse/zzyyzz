<?php setPostViews(get_the_ID()); ?>
<?php get_header();?>
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Current-Issue"/>
    	<div class="panelLeft">
            <?php while ( have_posts() ) : the_post(); ?>
                <section class="title">
                    <h1><?php the_title(); ?></h1>
                </section>
        	<section class="currentIssue">
                    <div class="left">
                        <div class="thumb">
                            <?php custom_post_thumbnail(null,array(240,9999));?>
                        </div>
                        <?php if(get_field('link_boxs')):?>
                            <?php while(has_sub_field('link_boxs')):?>
                                <?php if(get_sub_field('left_or_right_side') == 'left'):?>
                                    <ul class="list">                                                               
                                        <?php $title = get_sub_field('title');?>
                                        <h3><?php echo $title; ?></h3>
                                        <?php while(has_sub_field('box_link')):?>
                                            <?php 
                                                $sub_header = get_sub_field('sub_header');
                                                $sub_header_content = get_sub_field('sub_header_content');
                                                $sub_header_read_more_link = get_sub_field('sub_header_read_more_link');
                                            ?>
                                            <?php if($sub_header):?>
                                                <h4 style="margin-top:0px;margin-bottom:0px;"><?php echo $sub_header;?></h4>
                                            <?php endif;?>
                                            <?php if($sub_header_content || $sub_header_read_more_link):?>
                                                <p style="margin-top:0px;margin-bottom:10px;">
                                                    <?php echo $sub_header_content;?>
                                                    <?php if($sub_header_read_more_link):?> <a style="color:#B0282E;" href="<?php echo $sub_header_read_more_link;?>">Read More &raquo;</a><?php endif;?>
                                                </p>
                                            <?php endif;?>                                             
                                            <?php while(has_sub_field('links')):?>
                                                    <?php 
                                                        $link = get_sub_field('link');
                                                        $title = get_sub_field('title');
                                                    ?>
                                                    <li><a style="color:#B0282E;" href="<?php echo $link;?>"><?php echo $title;?></a></li>
                                            <?php endwhile;?>
                                        <?php endwhile;?>
                                    </ul>    
                                <?php endif;?>
                            <?php endwhile;?>
                        <?php endif;?>
                    </div>
                    <style>
                        .currentIssue .right ul.list:first-child *{
                            margin-top: 0px !important;
                        }
                    </style>
                    <div class="right">
                        <?php the_content(); ?>
                        <?php if(get_field('link_boxs')):?>
                            <?php while(has_sub_field('link_boxs')):?>
                                <?php if(get_sub_field('left_or_right_side') == 'right'):?>
                                    <ul class="list">                                                               
                                        <?php $title = get_sub_field('title');?>
                                        <h3><?php echo $title; ?></h3>
                                        <?php while(has_sub_field('box_link')):?>
                                            <?php 
                                                $sub_header = get_sub_field('sub_header');
                                                $sub_header_content = get_sub_field('sub_header_content');
                                                $sub_header_read_more_link = get_sub_field('sub_header_read_more_link');
                                            ?>
                                            <?php if($sub_header):?>
                                                <h4 style="margin-top:0px;margin-bottom:0px;"><?php echo $sub_header;?></h4>
                                            <?php endif;?>
                                            <?php if($sub_header_content || $sub_header_read_more_link):?>
                                                <p style="margin-top:0px;margin-bottom:10px;">
                                                    <?php echo $sub_header_content;?>
                                                    <?php if($sub_header_read_more_link):?> <a style="color:#B0282E;" href="<?php echo $sub_header_read_more_link;?>">Read More &raquo;</a><?php endif;?>
                                                </p>
                                            <?php endif;?>                                             
                                            <?php while(has_sub_field('links')):?>
                                                <?php 
                                                    $link = get_sub_field('link');
                                                    $title = get_sub_field('title');
                                                ?>
                                                <li><a style="color:#B0282E;" href="<?php echo $link;?>"><?php echo $title;?></a></li>
                                            <?php endwhile;?>
                                        <?php endwhile;?>
                                    </ul>    
                                <?php endif;?>
                            <?php endwhile;?>
                        <?php endif;?>
                    </div>
                    <div class="clearfix"></div>
                </section>
            <?php endwhile;?>
            
            <?php do_shortcode('[back_issues]');?>                        
        </div>
        <div class="panelRight">
            <?php get_sidebar();?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>