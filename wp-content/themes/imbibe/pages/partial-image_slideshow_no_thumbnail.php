<?php 
    $article_type = get_field("article_type"); 
    if(!$article_type) $article_type = "image";
?>

<?php if($article_type == "image"):?>            
        <?php the_content();?>
<?php elseif($article_type == "slideshow"):?>
    <?php if(get_field('article_slideshow')):?>
            <?php the_content();?>
            <section class="widget">
                <div id='articleSlider<?php echo get_the_ID();?>' class='swipe'>
                    <div class='swipe-wrap'>                        
                        <?php while(has_sub_field('article_slideshow')): ?>
                        <div>
                            <div class="imgArticle"><img src="<?php echo get_sub_field("article_slideshow_image");?>"></div>
                            <div class="descriptionArticle" style="margin-top:25px;">
                                <?php echo get_sub_field('Content Slideshow');?>
                            </div>
                        </div>    
                        <?php endwhile;?>
                    </div>
                    <div class="control">
                        <div onclick='articleSwipe<?php echo get_the_ID();?>.prev()' class="controlPrev">prev</div>
                        <ul class="position" id="articlePosition<?php echo get_the_ID();?>">
                          <?php $index_banner = 0; while(has_sub_field('article_slideshow')): $index_banner++;?>
                            <li <?php if($index_banner == 1) echo 'class="on"';?>><?php echo $index_banner;?></li>
                          <?php endwhile;?>  
                        </ul>                        
                        <div onclick='articleSwipe<?php echo get_the_ID();?>.next()' class="controlNext">next</div>
                    </div>
                </div>
            </section> 
            <script>
                 
                var article_bullets<?php echo get_the_ID();?> = document.getElementById('articlePosition<?php echo get_the_ID();?>').getElementsByTagName('li');
                // pure JS
                var elem = document.getElementById('articleSlider<?php echo get_the_ID();?>');
                window.articleSwipe<?php echo get_the_ID();?> = Swipe(elem, {
                    startSlide: 0,
                    auto: 4000,
                    continuous: true,
                    disableScroll: false,
                    stopPropagation: false,
                    callback: function(pos) {
                        var i = article_bullets<?php echo get_the_ID();?>.length;
                        while (i--) {
                            article_bullets<?php echo get_the_ID();?>[i].className = ' ';
                        }
                        article_bullets<?php echo get_the_ID();?>[pos].className = 'on';                        
                    }
                });
                $('#articlePosition<?php echo get_the_ID();?> li').click(function() {
                        idx=( $(this).index() );
                        articleSwipe<?php echo get_the_ID();?>.slide(idx, 800);
                });        
                // with jQuery
                //window.articleSwipe = $('#articleSlider').Swipe().data('Swipe');
            </script>

   <?php endif;?>
<?php endif;?>