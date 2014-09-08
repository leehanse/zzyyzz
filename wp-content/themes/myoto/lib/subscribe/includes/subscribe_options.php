<?php // subscription/renewal/invoice/ options for form on subscribe.php.  The form on gift.php is set within that file.

/* To add a promotion, paste the following four lines in AFTER the line switch($promo)

  case 'promoname':
    $sub_options['1-year promoname'] = array(15.00, 'Text that gets displayed next to the first radio button on the subscribe page');
    $sub_options['2-year promoname'] = array(25.00, 'Text that gets displayed next to the second radio button on the subscribe page');
    break;

 You can change the promoname, the prices, and all the text between the ' '.  The promoname should have no spaces or special characters other than dash(-) or underscore(_).  Leave the words 1-year and 2-year as they are because the digits 1 and 2 are used in the program.

 International prices are automatically calculated when order is for a shiptoaddress other than the US.  ($20/yr is added)  Do not attempt to set those here.

 DO NOT change the first five cases below, or the last one.  These are the ones that start with:
 case: 'subscribe'
 case: 'renew'
 case: 'invoice'
  case: 'invoice2year'
 default:

 To get visitors to the promotion, point the website to the page named www.imbibemagazine.com/subscribe?promo=promoname
  where you put your actual promoname in.  For the example of the trade promotion,
  www.imbibemagazine.com/subscribe?promo=trade
  You may use a redirect if you prefer to distribute different url.

 Be sure to create a header and a sidebar for your new promotion, even if it is a duplicate of the default.
 These files are in the includes directory.
 subscribe_header.php
 and
 subscribe_sidebar.php

 name your new versions with your promoname.  E.g.
 trade_header.php
 and
 trade_sidebar.php

 */


$sub_options = array();
switch ($promo) {
  case 'subscribe':
  $sub_options['1-year subscription'] = array(20.00, '<b>1 year</b> (6 issues) - $20.00 - Save 33% off the cover price - (Int/l. $40.00)');
  $sub_options['2-year subscription'] = array(32.00, '<strong>BEST VALUE!</strong> 2 years (12 issues) - $32.00 - <strong>Save 46%</strong> - (Int/l. $72.00)');
 break;
  case 'renew':
  $sub_options['1-year renewal'] = array($renew_1yr, '<b>1 year</b> (6 issues) - <del>$29.70</del> $' . $renew_1yr);
  $sub_options['2-year renewal'] = array($renew_2yr, '<strong>BEST VALUE!</strong> 2 years (12 issues) - <del>$59.40</del> $' . $renew_2yr);
 break;
  case 'invoice':
  $sub_options['1-year payup'] = array($invoice_1yr, 'Amount Due - $' . $invoice_1yr);
  $sub_options['2-year payup'] = array($invoice_2yr, '<strong>BEST VALUE!</strong> Get 6 more issues and pay only  - $' . $invoice_2yr);
 break;
  case 'invoice2year':
  $sub_options['2-year payup'] = array($invoice_2yr, 'Amount Due - $' . $invoice_2yr);
 break;
  default:
    $sub_options['1-year subscription'] = array(20.00, '<b>1 year</b> (6 issues) - $20.00 (Int/l. $40.00) - Save 33% off the cover price');
    $sub_options['2-year subscription'] = array(32.00, '<b><i>BEST VALUE!</i>  2 years</b> (12 issues) - $32.00 (Int/l. $72.00) - <strong>Save 46%</strong>');
 break;
  case 'trade':
  $sub_options['1-year trade subscription'] = array(16.00, '<b>1 year</b> (6 issues) - $16.00 - Save 46% (Int/l. $36.00)');
  $sub_options['2-year trade subscription'] = array(26.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $26.00 - <strong>Save 56%</strong> (Int/l. $66.00)');
 break;
  case 'flavor':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
  case 'tales':
  $sub_options['1-year subscription'] = array(15.00, '<b>1 year</b> (6 issues) - $15.00 - Save 49% (Int/l. $35.00)');
  $sub_options['2-year subscription'] = array(25.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $25.00 - <strong>Save 58%</strong> (Int/l. $65.00)');
 break;
  case 'facebook':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
  case 'twitter':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
  case 'scaa':
  $sub_options['1-year trade subscription'] = array(16.00, '<b>1 year</b> (6 issues) - $16.00 - <strong>Save 46%</strong> (Int/l. $36.00)');
  $sub_options['2-year trade subscription'] = array(26.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $26.00 - Save 56% (Int/l. $66.00)');
 break;
 case 'drinkup':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
case 'wallys':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'works':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'flavor2':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'drinkup2':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
  break;
 case '1829':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'cedl':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'zap':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b> (12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'zinfandel':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b> (12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'nightschool':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 case 'sdwff':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'coolvines':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'pinotdays':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'wow':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'beerclub':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'wineclub':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
  case 'whisky':
    $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
    $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'winespies':
    $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
    $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break; 
 case 'hpost':
  $sub_options['1-year subscription'] = array(20.00, '<b>1 year</b> (6 issues) - $20.00 - Save 33% off the cover price - (Int/l. $40.00)');
  $sub_options['2-year subscription'] = array(32.00, '<strong>BEST VALUE!</strong> 2 years (12 issues) - $32.00 - <strong>Save 46%</strong> - (Int/l. $72.00)');
 break;
 case 'hukilau':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'fd13fb':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'fd13tw':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'md12fb':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'md12tw':
   $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
   $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'kegworks':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'amazingwine':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'amazingbeer':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'plonk':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'cask':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'napastyle':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
   break;
 case 'hitime':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
   break;
 case 'bourbonb':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
   break;
 case 'bevmo':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
   break;
 case 'cvibe':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'cking':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
  case 'truebeer':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'deandeluca':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 break;
 case 'espressoparts':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
  break;
 case 'coffeeproject':
  $sub_options['1-year subscription'] = array(18.00, '<b>1 year</b> (6 issues) - $18.00 - Save 39% (Int/l. $38.00)');
  $sub_options['2-year subscription'] = array(29.00, '<b><i>BEST VALUE!</i>  2 years</b>(12 issues) - $29.00 - <strong>Save 51%</strong> (Int/l. $69.00)');
 }

?>