<?php
/* Creating Custom Post Types */
function custom_post_paper_size(){
	$labels = array(
		'name'               => _x( 'Paper size', 'post type general name' ),
		'singular_name'      => _x( 'Paper size', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Paper size' ),
		'edit_item'          => __( 'Edit Paper size' ),
		'new_item'           => __( 'New Paper size' ),
		'all_items'          => __( 'Paper Sizes'),
		'view_item'          => __( 'View Paper size' ),
		'search_items'       => __( 'Search Paper sizes' ),
		'not_found'          => __( 'No paper sizes found' ),
		'not_found_in_trash' => __( 'No paper sizes found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Paper sizes'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our paper sizes and paper size specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title'),
                'show_in_menu'  => 'edit.php?post_type=product',
		'has_archive'   => 'paper size-category',
                'taxonomies'    => array('paper size-category'),
	);
	register_post_type( 'paper_size', $args );	
}
add_action( 'init', 'custom_post_paper_size' );

/* Custom Interaction Messages */
function paper_size_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['paper_size'] = array(
		0 => '', 
		1 => sprintf( __('Paper size updated. <a href="%s">View paper size</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Paper size updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Paper size restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Paper size published. <a href="%s">View paper size</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Paper size saved.'),
		8 => sprintf( __('Paper size submitted. <a target="_blank" href="%s">Preview paper size</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Paper size scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview paper size</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Paper size draft updated. <a target="_blank" href="%s">Preview paper size</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'paper_size_updated_messages' );

/* Contextual Help */
function paper_size_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'paper_size' == $screen->id ) {

		$contextual_help = '<h2>Paper sizes</h2>
		<p>Paper sizes show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each paper size by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-paper_size' == $screen->id ) {

		$contextual_help = '<h2>Editing paper sizes</h2>
		<p>This page allows you to view/modify paper size details. Please make sure to fill out the available boxes with the appropriate details (paper size image) and <strong>not</strong> add these details to the paper size description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'paper_size_contextual_help', 10, 3 );

//function my_taxonomies_paper_size() {
//	$labels = array(
//		'name'              => _x( 'Paper size Categories', 'taxonomy general name' ),
//		'singular_name'     => _x( 'Paper size Category', 'taxonomy singular name' ),
//		'search_items'      => __( 'Search Paper size Categories' ),
//		'all_items'         => __( 'All Paper size Categories' ),
//		'parent_item'       => __( 'Parent Paper size Category' ),
//		'parent_item_colon' => __( 'Parent Paper size Category:' ),
//		'edit_item'         => __( 'Edit Paper size Category' ), 
//		'update_item'       => __( 'Update Paper size Category' ),
//		'add_new_item'      => __( 'Add New Paper size Category' ),
//		'new_item_name'     => __( 'New Paper size Category' ),
//		'menu_name'         => __( 'Paper size Categories' ),
//	);
//	$args = array(
//                'hierarchical'      => true,
//		'labels'            => $labels,		
//                'show_ui'           => true,
//		'show_admin_column' => true,
//		'query_var'         => true
//	);
//	register_taxonomy( 'paper_size_category', array('paper_size'), $args );        
//}
//add_action( 'init', 'my_taxonomies_paper_size', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_paper_size_posts_columns', 'add_paper_size_column', 5);

function add_paper_size_column($cols) { 
//    $cols['paper_size_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_paper_size_posts_custom_column', 'display_paper_size_column', 5, 2);
function display_paper_size_column($col, $id) {
//    switch($col) {
//        case 'paper_size_thumbnail' :
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

//add_filter( 'manage_edit-paper_size_sortable_columns', 'sort_paper_size' );
//function sort_paper_size( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['paper_size_group'] = 'paper_size_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_paper_size' );
// 
//function column_orderby_paper_size ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'paper_size_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'paper_size_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}