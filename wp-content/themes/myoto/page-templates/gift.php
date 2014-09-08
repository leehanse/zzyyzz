<?php
/**
 * Template Name: Gift Template
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
    if($_GET['promo']){
      if(!check_gift_promotion_active($_GET['promo'])){
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
  
  
  $action = !empty($_GET['action']) ? $_GET['action'] : 'show';
  $action = !empty($_POST['action']) ? $_POST['action'] : $action;
  
  $source = !empty($_GET['SourceCode']) ? $_GET['SourceCode'] : 'web';
  $source = !empty($_POST['SourceCode']) ? $_POST['SourceCode'] : $source;
  
  $gift2  = isset($_GET['2year']) ? $_GET['2year'] : 0;
  $promo  = isset($_GET['promo']) ? $_GET['promo'] : 'gift'; 
  
  $_POST['SourceCode'] = $source;

  $referrer = '';

  $gift_page_id    = get_page_by_title('Gift')->ID;      
  
  if($gift2){
    if(get_field('header_image_2_years',$gift_page_id))          
        $t_header_image   = get_field('header_image_2_years',$gift_page_id);
    else $t_header_image = get_template_directory_uri ().'/images/subscribe/gift_2_header.jpg';
  }else{
    if(get_field('header_image_1_year',$gift_page_id))          
        $t_header_image   = get_field('header_image_1_year',$gift_page_id);
    else $t_header_image = get_template_directory_uri ().'/images/subscribe/gift_header.jpg';
  }
  
  if(get_field('sidebar_image',$gift_page_id))
    $t_sidebar_image   = get_field('sidebar_image',$gift_page_id);
  else $t_sidebar_image = get_template_directory_uri ().'/images/subscribe/gift_sidebar.jpg';      

  $header_image = $t_header_image;
  $sidebar_image = $t_sidebar_image;

  $hpromo = null;
  if($promo && $promo != 'gift'){
    $gift_page_id = get_page_by_title('Gift')->ID;
    if(get_field('gift_promotions')){
        while(has_sub_field('gift_promotions',$gift_page_id)){
                $promo_name = get_sub_field('promo_name',$gift_page_id);                
                if($promo_name == $promo){
                    $hpromo = array(
                        "header_image"  => get_sub_field('header_image',$gift_page_id),
                        "sidebar_image" => get_sub_field('sidebar_image',$gift_page_id),
                        "PRICES"        => array(
                                               get_sub_field('price_1',$gift_page_id),get_sub_field('price_2',$gift_page_id),
                                               get_sub_field('price_3',$gift_page_id),get_sub_field('price_4',$gift_page_id),
                                               get_sub_field('price_5',$gift_page_id),get_sub_field('price_6',$gift_page_id),
                                           )
                    );
                }
        }
    }  
  }
  
  if($hpromo){
      if($hpromo["header_image"])
        $header_image   = $hpromo["header_image"];
      
      if($hpromo["sidebar_image"])
        $sidebar_image = $hpromo["sidebar_image"];
  }
  
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
  
  if($gift2){
      $PRICES = array(32,29,29,29,29,29);
      require_once(INCLUDES . 'gift2_form.php');  
  }else{
      if(!$hpromo)
        $PRICES = array(20,18,18,18,18,18);
      else 
        $PRICES = $hpromo['PRICES'];
      require_once(INCLUDES . 'gift_form.php');
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

  if ($action == 'process') {
    unset($_POST['action']);
    unset($_POST['time']);
    /* See note above about the removal of the county formot check
        unset($_POST['county']);
    */
    unset($_POST['submit']);
    $error = '';

    // Clean each post variable
    $post_vars = array();
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
    $post_vars['card_number'] = str_replace ($remove, "", $post_vars['card_number']);


    // Process useful GET values
    if (isset($get_vars['Src'])) $referrer = $get_vars['Src'];


    // Process POSTed values in form
    // check which gift forms are being filled out, stick the gift number in the $attempted_gifts array if any of the fields in gift were submitted
    $attempted_gifts = array();
    foreach ($form as $fc_name => $fc_def) {
      $gift_num = (!empty($fc_def['gift'])) ? $fc_def['gift'] : '';
      // use isset() in following rather than !empty() because empty values
      // are valid and include things like '0' (string with zero in it)
      $post_value = isset($post_vars[$fc_name]) ? $post_vars[$fc_name] : '';
      // DEBUG echo $fc_name . ' = ' . $post_value;
      // DEBUG echo $gift_num;
      if ($gift_num != '' && $post_value !='') {
       if (!in_array($gift_num, $attempted_gifts)) $attempted_gifts[] = $gift_num;
      }
    }

    $num_gifts = count($attempted_gifts);
    // DEBUG echo 'attempted gifts: '; print_r($attempted_gifts);
    foreach ($form as $fc_name => $fc_def) {
      // use isset() in following rather than !empty() because empty values
      // are valid and include things like '0' (string with zero in it)
      $post_value = isset($post_vars[$fc_name]) ? $post_vars[$fc_name] : '';
      $gift_num = (!empty($fc_def['gift'])) ? $fc_def['gift'] : '';
      $gift = ($gift_num != '') ? 'Gift' . $gift_num . ': ' : 'Billing: ';

      /* idenify which gift it is depending on the prefix of fc_name
      if (strpos($fc_name, '_') == 1) {
         $gift = 'Gift ' . substr($fc_name, 0, 1) . ': ';
      } else {
       $gift = '';
      }
      */
      // create error for required fields for non gift fields and for gift fields when that particular gift number is being attempted
      if ($gift_num == '' || in_array($gift_num, $attempted_gifts)) {
        if ($fc_def['required']
            && (empty($post_value) || !preg_match('/\S/', $post_value))) {
      // skip Card Number, Expiration month/year, and CVV if paying by PayPal
            if ($post_vars['CardType'] == 'PayPal'
            && ($fc_name == 'card_number' || $fc_name == 'exp_month' || $fc_name == 'exp_year' || $fc_name == 'cvv')) {
               break;
            } else {
          $place = ($fc_def['label']) ? $fc_def['label'] : $fc_def['text'];
          $error .= $gift . $place . ' is blank; please fill in and resubmit<br />';
          $form[$fc_name]['error'] = true;
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

    if ($attack_reason) {
      exit($attack_reason);
      error_log('Formbot attack (' . $attack_reason . ') on ' . COMPANY_NAME . print_r($_POST, true), 1, ERROR_EMAIL);
      $error = 'An error occurred processing your entry. Please try again.';
      $_POST = array();
      $action = 'show';
    }
  }  
  
  // Valid form data. Process the payment, log it in db, send order email, and send confirmation email
  if ($action == 'process') {
    if(!$gift2){
        $post_vars['SubType'] = '1-year gift subscription';
        // calculate the price for each issue
        // assumed one year issues, may need to change in future
        $post_vars['Price'] = 0;
        foreach ($attempted_gifts as $key=>$gift_num) {
            if ($gift_num == 1) {
                $post_vars['1_Price'] = ($post_vars['1_ShiptoCountry'] == 'US') ? $PRICES[$gift_num-1] : $PRICES[$gift_num-1] + 20;
            } else {
                $post_vars[$gift_num . '_Price'] = ($post_vars[$gift_num . '_ShiptoCountry'] == 'US') ? $PRICES[$gift_num-1] : $PRICES[$gift_num-1] + 20;
            }
            // DEBUG echo 'gift ' . $gift_num . ' is ' . $post_vars[$gift_num . '_Price'];
            // add to running total price
            $post_vars['Price'] += $post_vars[$gift_num . '_Price'];
        }
    }else{
        $post_vars['SubType'] = '2-year gift subscription';
        // calculate the price for each issue
        // assumed one year issues, may need to change in future
        $post_vars['Price'] = 0;
        foreach ($attempted_gifts as $key=>$gift_num) {
            if ($gift_num == 1) {
                $post_vars['1_Price'] = ($post_vars['1_ShiptoCountry'] == 'US') ? $PRICES[$gift_num-1] : $PRICES[$gift_num-1] + 40;
            }else{
                $post_vars[$gift_num . '_Price'] = ($post_vars[$gift_num . '_ShiptoCountry'] == 'US') ? $PRICES[$gift_num-1] : $PRICES[$gift_num-1] + 40;
            }
            // DEBUG echo 'gift ' . $gift_num . ' is ' . $post_vars[$gift_num . '_Price'];
            // add to running total price
            $post_vars['Price'] += $post_vars[$gift_num . '_Price'];
        }        
    }
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
            $post_string =
            '&Price=' . $post_vars['Price'] . '&SubType=' . $post_vars['SubType'] . '&ShiptoFirstName=' . $post_vars['ShiptoFirstName'] . '&ShiptoLastName=' . $post_vars['ShiptoLastName'] . '&ShiptoCompany=' . $post_vars['ShiptoCompany'] . '&ShiptoAddress1=' . $post_vars['ShiptoAddress1'] . '&ShiptoAddress2=' . $post_vars['ShiptoAddress2'] . '&ShiptoCity=' . $post_vars['ShiptoCity'] . '&ShiptoState=' . $post_vars['ShiptoState'] . '&ShiptoZip=' . $post_vars['ShiptoZip'] . '&ShiptoCountry=' . $post_vars['ShiptoCountry'] . '&FirstName=' . $post_vars['FirstName'] . '&LastName=' . $post_vars['LastName'] . '&Company=' . $post_vars['Company'] . '&Address1=' . $post_vars['Address1'] . '&Address2=' . $post_vars['Address2'] . '&City=' . $post_vars['City'] . '&State=' . $post_vars['State'] . '&Zip=' . $post_vars['Zip'] . '&Country=' . $post_vars['Country'] . '&Phone=' . $post_vars['Phone'] . '&Email=' . $post_vars['Email'] . '&Contact=' . $post_vars['Contact'] . '&Newsletter=' . $post_vars['Newsletter'] . '&Referred=' . $post_vars['Referred'] . '&CardType=' . $post_vars['CardType'];
            // if this is a renewal or invoice, also pass along the Customer Number and Subscription Number
            if (!empty($post_vars['CustomerNum']) && !empty($post_vars['SubscriptionNum'])) {
            $post_string .= '&CustomerNum=' . $post_vars['CustomerNum'] . '&SubscriptionNum=' . $post_vars['SubscriptionNum'];
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
                $error = 'Sorry, we have encountered a problem sumbitting your order to PayPal.  Please try again. If you continue to experience problems ordering online, call toll-free at ' . COMPANY_PHONE . '.';
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
        foreach ($attempted_gifts as $key=>$gift_num) {
            $post_vars_gift = array(); // reset the temporary gift-specific post values
            foreach ($post_vars as $name => $value) {
                $post_vars_gift[$name] = $value;
            }
            foreach ($post_vars_gift as $name => $value) {
                // strpos has difficulty reporting first position '0'
                if (strpos('x' . $name, (string)$gift_num) == 1) {
                    $post_vars_gift[substr($name, 2)] = $value;
                }
                // CLEAR OUT ANY EMPTY POST VARS AND ANY POST VARS WITH A GIFT PREFIX
                if (empty($value)) unset($post_vars_gift[$name]);
                if (strpos($name, '_') == 1) unset($post_vars_gift[$name]);
            }

            // switch to country name instead of country code
            if (!empty($post_vars_gift['ShiptoCountry'])) {
                $post_vars_gift['ShiptoCountry'] = $countries[$post_vars_gift['ShiptoCountry']];
            }
            // echo 'country name should be: ' . $countries[$post_vars_gift['ShiptoCountry']];
            // print_r($post_vars_gift); die;
            // DEBUG echo '<pre>'; print_r($post_vars_gift);

            $insert_sql  = 'INSERT INTO orders SET DateAdded = NOW()';
            $insert_sql .= ', LastUpdated = NOW()';

            // reset the post array so that we can add this to the database
            reset($post_vars_gift);

            while (list($field_name, $field_value) = each($post_vars_gift)) {
                $insert_sql .= ', ' . $field_name . ' = "' . mysql_real_escape_string($field_value) . '"';
            }
            // DEBUG echo $insert_sql;
            global $wpdb;
            $wpdb->query($insert_sql);
        }
    }
    
    // END LOGGING ORDER IN THE DATABASE
    // ORDER EMAIL TO IMBIBE
    $html = <<<HTML_HEAD
<html>
<body>
<font style="font-family:arial;" color="#000000">

HTML_HEAD;
    $html .= COMPANY_NAME . ' subscription order<br /><br />' . "\n";
    $text = COMPANY_NAME . ' subscription order' . "\n" . "\n";

    $html .= '<table>' . "\n";
    //$html .= '<tr><td>Elapsed time: </td><td>' . $elapsed_time . '</td></tr>' . "\n";

    // subtype is not a selection, it's always 1-year gift.  Force the first line of the order table:
    $html .= '<tr><td>Subscription Type: </td><td>' . $num_gifts . ' 1-year gift(s) at $' . $post_vars['Price'] . '</td></tr>' . "\n";
    $text .= 'Subscription Type: ' . $num_gifts . ' 1-year gift(s) at $' . $post_vars['Price'] . "\n";

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
            if ($fc_def['label'] == 'Subscription Length') {
              switch ($post_vars['SubType']) {
              case 'S1': $sub_type = '1-year sub'; break;
              case 'S2': $sub_type = '2-year sub'; break;
              case 'G1': $sub_type = '1-year gift'; break;
              case 'G2': $sub_type = '2-year gift'; break;
              default: $sub_type = $post_vars['SubType']; break;
              }
           	 	$html .= '<td>' . $sub_type . ' at $' . $post_vars['Price'] . '</td></tr>' . "\n";
            	$text .= $sub_type . ' at $' . $post_vars['Price'] . "\n";
            } elseif  ($fc_def['label'] == 'State/Province' || $fc_def['label'] == 'Billing State'){
            	$html .= '<td>' . $value . '</td></tr>' . "\n";
            	$text .= $value . "\n";
            } else {
            	$html .= '<td>' . $fc_def['options'][$value] . '</td></tr>' . "\n";
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
    }   // end generating form control responses
    $html .= '<tr><td>Submitted: </td><td>' . date('m-d-y, g:i a', time()) . '  Pacific</td></tr>';
    $html .= '<tr><td>PayPalTransactionID: &nbsp;</td><td>' . $post_vars['TransactionID'] . '</td></tr>';
    $html .= '</table><br />' . "\n";
    $text .= 'Submitted: ' . date('m-d-y, g:i a', time()) . '  Pacific'. "\n";
    $text .= 'PayPalTransactionID:' . $post_vars['TransactionID'];
    $html .= '</body>';
    $html .= '</html>';

    $email =new Email();
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
    
   $gift_vars = array();
   foreach ($attempted_gifts as $key=>$gift_num) {
            $tmp_gift_var   = array(); 
            $post_vars_gift = array(); // reset the temporary gift-specific post values
            foreach ($post_vars as $name => $value) {
                $post_vars_gift[$name] = $value;
            }
            foreach ($post_vars_gift as $name => $value) {
                // strpos has difficulty reporting first position '0'
                if (strpos('x' . $name, (string)$gift_num) == 1) {
                    $post_vars_gift[substr($name, 2)] = $value;
                    $tmp_gift_var[substr($name, 2)] = $value;                    
                }
            }
            if(count($tmp_gift_var))
                $gift_vars[] = $tmp_gift_var;
   }
   $post_vars['Gifts']       = $gift_vars;
   $post_vars['NumberGifts'] = count($gift_vars);
   
   $h_confirmation           = null;
   $h_confirmation_default   = null;
   if(get_field('gift_confirmation_templates')){
        while(has_sub_field('gift_confirmation_templates')){
            $gift_confirmation_template_promo  = get_sub_field('promo');
            $data   = array(
                        "email_confirmation" => get_sub_field("email_confirmation_content"),
                        "browser_confirmation_content" => get_sub_field("browser_confirmation_content")
                      );
            
            if($gift_confirmation_template_promo == 'gift'){
                $h_confirmation_default = $data;
            }
            if($gift_confirmation_template_promo == $promo){
                $h_confirmation = $data;
            }            
        }         
   }
   
   if(!$h_confirmation)
    $h_confirmation = $h_confirmation_default;
    
    require_once(get_template_directory().'/lib/liquid-template/Liquid.class.php');
    $liquid = new LiquidTemplate();
    try{
        $liquid->parse($h_confirmation["email_confirmation"]);
        $html   = $liquid->render($post_vars);
    }catch(Exception $ex){
        echo $ex->getMessage(); die;
    }
    $text   = $html;
    $text   = str_replace(array('<br/>','<br />'),array("\n","\n"), $text);
    $text   = strip_tags($text);

    $email =new Email();
    $email->SetMailer(COMPANY_NAME . ' mail program'); // this is optional but helpful
    $email->SetRecipient($form['Email']['ctl_value']);
    $email->SetBlindCopy(CONFIRM_BCC);
    // Set this to be a default address if cannot be set from form
    $from = '"' . FROM_EMAIL . '" <' . FROM_EMAIL . '>';
    $email->SetFrom($from);
    $email->SetSubject(COMPANY_NAME . ' order confirmation');
    $email->SetHtml($html);
    $email->SetText($text);

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
                        <?php if ($action == 'show'): ?>
                    	<section class="formShop">
                            <div class="title03">
                                <img src="<?php echo $header_image;?>">
                                <?php if($promo == 'gift'):?>
                                    <?php if($gift2):?>
                                        <p class="subscription-subheader"><strong>To give a 1-year gift subscription, click <a href="<?php echo add_query_arg(array('SourceCode'=>$source),get_permalink(get_the_ID()));?>"><strong>here.</strong></a></strong></p>
                                    <?php else: ?>
                                        <p class="subscription-subheader"><strong>To give a 2-year gift subscription, click <a href="<?php echo add_query_arg(array('SourceCode'=>$source,'2year'=>1),get_permalink(get_the_ID()));?>"><strong>here.</strong></a></strong></p>
                                    <?php endif;?>                                    
                                <?php endif;?>        
                                <p>Add $20/year for all subscriptions mailed outside the United States.</p>
                            </div>
                        </section>
                        <?php                             
                            if ($error) {
                                echo '<p class="contact_error">' . $error . '</p>' . "\n";
                            }
                            if ($action == 'show'){
                                echo '<p class="small_text">Required fields are marked with<span class="contact_required">&nbsp;*</span></p>' . "\n";
                            }
                        ?>
                        <form method="post" id="gift_form" action="<?php echo add_query_arg(array('page_id' =>  get_the_ID(),'SourceCode'=>$source,'2year'=>$gift2));?>">
                                <section class="formShop">
                                    <ul class="form">
                                    <input type="hidden" name="time" value="<?php echo time(); ?>" />
                                    <input type="hidden" name="action" value="process" />                                
                                    <?php
                                    foreach ($form as $fc_name => $fc_def) {
                                        $req_mark = !empty($fc_def['required']) ? '<span class="required">*</span>' : '';
                                        $text_req_mark = ($fc_def['label'] != '') ? '' : $req_mark;
                                        $parm = !empty($fc_def['parm']) ? ' ' . $fc_def['parm'] : '';
                                        $value = $fc_def['ctl_value'];

                                        $label_req_mark = ($fc_def['label'] != '') ? $req_mark : '';                                                                                        
                                        
                                        if($fc_def['type'] == 'radio' || $fc_def['type'] == 'checkbox'){
                                            echo '<li>';
                                        }else{
                                            echo '<li class="field">';
                                        }
                                        
                                        $jquery_validate = '';
                                        if(!empty($fc_def['required'])){
                                            if($fc_name != 'ShiptoZip' && $fc_name != 'Zip'){
                                                if($fc_name == 'Email'){
                                                    $jquery_validate = 'validate="required:true,email:true"';
                                                }else
                                                    $jquery_validate = 'validate="required:true"';                                                
                                            }
                                            /*
                                            if($fc_name != 'card_number' && $fc_name != 'exp_month' 
                                                    && $fc_name != 'exp_year' && $fc_name != 'cvv' 
                                                    && $fc_name != 'ShiptoZip' && $fc_name != 'Zip'
                                                    && fc_name != 'Contact' && $fc_name != 'Newsletter'){
                                                        if($fc_name == 'Email'){
                                                            $jquery_validate = 'validate="required:true,email:true"';
                                                        }else
                                                            $jquery_validate = 'validate="required:true"';
                                            }
                                             */
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
                                                    echo '<label><input '.$jquery_validate.' type="radio" name="' . $fc_name . '" value="' . htmlspecialchars($opt_name) . '"' . $checked . $parm .' />&nbsp;' . $opt_label . "</label>";
                                                    if($fc_name == 'SubType') echo '<br/>';
                                                    else echo '&nbsp;';
                                                }												
                                                if($fc_name == 'SubType' || $fc_name == 'Contact' || $fc_name == 'Newsletter')
                                                        echo '<label class="error" for="SubType">This field is required</label>';
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
                                            echo '<br/><label>&nbsp;</label>';
                                            echo $fc_def['text_below'];
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
                        <?php if ($action == 'thanks'):
                            require_once(get_template_directory().'/lib/liquid-template/Liquid.class.php');
                            $liquid = new LiquidTemplate();
                            try{
                                $liquid->parse($h_confirmation["browser_confirmation_content"]);
                                $html   = $liquid->render($post_vars);
                            }catch(Exception $ex){
                                echo $ex->getMessage(); die;
                            }
                            $text   = $html;
                            $text   = str_replace(array('<br/>','<br />'),array("\n","\n"), $text);
                            $text   = strip_tags($text);
                            echo $html;
                            ?>
                            <p><a href="<?php echo get_permalink(); ?>">Return to gift page</a></p>
                        <?php endif;?>                        
                    </div>
                    <div class="clearfix"></div>
            </section>
        </div>
        <div class="clearfix"></div>
        <script type="text/javascript">           
            $(document).ready(function(){
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
               $("select[name=exp_month]").parent(".field").addClass("megaSelect");
               var parent_exp_year = $("select[name=exp_year]").parent(".field");               
               $("select[name=exp_year]").insertAfter("select[name=exp_month]");
               $("select[name=exp_year]").before("&nbsp;");               
               parent_exp_year.remove(); 
            });
            function submitFormProcess(){
                jQuery("#gift_form").submit();
            }
        </script>    
    </div>
<?php get_footer();?>