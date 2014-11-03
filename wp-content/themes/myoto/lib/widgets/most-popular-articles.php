<?php

add_action( 'widgets_init', 'widget_init_most_popular_article' );

function widget_init_most_popular_article() {
	register_widget( 'MostPopularArticle_Widget' );
}

class MostPopularArticle_Widget extends WP_Widget {

	function MostPopularArticle_Widget() {
		$widget_ops = array( 'classname' => 'most-popular-article', 'description' => __('Most Popular Article', 'most-popular-article') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'most-popular-article-widget' );
		
		$this->WP_Widget( 'most-popular-article-widget', __('Most Popular Article', 'most-popular-article'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
            extract( $args );
            $title = apply_filters('widget_title', $instance['title'] );
        ?>
        <?php
            query_posts(array(
                'posts_per_page' => 5,
                'paged'          => 1,
                'post_type'      => "article",
                "meta_key"       => "post_views_count",
                "orderby"        => "meta_value_num",
                "order"          => "DESC"
            ));
        ?>
        <?php if ( have_posts() ) : ?>
            <section>
                <h1>Most Popular Articles</h1>
                <ul class="list">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <li>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                        </li>                
                    <?php endwhile;?>
                </ul>
            </section>
        <?php endif;?>
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