<?php

add_action( 'widgets_init', 'widget_init_follow_us_on_facebook' );

function widget_init_follow_us_on_facebook() {
	register_widget( 'FollowUsOnFacebook_Widget' );
}

class FollowUsOnFacebook_Widget extends WP_Widget {

	function FollowUsOnFacebook_Widget() {
		$widget_ops = array( 'classname' => 'follow-us-on-facebook', 'description' => __('Follow Us On Facebook', 'follow-us-on-facebook') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'follow-us-on-facebook-widget' );
		
		$this->WP_Widget( 'follow-us-on-facebook-widget', __('Follow Us On Facebook', 'follow-us-on-facebook'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
            $width = apply_filters('widget_width', $instance['width'] );
            $height = apply_filters('widget_height', $instance['height'] );
        ?>
            <section class="followFacebook">
                <iframe id="iframe-facebook" scrolling="no" frameborder="0" style="border: medium none; overflow: hidden; background: none repeat scroll 0% 0% rgb(255, 255, 255); height: <?php echo $height;?>px; width: <?php echo $width;?>px;" src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2F<?php echo get_option('imbibe_facebook_id');?>&amp;width=<?php echo $width;?>&amp;height=327&amp;colorscheme=light&amp;show_faces=true&amp;stream=false&amp;show_border=true&amp;header=true&amp;force_wall=false"></iframe>
            </section>
        <?php        
	}
        
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['width'] = strip_tags( $new_instance['width'] );
            $instance['height'] = strip_tags( $new_instance['height'] );
            return $instance;
	}

	
	function form( $instance ) {
            $defaults = array( 'width' => 300, 'height' => 327);
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
            <p>
                    <label for="<?php echo $this->get_field_id( 'width' ); ?>">Width</label>
                    <input id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" style="width:100%;" />
            </p>
            <p>
                    <label for="<?php echo $this->get_field_id( 'height' ); ?>">Height</label>
                    <input id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" style="width:100%;" />
            </p>
	<?php
	}
}
?>