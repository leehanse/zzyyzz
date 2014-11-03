<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $start = 'January/February 2010 issue';
   ?>

<img src="/images/spacer.gif" width="1" height="1" onload="javascript:pageTracker._trackPageview('/funnel_gift/step2.html')" /><br />
<h1>THANK YOU! We appreciate your order.</h1>

<p class="confirm">Thank you for your order of <?php echo $num_gifts ?> <?php echo $type ?>(s) to <em>Imbibe</em> for a total of  <?php echo '$' . $price; ?>. New subscriptions will begin with our <?php echo $start ?>, and include a total of 6 issues for one-year subscriptions and 12 issues for two-year subcriptions. Allow 4-8 weeks for delivery of the first issue in the US and up to 12 weeks internationally. Please check below to make sure all addresses are correct.</p>

<p class="confirm">Click <a href="http://www.imbibemagazine.com/giftcard">this link</a> to get an e-card you can use to announce your gift!</p>

<p class="confirm">If you have any questions or changes, please e-mail us at <?php echo $email ?> or call <?php echo $phone ?>.</p>

<p class="confirm">We invite you to:</p>
<ol>
<li>Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog">Imbibe Unfiltered</a></li>
<li>Read from back issues online at: <a href="http://www.imbibemagazine.com/backissues">www.imbibemagazine.com/backissues</a></li>
</ol>

<p class="confirm">We will send <em>Imbibe</em> to the following address(s) as requested:<br />

<?php
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
  }

   $name = $post_vars_gift['ShiptoFirstName'] . ' ' . $post_vars_gift['ShiptoLastName'];
   $company = $post_vars_gift['ShiptoCompany'];
   $address1 = $post_vars_gift['ShiptoAddress1'];
   $address2 = $post_vars_gift['ShiptoAddress2'];
   $city = $post_vars_gift['ShiptoCity'];
   $state = ($post_vars_gift['ShiptoState'] == 'None') ? '' : $post_vars_gift['ShiptoState'];
   $zip = $post_vars_gift['ShiptoZip'];
   $country = $countries[$post_vars_gift['ShiptoCountry']];


   echo $name . '<br />';
   echo ($company) ? $company . '<br />' : '';
   echo $address1 . '<br />';
   echo ($address2) ? $address2 . '<br />' : '';
   echo $city . ', ' . $state . ' ' . $zip . '<br />';
   echo $country. '<br /><br />';
}
?>

</p>

<p class="confirm">Cheers,<br />
Your friends at Imbibe</p>

<p class="confirm">Imbibe Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>
