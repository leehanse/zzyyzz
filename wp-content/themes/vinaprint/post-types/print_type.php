<?php
/* Creating Custom Post Types */
function my_custom_post_print_type(){
	$labels = array(
		'name'               => _x( 'Print Type', 'post type general name' ),
		'singular_name'      => _x( 'Print Type', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Print Type' ),
		'edit_item'          => __( 'Edit Print Type' ),
		'new_item'           => __( 'New Print Type' ),
		'all_items'          => __( 'All Print Types' ),
		'view_item'          => __( 'View Print Type' ),
		'search_items'       => __( 'Search Print Types' ),
		'not_found'          => __( 'No print types found' ),
		'not_found_in_trash' => __( 'No print types found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Print Types'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our print types and print_type specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => false,
                'taxonomies'    => array(),
	);
	register_post_type( 'print_type', $args );	
}
add_action( 'init', 'my_custom_post_print_type' );

/* Custom Interaction Messages */
function print_type_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['print_type'] = array(
		0 => '', 
		1 => sprintf( __('Print Type updated. <a href="%s">View print_type</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Print Type updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Print Type restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Print Type published. <a href="%s">View print_type</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Print Type saved.'),
		8 => sprintf( __('Print Type submitted. <a target="_blank" href="%s">Preview print_type</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Print Type scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview print_type</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Print Type draft updated. <a target="_blank" href="%s">Preview print_type</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'print_type_updated_messages' );

/* Contextual Help */
function print_type_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'print_type' == $screen->id ) {

		$contextual_help = '<h2>Print Types</h2>
		<p>Print Types show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each print type by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-print_type' == $screen->id ) {

		$contextual_help = '<h2>Editing print_types</h2>
		<p>This page allows you to view/modify print type details. Please make sure to fill out the available boxes with the appropriate details (print_type image) and <strong>not</strong> add these details to the print_type description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'print_type_contextual_help', 10, 3 );

//function my_taxonomies_print_type() {
//	$labels = array(
//		'name'              => _x( 'Print Type Categories', 'taxonomy general name' ),
//		'singular_name'     => _x( 'Print Type Category', 'taxonomy singular name' ),
//		'search_items'      => __( 'Search Print Type Categories' ),
//		'all_items'         => __( 'All Print Type Categories' ),
//		'parent_item'       => __( 'Parent Print Type Category' ),
//		'parent_item_colon' => __( 'Parent Print Type Category:' ),
//		'edit_item'         => __( 'Edit Print Type Category' ), 
//		'update_item'       => __( 'Update Print Type Category' ),
//		'add_new_item'      => __( 'Add New Print Type Category' ),
//		'new_item_name'     => __( 'New Print Type Category' ),
//		'menu_name'         => __( 'Print Type Categories' ),
//	);
//	$args = array(
//                'hierarchical'      => true,
//		'labels'            => $labels,		
//                'show_ui'           => true,
//		'show_admin_column' => true,
//		'query_var'         => true
//	);
//	register_taxonomy( 'print_type_category', array('print_type'), $args );        
//}
//add_action( 'init', 'my_taxonomies_print_type', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_print_type_posts_columns', 'add_print_type_column', 5);

function add_print_type_column($cols) { 
//    $cols['print_type_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_print_type_posts_custom_column', 'display_print_type_column', 5, 2);
function display_print_type_column($col, $id) {
//    switch($col) {
//        case 'print_type_thumbnail' :
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

//add_filter( 'manage_edit-print_type_sortable_columns', 'sort_print_type' );
//function sort_print_type( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['print_type_group'] = 'print_type_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_print_type' );
// 
//function column_orderby_print_type ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'print_type_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'print_type_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}
?>