<?php
  add_shortcode('filter_stores', 'sc_filter_stores');
    function sc_filter_stores($atts){ ?>
    <?php 
        $selected_state = isset($_GET['filter_store']) ? $_GET['filter_store'] : null;
        global $wpdb;
        $sql    = 'SELECT DISTINCT state_full as state FROM stores GROUP BY state_full';
        $states = $wpdb->get_results($sql,ARRAY_A);
        $html = '';
        $html.='<form action="'.home_url().'" method="get">';
        $html.='<input type="hidden" name="page_id" value="'.get_the_ID().'"/>';
        $html.='<label for="filter_store">Choose State: </label>';
        $html.='<select name="filter_store" onchange="$(this).parent(\'form\').submit();">';
        if(empty($selected_state))
            $html.='<option value="" selected="selected">Choose a State</option>';
        else
            $html.='<option value="" >Choose a State</option>';
        
        foreach($states as $state){
            if($state["state"] == $selected_state)
                $html.='<option selected="selected" value="'.$state["state"].'">'.$state["state"].'</option>';
            else
                $html.='<option value="'.$state["state"].'">'.$state["state"].'</option>';            
        }
        $html.='</select>';
        $html.='</form>';
        $html.='<p>Please select your state/province from the list above. This is a partial list, and continues to grow as we add more stores. Results will be displayed alphabetically by city, then by zip code.</p>';
        if($selected_state){
            $html.='<table class="uvmtable" width="100%">';
            $html.='<thead>';
            $html.='<tr>';
            $html.='<th>Name</th><th>Address</th><th>City</th><th>Zip</th>';
            $html.='</tr>';
            $html.='</thead>';
            $sql    = 'SELECT * FROM stores WHERE state_full = "' . $selected_state . '" ORDER BY city, zip ASC';
            $results = $wpdb->get_results($sql,ARRAY_A); 
            if(count($results)){
                foreach($results as $row ){
                    $html.='<tr>';
                        $html.='<td>'.$row['name'].'</td>';
                        $html.='<td>'.$row['address'].'</td>';
                        $html.='<td>'.$row['city'].'</td>';
                        $html.='<td>'.$row['zip'].'</td>';
                    $html.='</tr>';
                }
            }else{
                $html .= '<tr><td colspan="4">Not Found Stores</td></tr>';
            }
            $html.='</table>';
        }
        return $html;
} ?>