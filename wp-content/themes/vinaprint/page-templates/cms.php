<?php
/**
 * Template Name: CMS Template
 */
?>

<?php get_header(); ?>
<div id="main_content" class="main_content ">
    <div class="sidebar">
       <div class="moduletable">
          <h3>Produkter</h3>
          <ul class="menu">
             <li class="item-264"><a href="/produkter/bannere"><img alt="Bannere" src="/images/menu/banner_ny.jpg"><span class="image-title">Bannere</span> </a></li>
             <li class="item-500"><a href="/produkter/print-af-billetter"><img alt="Billetter" src="/images/stories/produkter/billet-ikon.jpg"><span class="image-title">Billetter</span> </a></li>
             <li class="item-230"><a href="/produkter/brevpapir"><img alt="Brevpapir" src="/images/menu/brevpapir.jpg"><span class="image-title">Brevpapir</span> </a></li>
             <li class="item-506"><a href="/produkter/boger"><img alt="Bøger" src="/images/menu/ikon-Bger.jpg"><span class="image-title">Bøger</span> </a></li>
             <li class="item-433"><a href="/produkter/facade-folie"><img alt="Facade folie" src="/images/menu/facade folie.png"><span class="image-title">Facade folie</span> </a></li>
             <li class="item-104 parent"><a href="/produkter/flyers"><img alt="Flyers" src="/images/menu/flyers.jpg"><span class="image-title">Flyers</span> </a></li>
             <li class="item-231"><a href="/produkter/foldere"><img alt="Foldere" src="/images/menu/foldere.jpg"><span class="image-title">Foldere</span> </a></li>
             <li class="item-232"><a href="/produkter/fotoprint"><img alt="Fotoprint" src="/images/menu/fotoprint.jpg"><span class="image-title">Fotoprint</span> </a></li>
             <li class="item-233"><a href="/produkter/haefter"><img alt="Hæfter" src="/images/menu/haefter.jpg"><span class="image-title">Hæfter</span> </a></li>
             <li class="item-235"><a href="/produkter/klistermaerker"><img alt="Klistermærker" src="/images/menu/stickers.jpg"><span class="image-title">Klistermærker</span> </a></li>
             <li class="item-229"><a href="/produkter/kuverter"><img alt="Kuverter" src="/images/menu/kuverter.jpg"><span class="image-title">Kuverter</span> </a></li>
             <li class="item-236"><a href="/produkter/laminering"><img alt="Laminering" src="/images/menu/laminering.jpg"><span class="image-title">Laminering</span> </a></li>
             <li class="item-237"><a href="/produkter/loesblade"><img alt="Løsblade" src="/images/menu/losblade.jpg"><span class="image-title">Løsblade</span> </a></li>
             <li class="item-238"><a href="/produkter/plakater"><img alt="Plakater" src="/images/menu/plakater.jpg"><span class="image-title">Plakater</span> </a></li>
             <li class="item-240"><a href="/produkter/postkort"><img alt="Postkort" src="/images/menu/postkort.jpg"><span class="image-title">Postkort</span> </a></li>
             <li class="item-241 parent"><a href="/produkter/print-af-rapporter"><img alt="Rapporter" src="/images/menu/rapporter.jpg"><span class="image-title">Rapporter</span> </a></li>
             <li class="item-432"><a href="/produkter/rapporter-med-studierabat"><img alt="Rapporter" src="/images/produktbaggrund/rapporter m studierabat hos nemprint.png"><span class="image-title">Rapporter</span> </a></li>
             <li class="item-228"><a href="/produkter/roll-up"><img alt="Roll-Up" src="/images/menu/Rollup.jpg"><span class="image-title">Roll-Up</span> </a></li>
             <li class="item-242"><a href="/produkter/skilte"><img alt="Skilte" src="/images/menu/skilte.jpg"><span class="image-title">Skilte</span> </a></li>
             <li class="item-243"><a href="/produkter/tekstiltryk"><img alt="Tekstiltryk" src="/images/menu/tekstiltryk.jpg"><span class="image-title">Tekstiltryk</span> </a></li>
             <li class="item-221"><a href="/produkter/visitkort"><img alt="Visitkort" src="/images/menu/visitkort.jpg"><span class="image-title">Visitkort</span> </a></li>
             <li class="item-379 parent"><a href="/produkter/tilbud"><img alt="Tilbud" src="/images/menu/tilbud.jpg"><span class="image-title">Tilbud</span> </a></li>
             <li class="item-505"><a href="/produkter/print-selv"><img alt="Print Selv" src="/images/menu/ikon_print_selv_og_kopi_02.jpg"><span class="image-title">Print Selv</span> </a></li>
          </ul>
       </div>
       <div class="moduletable">
          <h3>Diverse</h3>
          <ul class="menu">
             <li class="item-447 parent"><a href="/om-nemprint">Om Nemprint</a></li>
             <li class="item-450"><a href="/kontakt">Kontakt</a></li>
             <li class="item-451"><a href="/min-konto">Min Konto</a></li>
             <li class="item-459"><a href="/gratis-fil-tjek">Gratis Fil Tjek</a></li>
          </ul>
       </div>
    </div>
    
    <div class="main_small">                            
        <div class="item-page">            
            <?php while ( have_posts() ) : the_post(); ?>
                    <h1><?php the_title();?></h1>
                    <?php get_template_part( 'content', 'page' ); ?>
                    <?php comments_template( '', true ); ?>
            <?php endwhile; // end of the loop. ?>            
        </div>
    </div>
    <br style="clear:both;">
</div>
<?php get_footer();?>