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
         <div class="top-banner">
            <!--
            <div class="logo">
               <a href="/"><img src="http://nemprint.dk/templates/nemprint_2013/images/logo.png" alt="logo" /></a>
            </div>
            -->
             <!--
            <div class="navigation top-bar">
               <div class="moduletable_menu">
                  <ul class="menu">
                     <li class="item-227 deeper parent">
                        <span class="separator">Produkter</span>
                        <ul>
                           <li class="item-264"><a href="/produkter/bannere" ><img src="http://nemprint.dk/images/menu/banner_ny.jpg" alt="Bannere" /><span class="image-title">Bannere</span> </a></li>
                           <li class="item-500"><a href="/produkter/print-af-billetter" ><img src="http://nemprint.dk/images/stories/produkter/billet-ikon.jpg" alt="Billetter" /><span class="image-title">Billetter</span> </a></li>
                           <li class="item-230"><a href="/produkter/brevpapir" ><img src="http://nemprint.dk/images/menu/brevpapir.jpg" alt="Brevpapir" /><span class="image-title">Brevpapir</span> </a></li>
                           <li class="item-506"><a href="/produkter/boger" ><img src="http://nemprint.dk/images/menu/ikon-Bger.jpg" alt="Bøger" /><span class="image-title">Bøger</span> </a></li>
                           <li class="item-433"><a href="/produkter/facade-folie" ><img src="http://nemprint.dk/images/menu/facade folie.png" alt="Facade folie" /><span class="image-title">Facade folie</span> </a></li>
                           <li class="item-104 parent"><a href="/produkter/flyers" ><img src="http://nemprint.dk/images/menu/flyers.jpg" alt="Flyers" /><span class="image-title">Flyers</span> </a></li>
                           <li class="item-231"><a href="/produkter/foldere" ><img src="http://nemprint.dk/images/menu/foldere.jpg" alt="Foldere" /><span class="image-title">Foldere</span> </a></li>
                           <li class="item-232"><a href="/produkter/fotoprint" ><img src="http://nemprint.dk/images/menu/fotoprint.jpg" alt="Fotoprint" /><span class="image-title">Fotoprint</span> </a></li>
                           <li class="item-233"><a href="/produkter/haefter" ><img src="http://nemprint.dk/images/menu/haefter.jpg" alt="Hæfter" /><span class="image-title">Hæfter</span> </a></li>
                           <li class="item-235"><a href="/produkter/klistermaerker" ><img src="http://nemprint.dk/images/menu/stickers.jpg" alt="Klistermærker" /><span class="image-title">Klistermærker</span> </a></li>
                           <li class="item-229"><a href="/produkter/kuverter" ><img src="http://nemprint.dk/images/menu/kuverter.jpg" alt="Kuverter" /><span class="image-title">Kuverter</span> </a></li>
                           <li class="item-236"><a href="/produkter/laminering" ><img src="http://nemprint.dk/images/menu/laminering.jpg" alt="Laminering" /><span class="image-title">Laminering</span> </a></li>
                           <li class="item-237"><a href="/produkter/loesblade" ><img src="http://nemprint.dk/images/menu/losblade.jpg" alt="Løsblade" /><span class="image-title">Løsblade</span> </a></li>
                           <li class="item-238"><a href="/produkter/plakater" ><img src="http://nemprint.dk/images/menu/plakater.jpg" alt="Plakater" /><span class="image-title">Plakater</span> </a></li>
                           <li class="item-240"><a href="/produkter/postkort" ><img src="http://nemprint.dk/images/menu/postkort.jpg" alt="Postkort" /><span class="image-title">Postkort</span> </a></li>
                           <li class="item-241 parent"><a href="/produkter/print-af-rapporter" ><img src="http://nemprint.dk/images/menu/rapporter.jpg" alt="Rapporter" /><span class="image-title">Rapporter</span> </a></li>
                           <li class="item-432"><a href="/produkter/rapporter-med-studierabat" ><img src="http://nemprint.dk/images/produktbaggrund/rapporter m studierabat hos nemprint.png" alt="Rapporter" /><span class="image-title">Rapporter</span> </a></li>
                           <li class="item-228"><a href="/produkter/roll-up" ><img src="http://nemprint.dk/images/menu/Rollup.jpg" alt="Roll-Up" /><span class="image-title">Roll-Up</span> </a></li>
                           <li class="item-242"><a href="/produkter/skilte" ><img src="http://nemprint.dk/images/menu/skilte.jpg" alt="Skilte" /><span class="image-title">Skilte</span> </a></li>
                           <li class="item-243"><a href="/produkter/tekstiltryk" ><img src="http://nemprint.dk/images/menu/tekstiltryk.jpg" alt="Tekstiltryk" /><span class="image-title">Tekstiltryk</span> </a></li>
                           <li class="item-221"><a href="/produkter/visitkort" ><img src="http://nemprint.dk/images/menu/visitkort.jpg" alt="Visitkort" /><span class="image-title">Visitkort</span> </a></li>
                           <li class="item-379 parent"><a href="/produkter/tilbud" ><img src="http://nemprint.dk/images/menu/tilbud.jpg" alt="Tilbud" /><span class="image-title">Tilbud</span> </a></li>
                           <li class="item-505"><a href="/produkter/print-selv" ><img src="http://nemprint.dk/images/menu/ikon_print_selv_og_kopi_02.jpg" alt="Print Selv" /><span class="image-title">Print Selv</span> </a></li>
                        </ul>
                     </li>
                     <li class="item-134"><a href="/sadan-bestiller-du" >Sådan bestiller du</a></li>
                     <li class="item-205 deeper parent">
                        <span class="separator">Support / FAQ</span>
                        <ul>
                           <li class="item-307"><a href="/faq/fragt" >Fragt</a></li>
                           <li class="item-308"><a href="/faq/ean-betaling" >EAN Betaling</a></li>
                           <li class="item-311"><a href="/faq/handelsvilkar" >Handelsvilkår</a></li>
                           <li class="item-312"><a href="/faq/kontakt" >Kontakt</a></li>
                           <li class="item-313"><a href="/faq/min-konto" >Min Konto</a></li>
                           <li class="item-314"><a href="/faq/miljo" >Miljø</a></li>
                           <li class="item-315"><a href="/faq/faq" >FAQ</a></li>
                           <li class="item-316"><a href="/faq/vaegt-beregner" >Vægt Beregner</a></li>
                           <li class="item-325"><a href="/faq/produktionstider" >Produktionstider</a></li>
                           <li class="item-326"><a href="/faq/download" >Download</a></li>
                           <li class="item-399"><a href="/upload-en-fil" >Upload en fil</a></li>
                           <li class="item-431"><a href="/faq/gratis-fil-tjek" >Gratis Fil Tjek</a></li>
                           <li class="item-430"><a href="/faq/papir-storrelser" >Papir Størrelser</a></li>
                           <li class="item-498"><a href="/faq/samarbejdspartnere" >Samarbejdspartnere</a></li>
                           <li class="item-130"><a href="/faq/om-trykfiler" >Om Trykfiler</a></li>
                        </ul>
                     </li>
                  </ul>
               </div>
            </div>
             -->
             <div class="navigation top-bar">
               <div class="moduletable_menu">
                    <?php ubermenu( 'main' ); ?>
               </div>
             </div>
            <div class="cart">
               <div class="moduletable_login">
                  <script type="text/javascript">
                     function toggle() {
                     	var ele = document.getElementById("login_container");
                     	if(ele.style.display == "block") {
                         	ele.style.display = "none";
                       	}
                     	else {
                     		ele.style.display = "block";
                     	}
                     } 
                  </script>
                  <a href="javascript:toggle();" id="click"><img src="http://nemprint.dk/images/log-in-btn.png" alt="login" /></a>
                  <div class="login_container" id="login_container">
                     <br/>
                     <form action="/" method="post" id="login-form" >
                        <fieldset class="userdata">
                           <p id="form-login-username">
                              <input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" style="color:#cccccc;" value="Email adresse" onblur="if (this.value == '') {this.value = 'Email adresse';} else {this.style.color = '#494949';}"
                                 onfocus="if (this.value == 'Email adresse') {this.value = '';} " />
                           </p>
                           <p id="form-login-password">
                              <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" style="color:#cccccc;" value="Adgangskode" onblur="if (this.value == '') {this.value = 'Adgangskode';}else {this.style.color = '#494949';}"
                                 onfocus="if (this.value == 'Adgangskode') {this.value = '';}" />
                           </p>
                           <p id="form-login-remember">
                              <label for="modlgn-remember">Husk mig</label>
                              <input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
                           </p>
                           <input type="submit" name="Submit" class="button" value="Log på" />
                           <input type="hidden" name="option" value="com_users" />
                           <input type="hidden" name="task" value="user.login" />
                           <input type="hidden" name="return" value="aW5kZXgucGhwP0l0ZW1pZD0xMDE=" />
                           <input type="hidden" name="59d0677b810d1b0dc79d030e02e93ec5" value="1" />	
                        </fieldset>
                        <ul>
                           <li>
                              <a href="/component/users/?view=reset">
                              Glemt din adgangskode?</a>
                           </li>
                           <li>
                              <a href="/component/users/?view=remind">
                              Glemt dit brugernavn?</a>
                           </li>
                           <li>
                              <a href="/kundecenter/">
                              Registrer</a>
                           </li>
                        </ul>
                     </form>
                  </div>
               </div>
               <div class="moduletable_cart">
                  <!-- Virtuemart 2 Ajax Card -->
                  <div class="vmCartModule _cart" id="vmCartModule">
                     <div id="hiddencontainer" style=" display: none; ">
                        <div class="container">
                           <div class="prices" style="float: right;"></div>
                           <div class="product_row">
                              <span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>
                           </div>
                           <div class="product_attributes"></div>
                        </div>
                     </div>
                     <!--<div class="vm_cart_products">
                        <div class="container">
                        
                        		</div>
                        </div>-->
                     <div class="total" style="float: right;">
                        Din indkøbskurv er tom <span class="empty">kr. 0,00</span>
                        <script type="text/javascript">
                           jQuery(function($) {
                           $('.show_cart a').attr('href','javascript:alert("Du har ikke noget i indkøbskurven");');
                           });
                        </script>
                     </div>
                     <!--<div class="total_products">Tom kurv</div>-->
                     <div class="show_cart">
                        <a style ="float:right;" href="/indkobskurv">Til betaling</a>
                     </div>
                     <div style="clear:both;"></div>
                     <noscript>
                        Please wait
                     </noscript>
                  </div>
               </div>
            </div>
            <div class="clr"></div>
         </div>
         <div class="clr"></div>
         <div class="separator"></div>
         <div class="clr"></div>