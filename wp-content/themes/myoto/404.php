<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php get_header(); ?> 
    <div class="content clearfix">
    	<div class="panelLeft">
            <h1>Page not found</h1>
            <br/>
            <p>
                <?php printf( __( 'You tried going to %1$s, and it doesn\'t exist. All is not lost! You can search for what you\'re looking for.', 'oxygen' ), '<code>' . home_url( esc_url( $_SERVER['REQUEST_URI'] ) ) . '</code>' ); ?>
            </p>
            <br/>
            <?php get_search_form(); // Loads the searchform.php template. ?>            
        </div>        
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>
        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>
