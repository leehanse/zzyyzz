<?php if( have_rows('banner_images') ): ?>
<div class="banner">
    <div class="moduletable">
       <div id="avatar_vm_slide_products" class="">
          <div class="slider-wrapper theme-default">
             <div class="ribbon"></div>
             <div id="slider_vm_slide_products" class="nivoSlider">
                <?php while( have_rows('banner_images') ): the_row(); 
                            $image = get_sub_field('image');
                            $link  = get_sub_field('link_to');
                            $title = get_sub_field('title');
                            if(empty($link)) $link = '#';
                        ?>
                 
                 <a href="<?php echo $link;?>" title="<?php echo $title;?>">
                    <img src="<?php echo $image;?>" alt="<?php echo $title;?>" title="<?php echo $title;?>">
                    <span class = "imgDes"></span>
                 </a>
               <?php endwhile;?>     
             </div>
          </div>
       </div>  
       <script type="text/javascript">
          (function($) 
          { 
                $(function()
                {
                        $(document).ready( function()
                        {			 
                                $('#avatar_vm_slide_products').css("width","730px");
                                $('#avatar_vm_slide_products').css("margin-bottom","5px");
                                if($('#avatar_vm_slide_products').width()%2!=0)
                                        $('#avatar_vm_slide_products').width($('#avatar_vm_slide_products').width()-1);
                                $('#slider_vm_slide_products').css("width","730px");
                                $('#slider_vm_slide_products').css("height","155");
                                $('#slider_vm_slide_products').nivoSlider({
                                        slices			:1,
                                        boxRows			:1,
                                        boxCols			:2,
                                        animSpeed		:200,
                                        pauseTime		:7000,
                                });
                        });
                })
          })(jQuery);
       </script>
    </div>
    <div class="moduletable">
       <div class="custom"  >
          <div style="background-color: white; text-align: center;"><img src="http://nemprint.dk/images/nemprint_anmeldelser.png" alt="nemprint anmeldelser" width="260" /><br /><br /></div>
          <p><a href="http://www.trustpilot.dk/review/nemprint.dk"><img src="http://nemprint.dk/images/hvorfor-nemprint.png" alt="hvorfor-nemprint" width="310" /></a></p>
       </div>
    </div>
    <div class="clr"></div>
</div>
<?php endif;?>