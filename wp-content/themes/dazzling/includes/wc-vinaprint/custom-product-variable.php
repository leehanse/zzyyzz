<?php
   //Display Fields
   add_action( 'woocommerce_product_after_variable_attributes', 'variable_fields', 10, 2 );
   //JS to add fields for new variations
   add_action( 'woocommerce_product_after_variable_attributes_js', 'variable_fields_js' );
   //Save variation fields
   add_action( 'woocommerce_process_product_meta_variable', 'save_variable_fields', 10, 1 );
    
   /**
   * Create new fields for variations
   *
   */
   function variable_fields( $loop, $variation_data ) {
   ?>
<tr>
   <td colspan="2">
      <?php
         // Textarea
         woocommerce_wp_textarea_input(
            array(
                'id' => '_tier_price['.$loop.']',
                'label' => __( 'Tier price', 'woocommerce' ),
                'placeholder' => '',
                'description' => __( 'Enter the custom tier price here. Ex: qty1-price1,qty2-price2', 'woocommerce' ),
                'value' => $variation_data['_tier_price'][0],
            )
         );
         ?>
   </td>
</tr>
<?php
   }
    
   /**
   * Create new fields for new variations
   *
   */
   function variable_fields_js() {
   ?>
<tr>
   <td colspan="2">
      <?php
         // Textarea
         woocommerce_wp_textarea_input(
            array(
               'id' => '_tier_price[ + loop + ]',
               'label' => __( 'Tier price', 'woocommerce' ),
               'placeholder' => '',
               'description' => __( 'Enter the custom tier price here. Ex: qty1-price1,qty2-price2', 'woocommerce' ),
               'value' => $variation_data['_tier_price'][0],
            )
         );
         ?>
   </td>
</tr>
<?php
}
/**
* Save new fields for variations
*
*/

function save_variable_fields( $post_id ) {
    $variable_post_id = $_POST['variable_post_id'];
    // Text Field
    $_tier_price = $_POST['_tier_price'];
    for ( $i = 0; $i < sizeof( $variable_post_id ); $i++ ) :
        $variation_id = (int) $variable_post_id[$i];
        if ( isset( $_tier_price[$i] ) ) {
            update_post_meta( $variation_id, '_tier_price', stripslashes( $_tier_price[$i] ) );
        }
    endfor;    
}