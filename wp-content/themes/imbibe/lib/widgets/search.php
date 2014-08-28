<?php

add_action( 'widgets_init', 'widget_init_search' );

function widget_init_search() {
	register_widget( 'Search_Widget' );
}

class Search_Widget extends WP_Widget {

	function Search_Widget() {
		$widget_ops = array( 'classname' => 'search', 'description' => __('Imbibe Search', 'search') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'search-widget' );
		
		$this->WP_Widget( 'search-widget', __('Imbibe Search', 'search'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );            
        ?>
            <?php get_search_form(); ?>
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