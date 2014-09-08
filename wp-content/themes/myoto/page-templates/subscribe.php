<?php
/**
 * Template Name: Subscribe Template
 */
?>
<?php    

    $promo = get_query_var('promo');
    $SourceCode = get_query_var('SourceCode');
    if($promo && !isset($_GET['promo'])){
        $arr  = array("promo"=>$promo);
        if($SourceCode)
            $arr["SourceCode"] = $SourceCode;
        $link = add_query_arg($arr,get_permalink());
        header('Location: '.$link);
        exit;
    }
    
    if($_GET['promo'] && $_GET['promo'] != 'renew' && $_GET['promo'] != 'invoice' && $_GET['promo'] != 'subscribe' && $_GET['promo'] != 'upgrade-digital'){
      if(!check_subscribe_promotion_active($_GET['promo'])){
        header('Location: '.get_permalink());
        exit;
      }
    }

    $security_page = get_permalink(get_page_by_title('Security')->ID);
    
    function get_action_url($action){
        $args = array('page_id'=>  get_the_ID());
        if($action)
            $args['action']  = $action;
        
        $tmp_return_url = home_url().add_query_arg($args);
        if ($_SERVER["HTTPS"] == "on"){        
            $tmp_return_url = str_replace('http://','https://', $tmp_return_url);
        }
        return $tmp_return_url;
    }
  define('COMPANY_NAME', get_theme_option('COMPANY_NAME'));                        // name used in titles
  define('CONTACT_EMAIL', get_theme_option('CONTACT_EMAIL'));             // address where order is sent
  define('COMPANY_PHONE', get_theme_option('COMPANY_PHONE'));              // phone number to diplay when PayPal errors appear.
  define('FROM_EMAIL', get_theme_option('FROM_EMAIL'));             // address default where email is sent from
  define('ERROR_EMAIL', get_theme_option('ERROR_EMAIL'));               // address where errors are sent
  /*
        this needs to be a single string.  If you want multiple emails, separate them with commas like this:
        $email->SetBlindCopy('email1@synotac.com,email2@synotac.com,email3@synotac.com');
  */
  define('CONTACT_BCC', get_theme_option('CONTACT_BCC'));               // address where a copy of contacts are blind copied
  define('CONFIRM_BCC', get_theme_option('CONFIRM_BCC'));    // address where a copy of confirm email are blind copied

  define('API_USERNAME',get_theme_option('PAYPAL_API_USERNAME'));
  define('API_PASSWORD',get_theme_option('PAYPAL_API_PASSWORD'));
  define('API_SIGNATURE',get_theme_option('PAYPAL_API_SIGNATURE'));
  define('API_ENDPOINT',get_theme_option('PAYPAL_API_ENDPOINT'));
  define('SUBJECT',get_theme_option('PAYPAL_SUBJECT'));
  define('USE_PROXY',get_theme_option('PAYPAL_USE_PROXY'));
  define('PROXY_HOST',get_theme_option('PAYPAL_PROXY_HOST'));
  define('PROXY_PORT',get_theme_option('PAYPAL_PROXY_PORT'));
  define('PAYPAL_URL',get_theme_option('PAYPAL_URL'));
    
    
    
  define('DB_EMAIL_LOGGING', true);                      // are we logging the contact in the database?
  define('DB_TABLE_NAME', 'orders');                       // name of table where contacts are stored
  define('DOC_ROOT', get_template_directory() .'/lib/subscribe/');  
  define('INCLUDES', DOC_ROOT . 'includes/');
  define('CLASSES', INCLUDES . 'classes/');
  define('FUNCTIONS', INCLUDES . 'functions/');
  define('JS', INCLUDES . 'js/');
  define('PEAR', CLASSES . 'PEAR/');
  
  global $wpdb;
  
  require_once(FUNCTIONS . 'general.php');
  require_once(INCLUDES . 'get_renewal.php');
  
  
  $action = !empty($_GET['action']) ? $_GET['action'] : 'show';
  $action = !empty($_POST['action']) ? $_POST['action'] : $action;
  
  $promo = !empty($_GET['promo']) ? $_GET['promo'] : 'subscribe';
  $promo = !empty($_POST['promo']) ? $_POST['promo'] : $promo;

  $sub_num = !empty($_GET['sn']) ? $_GET['sn'] : '';
  $sub_num = !empty($_POST['SubscriptionNum']) ? $_POST['SubscriptionNum'] : $sub_num;

  $source = !empty($_GET['SourceCode']) ? $_GET['SourceCode'] : 'web';
  $source = !empty($_POST['SourceCode']) ? $_POST['SourceCode'] : $source;
  $_POST['SourceCode'] = $source;
  
  $fill = FALSE;  // default indicating form is not being populated by an initial set of post vars

  $referrer = '';
  
  
  if(get_field('subscription_header_image')){
     $header_image = get_field('subscription_header_image');
  }else
    $header_image  = get_template_directory_uri() .'/images/subscribe/subscribe_header.gif';
    
  
  if(get_field('subscription_sidebar_image')){
    $sidebar_image = get_field('subscription_sidebar_image');
  }else  
    $sidebar_image = get_template_directory_uri() .'/images/subscribe/subscribe_sidebar.jpg';      
  
  // get details from db on this renewal or invoice
  // in order to set form controls (price options)
  if($promo == 'upgrade-digital'){
    $sql        = $wpdb->prepare("SELECT * FROM customer_renewals WHERE SubscriptionNum = %s", $sub_num);
    $fill_form  = $wpdb->get_row($sql,ARRAY_A);    
    if(!$fill_form){
        header('Location: '.  get_permalink(get_page_by_title('Upgrade Print To Digital Subscription')->ID));
        exit;
    }    
    $fill_form['SourceCode'] = $source;
  }
  
  $display_renewal_notification_question = false;
  
  if ($promo == 'renew') {
    $sql                = $wpdb->prepare("SELECT * FROM customer_renewals WHERE SubscriptionNum = %s", $sub_num);
    $customer_print_sub = $wpdb->get_row($sql,ARRAY_A);    

    $sql                  = $wpdb->prepare("SELECT * FROM customer_digitals WHERE SubscriptionNum = %s", $sub_num);
    $customer_digital_sub = $wpdb->get_row($sql,ARRAY_A);    
    
    if(!$customer_print_sub && !$customer_digital_sub){
        header('Location: '.  get_permalink(get_page_by_title('Renew')->ID));
        exit;
    }else{
        if($customer_print_sub){
            $fill_form  = $customer_print_sub;
            if($customer_print_sub['Gift']) $display_renewal_notification_question = true;
        }else{
            $fill_form  = $customer_digital_sub;
            if($customer_digital_sub['Gift']) $display_renewal_notification_question = true;
        }
    }
    
    $last_issue              = $customer_print_sub['LastIssue'];
    $last_issue_digital      = $customer_digital_sub['LastIssue'];
    
    $fill_form['SourceCode'] = $source;
  }
    
   
  if ($promo == 'invoice') {
    //$fill_form = GetInvoice($sub_num);

    $sql        = $wpdb->prepare("SELECT * FROM customer_invoices WHERE SubscriptionNum = %s", $sub_num);        
    $fill_form  = $wpdb->get_row($sql,ARRAY_A); 
    if($fill_form){
      if($fill_form['Gift']){
        $display_renewal_notification_question = true;
      }
    }
    if(!$fill_form){
        header('Location: '.  get_permalink(get_page_by_title('Invoice')->ID));
        exit;
    }
   //  if it's a two year invoice, only provide the 2-year payup level
   if ($fill_form['Type'] == 'S2' || $fill_form['Type'] == 'G2' || $fill_form['Type'] == 'D2') {
     $promo = 'invoice2year';
     $invoice_1yr = $fill_form['AmountDue'];
     $invoice_2yr = $fill_form['AmountDue'];
     $fill_form['SourceCode'] = $source;
   } else {
     $invoice_1yr = $fill_form['AmountDue'];
     $invoice_2yr = $fill_form['UpgradePrice'];
     $fill_form['SourceCode'] = $source;
   }
  }   
  
  // determine if this is a gift (needed to know before processing form controls)
  $gift = !empty($fill_form['Gift']) ? $fill_form['Gift'] : FALSE;  // check the renewal/invoice
  $gift = !empty($_POST['Gift']) ? $_POST['Gift'] : $gift;          // check the post vars   
  
  ###$gift = true;
  //
  // set the options for the subscription from default or from get var
  //require_once(INCLUDES . 'subscribe_options.php');  
  if($promo == 'upgrade-digital'){
      $renew_page_id    = get_page_by_title('Upgrade Print To Digital Subscription')->ID;      
      
      if(get_field('header_image',$renew_page_id))
        $t_header_image   = get_field('header_image',$renew_page_id);
      else $t_header_image = get_template_directory_uri ().'/images/subscribe/subscribe_header.gif';      
      
      if(get_field('sidebar_image',$renew_page_id))
        $t_sidebar_image   = get_field('sidebar_image',$renew_page_id);
      else $t_sidebar_image = get_template_directory_uri ().'/images/subscribe/subscribe_sidebar.jpg';      
      
      $header_image = $t_header_image;
      $sidebar_image = $t_sidebar_image;
	  
	  if(get_field('option_default_for_all_sidebar_image','option')){
		$sidebar_image = get_field('option_default_for_all_sidebar_image','option');
	  }	  
  }elseif($promo == 'invoice' || $promo == 'invoice2year'){
      $renew_page_id    = get_page_by_title('Invoice')->ID;      
      
      if(get_field('header_image',$renew_page_id))
        $t_header_image   = get_field('header_image',$renew_page_id);
      else $t_header_image = get_template_directory_uri ().'/images/subscribe/payinvoice_header.png';      
      
      if(get_field('sidebar_image',$renew_page_id))
        $t_sidebar_image   = get_field('sidebar_image',$renew_page_id);
      else $t_sidebar_image = get_template_directory_uri ().'/images/subscribe/subscribe_sidebar.jpg';      
      
      $header_image = $t_header_image;
      $sidebar_image = $t_sidebar_image;
	  
	  if(get_field('option_default_for_all_sidebar_image','option')){
		$sidebar_image = get_field('option_default_for_all_sidebar_image','option');
	  }
	  
  }elseif($promo == 'renew'){
      $renew_page_id    = get_page_by_title('Renew')->ID;      
      
      if(get_field('header_image',$renew_page_id))
        $t_header_image   = get_field('header_image',$renew_page_id);
      else $t_header_image = get_template_directory_uri ().'/images/subscribe/renew_header.png';      
      
      if(get_field('sidebar_image',$renew_page_id))
        $t_sidebar_image   = get_field('sidebar_image',$renew_page_id);
      else $t_sidebar_image = get_template_directory_uri ().'/images/subscribe/renew_sidebar.jpg';      
      
      $header_image = $t_header_image;
      $sidebar_image = $t_sidebar_image;

	  if(get_field('option_default_for_all_sidebar_image','option')){
		$sidebar_image = get_field('option_default_for_all_sidebar_image','option');
	  }
	  
  }elseif($promo != 'subscribe' && $promo != 'renew' && $promo != 'invoice' && $promo != 'invoice2year'){
    $subscribe_page_id = get_page_by_title('Subscribe')->ID;
    if(get_field('promo')){
        while(has_sub_field('promo',$subscribe_page_id)){
                $promo_name = get_sub_field('name',$subscribe_page_id);
                $t_header_image  = get_sub_field('header_image',$subscribe_page_id);
                $t_sidebar_image = get_sub_field('sidebar_image',$subscribe_page_id);
                if($promo_name == $promo){
                    if($t_header_image)
                        $header_image = $t_header_image;
                    if($t_sidebar_image)
                        $sidebar_image = $t_sidebar_image;
                }
        }
    }
  }
  
  $sub_options         = array();
  $sub_display         = array(); // the form will use this array to display two radio button options
  
  switch($promo){
      case 'upgrade-digital':
            $sub_options = get_upgrade_digital_subscription_options();
          break;
      case 'renew':
            $sub_options = get_renew_subscription_options($customer_print_sub,$customer_digital_sub);
          break;
      case 'invoice':
            $sub_options = get_invoice_subscriptions_options('invoice',$invoice_1yr,$invoice_2yr);            
          break;
      case 'invoice2year':
            $sub_options = get_invoice_subscriptions_options('invoice2year',$invoice_1yr,$invoice_2yr);            
          break;          
      default:
          $sub_options = get_subscrip_option($promo);
  }  
  //echo '<pre>'; print_r($sub_options); die;
  
  $sub_display = array(); // the form will use this array to display two radio button options
    foreach ($sub_options as $key => $array) {
    $sub_display[$key] = $array[1];
  }
  
  // set promo back to regular 'invoice' if switched to special 2-year scenario
  $promo = ($promo == 'invoice2year') ? 'invoice' : $promo;

  $states = get_states();
  $countries = get_countries();
  $years = get_years();
  $months = get_months();
  $cards = array ( '' => 'Choose Card Type',
                  'Visa' => 'Visa',
                  'MasterCard' => 'MasterCard',
                  'Amex' => 'American Express',
                  'Discover' => 'Discover',
                  'PayPal' => 'PayPal',
                 );

  $referral_options = array ('' => 'Choose one',
                'Blog' => 'Blog',
                'Event' => 'Event',
                'Bar/Industry' => 'Bar/Industry',
                'Internet Search' => 'Internet Search',
                'Newsstand' => 'Newsstand',
                'Sample Copy' => 'Sample Copy',
                'Social Network/Online Forums' => 'Social Network/Online Forums',
                'Radio/Television/Newspaper' => 'Radio/Television/Newspaper',
                'Word of Mouth' => 'Word of Mouth',
                'Other' => 'Other',
               );

  
  require_once(INCLUDES . 'subscribe_form.php');
  
  ###require_once(INCLUDES . 'gift_form.php');
  
  if($_GET['promo'] == 'upgrade-digital') $_GET['sub'] = 'upgrade-digital';
  
  if(isset($_GET['sub'])){
     switch($_GET['sub']){
         case 'upgrade-digital':
                $form['SubType']['value'] = '1-year digital upgrade subscription';
             break;
         case 'print':
                $form['SubType']['value'] = '1-year print subscription'; 
            break;
        case 'digital':
                $form['SubType']['value'] = '1-year digital subscription'; 
            break;
        case 'print-and-digital':
                $form['SubType']['value'] = '1-year print and digital subscription'; 
            break;
     }     
  }
  
  // leech mini-form
  if(isset($_POST['from'])){
      $form['ShiptoFirstName']['value'] = isset($_POST['ShiptoFirstName']) ? $_POST['ShiptoFirstName'] : '';
      $form['ShiptoLastName']['value'] = isset($_POST['ShiptoLastName']) ? $_POST['ShiptoLastName'] : '';
      $form['ShiptoCompany']['value'] = isset($_POST['ShiptoCompany']) ? $_POST['ShiptoCompany'] : '';
      $form['ShiptoAddress1']['value'] = isset($_POST['ShiptoAddress1']) ? $_POST['ShiptoAddress1'] : '';
      $form['ShiptoAddress2']['value'] = isset($_POST['ShiptoAddress2']) ? $_POST['ShiptoAddress2'] : '';
      $form['ShiptoCity']['value'] = isset($_POST['ShiptoCity']) ? $_POST['ShiptoCity'] : '';
      $form['ShiptoState']['value'] = isset($_POST['ShiptoState']) ? $_POST['ShiptoState'] : '';
      $form['ShiptoZip']['value'] = isset($_POST['ShiptoZip']) ? $_POST['ShiptoZip'] : '';
      $form['Email']['value'] = isset($_POST['Email']) ? $_POST['Email'] : '';
      $form['ShiptoCountry']['value'] = isset($_POST['ShiptoCountry']) ? $_POST['ShiptoCountry'] : '';
      $form['Phone']['value'] = isset($_POST['Phone']) ? $_POST['Phone'] : '';
      $form['SubType']['value'] = isset($_POST['SubType']) ? $_POST['SubType'] : '';
  }
  // All sites must have the following define and then include the email class.
  define('_VALID_INCLUDE', 1);

  define('PAGE_NAME', basename($_SERVER['PHP_SELF']));  // this page
  // MAKE SURE THIS IS SET TO "FALSE" FOR PRODUCTION.  // GOLIVE
  define('DISPLAY_ERRORS', true);

  // Formbot fighting constants.
  define('TIME_HUMAN', 5);    // minimum time in seconds for humans to fill out form

  // Some sites may set this in .htaccess, but if not, include the line below.
  ini_set('include_path', '.' . PATH_SEPARATOR . PEAR);

  // Set error reporting and display.
  // error_reporting(E_ALL);
  // ini_set('display_errors', DISPLAY_ERRORS);
  // Require the email class.
  require_once(CLASSES . 'email.php');

  // Initialize the form control definitions. Validate required array
  // elements and initialize ones such as "error" and "ctl_value".
  
  foreach ($form as $fc_name => $fc_def) {
    $form[$fc_name]['error'] = false;
    if (empty($fc_def['required'])) $form[$fc_name]['required'] = false;
    if (empty($fc_def['label'])) $form[$fc_name]['label'] = '';
    switch ($fc_def['type']) {
      case 'text':
        $form[$fc_name]['ctl_value'] = !empty($fc_def['value']) ? $fc_def['value'] : '';
        break;
      case 'textarea':
        $form[$fc_name]['ctl_value'] = !empty($fc_def['value']) ? $fc_def['value'] : '';
        if (empty($fc_def['cols']) || empty($fc_def['rows'])) {
          error_log('Missing "cols" or "rows" on "' . $fc_name . '" textarea control in ' . COMPANY_NAME . ' contact form ' . print_r($form, true), 1, ERROR_EMAIL);
          exit('Missing "cols" or "rows" on "' . $fc_name . '" textarea control. FATAL ERROR--form processing terminated.');
        }
        break;
      case 'hidden':
        $form[$fc_name]['ctl_value'] = !empty($fc_def['value']) ? $fc_def['value'] : '';
        break;
      case 'select':
        if (empty($fc_def['options'])) {
          error_log('Missing "options" on "' . $fc_name . '" select control in ' . COMPANY_NAME . ' contact form ' . print_r($form, true), 1, ERROR_EMAIL);
          exit('Missing "options" on "' . $fc_name . '" select control. FATAL ERROR--form processing terminated.');
        }
        if (!empty($fc_def['parm']) && !is_array($fc_def['parm'])) {
          error_log('"parm" on ' . $fc_name . '" select control not an array in ' . COMPANY_NAME . ' contact form ' . print_r($form, true), 1, ERROR_EMAIL);
          exit('"parm" on ' . $fc_name . '" select control not an array. FATAL ERROR--form processing terminated.');
        }
        $fc_value = !empty($fc_def['value']) ? $fc_def['value'] : '';
        if (!array_key_exists($fc_value, $fc_def['options'])) {
          $option_keys = array_keys($fc_def['options']);
          $fc_value = $option_keys[0];
        }
        
        $form[$fc_name]['ctl_value'] = $fc_value;
        break;
      case 'radio':
        if (empty($fc_def['options'])) {
          error_log('Missing "options" on "' . $fc_name . '" radio control in ' . COMPANY_NAME . ' contact form ' . print_r($form, true), 1, ERROR_EMAIL);
          exit('Missing "options" on "' . $fc_name . '" radio control. FATAL ERROR--form processing terminated.');
        }
        if (!empty($fc_def['parm']) && !is_array($fc_def['parm'])) {
          error_log('"parm" on ' . $fc_name . '" radio control not an array in ' . COMPANY_NAME . ' contact form ' . print_r($form, true), 1, ERROR_EMAIL);
          exit('"parm" on ' . $fc_name . '" radio control not an array. FATAL ERROR--form processing terminated.');
        }
        $fc_value = !empty($fc_def['value']) ? $fc_def['value'] : '';
        if (!array_key_exists($fc_value, $fc_def['options'])) {
          $option_keys = array_keys($fc_def['options']);
          $fc_value = $option_keys[0];
        }
        $form[$fc_name]['ctl_value'] = $fc_value;
        break;
      case 'checkbox':
        $form[$fc_name]['ctl_value'] = !empty($fc_def['value']) ? 'on' : '';
        break;
      default:
        error_log('Unknown form control type on "' . $fc_name . '" in contact form for ' . COMPANY_NAME . print_r($form, true), 1, ERROR_EMAIL);
        exit('Unknown form entry type on "' . $fc_name . '". FATAL ERROR--form processing terminated.');
    }
  }   // end foreach $form  
  
  $error = '';


  // check for formbot attacks
  if ($action == 'process') {
    $start_time = !empty($_POST['time']) ? (int)$_POST['time'] : 0;
    $elapsed_time = time() - $start_time;
    if (!$start_time || ($elapsed_time < TIME_HUMAN)) {
      $attack_reason = 'time';
 /* removing the county check, had a bug that was catching legitimate users
    If forbot attacks need to be filtered in the future, try putting this back with something other than county,
    because it was picking up the ShiptoState code somehow and might be tied to autofill...
    } elseif (!array_key_exists('county', $_POST) || $_POST['county']) {
      $attack_reason = 'county';
*/
    } else {
      $attack_reason = '';
    }
    if ($attack_reason) {
      // clear credit card number!
      unset($_POST['card_number']);
      error_log('Formbot attack (' . $attack_reason . ') on ' . COMPANY_NAME . print_r($_POST, true), 1, ERROR_EMAIL);
      $error = 'An error occurred processing your entry. Please try again.';
      $_POST = array();
      $action = 'show';
    }
  }   // end checking for attack 
 // modify $fill_form ex: state=> None
 
 if(!$fill_form['State']) $fill_form['State'] = 'None';     
 if(!$fill_form['ShiptoState'])  $fill_form['ShiptoState'] = 'None';
 
 if($fill_form['Contact'] && strtolower($fill_form['Contact']) == 'yes') $fill_form['Contact'] = 'y';
 else $fill_form['Contact'] = 'n';
   
 // if this is the initial load of the invoice or renewal, stuff the data from the db into post vars to be displayed
  if ($action == 'fill') {
    $_POST = $fill_form;
    $fill = TRUE;
    $action = 'process';
  }

  // probably human generated form so process
  if ($action == 'process' || $action == 'process_mini') {
    unset($_POST['action']);
    unset($_POST['time']);
/* see note above about removal of county formot check
    unset($_POST['county']);
*/
    unset($_POST['submit']);
    unset($_POST['Submit']);
    $error = '';
    $action = 'process';


    // Clean each post variable
    $post_vars = array();
    // DEBUG print_r($_POST);
    foreach ($_POST as $post_name => $post_value) {
      // get rid of slashes if magic quotes on
      if (get_magic_quotes_gpc()) $post_value = stripslashes($post_value);
      $post_value = trim($post_value);
      $post_vars[$post_name] = $post_value;
    }   // end processing POSTed values

    // Clean each get variable
    $get_vars = array();
    foreach ($_GET as $get_name => $get_value) {
      // get rid of slashes if magic quotes on
      if (get_magic_quotes_gpc()) $get_value = stripslashes($get_value);
      $get_value = trim($get_value);
      $get_vars[$get_name] = $get_value;
    }   // end cleaning GET values

    $attack_reason = '';


    // trim spaces and hyphens off of credit card number
    $remove = array("", "-", "/");
    if (!empty($post_vars['card_number'])) {
      $post_vars['card_number'] = str_replace ($remove, "", $post_vars['card_number']);
    }



    // Set up miniform correctly
    if (isset($get_vars['miniform'])) {
      $referrer = 'miniform';
      unset($get_vars['mini']);
      $get_vars['SourceCode'] = 'miniform';
    }
    
    if(empty($post_vars['ShiptoZip'])) $post_vars['ShiptoZip'] = '0000';
    if(empty($post_vars['Zip']))       $post_vars['Zip'] = '0000';            
    
    // Process POSTed values in form
    foreach ($form as $fc_name => $fc_def) {
      // use isset() in following rather than !empty() because empty values
      // are valid and include things like '0' (string with zero in it)
      $post_value = isset($post_vars[$fc_name]) ? $post_vars[$fc_name] : '';
      // DEBUG echo '<br /> post value is: ' . $post_value;
      // check required data
      // don't check required data if it was imported off of the mini form
      if ($referrer != 'miniform') {
        if ($fc_def['required']
            && (empty($post_value) || !preg_match('/\S/', $post_value))) {
        // don't require Card Number, Expiration month/year, and CVV if paying by PayPal
          if (!empty($post_vars['CardType']) && $post_vars['CardType'] == 'PayPal'
          && ($fc_name == 'card_number' || $fc_name == 'exp_month' || $fc_name == 'exp_year' || $fc_name == 'cvv')) {
          break;
        } else {
          $place = ($fc_def['label']) ? $fc_def['label'] : $fc_def['text'];
          $error .= $place . ' is blank; please fill in and resubmit<br />';
          $form[$fc_name]['error'] = true;
          // if the form is being filled for the first time, don't list all the blank fields
          if ($fill) {
            $error = 'Please fill in all required fields.';
          }
          $action = 'show';
              }
            }
      }   // end checking required data


      // check for standard email address (one "@" symbol)
      // take only characters ahead of first \n in non-textarea fields
      if ($fc_name == 'Email') {
        if (substr_count($post_vars['Email'], '@') != 1) {
          $error .= 'Email address provided is not valid.  Please provide a standard email address.<br />';
          $action = 'show';
        }
      }
      // take only characters ahead of first \n in non-textarea fields
      if ($form[$fc_name]['type'] != 'textarea') {
        $tmp = explode("\n", $post_value);
        $post_value = $tmp[0];
      }


      switch ($fc_def['type']) {
      case 'text':
      case 'textarea':
        if (!empty($post_value)) $form[$fc_name]['ctl_value'] = $post_value;
        break;
      case 'hidden':
        if ($post_value != $fc_def['ctl_value'] && FALSE) {  // supressed error, deemed not a critical check
          $attack_reason = 'hidden control';
        } else {
          $form[$fc_name]['ctl_value'] = $post_value;
        }
        break;
      case 'radio':
      case 'select':
        if($post_value){
            if (!array_key_exists($post_value, $fc_def['options']) && FALSE) {  // supressed error, deemed not a critical check
            $attack_reason = 'select control' . $fc_def['label'];
            } else {
            $form[$fc_name]['ctl_value'] = $post_value;
            }
        } 
        break;
      case 'checkbox':
        $form[$fc_name]['ctl_value'] = $post_value ? 'on' : '';
      }   // end processing form control type
    }   // end foreach $form

    if ($attack_reason) {
      exit($attack_reason);
      error_log('Formbot attack (' . $attack_reason . ') on ' . COMPANY_NAME . print_r($_POST, true), 1, ERROR_EMAIL);
      $error = 'An error occurred processing your entry. Please try again.';
      $_POST = array();
      $action = 'show';
    }
  }   // end validating form data
  
  // if coming from mini form, don't continue processing!  stop and show the form for completion.
      if ($referrer == 'miniform') {
        $error = 'Please provide additional required information.';
        $action = 'show';
      }

  
  // Valid form data. Process the payment, log it in db, send order email, and send confirmation email
  if ($action == 'process') {
    // calculate the price from SubType and ShiptoCountry ($20 more/yr if outside U.S.)
    $type = strtolower($post_vars['SubType']);
    $order_years = substr($type, 0 , 1);
    $domestic_price = $sub_options[$type][0];
    // HOWEVER, renewals and invoices already have prices set for int'l shipping, so don't add shipping when promo is renew or invoice
    if ($promo != 'renew' && $promo != 'invoice' && strpos($type,'print') !== false) {
        $intl_price = $domestic_price+($order_years*20); // add $20 per year for international shipping
    } else {
        $intl_price = $domestic_price;
    }
    $post_vars['Price'] = ($post_vars['ShiptoCountry'] == 'US') ? $domestic_price : $intl_price;
  }
  
  if ($action == 'process' || $action == 'return') {
    // prepare for communication with paypal
    require_once(INCLUDES . 'php_nvp/CallerService.php');
    require_once(INCLUDES . 'php_nvp/constants.php');
    $IP = $_SERVER['REMOTE_ADDR'];
  }
    
    /*** PROCESS PAYMENT **/
    if ($action == 'process') {
        // send off to paypal through DirectPayment (using credit card) or Express (paying through PayPal interface)
        // ********************** api calls ******************************
        if ($post_vars['CardType'] != 'PayPal') {
            /**
            * DoDirectPayment
            */
            $resArray = array();

            $paymentType =urlencode('Sale');
            $firstName =urlencode($post_vars['FirstName']);
            $lastName =urlencode($post_vars['LastName']);
            $creditCardType =urlencode($post_vars['CardType']);
            $creditCardNumber = urlencode($post_vars['card_number']);
            $expDateMonth =urlencode($post_vars['exp_month']);
            $expDateYear =urlencode( $post_vars['exp_year']);
            $cvv2Number = urlencode($post_vars['cvv']);
            $address1 = urlencode($post_vars['Address1']);
            $address2 = urlencode($post_vars['Address2']);
            $city = urlencode($post_vars['City']);
            $state =urlencode($post_vars['State']);
            $zip = urlencode($post_vars['Zip']);
            $amount = urlencode($post_vars['Price']);
            $currencyCode="USD";
            $country = urlencode($post_vars['Country']);
            $shiptoname = urlencode($post_vars['ShiptoFirstName'] . ' ' . $post_vars['ShiptoLastName']);
            $shiptostreet = urlencode($post_vars['ShiptoAddress1']);
            $shiptostreet2 = urlencode($post_vars['ShiptoAddress2']);
            $shiptocity = urlencode($post_vars['ShiptoCity']);
            $shiptostate = urlencode($post_vars['ShiptoState']);
            $shiptozip = urlencode($post_vars['ShiptoZip']);
            $shiptocountry = urlencode($post_vars['ShiptoCountry']);
            $description = urlencode($post_vars['SubType']);

            /* Construct the request string that will be sent to PayPal.
            The variable $nvpstr contains all the variables and is a
            name value pair string with & as a delimiter */
            $nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $expDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
            "&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode&SHIPTONAME=$shiptoname&SHIPTOSTREET=$shiptostreet&SHIPTOSTREET2=$shiptostreet2&SHIPTOCITY=$shiptocity&SHIPTOSTATE=$shiptostate&SHIPTOZIP=$shiptozip&SHIPTOCOUNTRYCODE=$shiptocountry&DESC=$description";

            /* Make the API call to PayPal, using API certificate.
            The API response is stored in an associative array called $resArray */
            $resArray=hash_call("doDirectPayment",$nvpstr);


        /* Display the API response back to the browser.
        If the response from PayPal was a success, display the response parameters'
        If the response was an error, display the errors received using APIError.php.  Note - since sessions are not being used, APIError.php is not called.  Errors are processed in subscribe.php file.
        */

        if (empty($resArray['ACK'])) {
                $error .= 'If you continue to experience problems ordering online, call toll-free at ' . COMPANY_PHONE . '.';
            $action = 'show';
        }

            // check for Ack response and error code. If errors, processing stops and form displayed with error message
            if ($resArray['ACK'] == 'Failure' || $resArray['ACK'] == 'FailureWithWarning') {
                $error = '';
                $count=0;
                while (isset($resArray["L_SHORTMESSAGE".$count])) {
                    $errorCode    = $resArray["L_ERRORCODE".$count];
                    $shortMessage = $resArray["L_SHORTMESSAGE".$count];
                    $longMessage  = $resArray["L_LONGMESSAGE".$count];
                    $count=$count+1;
                $error .= $longMessage . '<br />';
                }
                    $error .= 'If you continue to experience problems ordering online, call toll-free at ' . COMPANY_PHONE . '.';
                $action = 'show';
            }
            $transaction_id = (!empty($resArray['TRANSACTIONID'])) ? $resArray['TRANSACTIONID'] : '';

        } else {
            /**
            *  Set Express Checkout
            */
            /* The servername and serverport tells PayPal where the buyer
            should be directed back to after authorizing payment.
            In this case, its the local webserver that is running this script
            Using the servername and serverport, the return URL is the first
            portion of the URL that buyers will return to after authorizing payment
            */
            $serverName = $_SERVER['SERVER_NAME'];
            $serverPort = $_SERVER['SERVER_PORT'];
            
            $tmp_return_url = add_query_arg(array('page_id'=>  get_the_ID(),'action'=>'return'));
            
            $url = get_action_url('return');
            
            $paymentAmount=$post_vars['Price'];
            $currencyCodeType='USD';
            $paymentType='Sale';
            $description=$post_vars['SubType'];

            // send off to PayPal with get vars with all of the form info that will be needed to process upon return
            // set up string of get vars from the post vars that will be appended to the return/cancel urls below
            // PROBABLY BETTER TO DYNAMICALLY PULL THIS LIST FROM THE FORM CONTROLS, BUT IN THE MEANTIME, HERE ARE THE NECESSARY FIELDS
            // MISSING: SourceCode
            
	    foreach($post_vars as $p_key => $p_item){
                $post_vars[$p_key] = str_replace('&','%26',$p_item);
            }
            
            $post_string = '&Price=' . $post_vars['Price'] . '&SubType=' . $post_vars['SubType'] . '&ShiptoFirstName=' . $post_vars['ShiptoFirstName'] . '&ShiptoLastName=' . $post_vars['ShiptoLastName'] . '&ShiptoCompany=' . $post_vars['ShiptoCompany'] . '&ShiptoAddress1=' . $post_vars['ShiptoAddress1'] . '&ShiptoAddress2=' . $post_vars['ShiptoAddress2'] . '&ShiptoCity=' . $post_vars['ShiptoCity'] . '&ShiptoState=' . $post_vars['ShiptoState'] . '&ShiptoZip=' . $post_vars['ShiptoZip'] . '&ShiptoCountry=' . $post_vars['ShiptoCountry'] . '&FirstName=' . $post_vars['FirstName'] . '&LastName=' . $post_vars['LastName'] . '&Company=' . $post_vars['Company'] . '&Address1=' . $post_vars['Address1'] . '&Address2=' . $post_vars['Address2'] . '&City=' . $post_vars['City'] . '&State=' . $post_vars['State'] . '&Zip=' . $post_vars['Zip'] . '&Country=' . $post_vars['Country'] . '&Phone=' . $post_vars['Phone'] . '&Email=' . $post_vars['Email'] . '&Contact=' . $post_vars['Contact'] . '&Newsletter=' . $post_vars['Newsletter'] . '&Referred=' . $post_vars['Referred'] . '&CardType=' . $post_vars['CardType'];
            // if this is a renewal or invoice, also pass along the Customer Number and Subscription Number
            if (!empty($post_vars['CustomerNum']) && !empty($post_vars['SubscriptionNum'])) {
                $post_string .= '&CustomerNum=' . $post_vars['CustomerNum'] . '&SubscriptionNum=' . $post_vars['SubscriptionNum'];
            }

            if(!empty($post_vars['DigitalPassword'])){
                $post_string .= '&DigitalPassword=' . $post_vars['DigitalPassword'];
            }
            if(!empty($post_vars['NumberIssues'])){
                $post_string .= '&NumberIssues=' . $post_vars['NumberIssues'];
            }
            if(!empty($post_vars['is_digital_subscription'])){
                $post_string .= '&is_digital_subscription=' . $post_vars['is_digital_subscription'];
            }
            if(!empty($post_vars['is_print_subscription'])){
                $post_string .= '&is_print_subscription=' . $post_vars['is_print_subscription'];
            }

            /* The returnURL is the location where buyers return when a
            payment has been succesfully authorized.
            The cancelURL is the location buyers are sent to when they hit the
            cancel button during authorization of payment during the PayPal flow
            */
            
            $returnURL = urlencode($url.'&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType.'&paymentAmount='.$paymentAmount.$post_string);
            $cancelURL = get_action_url('cancel');
            
            /* Construct the parameter string that describes the PayPal payment
            the varialbes were set in the web form, and the resulting string
            is stored in $nvpstr
            */
            $nvpstr="&Amt=".$paymentAmount."&PAYMENTACTION=".$paymentType."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&NoShipping=1&DESC=".$description;

            /* Make the call to PayPal to set the Express Checkout token
            If the API call succeded, then redirect the buyer to PayPal
            to begin to authorize payment.  If an error occured, show the
            resulting errors
            */
            $resArray=hash_call("SetExpressCheckout",$nvpstr);
            $ack = strtoupper($resArray["ACK"]);
            
            if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){  //GOLIVE remove .sandbox. from url below and change to live imibe (https) urls
                // Redirect to paypal.com here
                $token = urldecode($resArray["TOKEN"]);
                //$payPalURL = PAYPAL_URL.$token;
                $tmp_return_url = get_action_url('return');
                $tmp_cancel_url = get_action_url('cancel');
                
                $tmp_url        = PAYPAL_URL . $token . '&AMT='.$post_vars['Price'].'&CURRENCYCODE=USD&useraction=commit&RETURNURL='.urlencode($tmp_return_url).'&CANCELURL='.urlencode($tmp_cancel_url);
                header('Location: '.$tmp_url);
                exit;
            }else{
                $error = 'Sorry, we have encountered a problem sumbitting your order to PayPal. Please try again. If you continue to experience problems ordering online, call toll-free at ' . COMPANY_PHONE . '.';
                $action = 'show';
            }
        }
      }
    /* END PROCESS PAYMENT */    

    // If user clicks the link to "cancel" once in PayPal's site, it brings them back to here:
    if ($action == 'cancel') {
        $action = 'show';
    }
  
  /* PROCESS PAYMENT RETURN DoExpressCheckout*/
  if ($action == 'return') {       
        // receive the get vars, clean them, DoExpressCheckout
        // move get vars to post vars, set the form values, and continue on with processing

        // Clean each get variable
        $get_vars = array();
        foreach ($_GET as $get_name => $get_value) {
        // get rid of slashes if magic quotes on
        if (get_magic_quotes_gpc()) $get_value = stripslashes($get_value);
        $get_value = trim($get_value);
        $get_vars[$get_name] = $get_value;
        }   // end cleaning GET values

        /* Gather the information to make the final call to
            finalize the PayPal payment.  The variable nvpstr
            holds the name value pairs
        */
        $token =urlencode($get_vars['token']);
        $paymentAmount =urlencode($get_vars['Price']);
        $paymentType = urlencode('Sale');
        $currCodeType = urlencode('USD');
        $payerID = urlencode($get_vars['PayerID']);
        $serverName = urlencode($_SERVER['REMOTE_ADDR']);

        $nvpstr='&TOKEN='.$token.'&PAYERID='.$payerID.'&PAYMENTACTION='.$paymentType.'&AMT='.$paymentAmount.'&CURRENCYCODE='.$currCodeType.'&IPADDRESS='.$serverName ;
        /* Make the call to PayPal to finalize payment, If an error occured, show the resulting errors
        */
        $resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);
        /* Display the API response back to the browser.
        If the response from PayPal was a success, display the response parameters'
        If the response was an error, display the errors received using APIError.php.
        */
        $ack = strtoupper($resArray["ACK"]);
        // no failure expected at this point, but including a check here because there has been a case of an order being processed even though PayPal was not charged.
        if($ack!=="SUCCESS" && $ack!=="SUCCESSWITHWARNING"){
            $error = 'Sorry, we have encountered a problem completing your order through PayPal. The final step of PayPal processing was not completed. If you continue to experience problems ordering online, call toll-free at ' . COMPANY_PHONE . '.';
            $action = 'show';
        } else {

        // take the get results and put into post vars
        foreach ($_GET as $get_name => $get_value) {
        $_POST[$get_name] = $get_value;
        }

        // Clean any existing post variable
        $post_vars = array();
        foreach ($_POST as $post_name => $post_value) {
            // get rid of slashes if magic quotes on
            if (get_magic_quotes_gpc()) $post_value = stripslashes($post_value);
            $post_value = trim($post_value);
            $post_vars[$post_name] = $post_value;
        }   // end processing POSTed values

        // set the 4-character card number to show that it's a PayPal payment
        $post_vars['card_number'] = 'PPal';
        
        // Process useful GET values  - NOT CURRENTLY USED
        if (isset($get_vars['SourceCode'])) $referrer = $get_vars['SourceCode'];
        
        // Process POSTed values in form
        foreach ($form as $fc_name => $fc_def) {
            // use isset() in following rather than !empty() because empty values
            // are valid and include things like '0' (string with zero in it)
            $post_value = isset($post_vars[$fc_name]) ? $post_vars[$fc_name] : '';
            // take only characters ahead of first \n in non-textarea fields
            if ($form[$fc_name]['type'] != 'textarea') {
                $tmp = explode("\n", $post_value);
                $post_value = $tmp[0];
            }

            switch ($fc_def['type']) {
                case 'text':
                case 'textarea':
                    if (!empty($post_value)) $form[$fc_name]['ctl_value'] = $post_value;
                    break;
                case 'hidden':
                    if ($post_value != $fc_def['ctl_value']) {
                        $attack_reason = 'hidden control';
                    }
                    break;
                case 'radio':
                case 'select':
                    if (!array_key_exists($post_value, $fc_def['options'])) {
                        $attack_reason = 'select control' . $fc_def['label'];
                    } else {
                    $form[$fc_name]['ctl_value'] = $post_value;
                    }
                    break;
                case 'checkbox':
                    $form[$fc_name]['ctl_value'] = $post_value ? 'on' : '';
            }   // end processing form control type
        }   // end foreach $form
        if($post_vars['SubscriptionNum'])
            $form['SubscriptionNum']['ctl_value'] = $post_vars['SubscriptionNum'];
        if($post_vars['CustomerNum']){
            $form['CustomerNum']['ctl_value']     = $post_vars['CustomerNum'];
        }
    // clear out paypal account payment values
    unset($post_vars['token']);
    unset($post_vars['PayerID']);
    unset($post_vars['action']);
    // continue processing the order in the same way as for credit cards
    $action = 'process';
     }
  }
  /* END PROCESS RETURN PAYMENT */
  
  
  /* SAVE DB */
  if ($action == 'process') {
    sc_FilterData();
    // clear unnecessary post vars
    unset($post_vars['BillingUseShipping']);

    // clear the credit card info except last four digits of card number
    unset($post_vars['exp_month']);
    unset($post_vars['exp_year']);
    unset($post_vars['cvv']);
    // unset anything that came in from the renewal or invoice post var
    unset($post_vars['InvoiceId']);
    unset($post_vars['RenewalId']);
    unset($post_vars['AmountDue']);
    unset($post_vars['UpgradePrice']);
    unset($post_vars['RenewalPrice1YR']);
    unset($post_vars['RenewalPrice2YR']);
    $post_vars['LastFour'] = substr($post_vars['card_number'], -4);
    unset($post_vars['card_number']);
    // define the PayPal TransactionID if not already defined
    $post_vars['TransactionID'] = (isset($transaction_id)) ? $transaction_id : '';
    // switch to country name instead of country code
    $post_vars['Country'] = $countries[$post_vars['Country']];
    $post_vars['ShiptoCountry'] = $countries[$post_vars['ShiptoCountry']];
    // if state selection was 'none', clear state entry
    $post_vars['ShiptoState'] = ($post_vars['ShiptoState'] == 'None') ? '' : $post_vars['ShiptoState'];
    $post_vars['State'] = ($post_vars['State'] == 'None') ? '' : $post_vars['State'];
    
    //print_r($form);

    // LOG THIS ORDER IN THE DATABASE
    if (DB_EMAIL_LOGGING) {
        // the name of the table we are entering the subscription into
        // defaults to the order table.  Send to renewal table if renewal or invoice
        if (!empty($post_vars['CustomerNum'])) {                        
          $table_name = 'renewals';
          $db_fields = array(
                    'SubType',
                    'DateAdded' ,
                    'Price',
                    'CardType',
                    'ShiptoFirstName',
                    'ShiptoLastName',
                    'ShiptoCompany',
                    'ShiptoAddress1',
                    'ShiptoAddress2',
                    'ShiptoCity',
                    'ShiptoState',
                    'ShiptoZip',
                    'ShiptoCountry',
                    'RenewalNotice',
                    'FirstName',
                    'LastName',
                    'Company',
                    'Address1',
                    'Address2',
                    'City',
                    'State',
                    'Zip',
                    'Country',
                    'Phone',
                    'Email',
                    'Contact',
                    'Newsletter',
                    'Via',
                    'SourceCode',
                    'Renewal',
                    'LastFour',
                    'TransactionID',
                    'CompOrPaid',
                    'Numofcopies',
                    'Referred',
                    'LastUpdated',
                    'SubscriptionNum',
                    'CustomerNum');
        } else {
        $table_name = DB_TABLE_NAME;
          $db_fields = array(
                    'SubType',
                    'DateAdded' ,
                    'Price',
                    'CardType',
                    'ShiptoFirstName',
                    'ShiptoLastName',
                    'ShiptoCompany',
                    'ShiptoAddress1',
                    'ShiptoAddress2',
                    'ShiptoCity',
                    'ShiptoState',
                    'ShiptoZip',
                    'ShiptoCountry',
                    'RenewalNotice',
                    'FirstName',
                    'LastName',
                    'Company',
                    'Address1',
                    'Address2',
                    'City',
                    'State',
                    'Zip',
                    'Country',
                    'Phone',
                    'Email',
                    'Contact',
                    'Newsletter',
                    'Via',
                    'SourceCode',
                    'Renewal',
                    'LastFour',
                    'TransactionID',
                    'CompOrPaid',
                    'Numofcopies',
                    'Referred',
                    'LastUpdated',
                    'DigitalPassword');
        }

        $insert_sql = 'INSERT INTO ' . $table_name . '
                    SET DateAdded = NOW()';
        $insert_sql .= ', LastUpdated = NOW()';

        // reset the post array so that we can add this to the database
        reset($post_vars);

        while (list($field_name, $field_value) = each($post_vars)) {
          // only insert if the field exists in the table
          if (in_array($field_name, $db_fields)) {
          $insert_sql .= ', ' . $field_name . ' = "' . mysql_real_escape_string($field_value) . '"';
          }
        }
        global $wpdb;
        $wpdb->query($insert_sql);
    } 
// ORDER EMAIL TO IMBIBE
$html = <<<HTML_HEAD
<html>
<meta Content-Type: text/html; charset=UTF-8
<body>
<font style="font-family:Arial;font-size:12px;" color="#000000">

HTML_HEAD;
    $html .= COMPANY_NAME . ' subscription order<br /><br />' . "\n";
    $text = COMPANY_NAME . ' subscription order' . "\n" . "\n";

    $html .= '<table>' . "\n";
    //$html .= '<tr><td>Elapsed time: </td><td>' . $elapsed_time . '</td></tr>' . "\n";
    //echo '<pre>'; print_r($form); die;
    foreach ($form as $fc_def) {
      //only include the form item in email if the email parameter is set to true
      if ($fc_def['email'] == TRUE) {
      	// swap in a different label for the email if set in the form parameters
      	$fc_def['label'] = (isset($fc_def['email_label'])) ? $fc_def['email_label'] : $fc_def['label'];
        $html .= '<tr><td>' . $fc_def['label'] . ': </td>';
        $text .= $fc_def['label'] . ': ';
        $value = $fc_def['ctl_value'];
        switch ($fc_def['type']) {
          case 'text':
          case 'hidden':
            $value = htmlspecialchars($value);
            //only email the last four digits of the card number
            if ($fc_def['label'] == 'Card Number') {
              $value = 'xxxx-xxxx-xxxx-' . substr($value, -4);
            }
            $html .= '<td>' . $value . '<br /></td></tr>' . "\n";
            $text .= $value . "\n";
            break;
          case 'textarea':
        // indent textarea type fields
            $value = htmlspecialchars($value);
            $html .= '<td width="400">' . nl2br($value) . '</td></tr>' . "\n";
            $text .= $value . "\n";
            break;
          case 'radio':
          case 'select':
            $value = htmlspecialchars($value);              
            if ($fc_def['label'] && strip_tags($fc_def['label']) == 'Subscription Length') {
              switch ($post_vars['SubType']) {
                case 'S1': $sub_type = '1-year sub'; break;
                case 'S2': $sub_type = '2-year sub'; break;
                case 'G1': $sub_type = '1-year gift'; break;
                case 'G2': $sub_type = '2-year gift'; break;
                default: $sub_type = $post_vars['SubType']; break;
              }
              $html .= '<td>' . $sub_type . ' at $' . $post_vars['Price'] . '</td></tr>' . "\n";
              $text .= $sub_type . ' at $' . $post_vars['Price'] . "\n";
              // insert customer_num and subscription_num with renewal              
            } elseif  ($fc_def['label'] == 'State/Province' || $fc_def['label'] == 'Billing State'){
            	$html .= '<td>' . $value . '</td></tr>' . "\n";
            	$text .= $value . "\n";
            } else {
            	$html .= '<td>'.$fc_def['options'][$value] . '</td></tr>' . "\n";
            	$text .= $fc_def['options'][$value] . "\n";               
            }
            break;
          case 'checkbox':
            $value = $value == 'on' ? 'Yes' : 'No';
            $html .= '<td>' . $value . '<br /></td></tr>' . "\n";
            $text .= $value . "\n";
            break;
        }   // end processing form control type
      }
      if(strtolower($fc_def['label']) == 'email address'){
          $SubType = $post_vars['SubType'];
          $DigitalPassword = $post_vars['DigitalPassword'];
          if(strpos($SubType, 'digital') !== false){
              $html .= '<tr><td>Digital Subscription Password</td><td>'.$DigitalPassword.'</td></tr>';
              $text .= 'Digital Subscription Password : '.$DigitalPassword . "\n";
          }
      }
    }   // end generating form control responses
    
    $html .= '<tr><td>Submitted: </td><td>' . date('m-d-y, g:i a', time()) . '  Pacific</td></tr>';
    $html .= '<tr><td>PayPalTransactionID: &nbsp;</td><td>' . $post_vars['TransactionID'] . '</td></tr>';
    $html .= '</table><br />' . "\n";
    $text .= 'Submitted: ' . date('m-d-y, g:i a', time()) . '  Pacific'. "\n";
    $text .= 'PayPalTransactionID:' . $post_vars['TransactionID'];
    $html .= '</body>';
    $html .= '</html>';
    
    $email = new Email();
    $email->SetMailer(COMPANY_NAME . ' mail program'); // this is optional but helpful
    $email->SetRecipient(CONTACT_EMAIL);
    $email->SetBlindCopy(CONTACT_BCC);
    // Set this to be a default address if cannot be set from form
    $from = '"' . FROM_EMAIL . '" <' . FROM_EMAIL . '>';
    $email->SetFrom($from);
    $email->SetSubject($post_vars['SubType'] . ' (' . $post_vars['LastName'] . ')');
    $email->SetHtml($html);
    $email->SetText($text);

    // mail form contents
    if (@$email->SendMail()) {
      $action = 'process'; //continue below with emailing the confirmation to purchaser
    } else {
      $error = 'failed trying to send to us';
      $action = 'show';
    }
    
    error_reporting(E_ALL ^ E_NOTICE);
    
    // get email with promo
    $tmp_promo = $promo;
    if($promo == 'invoice2year') $tmp_promo = 'invoice';
    
    $final_email_confirmation = '';
    $order_email_confirm_template_content_subscribe = '';

    $order_email_confirm_template_content_subscribe = '';
    if(get_field('order_email_confirmation_templates')){
        while(has_sub_field('order_email_confirmation_templates')){
            $order_email_confirmation_template_promo = get_sub_field('order_email_confirmation_template_promo');
            $order_email_confirmation_template_content = get_sub_field('order_email_confirmation_template_content');
            
            if($order_email_confirmation_template_promo == 'subscribe'){
                $order_email_confirm_template_content_subscribe = $order_email_confirmation_template_content;
            }
            if($tmp_promo == $order_email_confirmation_template_promo){
                $final_email_confirmation = $order_email_confirmation_template_content;
            }
        }
    }          
    if(!$final_email_confirmation) $final_email_confirmation = $order_email_confirm_template_content_subscribe;
    $email_confirmation_template = $final_email_confirmation;
    
    //$email_confirmation_template = get_field('subscription_confirmation_email_template',  get_the_ID());        
    require_once(get_template_directory().'/lib/liquid-template/Liquid.class.php');
    $liquid = new LiquidTemplate();
    try{
        $liquid->parse($email_confirmation_template);
        $post_vars['NumberIssues'] = substr($post_vars['SubType'], 0, 1) * 6;
        $post_vars['is_print_subscription']   = (strpos(strtolower($post_vars['SubType']),'print') !== false) ? 1 : 0;
        $post_vars['is_digital_subscription'] = (strpos(strtolower($post_vars['SubType']),'digital') !== false) ? 1 : 0;
        if($promo == 'invoice2year' || $promo == 'invoice'){
            switch($post_vars['SubType']){
                case '1-year digital subscription upgrade':
                case '2-year digital subscription upgrade':
                        $post_vars['is_print_subscription'] = 1;
                        $post_vars['is_digital_subscription'] = 1;
                    break;
            }
        }
        $post_vars['SubType'] = str_replace('payup print ', '', $post_vars['SubType']);
        $html   = $liquid->render($post_vars);
    }catch(Exception $ex){
        echo $ex->getMessage(); die;
    }
    $text   = $html;
    $text   = str_replace(array('<br/>','<br />'),array("\n","\n"), $text);
    $text   = strip_tags($text);
    
    $email = new Email();
    $email->SetMailer(COMPANY_NAME . ' mail program'); // this is optional but helpful
    $email->SetRecipient($form['Email']['ctl_value']);
    $email->SetBlindCopy(CONFIRM_BCC);
    // Set this to be a default address if cannot be set from form
    $from = '"' . FROM_EMAIL . '" <' . FROM_EMAIL . '>';
    $email->SetFrom($from);
    $email->SetSubject(COMPANY_NAME . ' order confirmation');
    $email->SetHtml($html);
    $email->SetText($text);
    
    //var_dump($html); die;
    // mail form contents
    if (@$email->SendMail()) {
      $action = 'thanks';
    } else {
      $error = 'failed trying to send to us';
      $action = 'show';
    }

  }
  /** END SAVE DB**/
    
  // Display either form page or "thanks" page (action is "show" or "thanks")

  // clear out cc number if showing form
  
  if ($action == 'show')  $form['card_number']['ctl_value'] = '';    
?>
<?php if ($action == 'thanks'):
    $tmp_promo = $promo;
    if($promo == 'invoice2year') $tmp_promo = 'invoice';
    $final_confirmation = '';
    $order_confirm_template_content_subscribe = '';

    $order_confirm_template_content_subscribe = '';
    if(get_field('order_confirmation_templates')){
        while(has_sub_field('order_confirmation_templates')){
            $order_confirmation_template_promo = get_sub_field('order_confirmation_template_promo');
            $order_confirmation_template_content = get_sub_field('order_confirmation_template_content');
            if($order_confirmation_template_promo == 'subscribe'){
                $order_confirm_template_content_subscribe = $order_confirmation_template_content;
            }
            if($tmp_promo == $order_confirmation_template_promo){
                $final_confirmation = $order_confirmation_template_content;
            }
        }
    }          
    if(!$final_confirmation) $final_confirmation = $order_confirm_template_content_subscribe;

    require_once(get_template_directory().'/lib/liquid-template/Liquid.class.php');
    $liquid = new LiquidTemplate();
    $liquid->parse($final_confirmation);                                
    $html   = $liquid->render($post_vars);  
    $_SESSION['confirmation_page'] = $html;
    header('Location: '. add_query_arg(array("confirmation"=>1),  get_permalink()));
    exit;
?>
<?php endif;?> 

<?php get_header(); ?> 
    <div class="content clearfix">
    	<div class="panelCenter">
            <style>
                label.error{
                    color: red !important;
                    width: auto !important;
		    display:none;
                    margin-left: 5px;
                }
                input.error{
                    border: 1px solid red !important;
                }
                select.error{
                    border: 1px solid red !important;
                }
            </style>
        	<section>
            	<ul class="breadcrumb">
                    <li><a href="<?php echo home_url();?>">Home</a></li>
                    <li><span>Subscribe</span></li>
                </ul>
            </section>
            <?php 
                $shop_page = get_page_by_title('Shop');
                $shop_page_id = null;
                if($shop_page) $shop_page_id = $shop_page->ID;                
                $cstools = array();
                if($shop_page_id){
                    if(get_field('cstools',$shop_page_id)){
                        while(has_sub_field('cstools',$shop_page_id)){
                            $cstools[] = array(
                                "link"   => get_sub_field("cstool_link",$shop_page_id),
                                "title"  => get_sub_field("cstool_title",$shop_page_id)
                            );
                        }
                    }
                }
            ?>
            <?php if(count($cstools)):?>
            <section class="title" style="margin-top: 0px;">
                <ul class="subBar" style="float: right; position: absolute; margin-top: -55px;">                    
                    <?php foreach($cstools as $key => $cstool):?>
                        <li><a href="<?php echo $cstool['link'];?>"><?php echo $cstool['title'];?></a><?php if($key < count($cstools)-1):?>|<?php endif;?></li>
                    <?php endforeach;?>
                </ul>
            </section>            
            <?php endif;?>
            <section class="Drinkup">                
                    <div class="left">
                        <div class="thumb" style="text-align:center;">
                            <img src="<?php echo $sidebar_image;?>">
                        </div>
                    </div>
                    <div class="right">
                        <?php if($_GET['confirmation'] == 1):?>  
                            <?php echo $_SESSION['confirmation_page'];?>
                            <p><a href="<?php echo get_permalink(); ?>">Return to subscribe page</a></p>
                        <?php elseif ($action == 'show'): ?>
                            <section class="formShop">
                                <div class="title03">
                                    <img src="<?php echo $header_image;?>">
                                    <p>Add $20/year for all subscriptions mailed outside the United States.</p>
                                </div>
                            </section>
                            <?php                             
                                if ($error) {
                                    echo '<p class="contact_error">' . $error . '</p>' . "\n";
                                }                            
                                if (!empty($last_issue)){
                                    echo '<p>Last issue of this print subscription: ' . $last_issue . '</p>';
                                }
                                if(!empty($last_issue_digital)){
                                    echo '<p>Last issue of this digital subscription: ' . $last_issue_digital . '</p>';
                                }
                                echo '<p class="small_text">Required fields are marked with<span class="contact_required">&nbsp;*</span></p>' . "\n";
                            ?>
                        <form method="post" id="subscribe_form" action="<?php echo add_query_arg(array('page_id' =>  get_the_ID(),'promo'=>$promo,'SourceCode'=>$source));?>">
                                <section class="formShop">
                                    <ul class="form">
                                    <input type="hidden" name="time" value="<?php echo time(); ?>" />
                                    <input type="hidden" name="action" value="process" />                                
                                    <?php                                    
                                    foreach ($form as $fc_name => $fc_def) {
                                        if(in_array($fc_name,array('ShiptoFirstName','ShiptoLastName','ShiptoAddress1','ShiptoCity','ShiptoState','ShiptoZip','ShiptoCountry'))){
                                            $fc_def['required'] = true;
                                        }
                                        $req_mark = !empty($fc_def['required']) ? '<span class="required">*</span>' : '';
                                        $text_req_mark = ($fc_def['label'] != '') ? '' : $req_mark;
                                        $parm = !empty($fc_def['parm']) ? ' ' . $fc_def['parm'] : '';
                                        $value = $fc_def['ctl_value'];

                                        $label_req_mark = ($fc_def['label'] != '') ? $req_mark : '';                                                                                        
                                        
                                        if($fc_def['type'] == 'radio' || $fc_def['type'] == 'checkbox'){
                                            echo '<li class="field_'.$fc_name.'">';
                                        }else{
                                            echo '<li class="field field_'.$fc_name.'">';
                                        }
                                        
                                        $jquery_validate = '';
                                        if(!empty($fc_def['required'])){
                                            if($fc_name != 'ShiptoZip' && $fc_name != 'Zip'){
                                                if($fc_name == 'Email'){
                                                    $jquery_validate = 'validate="required:true,email:true"';
                                                }else
                                                    $jquery_validate = 'validate="required:true"';                                                
                                            }
                                        }
                                        // build form controls
                                        switch ($fc_def['type']) {
                                            case 'hidden':
                                                $parm = !empty($fc_def['parm']) ? ' ' . $parm : '';
                                                $value = htmlspecialchars($value);
                                                echo '<input type="hidden" name="' . $fc_name . '" value="' . $value . '"' . $parm . ' />';
                                            break;
                                            case 'text':
                                                if (!empty($fc_def['text'])) echo $fc_def['text'] . $text_req_mark;
                                                if($fc_name == 'cvv'){
                                                    echo '<label style="width:auto;">'.htmlspecialchars($fc_def['label']).'<span class="required">*</span></label>&nbsp;';
                                                }else{
                                                    echo '<label>' . htmlspecialchars($fc_def['label']) . $label_req_mark . '</label>';
                                                }
                                                $parm = !empty($fc_def['parm']) ? ' ' . $parm : '';
                                                $value = htmlspecialchars($value);
                                                $size = !empty($fc_def['size']) ? ' size="' . $fc_def['size'] . '"' : '';
                                                $maxlength = !empty($fc_def['maxlength']) ? ' maxlength="' . $fc_def['maxlength'] . '"' : '';
                                                // insert the cvv "What's This" popup link
                                                $field_comment = ($fc_name == 'cvv') ? ' &nbsp; <a href="#" onclick="Popup=window.open(\''.$security_page.'\',\'Popup\',\'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=550,right=50,top=50\'); return false;">What\'s this?</a>' : '';
                                                $tmp_txt = '';
                                                if($fc_name == 'cvv') $tmp_txt = 'style="width:auto !important;"';
                                                echo '<input '.$tmp_txt.' '.$jquery_validate.' type="text" name="' . $fc_name . '"' . $size . $maxlength . $tabindex . ' value="' . $value . '"' . $parm . ' />' . $field_comment;
                                                if($fc_name == 'cvv'){
                                                    echo '<label class="error" for="cvv" style="display:none;">This field is required.</label>';
                                                }
                                            break;
                                            case 'textarea':
                                                if (!empty($fc_def['text'])) echo $fc_def['text'] . $text_req_mark.'&nbsp;';
                                                echo '<label>' . htmlspecialchars($fc_def['label']) . $label_req_mark . '</label>';
                                                $parm = !empty($fc_def['parm']) ? ' ' . $parm : '';
                                                $value = htmlspecialchars($value);
                                                echo '<textarea '.$jquery_validate.' name="' . $fc_name . '" cols="' . $fc_def['cols'] . '" rows="' . $fc_def['rows'] . '"' . $tabindex . $parm . '>' . $value . '</textarea>';
                                            break;
                                            case 'select':
                                                if (!empty($fc_def['text'])) echo $fc_def['text'] . $text_req_mark;
                                                if($fc_name == 'Referred'){
                                                    echo '<label style="width:auto;">'.htmlspecialchars($fc_def['label']).'</label><br/>';
                                                    echo '<label>&nbsp;</label>';
                                                }else{                                                    
                                                    echo '<label>' . htmlspecialchars($fc_def['label']) . $label_req_mark . '</label>';
                                                }                                                
                                                echo '<select '.$jquery_validate.' name="' . $fc_name . '"' . $tabindex . '>' . "\n";
                                                foreach ($fc_def['options'] as $opt_name => $opt_label) {
                                                    $opt_parm = !empty($parm) && !empty($parm[$opt_name]) ? ' ' . $parm[$opt_name] : '';
                                                    $selected = ((string)$value == $opt_name) ? ' selected="selected"' : '';
                                                    echo '<option' . $selected . ' value="' . htmlspecialchars($opt_name) . '"' . $parm . '>' . $opt_label . '</option>' . "\n";
                                                }
                                                echo '</select>';
                                                if($fc_name == 'exp_month'){
                                                    echo '<label class="error" for="exp_month" style="display:none;">Month is required. </label>';
                                                    echo '<label class="error" for="exp_year" style="display:none;">Year is required. </label>';
                                                }
                                            break;
                                            case 'radio': 
                                                if (!empty($fc_def['text']))
                                                    echo $fc_def['text'];
                                                
                                                if($fc_def['label'])
                                                    echo $fc_def['label'];
                                                
                                                if($fc_name == 'SubType') echo '<br/>';
                                                else echo '&nbsp;';
                                                
                                                if($fc_name == 'Contact' || $fc_name == 'Newsletter'){
                                                    echo '<br/>';
                                                    echo '<label style="width:110px;display:inline-block;">&nbsp;</label>';
                                                }
                                                
                                                foreach ($fc_def['options'] as $opt_name => $opt_label) {
                                                    $opt_parm = !empty($parm) && !empty($parm[$opt_name]) ? ' ' . $parm[$opt_name] : '';
                                                    $checked = ($value == $opt_name) ? ' checked="checked"' : '';
                                                    echo '<label style="line-height:30px;"><input '.$jquery_validate.' type="radio" name="' . $fc_name . '" value="' . htmlspecialchars($opt_name) . '"' . $checked . $parm .' />&nbsp;' . $opt_label . "</label>";
                                                    if($fc_name == 'SubType') echo '<br/>';
                                                    else echo '&nbsp;';
                                                }												
                                                if($fc_name == 'SubType' || $fc_name == 'Contact' || $fc_name == 'Newsletter'){
                                                    echo '<label class="error" for="SubType">This field is required</label>';
                                                }                                               
                                            break;

                                            case 'checkbox':
                                                if (!empty($fc_def['text'])) echo $fc_def['text'] . $text_req_mark.'&nbsp;';
                                                $parm = !empty($fc_def['parm']) ? ' ' . $parm : '';
                                                $checked = $value == 'on' ? ' checked="checked"' : '';
                                                echo '<label><input '.$jquery_validate.' type="checkbox" name="' . $fc_name . '" ' . $checked . $tabindex . $parm . ' />&nbsp;'.$fc_def['label'].'</label>';
                                                echo '&nbsp;';
                                            break;
                                        }  // end switch                                        
                                        // This is the special text to annotate the form section below the field.  Please format as you see fit.
                                        if (!empty($fc_def['text_below'])){                                            
											echo '<span class="text-below">'.$fc_def['text_below'].'</span>';
                                        }
                                        echo '</li>';

                                    }
                                    ?>
                                    </ul>
                                </section>
                                <section class="buttonRed">
                                    <a href="javascript:void(0);" onclick="submitFormProcess();return false;">Submit</a> &nbsp;&nbsp;Your transaction may take a few moments to process, please click the Submit button only once.
                                </section>                                
                            </form>
                        <?php endif;?>                                               
                    </div>
                    <div class="clearfix"></div>
            </section>
        </div>
        <div class="clearfix"></div>
        <script type="text/javascript">
            function rebuildStep(){
                var index = 0;
                $("#subscribe_form h2:visible").each(function(){
                    index++;
                    var text = $(this).html();    
                    var text = "STEP "+ index + text.substr(6);
                    $(this).html(text);
                });                
            }
            function hideShipping(){
                /*
                $("input[name='ShiptoFirstName']").val('');
                $("input[name='ShiptoLastName']").val('');
                $("input[name='ShiptoCompany']").val('');
                $("input[name='ShiptoAddress1']").val('');
                $("input[name='ShiptoAddress2']").val('');
                $("input[name='ShiptoCity']").val('');
                $("select[name='ShiptoState']").val('');
                $("input[name='ShiptoZip']").val('');
                $("select[name='ShiptoCountry']").val('');
                */
               
                $("input[name='ShiptoFirstName']").parent('li').hide();
                $("input[name='ShiptoLastName']").parent('li').hide();
                $("input[name='ShiptoCompany']").parent('li').hide();
                $("input[name='ShiptoAddress1']").parent('li').hide();
                $("input[name='ShiptoAddress2']").parent('li').hide();
                $("input[name='ShiptoCity']").parent('li').hide();
                $("select[name='ShiptoState']").parent('li').hide();
                $("input[name='ShiptoZip']").parent('li').hide();
                $("select[name='ShiptoCountry']").parent('li').hide();
                $("input[name='BillingUseShipping']").parent('label').hide();
                $("input[name='BillingUseShipping']").parents('li').find('h2').css("margin-bottom","0px");
                rebuildStep();               
            }
            function showShipping(){
                $("input[name='ShiptoFirstName']").parent('li').show();
                $("input[name='ShiptoLastName']").parent('li').show();
                $("input[name='ShiptoCompany']").parent('li').show();
                $("input[name='ShiptoAddress1']").parent('li').show();
                $("input[name='ShiptoAddress2']").parent('li').show();
                $("input[name='ShiptoCity']").parent('li').show();
                $("select[name='ShiptoState']").parent('li').show();
                $("input[name='ShiptoZip']").parent('li').show();
                $("select[name='ShiptoCountry']").parent('li').show();
                $("input[name='BillingUseShipping']").parent('label').show();
                $("input[name='BillingUseShipping']").parents('li').find('h2').css("margin-bottom","20px");
                rebuildStep();               
            }
            
            function showDigitalPasswordField(){
                if($("input[name='SubType']:checked").size() == 0) return false;
                
                var digital = false;
                if($("input[name='SubType']:checked").val().indexOf('digital') >= 0)
                    digital = true;
                
                var print = false;
                if($("input[name='SubType']:checked").val().indexOf('print') >= 0 || $("input[name='SubType']:checked").val().indexOf('upgrade') >= 0)
                    print = true;
                
                // upgrade $5 print to digital
                
                if(digital){
                    $(".field_digital").show();
                }else{
                    $(".field_digital > input").val('');
                    $(".field_digital").hide();
                }
                
                if(print){
                    showShipping();
                }else{
                    hideShipping();
                }
                // if digital upgrade from shop-welcome -> always hide mailing info fields
                <?php if($promo == 'upgrade-digital'):?>
                      hideShipping();      
                <?php endif;?>                
            }
            $(document).ready(function(){
               // check disable renewal notification question 
               <?php if(!$display_renewal_notification_question):?>
				   $(".field_RenewalNotice input[type='radio']:eq(1)").attr("checked",true);
                   $(".field_RenewalNotice").hide();
               <?php endif;?>
              
               // if is renewal <=> remove line out from SubType options
               <?php if($promo == 'renew'):?>
                      if($("#subscribe_form select[name='ShiptoCountry']").val() != 'US'){
                         $("#subscribe_form input[name='SubType']").parent("label").find("del").hide();
                      }
                      $("#subscribe_form select[name='ShiptoCountry']").change(function(){
                          if($(this).val()=='US'){
                              $("#subscribe_form input[name='SubType']").parent("label").find("del").show();
                          }else{
                              $("#subscribe_form input[name='SubType']").parent("label").find("del").hide();
                          }
                      });
               <?php endif;?>        
                
               <?php if($promo == 'upgrade-digital'):?>
                     $(".title03").parent().remove();
                     $(".subscription-length-span").remove();
                     $("ul.form li:first > h2").next("br").remove();
               <?php endif;?>        
               // auto check with null
               var checked_Newsletter = false;
               $("input[name='Newsletter']").each(function(){
               if($(this).attr("checked"))   
                    checked_Newsletter = true;
               });
               if(!checked_Newsletter){ 
                    $("input[name='Newsletter']:first").attr("checked",true);
               }
               
               $("select[name='CardType']").change(function(){                   
                   if($(this).val() == 'PayPal'){
                       var current_li = $(this).parent('li');
                       current_li.show();
                       current_li.next('li').hide();
                       current_li.next('li').next('li').hide();
                       current_li.next('li').next('li').next('li').hide();  
                       $("input[name='card_number']").val('');
                       $("select[name='exp_month']").val('');
                       $("select[name='exp_year']").val('');
                       $("input[name='cvv']").val('');
                   }else{
                       var current_li = $(this).parent('li');
                       current_li.show();
                       current_li.next('li').show();
                       current_li.next('li').next('li').show();
                       current_li.next('li').next('li').next('li').show();
                   }
               });
               $("input[name='SubType']").change(function(){
                 showDigitalPasswordField();
               });
               
               $("select[name=exp_month]").parent(".field").addClass("megaSelect");
               var parent_exp_year = $("select[name=exp_year]").parent(".field");               
               $("select[name=exp_year]").insertAfter("select[name=exp_month]");
               parent_exp_year.remove();
               $("select[name=exp_year]").before("&nbsp;");
               <?php if(isset($_POST['from'])):?> 
                       fill();
               <?php endif;?>        
               //$("#subscribe_form input[name='Email']")
               var html = '<li class="field field_digital" style="display:none;">';
               html+='<label>Password<span class="required">*</span></label>';	
               html+='<input type="password" class="sub_field" value="" size="25" name="DigitalPassword" id="DigitalPassword" validate="required:true,equalTo:ConfirmDigitalPassword">';
               html+='</li>';
               html+='<li class="field field_digital" style="display:none;">';
               html+='<label>Confirm Password<span class="required">*</span></label>';
               html+='<input type="password" class="sub_field" value="" size="25" name="ConfirmDigitalPassword" id="ConfirmDigitalPassword" validate="required:true">';
               html+='</li>';
               $("#subscribe_form input[name='Email']").parent('li').append(html);
               showDigitalPasswordField();
            });
            function submitFormProcess(){
                validate_form = validateRules();        
                if(validate_form.form()){ 
                    jQuery("#subscribe_form").submit();
                }else{
                    alert('Please fill in all required fields.');				}
            }
            function validateRules(){
                jQuery.metadata.setType("attr", "validate");
                return jQuery("#subscribe_form").validate();
            }    
            function fill(box) {
                if (box != undefined && box.checked == false) {
                    return;
                }
                var formid = document.getElementById('subscribe_form');
                formid.FirstName.value = formid.ShiptoFirstName.value;
                formid.LastName.value = formid.ShiptoLastName.value;
                formid.Company.value = formid.ShiptoCompany.value;
                formid.Address1.value = formid.ShiptoAddress1.value;
                formid.Address2.value = formid.ShiptoAddress2.value;
                formid.City.value = formid.ShiptoCity.value;
                formid.State.value = formid.ShiptoState.value;
                formid.Zip.value = formid.ShiptoZip.value;
                formid.Country.value = formid.ShiptoCountry.value;
            }            
        </script>    
    </div>
<?php get_footer();?>