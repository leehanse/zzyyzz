<?php

add_action( 'widgets_init', 'widget_init_subscribe' );

function widget_init_subscribe() {
	register_widget( 'Subscribe_Widget' );
}

class Subscribe_Widget extends WP_Widget {

	function Subscribe_Widget() {
		$widget_ops = array( 'classname' => 'subscribe', 'description' => __('Subscribe', 'subscribe') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'subscribe-widget' );
		
		$this->WP_Widget( 'subscribe-widget', __('Subscribe', 'subscribe'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
			$home_page_id  = get_page_by_title('Home Page');
            $home_page_id  = $home_page_id->ID;
            if(get_field('sub_box_image',$home_page_id))
               $sub_box_image = get_field('sub_box_image',$home_page_id);
            else 
                $sub_box_image = get_template_directory_uri() .'/images/pic-01.png';
        ?>
        <section>
            	<ul class="subscribe">
                    <img src="<?php echo $sub_box_image;?>">
                    <li><a href="<?php echo add_query_arg(array("SourceCode"=>"toolbox"),get_permalink(get_page_by_title('Subscribe')));?>">Subscribe</a></li>
                    <li><a href="<?php echo add_query_arg(array("SourceCode"=>"toolbox"),get_permalink(get_page_by_title('Gift')));?>">Give a Gift</a></li>
                    <li><a href="<?php echo add_query_arg(array("SourceCode"=>"toolbox"),get_permalink(get_page_by_title('Renew')));?>">Renew</a></li>
                </ul>
            </section>
        <?php        
	}
        
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            return $instance;
	}

	
	function form( $instance ) {
            $defaults = array( 'title' => '');
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
            <!--
            <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'example'); ?></label>
                    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
            </p>
            -->
	<?php
	}
}
?>