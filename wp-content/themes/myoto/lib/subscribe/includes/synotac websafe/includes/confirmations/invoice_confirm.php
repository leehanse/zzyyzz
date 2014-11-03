<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $domestic_start = 'May/June 2009 issue';
   $intl_start = 'May/June 2009 issue';



   $start = ($country == 'United States of America') ? $domestic_start : $intl_start;
   ?>
<img src="/images/spacer.gif" width="1" height="1" onload="javascript:pageTracker._trackPageview('/funnel_payup/step2.html')" /><br />
<h1>THANK YOU FOR YOUR PAYMENT!</h1>

<p class="confirm">
Your order is now complete.
</p>
<p class="confirm">
You have paid <?php echo '$' . $price; ?> for a <?php echo substr($type,0,6) ?> subscription to <em>Imbibe</em>. This subscription includes a total of <?php echo ($number*6) ?> issues, one or more of which has already been delivered.
</p>

<p class="confirm">We will send <em>Imbibe</em> to the following address as requested:<br />
   <?php
   echo $name . '<br />';
   echo ($company) ? $company . '<br />' : '';
   echo $address1 . '<br />';
   echo ($address2) ? $address2 . '<br />' : '';
   echo $city . ', ' . $state . ' ' . $zip . '<br />';
   echo $country;
   ?>
</p>

<p class="confirm">If you have any questions or changes, please e-mail us at <?php echo $email ?> or call <?php echo $phone ?>.</p>

<p class="confirm">While you await your next issue, also check out:<br />
1. Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog">Imbibe Unfiltered</a><br />
2. <a href="http://app.streamsend.com/public/wSMT/HKQ/subscribe">Sign-up for our monthly e-newsletter</a>, Tasting Notes, and get bonus recipes, reviews and ideas every month.</p>

<p class="confirm">Cheers,<br />
Your friends at Imbibe</p>

<p class="confirm">Imbibe Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>
