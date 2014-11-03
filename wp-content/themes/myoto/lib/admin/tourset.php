<?php
/* Creating Custom Post Types */
function my_custom_post_tourset(){
	$labels = array(
		'name'               => _x( 'Tour set', 'post type general name' ),
		'singular_name'      => _x( 'Tour set', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Tour set' ),
		'edit_item'          => __( 'Edit Tour set' ),
		'new_item'           => __( 'New Tour set' ),
		'all_items'          => __( 'All Tour sets' ),
		'view_item'          => __( 'View Tour set' ),
		'search_items'       => __( 'Search Tour sets' ),
		'not_found'          => __( 'No toursets found' ),
		'not_found_in_trash' => __( 'No toursets found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Tour sets'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our toursets and tourset specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => 'tourset-category',
                'taxonomies'    => array('tourset-category'),
	);
	register_post_type( 'tourset', $args );	
}
add_action( 'init', 'my_custom_post_tourset' );

/* Custom Interaction Messages */
function tourset_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['tourset'] = array(
		0 => '', 
		1 => sprintf( __('Tour set updated. <a href="%s">View tourset</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Tour set updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Tour set restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Tour set published. <a href="%s">View tourset</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Tour set saved.'),
		8 => sprintf( __('Tour set submitted. <a target="_blank" href="%s">Preview tourset</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Tour set scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview tourset</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Tour set draft updated. <a target="_blank" href="%s">Preview tourset</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'tourset_updated_messages' );

/* Contextual Help */
function tourset_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'tourset' == $screen->id ) {

		$contextual_help = '<h2>Tour sets</h2>
		<p>Tour sets show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each tourset by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-tourset' == $screen->id ) {

		$contextual_help = '<h2>Editing toursets</h2>
		<p>This page allows you to view/modify tourset details. Please make sure to fill out the available boxes with the appropriate details (tourset image) and <strong>not</strong> add these details to the tourset description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'tourset_contextual_help', 10, 3 );

function my_taxonomies_tourset() {
	$labels = array(
		'name'              => _x( 'Tour set Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Tour set Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Tour set Categories' ),
		'all_items'         => __( 'All Tour set Categories' ),
		'parent_item'       => __( 'Parent Tour set Category' ),
		'parent_item_colon' => __( 'Parent Tour set Category:' ),
		'edit_item'         => __( 'Edit Tour set Category' ), 
		'update_item'       => __( 'Update Tour set Category' ),
		'add_new_item'      => __( 'Add New Tour set Category' ),
		'new_item_name'     => __( 'New Tour set Category' ),
		'menu_name'         => __( 'Tour set Categories' ),
	);
	$args = array(
                'hierarchical'      => true,
		'labels'            => $labels,		
                'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true
	);
	register_taxonomy( 'tourset_category', array('tourset'), $args );        
}
add_action( 'init', 'my_taxonomies_tourset', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_tourset_posts_columns', 'add_tourset_column', 5);

function add_tourset_column($cols) { 
//    $cols['tourset_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_tourset_posts_custom_column', 'display_tourset_column', 5, 2);
function display_tourset_column($col, $id) {
//    switch($col) {
//        case 'tourset_thumbnail' :
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

//add_filter( 'manage_edit-tourset_sortable_columns', 'sort_tourset' );
//function sort_tourset( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['tourset_group'] = 'tourset_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_tourset' );
// 
//function column_orderby_tourset ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'tourset_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'tourset_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}
?>