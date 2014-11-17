<?php
/* Creating Custom Post Types */
function custom_post_paper_type(){
	$labels = array(
		'name'               => _x( 'Paper type', 'post type general name' ),
		'singular_name'      => _x( 'Paper type', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Paper type' ),
		'edit_item'          => __( 'Edit Paper type' ),
		'new_item'           => __( 'New Paper type' ),
		'all_items'          => __( 'Paper Types'),
		'view_item'          => __( 'View Paper type' ),
		'search_items'       => __( 'Search Paper types' ),
		'not_found'          => __( 'No paper types found' ),
		'not_found_in_trash' => __( 'No paper types found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Paper types'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our paper types and paper type specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title'),
                'show_in_menu'  => 'edit.php?post_type=product',
		'has_archive'   => 'paper type-category',
                'taxonomies'    => array('paper type-category'),
	);
	register_post_type( 'paper_type', $args );	
}
add_action( 'init', 'custom_post_paper_type' );

/* Custom Interaction Messages */
function paper_type_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['paper_type'] = array(
		0 => '', 
		1 => sprintf( __('Paper type updated. <a href="%s">View paper type</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Paper type updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Paper type restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Paper type published. <a href="%s">View paper type</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Paper type saved.'),
		8 => sprintf( __('Paper type submitted. <a target="_blank" href="%s">Preview paper type</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Paper type scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview paper type</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Paper type draft updated. <a target="_blank" href="%s">Preview paper type</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'paper_type_updated_messages' );

/* Contextual Help */
function paper_type_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'paper_type' == $screen->id ) {

		$contextual_help = '<h2>Paper types</h2>
		<p>Paper types show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each paper type by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-paper_type' == $screen->id ) {

		$contextual_help = '<h2>Editing paper types</h2>
		<p>This page allows you to view/modify paper type details. Please make sure to fill out the available boxes with the appropriate details (paper type image) and <strong>not</strong> add these details to the paper type description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'paper_type_contextual_help', 10, 3 );

//function my_taxonomies_paper_type() {
//	$labels = array(
//		'name'              => _x( 'Paper type Categories', 'taxonomy general name' ),
//		'singular_name'     => _x( 'Paper type Category', 'taxonomy singular name' ),
//		'search_items'      => __( 'Search Paper type Categories' ),
//		'all_items'         => __( 'All Paper type Categories' ),
//		'parent_item'       => __( 'Parent Paper type Category' ),
//		'parent_item_colon' => __( 'Parent Paper type Category:' ),
//		'edit_item'         => __( 'Edit Paper type Category' ), 
//		'update_item'       => __( 'Update Paper type Category' ),
//		'add_new_item'      => __( 'Add New Paper type Category' ),
//		'new_item_name'     => __( 'New Paper type Category' ),
//		'menu_name'         => __( 'Paper type Categories' ),
//	);
//	$args = array(
//                'hierarchical'      => true,
//		'labels'            => $labels,		
//                'show_ui'           => true,
//		'show_admin_column' => true,
//		'query_var'         => true
//	);
//	register_taxonomy( 'paper_type_category', array('paper_type'), $args );        
//}
//add_action( 'init', 'my_taxonomies_paper_type', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_paper_type_posts_columns', 'add_paper_type_column', 5);

function add_paper_type_column($cols) { 
//    $cols['paper_type_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_paper_type_posts_custom_column', 'display_paper_type_column', 5, 2);
function display_paper_type_column($col, $id) {
//    switch($col) {
//        case 'paper_type_thumbnail' :
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

//add_filter( 'manage_edit-paper_type_sortable_columns', 'sort_paper_type' );
//function sort_paper_type( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['paper_type_group'] = 'paper_type_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_paper_type' );
// 
//function column_orderby_paper_type ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'paper_type_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'paper_type_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}