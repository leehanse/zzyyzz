<?php

   $phone = '1-877-246-2423';
   $email = 'subscriptions@imbibemagazine.com';
   $domestic_start = 'November/December 2013';
   $intl_start = 'November/December 2013';



   $start = ($country == 'United States of America') ? $domestic_start : $intl_start;
   ?>


<h1>THANK YOU!</h1>

<p class="confirm">
We will continue to serve you the best blend of drink news, profiles, travelogues and recipes!
</p>
<p class="confirm">
You have ordered a <?php echo $type ?> for <?php echo '$' . $price; ?>.  This renewal will begin after the last issue of the current subscription (or if your subscription has lapsed, with our next issue) and includes a total of <?php echo ($number*6) ?> additional issues.
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

<!--cult beer bonus-->
<p class="confirm"><strong>BONUS:</strong> Get your <a href="http://www.imbibemagazine.com/images/stories/pdfs/Imbibe_CultBeers_Bonus.pdf">free download</a> of <em>Imbibe</em>'s Cult Beer Guide.</p>
<!--cult beer bonus-->

<p class="confirm">More ways to connect with <em>Imbibe</em>:<br />
&#187 Read recipes, news and more on our blog, <a href="http://imbibemagazine.com/blog"><em>Imbibe</em> Unfiltered</a><br />
&#187 Check out Imbibe's first-ever recipe book, <em>The American Cocktail</em>: <a href="http://www.imbibemagazine.com/shop">www.imbibemagazine.com/shop</a><br />
&#187 Join us on <a href="http://www.facebook.com/imbibe">Facebook</a> and <a href="http://www.twitter.com/imbibe">Twitter</a> for bonus recipes, news and exclusive giveaways</p>

<p class="confirm">Cheers,<br />
Your friends at <em>Imbibe</em></p>

<p class="confirm"><em>Imbibe</em> Magazine<br />
1-877-246-2423<br />
subscriptions@imbibemagazine.com</p>

<p class="confirm">P.S. <em>Imbibe</em> makes a great gift... <a href="https://www.imbibemagazine.com/gift.php?src=confirm">toast your family and friends and save!</a></p>

