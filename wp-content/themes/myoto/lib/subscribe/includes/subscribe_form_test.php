<?php

  $form = array('SubType' => array('type' => 'radio',
                                      'text' => '<br /><span class="subscribe_steps">STEP 1: Choose a subscription type</span>',
                                      'label' => 'Subscription Length', // be careful, this label is referenced later for layout purposes
                                      'options' => $sub_display,
                                      'email' => TRUE,
                                      'required' => TRUE,
                                        ),
                'ShiptoFirstName' => array('type' => 'text',
                                      'label' => 'First Name',
                                      'text' => '<br /><span class="subscribe_steps">STEP 2: Mailing address where we should send the subscription</span>',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoLastName' => array('type' => 'text',
                                      'label' => 'Last Name',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoCompany' => array('type' => 'text',
                                      'label' => 'Company',
                                      'value' => '',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoAddress1'     => array('type' => 'text',
                                      'label' => 'Address',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoAddress2'     => array('type' => 'text',
                                      'label' => 'Suite/Apt No.',
                                      'required' => FALSE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                     ),
                'ShiptoCity'        => array('type' => 'text',
                                      'label' => 'City',
                                      'size' => 25,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      ),
                'ShiptoState'    => array('type' => 'select',
                                      'label' => 'State/Province',
                                      'value' => '-Choose your state-',
                                      'options' => $states,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                     ),
                'ShiptoZip'        => array('type' => 'text',
                                      'label' => 'Zip/Postal Code',
                                      'size' => 25,
                                      'maxlength' => 10,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      ),
                'ShiptoCountry'    => array('type' => 'select',
                                      'label' => 'Country',
                                      'value' => '-Choose your country-',
                                      'options' => $countries,
                                      'required' => TRUE,
                                      'email' => TRUE,
                                     ),
                'BillingUseShipping'  => array('type' => 'checkbox',
                                      'label' => 'Same as above',
                                      'text' => '<br /><span class="subscribe_steps">STEP 3: Billing Address</span>',
                                      'required' => FALSE,
                                      'email' => FALSE,
                                      'parm' => 'onclick="fill(this)"',
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
                                      'label' => 'Your e-mail address',
                                      'email_label' => 'E-mail Address',
                                      'size' => 25,
                                      'text_below' => 'We will never share your e-mail address and/or phone number.',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'parm' => 'class="sub_field"',
                                      ),
                'Contact' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive e-mail renewal notifications?',
                                      'options' => array ( 'y' => 'Yes',
                                                           'n' => 'No',
                                                           ),
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'E-mail Renewal Notifications',
                                        ),
                'Newsletter' => array ('type' => 'radio',
                                      'text' => 'Would you like to receive our e-mail newsletter, Tasting Notes, including recipes, reviews, special events and contests?',
                                      'options' => array ( 'y' => 'Yes',
                                                           'n' => 'No',
                                                           ),
                                      'email' => TRUE,
                                      'required' => TRUE,
                                      'email_label' => 'Receive E-mail Newsletter',
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
                                      'text' => '<br /><span class="subscribe_steps">STEP 4: Payment Information</span>',
                                      'label' => 'Payment Type',
                                      'value' => '',
                                      'required' => TRUE,
                                      'email' => TRUE,
                                      'options' => $cards,
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
               // add a question to the end when the order or renewal is a gift
               if ($gift) {
                 $form['RenewalNotice'] = array ('type' => 'radio',
                                                 'text' => 'Who should receive renewal notices?',
                                                 'options' => array ( 'recipient' => 'Gift Recipient',
                                                                      'me' => 'Me',
                                                                      ),
                                                 'email' => TRUE,
                                                 'required' => TRUE,
                                                 'email_label' => 'Receive E-mail Newsletter',
                                        );
               }
?>