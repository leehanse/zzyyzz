<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $start = 'November/December 2013';
   ?>

<img src="/images/spacer.gif" width="1" height="1" onload="javascript:pageTracker._trackPageview('/funnel_gift/step2.html')" /><br />
<h1>THANK YOU! We appreciate your order.</h1>

<p class="confirm">Thank you for your order of <?php echo $num_gifts ?> <?php echo $type ?>(s) to <em>Imbibe</em> for a total of  <?php echo '$' . $price; ?>. New subscriptions will begin with our <?php echo $start ?>. One year subscriptions include a total of 6 issues; Two year subscriptions include a total of 12 issues. Allow 8-12 weeks for delivery of the first issue. Please check below to make sure all addresses are correct.</p>

<p class="confirm">Click <a href="http://www.imbibemagazine.com/giftcard">this link</a> to get an e-card you can use to announce your gift!</p>

<!--cult beers gift-->
<p class="confirm"><strong>BONUS:</strong> Get your <a href="http://www.imbibemagazine.com/images/stories/pdfs/Imbibe_CultBeers_Bonus.pdf">free download of <em>Imbibe</em>'s Cult Beer Guide,</a> our thank you gift for sharing <em>Imbibe</em>.</p>
<!--cult beers gift-->

<p class="confirm">If you have any questions or changes, please e-mail us at <?php echo $email ?> or call <?php echo $phone ?>.</p>

<p class="confirm">Connect with <em>Imbibe</em> online:<br />
&#187 Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog"><em>Imbibe</em> Unfiltered</a><br />
&#187 Check out Imbibe's first-ever recipe book, <em>The American Cocktail</em>: <a href="http://www.imbibemagazine.com/shop">www.imbibemagazine.com/shop</a><br />
&#187 Join us on <a href="http://www.facebook.com/imbibe">Facebook</a> and <a href="http://www.twitter.com/imbibe">Twitter</a> for bonus recipes, news and exclusive giveaways</p>

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
Your friends at <em>Imbibe</em></p>

<p class="confirm"><em>Imbibe</em> Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>
