<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $domestic_start = 'November/December 2013';
   $intl_start = 'November/December 2013';



   $start = ($country == 'United States of America') ? $domestic_start : $intl_start;
   ?>


<h1>THANK YOU! We appreciate your order.</h1>

<p class="confirm">You have ordered a <?php echo $type ?> to <em>Imbibe</em> for <?php echo '$' . $price; ?>.  New subscriptions will begin with our <?php echo $start ?>, and include a total of <?php echo ($number*6) ?> issues.  Please allow 8-12 weeks for delivery of the first issue.</p>


<p class="confirm">If this order is a gift, use our e-card to announce it: <a href="http://www.imbibemagazine.com/giftcard">www.imbibemagazine.com/giftcard</a></p>

<!--cult beers bonus-->
<p class="confirm"><strong>BONUS:</strong> Get your <a href="http://www.imbibemagazine.com/images/stories/pdfs/Imbibe_CultBeers_Bonus.pdf">free download</a> of <em>Imbibe</em>'s Cult Beer Guide.</p>
<!--cult beers bonus-->

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

<p class="confirm">While you await your first issue, connect with <em>Imbibe</em> online:<br />
&#187 Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog"><em>Imbibe</em> Unfiltered</a><br />
&#187 Check out Imbibe's first-ever recipe book, <em>The American Cocktail</em>: <a href="http://www.imbibemagazine.com/shop">www.imbibemagazine.com/shop</a><br />
&#187 Join us on <a href="http://www.facebook.com/imbibe">Facebook</a> and <a href="http://www.twitter.com/imbibe">Twitter</a> for bonus recipes, news and exclusive giveaways</p>

<p class="confirm">Cheers,<br />
Your friends at <em>Imbibe</em></p>

<p class="confirm"><em>Imbibe</em> Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>

