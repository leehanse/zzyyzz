<?php
/* Creating Custom Post Types */
function my_custom_post_car(){
	$labels = array(
		'name'               => _x( 'Car', 'post type general name' ),
		'singular_name'      => _x( 'Car', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Car' ),
		'edit_item'          => __( 'Edit Car' ),
		'new_item'           => __( 'New Car' ),
		'all_items'          => __( 'All Cars' ),
		'view_item'          => __( 'View Car' ),
		'search_items'       => __( 'Search Cars' ),
		'not_found'          => __( 'No cars found' ),
		'not_found_in_trash' => __( 'No cars found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Cars'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our cars and car specific data',
		'public'        => true,
		'menu_position' => 12,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => 'car-category',
                'taxonomies'    => array( 'post_tag' ,'car-category'),
	);
	register_post_type( 'car', $args );	
}
add_action( 'init', 'my_custom_post_car' );

/* Custom Interaction Messages */
function car_updated_messages( $messages ) {
	global $post, $post_ID;
	$messages['car'] = array(
		0 => '', 
		1 => sprintf( __('Car updated. <a href="%s">View car</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Car updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Car restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Car published. <a href="%s">View car</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Car saved.'),
		8 => sprintf( __('Car submitted. <a target="_blank" href="%s">Preview car</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Car scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview car</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Car draft updated. <a target="_blank" href="%s">Preview car</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);
	return $messages;
}
add_filter( 'post_updated_messages', 'car_updated_messages' );

/* Contextual Help */
function car_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if ( 'car' == $screen->id ) {

		$contextual_help = '<h2>Cars</h2>
		<p>Cars show the details of the items that we sell on the website. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p> 
		<p>You can view/edit the details of each car by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';

	} elseif ( 'edit-car' == $screen->id ) {

		$contextual_help = '<h2>Editing cars</h2>
		<p>This page allows you to view/modify car details. Please make sure to fill out the available boxes with the appropriate details (car image) and <strong>not</strong> add these details to the car description.</p>';

	}
	return $contextual_help;
}
add_action( 'contextual_help', 'car_contextual_help', 10, 3 );

function my_taxonomies_car() {
	$labels = array(
		'name'              => _x( 'Car Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Car Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Car Categories' ),
		'all_items'         => __( 'All Car Categories' ),
		'parent_item'       => __( 'Parent Car Category' ),
		'parent_item_colon' => __( 'Parent Car Category:' ),
		'edit_item'         => __( 'Edit Car Category' ), 
		'update_item'       => __( 'Update Car Category' ),
		'add_new_item'      => __( 'Add New Car Category' ),
		'new_item_name'     => __( 'New Car Category' ),
		'menu_name'         => __( 'Car Categories' ),
	);
	$args = array(
                'hierarchical'      => true,
		'labels'            => $labels,		
                'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true
	);
	register_taxonomy( 'car_category', 'car', $args );
}
add_action( 'init', 'my_taxonomies_car', 0 );


/**** CUSTOM LIST PAGE ***/
add_image_size( 'admin-list-thumb', 100, 70, true );
add_filter('manage_car_posts_columns', 'add_car_column', 5);

function add_car_column($cols) { 
//    $cols['car_thumbnail'] = __('Thumbnail Image');
    return $cols;
}

add_action('manage_car_posts_custom_column', 'display_car_column', 5, 2);
function display_car_column($col, $id) {
//    switch($col) {
//        case 'car_thumbnail' :
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

//add_filter( 'manage_edit-car_sortable_columns', 'sort_car' );
//function sort_car( $columns ) {
//    $columns['is_featured'] = 'is_featured';
//    $columns['car_group'] = 'car_group';
//    return $columns;
//}
//
//add_filter( 'request', 'column_orderby_car' );
// 
//function column_orderby_car ( $vars ) {
//    if ( !is_admin() )
//        return $vars;
//    if ( isset( $vars['orderby'] ) && 'is_featured' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'featured', 'orderby' => 'meta_value' ) );
//    }
//    if ( isset( $vars['orderby'] ) && 'car_group' == $vars['orderby'] ) {
//        $vars = array_merge( $vars, array( 'meta_key' => 'car_group', 'orderby' => 'meta_value' ) );
//    }    
//    return $vars;
//}
?>