<?php

add_action( 'widgets_init', 'widget_init_right_side_bar_ads' );

function widget_init_right_side_bar_ads() {
	register_widget( 'RightSideBarAds_Widget' );
}

class RightSideBarAds_Widget extends WP_Widget {

	function RightSideBarAds_Widget() {
		$widget_ops = array( 'classname' => 'right-side-bar-ads', 'description' => __('Right Side Bar Ads', 'right-side-bar-ads') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'right-side-bar-ads-widget' );
		
		$this->WP_Widget( 'right-side-bar-ads-widget', __('Right Side Bar Ads', 'right-side-bar-ads'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
	    $position = apply_filters('position', $instance['position'] );

            $args       = array( 'posts_per_page' => 99999, 'offset'=> 0, 'post_type'=>'ads');
            $arr_ads    = get_posts( $args );
            $ads_effect = array();
            $ads_effect_default = array();
            $ads_effect_custom  = array();
                        
            if($position == 'top'){	    
		    $query_object = get_queried_object();	    	
		    if($query_object && isset($query_object->taxonomy) && $query_object->taxonomy =='recipe-category')             			    {                                
		        $recipe_category = $query_object->term_id;
		    }else{
		        $recipe_category = -1;
		    }
		$_SESSION['recipe_category'] = $recipe_category;
	    }else{
                if(!isset($_SESSION['recipe_category'])){
                    $query_object = get_queried_object();	    	
		    if($query_object && isset($query_object->taxonomy) && $query_object->taxonomy =='recipe-category')             			    {                                
		        $recipe_category = $query_object->term_id;
		    }else{
		        $recipe_category = -1;
		    }                
                }else{
                    $recipe_category = isset($_SESSION['recipe_category']) ? $_SESSION['recipe_category'] : -1;
                }
	    }
            // get effect ads with current page
            foreach($arr_ads as $ads){
                $ads_id = $ads->ID;
                $show_with_all_recipe_category = get_field('show_with_all_recipe_category',$ads_id);
                $recipe_categories   = get_field('recipe_categories',$ads_id);
                if($show_with_all_recipe_category == 'all'){
                    $ads_effect_default[] = $ads_id;
                }else{
                    if($recipe_categories && in_array($recipe_category,$recipe_categories)){
                        $ads_effect_custom[] = $ads_id;
                    }
                }
            }
		
            $ads_effect = array(); 	    

            if(count($ads_effect_custom)) $ads_effect = $ads_effect_custom;
            else $ads_effect = $ads_effect_default;                         		
			
	    $top_ads    = array();
	    $bottom_ads = array();	

	    if( count($ads_effect) > 0){
		foreach($ads_effect as $key => $ad){
		   if($key == 0) $top_ads[] = $ad;
		   else $bottom_ads[] = $ad;             	
		}
	    }
	    $ads_effect = array();	
	    if($position == 'top'){		
		$ads_effect = $top_ads;
	    }elseif($position == 'bottom'){
		$ads_effect = $bottom_ads;
	    }
        ?>
            <?php if(count($ads_effect)):?>
                <?php foreach($ads_effect as $ads_id):?>
                       <?php 
                            $ads_type   = get_field('ads_type',$ads_id);
                            
                            $ads_width  = 307;
                            $ads_height = get_field('ads_height',$ads_id);                            
                            if(!$ads_height) $ads_height = 410;
                            
                            $ads_slide  = array();                            
                            while(has_sub_field('ads',$ads_id)){
                                $image = get_sub_field('image',$ads_id);
                                $alt   = get_sub_field('alt',$ads_id);
                                $link  = get_sub_field('link',$ads_id);
                                $ads_slide[] = array(
                                    "image" => $image,
                                    "alt"   => $alt,
                                    "link"  => $link
                                );
                            }
                            $ads_flash = get_field('ads_flash',$ads_id);                            
                       ?> 
                       <?php if($ads_type == 'image'):?>
                            <?php if(count($ads_slide)):?>
                                <section class="sliderSidebar">
                                    <div id='sliderSidebar<?php echo $position . "_" . $ads_id;?>' class='swipe'>
                                        <div class='swipe-wrap'>
                                            <?php foreach($ads_slide as $slide):?>
                                                <div style="with:<?php echo $ads_width;?>px !important;height:<?php echo $ads_height;?>px !important;">
                                                    <a <?php if($slide['link']): ?> class="iframe" <?php endif;?> href="<?php if($slide['link']) echo $slide['link']; else echo '#';?>"><img src="<?php echo $slide['image'];?>"></a>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
					<!--
                                        <div class="control">
                                            <ul id="position<?php echo $position . "_" . $ads_id;?>" class="position-02">
                                                <?php foreach($ads_slide as $key => $slide):?>
                                                    <li <?php if($key==0):?>class="on"<?php endif;?>><?php echo $key+1;?></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
					-->
                                    </div>
                                </section>  
                                <script>                                    
                                    var elem = document.getElementById('sliderSidebar<?php echo $position . "_" . $ads_id;?>');
                                    window.sliderSidebar<?php echo $position . "_" . $ads_id;?> = Swipe(elem, {
                                        startSlide: 0,
                                        speed: 800,
                                        auto: 3000,
                                        continuous: true,
                                        disableScroll: false,
                                        stopPropagation: false,
                                        callback: function (pos) {
                                        }
                                    });
				    /*	
                                    $('#position<?php echo $position . "_" . $ads_id;?> li').click(function() {
                                            gol=( $(this).index() );
                                            sliderSidebar<?php echo $position . "_" . $ads_id;?>.slide(gol, 800);
                                    });
				    */
                                </script>
                            <?php endif;?>
                       <?php endif;?> 
                                
                       <?php if($ads_type == 'flash' && $ads_flash):?>
                            <section>
                                <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="<?php echo $ads_width;?>" HEIGHT="<?php echo $ads_height;?>" id="<?php echo md5($ads_flash);?>" ALIGN="">
                                        <PARAM NAME=movie VALUE="<?php echo $ads_flash;?>"> 
                                        <PARAM NAME=quality VALUE=high> 
                                        <PARAM NAME=bgcolor VALUE=#333399> 
                                        <EMBED src="<?php echo $ads_flash;?>" quality=high bgcolor=#333399 WIDTH="<?php echo $ads_width;?>" HEIGHT="<?php echo $ads_height;?>" NAME="<?php echo md5($ads_flash);?>" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
                                        </EMBED>
                                </OBJECT>                    
                            </section>                     
                       <?php endif;?>
                                
                <?php endforeach;?>
            <?php endif; ?>
        <?php        
	wp_reset_query();
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['position'] = strip_tags( $new_instance['position'] );
            return $instance;
	}

	
	function form( $instance ) {
            $defaults = array( 'position' => 'top');
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
 <p>
                    <label for="<?php echo $this->get_field_id( 'position' ); ?>">Position</label>
		    <select id="<?php echo $this->get_field_id( 'position' ); ?>" name="<?php echo $this->get_field_name( 'position' ); ?>">
<option value="top" <?php if($instance['position']=='top') echo 'selected="selected"';?>>Top</option>
<option value="bottom" <?php if($instance['position']=='bottom') echo 'selected="selected"';?>>Bottom</option>
</select>	
            </p>
	<?php
	}
}
?>
