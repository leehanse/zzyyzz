<?php

add_action( 'widgets_init', 'widget_init_newsletter' );

function widget_init_newsletter() {
	register_widget( 'Newsletter_Widget' );
}

class Newsletter_Widget extends WP_Widget {

	function Newsletter_Widget() {
		$widget_ops = array( 'classname' => 'newsletter', 'description' => __('Newsletter', 'newsletter') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'newsletter-widget' );
		
		$this->WP_Widget( 'newsletter-widget', __('Newsletter', 'newsletter'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
            extract( $args );
            $streamsendURL = apply_filters('widget_streamsend-URL', $instance['streamsend-URL'] );
            
        ?>
            <section class="blockNewsletter">
                <h1>Stay in the know.</h1>
                <p>Sign up for Imbibe’s newsletter.</p>
                <form action="<?php echo $streamsendURL;?>" method="post" id="form_sign_up_newsletter">
                    <fieldset>
                        <input name="person[email_address]" id="person_email_address" type="text">
                        <input name="" type="submit" value="Sign up" >
                    </fieldset>
                </form>
            </section>
        <?php        
	}
        
	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['streamsend-URL'] = strip_tags($new_instance['streamsend-URL']);
            return $instance;
	}
	
	function form( $instance ) {
            $defaults = array( 'streamsend-URL' => 'http://app.streamsend.com/public/wSMT/HKQ/subscribe');
            $instance = wp_parse_args( (array) $instance, $defaults ); ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'streamsend-URL' ); ?>"><?php _e('streamsend-URL:', 'example'); ?></label>
                <input id="<?php echo $this->get_field_id( 'streamsend-URL' ); ?>" name="<?php echo $this->get_field_name( 'streamsend-URL' ); ?>" value="<?php echo $instance['streamsend-URL']; ?>" style="width:100%;" />
            </p>
	<?php
	}
}
?>