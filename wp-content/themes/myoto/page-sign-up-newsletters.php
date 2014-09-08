<?php if(isset($_GET['href'])): ?>
    <?php get_header();?>
    <div class="content clearfix">
        <div class="panelLeft">
                <section>
                    <div class="details">
                        <h1><?php the_title();?></h1>
                        <div class="thumb">
                            <?php the_post_thumbnail(array(220,9999));?>
                        </div>
                        <?php the_content();?>                        
                        <iframe src="<?php echo $_GET['href'];?>" frameborder="0"/>
                    </div>
                </section>
                <div class="clearfix"></div>                
        </div>
        
        <div class="panelRight">
            <?php get_sidebar();?>
        </div>
        
        <div class="clearfix"></div>        
    </div>        
    <?php get_footer();?>
<?php endif;?>