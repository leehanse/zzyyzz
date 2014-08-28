<?php
include 'wp-load.php';
$categories = $_POST['categories'];
$sub_categories = $_POST['sub_categories'];

foreach($categories as $term){
    if(!term_exists($term , 'car_category' )){
        wp_insert_term(
          $term, // the term 
          'car_category', // the taxonomy
          array(
            'description' => $term,
            'parent'      => 0
          )
        );
    }
}

foreach($sub_categories as $key => $sub_arr){
    $term_parent_name = $categories[$key];
    
    $parent_term = term_exists( $term_parent_name , 'car_category' );  // find parent term
    if($parent_term){
        $parent_term_id = $parent_term['term_id']; // get numeric term id
        if(count($sub_arr)){
            foreach($sub_arr as $child_term){
                wp_insert_term(
                  $child_term, // the term 
                  'car_category', // the taxonomy
                  array(
                    'description'=> $child_term,
                    'parent'=> $parent_term_id
                  )
                );    
            }
        }
    }
}
echo 'OK';