<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $domestic_start = 'November/December 2013';
   $intl_start = 'November/December 2013';



   $start = ($country == 'United States of America') ? $domestic_start : $intl_start;
   ?>

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

<!--iced cocktails bonus-->
<p class="confirm"><strong>BONUS:</strong> Get your <a href="http://www.imbibemagazine.com/images/stories/pdfs/Imbibe_CultBeers_Bonus.pdf">free download</a> of <em>Imbibe</em>'s Cult Beer Guide.</p>
<!--iced cocktails bonus-->

<p class="confirm">While you await your next issue, connect with <em>Imbibe</em> online:<br />
&#187 Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog"><em>Imbibe</em> Unfiltered</a><br />
&#187 Check out Imbibe's first-ever recipe book, <em>The American Cocktail</em>: <a href="http://www.imbibemagazine.com/shop">www.imbibemagazine.com/shop</a><br />
&#187 Join us on <a href="http://www.facebook.com/imbibe">Facebook</a> and <a href="http://www.twitter.com/imbibe">Twitter</a> for bonus recipes, news and exclusive giveaways</p>

<p class="confirm">Cheers,<br />
Your friends at <em>Imbibe</em></p>

<p class="confirm"><em>Imbibe Magazine</em><br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>
