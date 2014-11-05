<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>

<link href='http://fonts.googleapis.com/css?family=Exo:100,200,400,700,200italic,400italic,700italic' rel='stylesheet' type='text/css' />

</head>

<body <?php body_class(); ?>>
<body>            
    <div id="container" class="page-block">
        <div id="header">
            <?php 
                $logo_img = get_field('logo', 'option'); 
                if(!$logo_img){
                    $logo_img = get_template_directory_uri().'/img/logo/logo.gif';
                }
            ?>
            <a href="<?php echo home_url(); ?>" id="logo">
                <img src="<?php echo $logo_img;?>">
            </a>
            <div id="utilities">
                <div id="miniCart">
                        <div class="cartInfo">
                                <div class="general">
                                        <a href="/ae/control/viewCart" id="viewCart" class="cartIcon">View Cart</a>
                                        <span class="divider">|</span>
                                        <span class="checkout">Checkout</span>
                                        <span class="total"><!-- --></span>
                                </div>
                        </div>
                </div>
                <ul class="eclear" id="utilNav">
                    <li><strong>Call &nbsp;<span>1-800-653-1705</span> or <a onclick="javascript:window.open('http://support.envelopes.com/customer/widget/chats/new','_blank','width=475,height=450,resizable=yes');return false;" target="_blank" href="http://support.envelopes.com/customer/widget/chats/new"><span>Click to Chat</span></a></strong></li>
                    <li><a href="http://support.envelopes.com/">Customer Service</a></li>
                    <li class="last"><a href="/ae/control/orderStatus">Order Status</a></li>
                </ul>
            </div>
<!--
            <div id="envelopes_banner">
                <a href="http://www.envelopes.com">
                    <img alt="Action Envelope is now Envelopes.com. Great new name, same great company. Your order history awaits you." src="http://www.actionenvelope.com/html/img/promo/ActionEnvelope_Banner.jpg">
                </a>
            </div>
-->

            <a href="javascript:void(0);" id="subscribeLink"><img class="bannerTop" alt="Join Our Mailing List" src="<?php echo get_template_directory_uri();?>/img/hl/joinOurMailingList.gif"></a>
            <div class="clr"></div>
            
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>            
            
        </div> 
        <div class="separator"></div>
        <div class="clr"></div>