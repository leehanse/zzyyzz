<?php
/* Creating Custom Post Types */
function my_custom_post_tour(){
	$labels = array(
		'name'               => _x( 'Tour', 'post type general name' ),
		'singular_name'      => _x( 'Tour', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Tour' ),
		'edit_item'          => __( 'Edit Tour' ),
		'new_item'           => __( 'New Tour' ),
		'all_items'          => __( 'All Tours' ),
		'view_item'          => __( 'View Tour' ),
		'search_items'       => __( 'Search Tours' ),
		'not_found'          => __( 'No tours found' ),
		'not_found_in_trash' => __( 'No tours found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Tours'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our tours and tour specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => 'tour-category',
                'taxonomies'    => array('tour-category'),
	);
	register_post_type( 'tour', $args );	
}
add_action( 'init', 'my_custom_post_tour' );

/* Custom Interaction Messages */
function tour_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['tour'] = array(
		0 => '', 
		1 => sprintf( __('Tour updated. <a href="%s">View tour</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Tour updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Tour restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Tour published. <a href="%s">View tour</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Tour saved.'),
		8 => sprintf( __('Tour submitted. <a target="_blank" href="%s">Preview tour</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Tour scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview tour</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Tour draft updated. <a target="_blank" href="%s">Preview tour</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tour_updated_messages' );

/* Contextual Help */
function tour_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'tour' == $screen->id ) {

		$contextual_help = '<h2>Tours</h2>
		<p>Tours show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each tour by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-tour' == $screen->id ) {

		$contextual_help = '<h2>Editing tours</h2>
		<p>This page allows you to view/modify tour details. Please make sure to fill out the available boxes with the appropriate details (tour image) and <strong>not</strong> add these details to the tour description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tour_contextual_help', 10, 3 );

//function my_taxonomies_tour() {
//	$labels = array(
//		'name'              => _x( 'Tour Categories', 'taxonomy general name' ),
//		'singular_name'     => _x( 'Tour Category', 'taxonomy singular name' ),
//		'search_items'      => __( 'Search Tour Categories' ),
//		'all_items'         => __( 'All Tour Categories' ),
//		'parent_item'       => __( 'Parent Tour Category' ),
//		'parent_item_colon' => __( 'Parent Tour Category:' ),
//		'edit_item'         => __( 'Edit Tour Category' ), 
//		'update_item'       => __( 'Update Tour Category' ),
//		'add_new_item'      => __( 'Add New Tour Category' ),
//		'new_item_name'     => __( 'New Tour Category' ),
//		'menu_name'         => __( 'Tour Categories' ),
//	);
//	$args = array(
//                'hierarchical'      => true,
//		'labels'            => $labels,		
//                'show_ui'           => true,
//		'show_admin_column' => true,
//		'query_var'         => true
//	);
//	register_taxonomy( 'tour_category', array('tour'), $args );        
//}
//add_action( 'init', 'my_taxonomies_tour', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_tour_posts_columns', 'add_tour_column', 5);

function add_tour_column($cols) { 
//    $cols['tour_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_tour_posts_custom_column', 'display_tour_column', 5, 2);
function display_tour_column($col, $id) {
//    switch($col) {
//        case 'tour_thumbnail' :
//            if (function_exists('get_field_object') && function_exists('get_field')){
//                $url_thumbnail_image = get_field('url_thumbnail_image');
//                if($url_thumbnail_image){
//                   if((strpos($url_thumbnail_image,'http://') !== false) || (strpos($url_thumbnail_image,'https://') !== false)){
//                       echo "<img src='{$url_thumbnail_image}' width='70' height='70'>"; 
//                   }else{
//                       $url_thumbnail_image = home_url().'/wp-content/uploads/' . ltrim($url_thumbnail_image,'/');
//                       echo "<img src='{$url_thumbnail_image}' width='70' height='70'>"; 
//                   }                   
//                   break;
//                }
//            }
//            
//            if (function_exists('the_post_thumbnail')){
//                echo the_post_thumbnail('admin-list-thumb');
//            }else
//                echo '';
//        break;                
//    }
}

//add_filter( 'manage_edit-tour_sortable_columns', 'sort_tour' );
//function sort_tour( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['tour_group'] = 'tour_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_tour' );
// 
//function column_orderby_tour ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'tour_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'tour_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}
?>