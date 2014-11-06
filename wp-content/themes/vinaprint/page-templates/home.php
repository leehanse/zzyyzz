<?php
/**
 * Template Name: Home Template
 */
?>

<?php get_header(); ?>

         <?php echo get_template_part('partials/page','banner'); ?>
         <?php 
//                $order_id = 175;
//                $field_key_upload_files     = "field_5459d9dfce31c";
//                $order      = new WC_Order( $order_id );
//                $line_items = $order->get_items();
//                $field_upload_files_values = get_field($field_key_upload_files, $order_id);
//
//                foreach ( $line_items as $item_id => $item ) {
//                    $_product  = $order->get_product_from_item( $item );
//                    echo '<pre>';print_r($_product);echo '</pre>';
//                }
//                
//                
//                $field_key = "field_5459d9dfce31c";
//                $post_id   = 175;
//                $value = get_field($field_key, $post_id);
//                echo '<pre>';print_r($value); echo '</pre>';
//                $value[] = array(
//                    "more_contacts_name" => $row->ContactName, 
//                    "more_contacts_email" => $row->ContactEmail, 
//                    "acf_fc_layout" => "row_1"
//                );
//                $value[] = array(
//                    "more_contacts_name" => $row->ContactName2, 
//                    "more_contacts_email" => $row->ContactEmail2, 
//                    "acf_fc_layout" => "row_2"
//                );
//                update_field( $field_key, $value, $post_id );
         ?>
         <div class="separator" style="margin-bottom:20px;"></div>
         <div class="before_component">
            <div class="moduletable frontmenu">
               <ul class="menu">
                  <?php if(get_field('product_lists')):?>
                    <?php $product_list = get_field('product_lists'); ?>
                    <?php if(count($product_list)): ?>
                        <?php foreach($product_list as $product):?>
                            <li class="item-<?php echo $product->ID;?>">
                                <a href="<?php echo get_permalink($product->ID); ?>" >
                                    <?php echo get_the_post_thumbnail($product->ID, array(140, 136)); ?>
                                    <span class="image-title">
                                        <?php echo get_the_title($product->ID); ?>
                                    </span> 
                                </a>
                            </li>
                        <?php endforeach;?>
                    <?php endif;?>
                  <?php endif;?>
               </ul>
            </div>
            <div class="clr"></div>
         </div>
         <div class="separator" style="margin-bottom:20px;"></div>
         <div class="main_content  home" id="main_content">
            <div class="main">
               <div id="system-message-container"></div>
               <div class="item-page home">
                  <p>&nbsp;</p>
                  <table>
                     <tbody>
                        <tr>
                           <td>
                              <h2 style="margin-right: 0px; margin-bottom: 14px; margin-left: 0px; padding: 0px; direction: ltr; line-height: 1.1;">Hjælp / FAQ</h2>
                              <p style="margin: 0px 0px 17px; padding: 0px; direction: ltr;">Læs om trykfiler, tryksager, leveringstider på dine tryk og meget mere i vores FAQ sektion.</p>
                              <ul>
                                 <li><a href="/faq/min-konto/edit">Min konto</a></li>
                                 <li><a href="/faq/om-trykfiler">Om trykfiler</a></li>
                                 <li><a href="/faq/vaegt-beregner">Vægtberegner</a></li>
                                 <li><a href="/gratis-fil-tjek">Gratis Fil Check</a></li>
                              </ul>
                              <ul>
                                 <li><a href="/component/content/?id=78&amp;Itemid=446">EAN betaling</a></li>
                                 <li><a href="/faq/handelsvilkar">Handelsevilkår</a></li>
                                 <li><a href="/faq/miljo">Miljø</a></li>
                                 <li><a href="/faq/produktionstider">Produktionstider</a></li>
                              </ul>
                              <ul>
                                 <li><a href="/upload-en-fil">Upload en fil</a></li>
                                 <li><a href="/om-nemprint">Om NemPrint.dk</a></li>
                                 <li><a href="/kontakt">Kontakt</a></li>
                                 <li><a href="/faq/faq">FAQ</a></li>
                              </ul>
                           </td>
                           <td><a style="float: right;" href="/selvdesigner"><img src="http://nemprint.dk/images/nemprint_design.gif" alt="nemprint ad" /></a></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <br style="clear:both;" />
         </div>
         <div class="separator" style="margin-bottom:20px;"></div>
         
         <?php echo get_template_part('partials/page','referencer'); ?>
         
<?php get_footer();?>