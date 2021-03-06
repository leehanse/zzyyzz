<?php

  $form = array('SubType' => array('type' => 'radio',
                                      'text' => '<h2>STEP 1: Choose a subscription type</h2>',
                                      'label' => '<span class="subscription-length-span">Subscription Length</span>', // be careful, this label is referenced later for layout purposes
                                      'options' => $sub_display,
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'open_section' => true
                                        ),
                'ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<h2>STEP 2: Mailing address where we should send the subscription</h2>',
                                      'value' => '',
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      'open_section' => true,
                                      'close_section' => true
                                     ),
                'ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => false,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      ),
                'ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => false,
                                      'email' => TRUE,
                                     ),
                'ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => false,
                                      'email' => TRUE,
                                      ),
                'ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => false,
                                      'email' => TRUE,
                                     ),
                'BillingUseShipping'  => array('type' => 'checkbox',
                                      'label' => 'Same as Mailing Address',
                                      'text' => '<h2>STEP 3: Billing Address</h2>',
                                      'required' => FALSE,
                                      'email' => FALSE,
                                      'parm' => 'onclick="fill(this)"',
                                      'open_section' => true,
                                      'close_section' => true
                                      ),
                'SubscriptionNum'  => array('type' => 'hidden',
                                      'label' => 'Subscription Num',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      ),
                'CustomerNum'  => array('type' => 'hidden',
                                      'label' => 'Customer Num',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      ),
                'Gift'  => array('type' => 'hidden',
                                      'label' => 'Gift',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      ),
                'Promo'  => array('type' => 'hidden',     //           should not be logged in db or emailed, just used for
                                      'label' => 'Promo', //           setting the price options at the top of the form
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => FALSE,
                                      ),
                'SourceCode'  => array('type' => 'hidden',
                                      'label' => 'SourceCode',
                                      'value' => $source,
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      ),
                'FirstName' => array('type' => 'text',
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
                                      'label' => 'Email address',
                                      'email_label' => 'Email Address',
                                      'size' => 25,
                                      'text_below' => 'We will never share your email address and/or phone number.',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      ),                                                      
                'Contact' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive email renewal notifications?',
                                      'options' => array ( 'y' => 'Yes',
                                                           'n' => 'No',
                                                           ),
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'email Renewal Notifications',
                                        ),
                'Newsletter' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive our email newsletter, Tasting Notes, including recipes,<br/> reviews, special events and contests?',
                                      'options' => array ( 'y' => 'Yes',
                                                           'n' => 'No',
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
                                      'options' => $referral_options,
                                     ),
                'CardType'    => array('type' => 'select',
                                      'text' => '<h2>STEP 4: Payment Information</h2>',
                                      'label' => 'Payment Type',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'options' => $cards,
                                      'open_section' => true,
                                      'close_section' => true
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
                                      'field_comment' => 'cvv',
                                     ),
               );        
               if($promo == 'renew' || $promo =='invoice' || $promo == 'invoice2y'){
                    $form['RenewalNotice'] = array ('type' => 'radio',
                        'text' => 'Who should receive renewal notices?',
                        'options' => array ( 'recipient' => 'Gift Recipient',
                                            'me' => 'Me',
                                            ),
                        'email' => TRUE,
                        'required' => TRUE,
                        'email_label' => 'Receive Renewal Notices',
                        );  
               }
?>