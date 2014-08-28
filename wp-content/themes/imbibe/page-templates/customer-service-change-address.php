<?php
/**
 * Template Name: Customer Service Change Address
 */
?>
<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    require_once(get_template_directory() . '/lib/subscribe/includes/functions/general.php');
    $states    = get_states();
    $countries = get_countries();                
    $success = false;
    $error = false;
    if(isset($_POST['flag_submit'])){
        $data = $_POST;
        unset($data['flag_submit']);
        $old_data = array();
        $new_data = array();
        foreach($data as $key=>$value){
            if(strpos($key,'_New') !== false){
                $t_key = str_replace("_New","",$key);
                $new_data[$t_key] = $value;
            }else{
                $old_data[$key] = $value;
            }
        }
    $html  = '<html><body>';
    $html .= get_theme_option('COMPANY_NAME') . ' change of address<br /><br />';  
    $html .= 'OLD ADDRESS:<br/>';
    $html .= '<table>';
    foreach($old_data as $key=>$value){
        $html .='<tr>';
        $html .= '<td>'.$key.'</td>';
        $html .= '<td>'.$value.'</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= "<br/>";    
    $html .= 'NEW ADDRESS:<br/>';
    $html .= '<table>';
    foreach($new_data as $key=>$value){
        $html .='<tr>';
        $html .= '<td>'.$key.'</td>';
        $html .= '<td>'.$value.'</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '</body></html>';
    
    $from      = get_theme_option('COMPANY_NAME');
    $fromemail = "info@imbibemagazine.com";
    $reply     = "info@imbibemagazine.com";

    $subject = "Change Of Address";
    $body    = $html;
    
    /*    
    $headers  = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $from . "\r\n";
    //$headers .= "CC: susan@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";    
    */
    
    $headers  = "Reply-To: $from <$reply>\r\n"; 
    $headers .= "Return-Path: $from <$reply>\r\n"; 
    $headers .= "From: $from <$fromemail>\r\n"; 
    $headers .= "Organization: $from\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $email  = get_theme_option('CUSTOMER_SERVICE_CHANGE_OF_ADDRESS_TO_EMAIL');
    
    $sent   = mail($email,$subject,$body, $headers);
    
    /*
    
    // send code, do not edit unless you know what your doing
    $header  = "Reply-To: $from <$reply>\r\n"; 
    $header .= "Return-Path: $from <$reply>\r\n"; 
    $header .= "From: $from <$fromemail>\r\n"; 
    $header .= "Organization: $from\r\n"; 
    $header .= "Content-Type: text/html\r\n"; 
    
    $email  = get_theme_option('CUSTOMER_SERVICE_CHANGE_OF_ADDRESS_TO_EMAIL');    
    $sent   = mail($email,$subject,$body, $header);              
    */
    
    if($sent){
        $success  = "<h3 style='color:#B0282E;'>Thank you! We've updated your address in our system and your next issue will be mailed to your new address.</h3>";
        $success .= "<p>Questions? Please email subscriptions@imbibemagazine.com.</p>";
        $success .= "<p>Form on ".get_permalink(get_page_by_title('Customer Service')->ID)."</p>";
    }else{
        $error = "Sorry, We can't send email to <subscription@imbibemagazine.com> please contact with our via <info@imbibemagazine.com>";
    }
   }
?>
<html>
    <head>
        <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.metadata.js"></script>
        <title>Change Of Address</title>
        <style>
            body{
                color: #353535;
                font-family: Arial,sans-serif;
                font-size: 13px;
                font-weight: 300;
            }
            .formShop {
                border-bottom: 1px dotted #858585;
                margin-bottom: 30px;
            }
            .formShop h2 {
                color: #555555;
                font-family: Arial,sans-serif;
                font-size: 18px;
                font-weight: normal;
                line-height: 20px;
                margin: 0 0 20px;
            }
            .formShop ul {
            }
            .formShop li {
                margin-bottom: 15px;
                list-style: none;
            }
            .formShop li.field label {
                display: inline-block;
                height: 29px;
                line-height: 29px;
                width: 110px;
            }
            .formShop li.field label span {
                color: #B0282E;
            }
            .formShop li.field input {
                border: 1px solid #BEBEBE;
                height: 22px;
                width: 335px;
            }
            .formShop li.field textarea {
                border: 1px solid #BEBEBE;
                height: 80px;
                width: 335px;
            }
            .formShop li.field select {
                border: 1px solid #BEBEBE;
                padding: 4px 10px;
                width: 337px;
            }
            .formShop li.field.megaSelect select {
                width: 167px;
            }
            .buttonRed {
                margin-left: 150px;
                margin-bottom: 10px;
            }
            .buttonRed a {
                background: none repeat scroll 0 0 #B0282E;
                color: #FFFFFF;
                display: inline-block;
                height: 30px;
                line-height: 30px;
                padding: 0 15px;
                text-transform: uppercase;
                text-decoration: none;
            }
            a.buttonRed {
                background: none repeat scroll 0 0 #B0282E;
                color: #FFFFFF;
                display: inline-block;
                height: 30px;
                line-height: 30px;
                padding: 0 15px;
                text-transform: uppercase;
            }
            ul#tabnav {
                border-bottom: 1px solid #B0282E;
                font-family: Arial,sans-serif;
                font-size: 18px;
                list-style-type: none;
                margin: 1em 0;
                padding: 2px 10px;
                text-align: left;
            }
            ul#tabnav li {
                display: inline;
            }
            body#tab1 li.tab1, body#tab2 li.tab2, body#tab3 li.tab3, body#tab4 li.tab4 {
                background-color: #FFFFFF;
                border-bottom: 1px solid #FFFFFF;
            }
            body#tab1 li.tab1 a, body#tab2 li.tab2 a, body#tab3 li.tab3 a, body#tab4 li.tab4 a {
                background-color: #FFFFFF;
                color: #000000;
                padding-top: 4px;
                position: relative;
                top: 1px;
            }
            ul#tabnav li a {
                -moz-border-bottom-colors: none;
                -moz-border-left-colors: none;
                -moz-border-right-colors: none;
                -moz-border-top-colors: none;
                background-color: #cccccc;
                border-color: #B0282E;
                border-image: none;
                border-style: solid solid none;
                border-width: 1px 1px medium;
                color: #666666;
                margin-right: 0;
                padding: 3px 4px;
                text-decoration: none;
            }
            ul#tabnav a:hover,ul#tabnav a.active {
                background: none repeat scroll 0 0 #FFFFFF;
            }            
            #tab1{
                display: block;
            }
            #tab2{
                display: none;
            }
            label.error{color: red !important; width: auto !important;}
            input.error{border: 1px solid red !important;}
            select.error{border: 1px solid red !important;}
            
            @media only screen and (max-width: 320px) {
                .formShop ul{ padding-left:0px;}
                ul#tabnav{ font-size: 10px;}
                .formShop li.field input{ width: 300px;}
                .formShop li.field select{width: 300px;}
            }
        </style>
        <script type="text/javascript">
            function showtab(id){
                if($(id).size()>0){
                    $(".tab-content").hide();
                    $("#tabnav > li > a").removeClass('active');
                    $("#tabnav > li > a[href="+id+"]").addClass('active');
                    $(id).show();
                }
            }
            $(document).ready(function(){
               $("#tabnav > li > a").click(function(){
                   var href = $(this).attr("href");
                   showtab(href);
                   return false;
               });
            });
        </script>    
    </head>
    <body>
        <?php if($success || $error):?>
            <?php if($success): ?>
                <?php echo $success;?>
            <?php endif;?>
            <?php if($error): ?>
                <h3 style="color:red;"><?php echo $error;?></h3>    
            <?php endif;?>    
        <?php else:?>
        <ul id="tabnav">
            <li class="tab1"><a class="active" href="#tab1">Old Address Information</a></li>
            <li class="tab2"><a href="#tab2">New Address Information</a></li>
        </ul>
        <form action="" method="post" id="main_form">
            <input type="hidden" name="flag_submit" value="1"/>
            <section class="formShop tab-content" id="tab1">
                <ul>                
                    <li class="field">
                        <label>First Name<span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="FirstName" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Last Name<span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="LastName" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Company</label>
                        <input type="text" class="sub_field" value="" name="Company">
                    </li>
                    <li class="field">
                        <label>Address1 <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Address1" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Address2</label>
                        <input type="text" class="sub_field" value="" name="Address2">
                    </li>
                    <li class="field">
                        <label>City <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="City" validate="required:true">
                    </li>
                    <li class="field">
                        <label>State <span class="required">*</span></label>
                        <select name="State" validate="required:true">
                            <?php foreach($states as $k=>$s):?>
                                <option value="<?php echo $k;?>"><?php echo $s;?></option>
                            <?php endforeach;?>
                        </select>
                    </li>
                    <li class="field">
                        <label>Zip <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Zip" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Country <span class="required">*</span></label>
                        <select name="Country" validate="required:true">
                            <?php foreach($countries as $k=>$s):?>
                                <option value="<?php echo $k;?>"><?php echo $s;?></option>
                            <?php endforeach;?>
                        </select>
                    </li>
                </ul>
            </section>
            <section class="formShop tab-content" id="tab2">
                <ul>                
                    <li class="field">
                        <label>First Name<span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="FirstName_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Last Name<span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="LastName_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Company</label>
                        <input type="text" class="sub_field" value="" name="Company_New">
                    </li>
                    <li class="field">
                        <label>Address1 <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Address1_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Address2</label>
                        <input type="text" class="sub_field" value="" name="Address2_New">
                    </li>
                    <li class="field">
                        <label>City <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="City_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>State <span class="required">*</span></label>
                        <select name="State_New" validate="required:true">
                            <?php foreach($states as $k=>$s):?>
                                <option value="<?php echo $k;?>"><?php echo $s;?></option>
                            <?php endforeach;?>
                        </select>
                    </li>
                    <li class="field">
                        <label>Zip <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Zip_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Country <span class="required">*</span></label>
                        <select name="Country_New" validate="required:true">
                            <?php foreach($countries as $k=>$s):?>
                                <option value="<?php echo $k;?>"><?php echo $s;?></option>
                            <?php endforeach;?>
                        </select>
                    </li>
                    <li class="field">
                        <label>Phone <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Phone_New" validate="required:true">
                    </li>
                    <li class="field">
                        <label>Email <span class="required">*</span></label>
                        <input type="text" class="sub_field" value="" name="Email_New" validate="required:true,email:true">
                    </li> 
                    <li class="field">
                        <label>Note</label>
                        <textarea name="Note_New"></textarea>
                    </li>                    
                </ul>                
                <div class="buttonRed">
                    <a href="javascript:void(0);" onclick="tab_validate_process();">Submit</a>
                </div>    
                <br/>
            </section>
        </form>   
        <script type="text/javascript">
            function tab_validate_process(){  
                // show tab1 and validate tab1
                if(!$("#tab1").is(":visible")) showtab("#tab1");
                validate_form_tab1 = tab_validateRules();
                if(validate_form_tab1.form()){
                    if(!$("#tab2").is(":visible")) showtab("#tab2");
                    validate_form_tab2 = tab_validateRules();    
                    if(validate_form_tab1.form()){
                       jQuery("#main_form").submit(); 
                    }else{
                        alert('Please check again data.');
                    }
                }else{
                    alert('Please check again data.');
                }
            }
            function tab_validateRules(){
                jQuery.metadata.setType("attr", "validate");
                return jQuery("#main_form").validate();
            }    

        </script>         
        <?php endif;?>
    </body>
</html>