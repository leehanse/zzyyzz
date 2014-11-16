<?php 
    include('wp-load.php');
    // $query = new WP_Query(array(
    //     "post_type" => "product_variation",
    //     "post_status" => "publish",
    //     "meta_query" => array(
    //         "relation" => "AND",
    //         array(
    //             "key" => "attribute_pa_paper-size",
    //             "value" => 'a3-297-x-420mm',
    //         )
    //     )
    // ));
     
    // print $query->request; 
    vinaprint_admin_filter_variation(110, array(
        "attribute_pa_paper-size" => "a3-297-x-420mm",
        "attribute_pa_print-type" => "10-sort-hvid-en-side",
        "attribute_pa_paper-type" => "120g-mat-coated"
    ));
?>