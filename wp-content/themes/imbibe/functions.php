<?php
/**
 * Twenty Twelve functions and definitions.
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
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
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
function myoto_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'myoto' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'myoto', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'header-menu', __( 'Header Menu', 'myoto' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );
        
        add_action( 'init', 'myoto_image_sizes' );
                
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 133, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'myoto_setup' );

function myoto_image_sizes() {
    
}

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'myoto-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'myoto-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'myoto' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'myoto' );

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
		wp_enqueue_style( 'myoto-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'myoto-style', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
//	wp_enqueue_style( 'myoto-ie', get_template_directory_uri() . '/css/ie.css', array( 'myoto-style' ), '20121010' );
//	$wp_styles->add_data( 'myoto-ie', 'conditional', 'lt IE 9' );
        
        wp_enqueue_style('myoto-bootstrap', get_template_directory_uri() .'/assets/css/bootstrap.css');
        wp_enqueue_style('myoto-main', get_template_directory_uri() .'/main.css', array('myoto-bootstrap'), '1.0');
        wp_enqueue_style('myoto-font-style', get_template_directory_uri() .'/fonts/style.css', array('myoto-bootstrap'), '1.0');        
        
        wp_enqueue_script('myoto-bootstrap', get_template_directory_uri() .'/js/bootstrap.js', array('jquery'), '3.0.0', true);
        wp_enqueue_script('myoto-parallax', get_template_directory_uri() .'/js/jquery.parallax.js', array('jquery'), '2.0', true);
        wp_enqueue_script('myoto-fitvids', get_template_directory_uri() .'/js/jquery.fitvids.js', array('jquery'), '1.0.3', true);
        wp_enqueue_script('myoto-unveilEffects', get_template_directory_uri() .'/js/jquery.unveilEffects.js', array('jquery'), '1.0', true);
        wp_enqueue_script('myoto-retina', get_template_directory_uri() .'/js/retina-1.1.0.js', array('jquery'), '1.1.0', true);
        wp_enqueue_script('myoto-fhmm', get_template_directory_uri() .'/js/fhmm.js', array('jquery'), '1.0', true);
        wp_enqueue_script('myoto-bootstrap-select', get_template_directory_uri() .'/js/bootstrap-select.js', array('jquery'), '1.5.3', true);
        wp_enqueue_script('myoto-bootstrap-fancybox', get_template_directory_uri() .'/fancyBox/jquery.fancybox.pack.js', array('jquery'), '2.1.5', true);
        wp_enqueue_script('myoto-application', get_template_directory_uri() .'/js/application.js', array('jquery'), '1.0', true);
        wp_enqueue_script('myoto-flexslider', get_template_directory_uri() .'/js/jquery.flexslider.js', array('jquery'), '2.0', true);
        
        wp_enqueue_script('myoto-custom', get_template_directory_uri() .'/js/custom.js', array('jquery'), '1.0', true);
        
        if(is_home()){
            wp_enqueue_script('myoto-page-index', get_template_directory_uri() .'/js/pages/index.js', array('jquery'), '1.0', true);
        }
        
}
add_action( 'wp_enqueue_scripts', 'myoto_scripts_styles' );

//Making jQuery Google API
function modify_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri() .'/js/jquery-1.10.2.min.js', true, '1.10.2');
        wp_enqueue_script('jquery');
    }
}
add_action('init', 'modify_jquery');

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function myoto_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'myoto' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'myoto_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'myoto_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'myoto' ),
		'id' => 'main-sidebar',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'myoto' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'myoto_widgets_init' );

if ( ! function_exists( 'myoto_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'myoto' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'myoto' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'myoto' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'myoto_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own myoto_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'myoto' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'myoto' ), '<span class="edit-link">', '</span>' ); ?></p>
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
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'myoto' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'myoto' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'myoto' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'myoto' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'myoto' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'myoto_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own myoto_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'myoto' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'myoto' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'myoto' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'myoto' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'myoto' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'myoto' );
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
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function myoto_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'myoto-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'myoto_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'myoto_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function myoto_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'myoto_customize_register' );

function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length(){
    return 55;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function myoto_customize_preview_js() {
	wp_enqueue_script( 'myoto-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'myoto_customize_preview_js' );



/**********************************************************************************/
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

require( get_template_directory() . '/lib/main.php' );

add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
function my_restrict_manage_posts() {
	global $typenow;
	$taxonomy = $typenow.'-category';
        if($taxonomy == 'recipe-category' || $taxonomy == 'article-category'){
            if( $typenow != "page" && $typenow != "post" ){
                    $filters = array($taxonomy);
                    foreach ($filters as $tax_slug) {
                            $tax_obj = get_taxonomy($tax_slug);
                            $tax_name = $tax_obj->labels->name;                            
                            $terms = get_terms($tax_slug);
                            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
                            echo "<option value=''>Show All $tax_name</option>";
                                                        
                            // get parent category
                            foreach ($terms as $term) { 
                                $term_name = $term->name;
                                if($term->parent > 0){
                                   $parent_term =  get_term($term->parent,$taxonomy);
                                   $term_name = $parent_term->name . ' &raquo; ' .  $term_name;
                                }
                                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term_name .' (' . $term->count .')</option>';
                            }
                            echo "</select>";
                    }
            }
        }
}

function custom_post_thubnail_no_caption($post_id = null,$width = null,$height = null){
    custom_post_thumbnail($post_id,$width,$height,true,true,false);
}


function custom_post_thumbnail($post_id = null,$width = null,$height = null,$echo = true,$display_no_image = true,$display_caption=true){
    $thumb_caption = null;
    if($width) $swidth = "width=".$width; else $swidth = '';
    if($height) $sheight = "height='auto'";
    if($post_id == null)
        $post_id = get_the_ID ();
    $res = '';    
    if(get_field('url_thumbnail_image',$post_id)){
        $url_thumbnail_image = get_field('url_thumbnail_image',$post_id);
        if((strpos($url_thumbnail_image,'http://') !== false) || (strpos($url_thumbnail_image,'https://') !== false)){
            $res = "<img ".$swidth." ".$sheight." src='{$url_thumbnail_image}'>";
        }else{
            if(get_post_type($post_id) == 'article'){
                $url_thumbnail_image = home_url().'/'.ltrim($url_thumbnail_image,'/');
                $res = "<img ".$swidth." ".$sheight." src='{$url_thumbnail_image}'>";
            }else{
                $url_thumbnail_image = home_url().'/wp-content/uploads/' . ltrim($url_thumbnail_image,'/');
                $res = "<img ".$swidth." ".$sheight." src='{$url_thumbnail_image}'>";
            }
        }        
    }else{
            $thumb_id = get_post_thumbnail_id($post_id);
            $args = array(
                    'p' => $thumb_id,
                    'post_type' => 'attachment'
                    );
            $thumb_image = get_posts($args);
            $thumb_caption = $thumb_image[0]->post_excerpt;
            if($width && $height){
                $res = get_the_post_thumbnail($post_id,array($width,$height));
            }else{
                $res = get_the_post_thumbnail($post_id,"full");
            }
            if($display_no_image){
                if(!$res){
                    echo '<img src="'.  get_template_directory_uri().'/images/no-image.jpg">';
                }
            }
    }    
    if($echo){
        echo $res;
        if($display_caption){
            if(get_field('feature_image_caption_credit')){
                    echo '<p class="caption" style="margin-top:5px;font-style:italic;text-align:left;font-size:11.5px;">'.get_field('feature_image_caption_credit').'</p>';
            }elseif($thumb_caption){
                echo '<p class="caption" style="margin-top:5px;font-style:italic;text-align:left;font-size:11.5px;">'.$thumb_caption.'</p>';
            }
        }
    }
    else return $res;
}
function custom_post_thumbnail_img($post_id = null,$width=null,$height=null){
    $img = "";
    if($post_id == null)
        $post_id = get_the_ID ();
	$ss = get_field('url_thumbnail_image',$post_id);
    if(get_field('url_thumbnail_image',$post_id)){
        $url_thumbnail_image = get_field('url_thumbnail_image',$post_id);
        if((strpos($url_thumbnail_image,'http://') !== false) || (strpos($url_thumbnail_image,'https://') !== false)){
            $img = $url_thumbnail_image;
        }else{
            if(get_post_type($post_id) == 'article'){
                $url_thumbnail_image = home_url().'/' . ltrim($url_thumbnail_image,'/');
                $url_thumbnail_image = $url_thumbnail_image;
            }else{
                $url_thumbnail_image = home_url().'/wp-content/uploads/' . ltrim($url_thumbnail_image,'/');
                $url_thumbnail_image = $url_thumbnail_image;
            }
            $img = $url_thumbnail_image;
        }
    }else{       
        $thumbnail_id = get_post_thumbnail_id($post_id);
        if($thumbnail_id){
            if($width && $height){
                $thumb = wp_get_attachment_image_src($thumbnail_id,array($width,$height));
            }else
                $thumb = wp_get_attachment_image_src($thumbnail_id,"full");
            
            $img = $thumb[0];
        }else $img =  get_template_directory_uri().'/images/no-image.jpg';
    }    
    return $img;    
}

require_once ( get_stylesheet_directory() . '/theme-options.php' );

$file_log_header_menu = ABSPATH . '/' . 'header-menu.log';
if(!file_exists($file_log_header_menu)){
    function callback_write_header_menu($buffer)
    {
        $file_log_header_menu = ABSPATH . '/' . 'header-menu.log';        
        file_put_contents( $file_log_header_menu , $buffer);
        return '';
    }
    ob_start("callback_write_header_menu");
    get_template_part('pages/partial','menu');
    ob_end_flush();        
}

add_filter('the_content', 'remove_empty_p', 20, 1);
function remove_empty_p($content){
    $content = force_balance_tags($content);
    $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    return str_replace('<p>&nbsp;</p>','', $content);    
}

function get_upgrade_digital_subscription_options(){
  $sub_options         = array();  
  $sub_options         = array();  
  $subscribe_page      = get_page_by_title('Upgrade Print To Digital Subscription');
  if(!$subscribe_page) return array();
  $subscribe_page_id       = $subscribe_page->ID;
  $price = get_field('upgrade_price',$subscribe_page_id);
  $description = get_field('upgrade_description',$subscribe_page_id);
  $sub_options['1-year digital subscription upgrade'] = array($price,$description);
  return $sub_options;
}


function get_subscrip_option($promo){
  $sub_options         = array();  
  $subscribe_page      = get_page_by_title('Subscribe');
  if(!$subscribe_page) return array();
  
  $subscribe_page_id       = $subscribe_page->ID;    
  $load_promotions_options = false;
  if(get_field('promo',$subscribe_page_id)){
      while(has_sub_field('promo',$subscribe_page_id)){
            $promo_name = get_sub_field('name',$subscribe_page_id);            
            if($promo == $promo_name){
				$promo_name = '';
                $load_promotions_options = true;
                if(get_sub_field('1_year_print_subscription_option',$subscribe_page_id)){                
                    while(has_sub_field('1_year_print_subscription_option',$subscribe_page_id)){                    
                        $title = '1-year print '.$promo_name.' subscription';
                        $price = (float)get_sub_field('price',$subscribe_page_id);
                        $description = get_sub_field('description',$subscribe_page_id);
                        $sub_options[$title] = array($price,$description);
                    }
                }
                if(get_sub_field('2_years_print_subscription_option',$subscribe_page_id)){
                    while(has_sub_field('2_years_print_subscription_option',$subscribe_page_id)){
                        $title = '2-year print '.$promo_name.' subscription';
                        $price = (float)get_sub_field('price',$subscribe_page_id);
                        $description = get_sub_field('description',$subscribe_page_id);
                        $sub_options[$title] = array($price,$description);
                    }
                }
                if(get_sub_field('1_year_digital_subscription_option',$subscribe_page_id)){
                    while(has_sub_field('1_year_digital_subscription_option',$subscribe_page_id)){                    
                        $title = '1-year digital '.$promo_name.' subscription';
                        $price = (float)get_sub_field('price',$subscribe_page_id);
                        $description = get_sub_field('description',$subscribe_page_id);
                        $sub_options[$title] = array($price,$description);
                    }
                }
                if(get_sub_field('1_year_print_and_digital_subscription_option',$subscribe_page_id)){
                    while(has_sub_field('1_year_print_and_digital_subscription_option',$subscribe_page_id)){                    
                        $title = '1-year print and digital '.$promo_name.' subscription';
                        $price = (float)get_sub_field('price',$subscribe_page_id);
                        $description = get_sub_field('description',$subscribe_page_id);
                        $sub_options[$title] = array($price,$description);
                    }
                }        
            }
      }
  }
  
  if(!$load_promotions_options){    
    if(get_field('1_year_print_subscription_option',$subscribe_page_id)){
        while(has_sub_field('1_year_print_subscription_option',$subscribe_page_id)){
            $title = '1-year print subscription';
            $price = (float)get_sub_field('price',$subscribe_page_id);
            $description = get_sub_field('description',$subscribe_page_id);
            $sub_options[$title] = array($price,$description);
        }
    }
    if(get_field('2_years_print_subscription_option',$subscribe_page_id)){
        while(has_sub_field('2_years_print_subscription_option',$subscribe_page_id)){
            $title = '2-year print subscription';
            $price = (float)get_sub_field('price',$subscribe_page_id);
            $description = get_sub_field('description',$subscribe_page_id);
            $sub_options[$title] = array($price,$description);
        }
    }
    if(get_field('1_year_digital_subscription_option',$subscribe_page_id)){
        while(has_sub_field('1_year_digital_subscription_option',$subscribe_page_id)){
            $title = '1-year digital subscription';
            $price = (float)get_sub_field('price',$subscribe_page_id);
            $description = get_sub_field('description',$subscribe_page_id);
            $sub_options[$title] = array($price,$description);
        }
    }
    if(get_field('1_year_print_and_digital_subscription_option',$subscribe_page_id)){
        while(has_sub_field('1_year_print_and_digital_subscription_option',$subscribe_page_id)){
            $title = '1-year print and digital subscription';
            $price = (float)get_sub_field('price',$subscribe_page_id);
            $description = get_sub_field('description',$subscribe_page_id);            
            $sub_options[$title] = array($price,$description);
        }
    }
  }  
  return $sub_options;
}


function get_renew_subscription_options($customer_print_sub,$customer_digital_sub){
    //$renew_print_1year, $renew_print_2_years,$renew_digital_1_year,$renew_print_and_digital_1_year
    $sub_options = array();
    $renew_page    = get_page_by_title('Renew');
    $renew_page_id = $renew_page->ID;
    $desc_renew_print_1_year            = get_field('renew_print_1_year',$renew_page_id);
    $desc_renew_print_2_year            = get_field('renew_print_2_year',$renew_page_id);
    $desc_renew_digital_1_year          = get_field('renew_digital_1_year',$renew_page_id);
    $desc_renew_print_and_digital_1_year = get_field('renew_print_and_digital_1_year',$renew_page_id);

    if($customer_print_sub && !$customer_digital_sub){
        $renew_print_1year              = $customer_print_sub['RenewalPrice1YR'];
        $renew_print_2_years            = $customer_print_sub['RenewalPrice2YR'];        
        $desc_renew_print_1_year = str_replace('{price}','$'.$renew_print_1year,$desc_renew_print_1_year);
        $desc_renew_print_2_year = str_replace('{price}','$'.$renew_print_2_years,$desc_renew_print_2_year);
        
        $sub_options['1-year print renewal']  = array($renew_print_1year,$desc_renew_print_1_year);
        $sub_options['2-year print renewal']  = array($renew_print_2_years,$desc_renew_print_2_year);
        $sub_options['1-year digital subscription upgrade'] = array($renew_print_1year + 5,"Renew Print 1 year + One-year digital subscription upgrade - $".($renew_print_1year + 5));
    }
    
    if($customer_print_sub && $customer_digital_sub){
        $renew_print_1year              = $customer_print_sub['RenewalPrice1YR'];
        $renew_print_2_years            = $customer_print_sub['RenewalPrice2YR'];
        $renew_digital_1_year           = $customer_print_sub['RenewalDigital1YR'];
        $renew_print_and_digital_1_year = $customer_print_sub['RenewalPrintDigital1YR'];
        
        $desc_renew_print_1_year = str_replace('{price}','$'.$renew_print_1year,$desc_renew_print_1_year);
        $desc_renew_print_2_year = str_replace('{price}','$'.$renew_print_2_years,$desc_renew_print_2_year);
        $desc_renew_digital_1_year = str_replace('{price}','$'.$renew_digital_1_year,$desc_renew_digital_1_year);
        $desc_renew_print_and_digital_1_year = str_replace('{price}','$'.$renew_print_and_digital_1_year,$desc_renew_print_and_digital_1_year);
        
        $sub_options['1-year print renewal']    = array($renew_print_1year,$desc_renew_print_1_year);
        $sub_options['2-year print renewal']    = array($renew_print_2_years,$desc_renew_print_2_year);
        $sub_options['1-year digital renewal']  = array($renew_digital_1_year,$desc_renew_digital_1_year);
        $sub_options['1-year print and digital renewal']  = array($renew_print_and_digital_1_year,$desc_renew_print_and_digital_1_year);
    }
    
    if(!$customer_print_sub && $customer_digital_sub){
        $sub_options['1-year digital renewal']            = array(20,"Renew Digital 1 year (6 issues) - $20");
        //$sub_options['2-year digital renewal']            = array(40,"Renew Digital 2 year (12 issues) - $40");
        $sub_options['1-year upgrade print subscription'] = array(25,"Renew Digital 1 year + One-year print subscription upgrade - $25");
    }
    
    return $sub_options;
}

function get_invoice_subscriptions_options($promo,$invoice_1yr,$invoice_2yr){
    
    $invoice_page      = get_page_by_title('Invoice');
    $invoice_page_id   = $invoice_page->ID;
    
    $desc_1_year_payup = get_field('1_year_payup',$invoice_page_id);    
    $desc_1_year_payup = str_replace('{price}','$'.$invoice_1yr,$desc_1_year_payup);

    $desc_2_year_payup = get_field('2_year_payup',$invoice_page_id);    
    $desc_2_year_payup = str_replace('{price}','$'.$invoice_2yr,$desc_2_year_payup);

    $desc_1_year_payup_and_upgrade_digital = get_field('1-year_payup_and_upgrade_digital',$invoice_page_id);        
    $desc_1_year_payup_and_upgrade_digital = str_replace('{price}','$'.($invoice_1yr + 5),$desc_1_year_payup_and_upgrade_digital);
    
    $desc_2_year_payup_and_upgrade_digital = get_field('2-year_payup_and_upgrade_digital',$invoice_page_id);    
    $desc_2_year_payup_and_upgrade_digital = str_replace('{price}','$'.($invoice_2yr + 5),$desc_2_year_payup_and_upgrade_digital);
    
    $sub_options = array();
    switch($promo){
        case 'invoice':
                $sub_options['1-year payup print subscription']  = array($invoice_1yr,$desc_1_year_payup);
                $sub_options['2-year payup print subscription']  = array($invoice_2yr,$desc_2_year_payup);
				
                //$sub_options['1-year print subscription plus digital upgrade']  = array($invoice_1yr + 5,$desc_1_year_payup_and_upgrade_digital);
				// change : 4/15/14
				$sub_options['1-year payup print plus digital upgrade']  = array($invoice_1yr + 5,$desc_1_year_payup_and_upgrade_digital);
				
				// disable invoice 2 year + upgrade digital : https://forix.bitrix24.com/workgroups/group/106/tasks/task/view/11962/ see doc file search "Invoice order page ONLY"
                //$sub_options['2-year digital subscription upgrade']  = array($invoice_2yr + 5,$desc_2_year_payup_and_upgrade_digital);
            break;
        case 'invoice2year':
                //$sub_options['1-year digital subscription upgrade']  = array($invoice_2yr,$desc_2_year_payup);
                //$sub_options['2-year digital subscription upgrade']  = array($invoice_2yr + 5,$desc_2_year_payup_and_upgrade_digital);                
                // hardcode by client-request
                $sub_options['2-year payup print subscription']  = array($invoice_2yr,"Two year print subscription amount due - $".$invoice_2yr);
				
				// disable invoice 2 year + upgrade digital : https://forix.bitrix24.com/workgroups/group/106/tasks/task/view/11962/ see doc file search "Invoice order page ONLY"
                //$sub_options['2-year digital subscription upgrade']  = array($invoice_2yr + 5,"Two year print + One-year digital subscription - $".($invoice_2yr + 5));
            break;
    }
    return $sub_options;
}

 function register_session(){
        if( !session_id())
            session_start();
    }

add_action('init','register_session');

add_action('init', 'check_ads_takeover_close');
function check_ads_takeover_close(){
    if(isset($_GET['close_ads_takeover']) && $_GET['close_ads_takeover']){
        $_SESSION['close_ads_takeover'] = 1;       
        echo 'OK'; die;
    }else{
    }
}



add_filter( 'rewrite_rules_array','my_insert_rewrite_rules' );
add_filter( 'query_vars','my_insert_query_vars' );
add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
        
        /*
	if ( ! isset( $rules['(beer-detail)/(\d*)$'] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}else{
            
        }*/
}

// Adding a new rule
function my_insert_rewrite_rules( $rules )
{
    $newrules = array();
    $page_subscribe = get_page_by_title('Subscribe');
    if($page_subscribe){
        $page_subscribe_id = $page_subscribe->ID;
    }else
        $page_subscribe_id = null;
    if($page_subscribe_id){
        if(get_field('promo',$page_subscribe_id)){
            while(has_sub_field('promo',$page_subscribe_id)){
                $name       = get_sub_field('name',$page_subscribe_id);
                $sourcecode = get_sub_field('sourcecode',$page_subscribe_id);
                $active     = get_sub_field('active',$page_subscribe_id);
                if($active)
                  $newrules['('.$name.')$'] = 'index.php?pagename=subscribe&promo=$matches[1]&SourceCode='.$sourcecode;
            }
        }
    }       
    
    $page_gift = get_page_by_title('Gift');
    if($page_gift){
        $page_gift_id = $page_gift->ID;
    }else
        $page_gift_id = null;
    if($page_gift_id){
        if(get_field('gift_promotions',$page_gift_id)){
            while(has_sub_field('gift_promotions',$page_gift_id)){
                $name       = get_sub_field('promo_name',$page_gift_id);
                $sourcecode = get_sub_field('source_code',$page_gift_id);
                $active     = get_sub_field('active',$page_gift_id);
                
                if(!$sourcecode) $sourcecode = $name;
                if($active)
                  $newrules['('.$name.')$'] = 'index.php?pagename=gift&promo=$matches[1]&SourceCode='.$sourcecode;
            }
        }
    }    
    
    return $newrules + $rules;
}

function check_subscribe_promotion_active($check_promo_name){
    $check_active = false;
    $page_subscribe = get_page_by_title('Subscribe');
    if($page_subscribe){
        $page_subscribe_id = $page_subscribe->ID;
    }else
        $page_subscribe_id = null;
    if($page_subscribe_id){
        if(get_field('promo',$page_subscribe_id)){
            while(has_sub_field('promo',$page_subscribe_id)){
                $name       = get_sub_field('name',$page_subscribe_id);
                $sourcecode = get_sub_field('sourcecode',$page_subscribe_id);
                $active     = get_sub_field('active',$page_subscribe_id);
                if($active && $check_promo_name == $name){
                  $check_active = true;
                }
            }
        }
    }
    return $check_active;
}

function check_gift_promotion_active($check_promo_name){
    $check_active = false;
    $page_gift = get_page_by_title('Gift');
    if($page_gift){
        $page_gift_id = $page_gift->ID;
    }else
        $page_gift_id = null;
    if($page_gift_id){
        if(get_field('gift_promotions',$page_gift_id)){
            while(has_sub_field('gift_promotions',$page_gift_id)){
                $name       = get_sub_field('promo_name',$page_gift_id);
                $sourcecode = get_sub_field('source_code',$page_gift_id);
                $active     = get_sub_field('active',$page_gift_id);
                if($active && $check_promo_name == $name){
                  $check_active = true;
                }
            }
        }
    }
    return $check_active;
}


// Adding the id var so that WP recognizes it
function my_insert_query_vars( $vars )
{
    array_push($vars, 'promo');
    array_push($vars, 'SourceCode');
    return $vars;
}

function highLight($text,$sr){
    $keys = explode(" ",$sr);
    $text = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $text);
    return $text;
}