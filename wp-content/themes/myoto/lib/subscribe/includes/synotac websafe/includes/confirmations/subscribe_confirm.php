<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $domestic_start = 'January/February 2010 issue, arriving late January';
   $intl_start = 'March/April 2010 issue';



   $start = ($country == 'United States of America') ? $domestic_start : $intl_start;
   ?>

<img src="/images/spacer.gif" width="1" height="1" onload="javascript:pageTracker._trackPageview('/funnel_subscribe/step2.html')" /><br />
<h1>THANK YOU! We appreciate your order.</h1>

<p class="confirm">You have ordered a <?php echo $type ?> to <em>Imbibe</em> for <?php echo '$' . $price; ?>.  New subscriptions will begin with our <?php echo $start ?>, and include a total of <?php echo ($number*6) ?> issues.  Please allow 4-8 weeks for delivery of the first issue in the US and up to 12 weeks internationally.</p>


<p class="confirm">If this order is a gift, use our e-card to announce it: <a href="http://www.imbibemagazine.com/giftcard">www.imbibemagazine.com/giftcard</a></p>

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

<p class="confirm">If you have any questions or changes, please e-mail us at <?php echo $email ?> or call <?php echo $phone ?> Monday through Friday, between 9 a.m. and 5 p.m. Pacific Time.</p>

<p class="confirm">We invite you to:<br />
1. Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog">Imbibe Unfiltered</a><br />
2. Read from back issues online at: <a href="http://www.imbibemagazine.com/backissues">www.imbibemagazine.com/backissues</a></p>

<p class="confirm">Cheers,<br />
Your friends at Imbibe</p>

<p class="confirm">Imbibe Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>

