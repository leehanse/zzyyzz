<?php
  $form = array(
  /* 'SubType' => array('type' => 'radio',
                                      'label' => 'Subscription Level',
                                      'email' => FALSE,
                                      'options' => array ( 'S1'=>'&nbsp; One year (6 issues) - $20.00 (Int\'l. $40.00) - Save 33% off the cover price',
                                                           'S2'=>'&nbsp; Two years (12 issues) - $32.00 (Int\'l. $72.00) - Save 46% - Best Value!',
                                                           ),
                                      'email' => TRUE,
                                        ),
 */
                '1_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">1</span><span class="gift_price">SEND GIFT 1 FOR $'.$PRICES[0].' TO:</h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                     ),
                '1_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                     ),
                '1_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                     ),
                '1_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                     ),
                '1_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                     ),
                '1_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 1,
                                      ),
                '1_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 1,
                                     ),
                '1_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 1,
                                      ),
                '1_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 1,
                                     ),
//Gift 2
                '2_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">2</span><span class="gift_price">SEND GIFT 2 FOR $'.$PRICES[1].' TO:</span></h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                     ),
                '2_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                     ),
                '2_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                     ),
                '2_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                     ),
                '2_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                     ),
                '2_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 2,
                                      ),
                '2_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 2,
                                     ),
                '2_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 2,
                                      ),
                '2_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 2,
                                     ),
// GIFT 3
                '3_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">3</span><span class="gift_price">SEND GIFT 3 FOR $'.$PRICES[2].' TO:</h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                     ),
                '3_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                     ),
                '3_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                     ),
                '3_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                     ),
                '3_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                     ),
                '3_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 3,
                                      ),
                '3_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 3,
                                     ),
                '3_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 3,
                                      ),
                '3_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 3,
                                     ),
//GIFT 4
                '4_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">4</span><span class="gift_price">SEND GIFT 4 FOR $'.$PRICES[3].' TO:</h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                     ),
                '4_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                     ),
                '4_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                     ),
                '4_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                     ),
                '4_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                     ),
                '4_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 4,
                                      ),
                '4_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 4,
                                     ),
                '4_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 4,
                                      ),
                '4_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 4,
                                     ),
// GIFT 5
                '5_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">5</span><span class="gift_price">SEND GIFT 5 FOR $'.$PRICES[4].' TO:</h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                     ),
                '5_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                     ),
                '5_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                     ),
                '5_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                     ),
                '5_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                     ),
                '5_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 5,
                                      ),
                '5_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 5,
                                     ),
                '5_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 5,
                                      ),
                '5_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 5,
                                     ),
//GIFT 6
                '6_ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2><span class="gift_num">6</span><span class="gift_price">SEND GIFT 6 FOR $'.$PRICES[5].' TO:</h2>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                     ),
                '6_ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                     ),
                '6_ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                     ),
                '6_ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                     ),
                '6_ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                     ),
                '6_ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'gift' => 6,
                                      ),
                '6_ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 6,
                                     ),
                '6_ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 6,
                                      ),
                '6_ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'gift' => 6,
                                     ),
                'SourceCode'  => array('type' => 'hidden',
                                      'label' => 'SourceCode',
                                      'value' => $source,
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      ),
// BILLING
                'FirstName' => array('type' => 'text',
                                      'text' => '<h2><span class="billing_info_line">BILLING INFORMATION:</h2>',
                                      'label' => 'First Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing First Name',
                                      'parm' => 'class="sub_field"',
                                     ),
                'LastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing Last Name',
                                      'parm' => 'class="sub_field"',
                                     ),
                'Company' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing Company',
                                      'parm' => 'class="sub_field"',
                                     ),
                'Address1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing Address',
                                      'parm' => 'class="sub_field"',
                                     ),
                'Address2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing Suite/Apt No.',
                                      'parm' => 'class="sub_field"',
                                     ),
                'City'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing City',
                                      'parm' => 'class="sub_field"',
                                      ),
                'State'       => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'Billing State',
                                     ),
                'Zip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'email_label' => 'Billing Zip',
                                      ),
                'Country'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'Billing Country',
                                     ),
                'Phone'        => array('type' => 'text',
                                      'label' => 'Phone',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      ),
                'Email'        => array('type' => 'text',
                                      'label' => 'Your email address',
                                      'email_label' => 'email Address',
                                      'size' => 25,
                                      'text_below' => 'We will never share your email address and/or phone number.',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      ),
                'Contact' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive email renewal notifications?',
                                      'options' => array ( 'yes' => 'Yes',
                                                           'no' => 'No',
                                                           ),
                                      'email' => TRUE,
                                       'required' => TRUE,
                                      'email_label' => 'email Renewal Notifications',
                                        ),
                'Newsletter' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive our email newsletter, Tasting Notes, including recipes, reviews, special events and contests?',
                                      'options' => array ( 'yes' => 'Yes',
                                                           'no' => 'No',
                                                           ),
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'Receive email Newsletter',
                                        ),

                'Referred'    => array('type' => 'select',
                                      'label' => 'How did you hear about Imbibe?',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'email_label' => 'Referred By',
                                      'options' => array ('' => '',
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
                                                         ),
                                     ),
                'CardType'    => array('type' => 'select',
                                      'label' => 'Payment Type',
                                      'value' => 'Choose Card Type',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'options' => array ('00' => 'Choose Card Type',
                                                          'Visa' => 'Visa',
                                                          'MasterCard' => 'MasterCard',
                                                          'Amex' => 'American Express',
                                                          'Discover' => 'Discover',
                                                          'PayPal' => 'PayPal',   // Disabled on gifts... needs to be set up for taking multiple orders or a total order, just haven't done yet.
                                                         ),
                                     ),
                'card_number' => array('type' => 'text',
                                      'label' => 'Card Number',  // careful editing, this label is referenced later in program
                                      'value' => '',
                                      'maxlength' => 16,
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'parm' => 'autocomplete="off"',
                                     ),

                'exp_month'    => array('type' => 'select',
                                      'label' => 'Expiration Date',
                                      'value' => '-Month-',
                                      'required' => TRUE,
                                      'email' => FALSE,
                                      'options' => $months,
                                     ),
                'exp_year'    => array('type' => 'select',
                                //    'parm' => 'class="exp_year"',
                                      'label' => 'Expiration Year',
                                      'value' => '-Year-',
                                      'required' => TRUE,
                                      'email' => FALSE,
                                      'options' => $years,
                                     ),
                'cvv' => array('type' => 'text',
                                      'label' => '3 or 4-digit CVV Code',
                                      'value' => '',
                                      'size' => 4,
                                      'maxlength' => 4,
                                      'required' => TRUE,
                                      'email' => FALSE,
                                      'field_comment' => 'cvv',  // tells form to display the What is CVV popup link
                                     ),
               );
               $form['RenewalNotice'] = array ('type' => 'radio',
                                    'text' => 'Who should receive renewal notices?',
                                    'options' => array ( 'recipient' => 'Gift Recipient',
                                                        'me' => 'Me',
                                                        ),
                                    'email' => TRUE,
                                    'required' => TRUE,
                                    'email_label' => 'Receive Renewal Notices',
                                    );               
?>