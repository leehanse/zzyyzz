<?php
/**
 * Template Name: Current Issue
 */
?>
<?php
    // new current issues
    $arr_year_exists = array();
    $archive_issues  = array();

    $query = new WP_Query('post_type=issue&paged=1&posts_per_page=999999999');
    while( $query->have_posts() ){
        $query->the_post();
        $year_archive  = get_field('year_archive',get_the_ID());
        $month_archive = get_field('month_archive',get_the_ID());
        $id            = get_the_ID();
        if(!in_array($year_archive, $arr_year_exists)) $arr_year_exists[] = $year_archive;

        if(!isset($archive_issues[$year_archive])) $archive_issues[$year_archive] = array();
        
        $archive_issues[$year_archive][$month_archive] = $id;
    }
    arsort($arr_year_exists);    
    $max_year      = reset($arr_year_exists);
    $arr_key_month = array_keys($archive_issues[$max_year]);
    arsort($arr_key_month);    
    $max_month     = reset($arr_key_month);
    
    $current_issue_id = $archive_issues[$max_year][$max_month];
    
    if($current_issue_id){
        header("Location: ".  get_permalink($current_issue_id));
        exit;    
    }else{
      global $wp_query;
      $wp_query->is_404 = true;
      $wp_query->is_single = false;
      $wp_query->is_page = false;
      include( get_query_template( '404' ) );
      exit();        
    }
?>
