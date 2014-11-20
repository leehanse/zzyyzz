<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dazzling
 */
?>
	<div id="footer-area">
                <?php $lang = getCurrentLanguage(); ?>
                <?php $footers = get_field('footer_'.$lang, 'option');?>
                <?php if(count($footers)):?>
                        <div class="container footer-inner">                       
                            <div class="footer-widget-area">
                                <?php foreach($footers as $item):?>
                                    <div class="col-sm-6 col-md-2 footer-widget" role="complementary">
                                        <h3 class="footer-title"><?php echo $item['box_title'];?></h3>
                                        <div class="footer-content">
                                            <?php echo $item['box_content'];?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>                                
                            </div>                            
                        </div>
                <?php endif;?>    
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info container">
				<?php dazzling_social(); ?>
				<nav role="navigation" class="col-md-6">
					<?php dazzling_footer_links(); ?>
				</nav>
				<div class="copyright col-md-6">
					<img src="<?php echo get_template_directory_uri();?>/images/cards.png">
					Made by Vinaprint.dk
				</div>
			</div><!-- .site-info -->
			<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
		</footer><!-- #colophon -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>