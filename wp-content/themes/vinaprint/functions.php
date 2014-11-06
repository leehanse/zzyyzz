<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'vinaprint' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'vinaprint', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'vinaprint' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'vinaprint_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function vinaprint_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'vinaprint' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'vinaprint' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'vinaprint-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140711', true );

	$font_url = vinaprint_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'vinaprint-fonts', esc_url_raw( $font_url ), array(), null );

	// Loads our main stylesheet.
	wp_enqueue_style( 'vinaprint-style', get_stylesheet_uri() );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'vinaprint-ie', get_template_directory_uri() . '/css/ie.css', array( 'vinaprint-style' ), '20121010' );
	$wp_styles->add_data( 'vinaprint-ie', 'conditional', 'lt IE 9' );
        
        wp_enqueue_style('vinaprint-main-style', get_template_directory_uri() .'/css/style.css', array(), '1.0');
        wp_enqueue_style('vinaprint-avatark2slideitems-style', get_template_directory_uri() .'/css/avatark2slideitems.css', array(), '1.0');
        wp_enqueue_style('vinaprint-nivo-style', get_template_directory_uri() .'/css/nivo-slider.css', array(), '1.0');
        wp_enqueue_style('vinaprint-vmsite-style', get_template_directory_uri() .'/css/vmsite-ltr.css', array(), '1.0');
        wp_enqueue_style('vinaprint-reset-style', get_template_directory_uri() .'/css/reset.css', array(), '1.0');
        wp_enqueue_style('vinaprint-menu-style', get_template_directory_uri() .'/css/menu.css', array(), '1.0');
        wp_enqueue_style('vinaprint-template-style', get_template_directory_uri() .'/css/template.css', array(), '1.0');
                
        wp_enqueue_script('vinaprint-migrate', get_template_directory_uri() .'/js/jquery-migrate-1.2.1.min.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('vinaprint-nivo', get_template_directory_uri() .'/js/jquery.nivo.slider.js', array('jquery'), '3.0.0', true);

}
add_action( 'wp_enqueue_scripts', 'vinaprint_scripts_styles' );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses vinaprint_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function vinaprint_mce_css( $mce_css ) {
	$font_url = vinaprint_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'vinaprint_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function vinaprint_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'vinaprint' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'vinaprint_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'vinaprint_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_widgets_init() {
    register_sidebar( array(
            'name' => __( 'Main Sidebar', 'vinaprint' ),
            'id' => 'sidebar-1',
            'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'vinaprint' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
    ) );    
}
add_action( 'widgets_init', 'vinaprint_widgets_init' );

if ( ! function_exists( 'vinaprint_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'vinaprint' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'vinaprint' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'vinaprint' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'vinaprint_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own vinaprint_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'vinaprint' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'vinaprint' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'vinaprint' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'vinaprint' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'vinaprint' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'vinaprint' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'vinaprint' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'vinaprint_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own vinaprint_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'vinaprint' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'vinaprint' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'vinaprint' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'vinaprint' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'vinaprint' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'vinaprint' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function vinaprint_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'vinaprint-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'vinaprint_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'vinaprint_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function vinaprint_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'vinaprint_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function vinaprint_customize_preview_js() {
	wp_enqueue_script( 'vinaprint-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130301', true );
}
add_action( 'customize_preview_init', 'vinaprint_customize_preview_js' );


// Register post types
$post_types = glob(__DIR__."/includes/post-types/*.php");
if(count($post_types)){    
    foreach ($post_types as $filename) {
        include $filename;
    }
}

// Register acf metabox file
$acf_files = glob(__DIR__."/includes/acf/*.php");
if(count($acf_files)){    
    foreach ($acf_files as $filename) {
        include $filename;
    }
}
// set value to cart item data
add_filter('woocommerce_add_cart_item_data','vinaprint_add_item_data',1,2);
if(!function_exists('vinaprint_add_item_data'))
{
    function vinaprint_add_item_data($cart_item_data,$product_id)
    {
        $new_value = array('vinaprint_user_custom_data_value' => '1234567');
        return array_merge($cart_item_data,$new_value);        
//        global $woocommerce;
//        session_start();    
//        if (isset($_SESSION['vinaprint_user_custom_data'])) {
//            $option = $_SESSION['vinaprint_user_custom_data'];       
//            $new_value = array('vinaprint_user_custom_data_value' => $option);
//        }
//        if(empty($option))
//            return $cart_item_data;
//        else
//        {    
//            if(empty($cart_item_data))
//                return $new_value;
//            else
//                return array_merge($cart_item_data,$new_value);
//        }
//        unset($_SESSION['vinaprint_user_custom_data']); 
    }
}
// Get cart from session
add_filter('woocommerce_get_cart_item_from_session', 'vinaprint_get_cart_items_from_session', 1, 3 );
if(!function_exists('vinaprint_get_cart_items_from_session'))
{
    function vinaprint_get_cart_items_from_session($item,$values,$key)
    {
        if (array_key_exists( 'vinaprint_user_custom_data_value', $values ) )
        {
        $item['vinaprint_user_custom_data_value'] = $values['vinaprint_user_custom_data_value'];
        }       
        return $item;
    }
}
// display cart checkout page
add_filter('woocommerce_checkout_cart_item_quantity','vinaprint_add_user_custom_option_from_session_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','vinaprint_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('vinaprint_add_user_custom_option_from_session_into_cart'))
{
 function vinaprint_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['vinaprint_user_custom_data_value']) > 0)
        {
            $return_string = $product_name . "</a><dl class='variation'>";
            $return_string .= "<table class='vinaprint_options_table' id='" . $values['product_id'] . "'>";
            $return_string .= "<tr><td>" . $values['vinaprint_user_custom_data_value'] . "</td></tr>";
            $return_string .= "</table></dl>"; 
            return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}
// Add Custom Data as Metadata to the Order Items
add_action('woocommerce_add_order_item_meta','vinaprint_add_values_to_order_item_meta',1,2);
if(!function_exists('vinaprint_add_values_to_order_item_meta'))
{
  function vinaprint_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        $user_custom_values = $values['vinaprint_user_custom_data_value'];
        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'vinaprint_user_custom_data',$user_custom_values);  
        }
  }
}
// Remove User Custom Data, if Product is Removed from Cart
add_action('woocommerce_before_cart_item_quantity_zero','vinaprint_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('vinaprint_remove_user_custom_data_options_from_cart'))
{
    function vinaprint_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
        if ( $values['vinaprint_user_custom_data_value'] == $cart_item_key )
            unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}


add_filter('woocommerce_get_price', 'return_custom_price', $product, 2); 
function return_custom_price($price, $product) {    
    return 9.5;
}

function vinaprint_woocommerce_new_order( $order_id ) {
    $field_key_upload_files     = "field_5459d9dfce31c";
    $field_upload_files_values  = get_field($field_key_upload_files, $order_id);
    
    $order      = new WC_Order( $order_id );
    $line_items = $order->get_items();    
    
    foreach ( $line_items as $item_id => $item ) {
        $_product  = $order->get_product_from_item( $item );
        $item_meta = $order->get_item_meta( $item_id );
        
        $field_upload_files_values[] = array(
            "product"   => $_product->post, 
            "file_list" => array(
                "file" => array(
                    "id"  => 168,
                    "alt" => "",
                    "title" => "visitkort_banner",
                    "caption" => "",
                    "description" => "",
                    "mime_type" => "image/jpeg",
                    "url" => "http://vinaprint.local/wp-content/uploads/2014/11/visitkort_banner.jpg"
                )
            )
        );
    }
    file_put_contents(ABSPATH.'/test.txt', print_r($line_items,true));
    
    update_field( $field_key_upload_files, $field_upload_files_values, $order_id );
}

add_action( 'woocommerce_new_order', 'vinaprint_woocommerce_new_order' );


function vinaprint_hidden_order_item_meta_fields( $fields ) {
    $fields[] = 'vinaprint_user_custom_data';
    return $fields;
}

add_filter( 'woocommerce_hidden_order_itemmeta', 'vinaprint_hidden_order_item_meta_fields' );