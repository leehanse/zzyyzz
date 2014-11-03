<?php
/**
 *
 * Miscellaneous functions used throughout this specific site
 *
 * All rights reserved. For license information,  contact Synotac Design at
 * http://www.synotac.com
 *
 * @package Core
 * @copyright Copyright 2008 by Synotac Design LLC
 * @version $Id: general.php 76 2008-05-19 22:41:00Z cat $
 *
 */

// escape an output value for mysql
  function escape_output($val) {
    if (is_string($val) || !is_numeric($val)) {
      $val = '"' . mysql_real_escape_string($val) . '"';
    }
    return($val);
  }
// end of escape output

  /**
   * Build associative array of months used in dropdown menus
   *
   * @return array associative array of month names keyed by month number

  function get_months() {
    $months = array();
    for ($i = 1; $i < 13; $i++) {
      $months[sprintf('%02d',  $i)] = strftime('%B', mktime(0, 0, 0, $i, 1, 2000));
    }
    return $months;
  }
   */

  /**
   * Build associative array of $num_years years used in dropdown menus
   *
   * @param int number of year entries to generate; default is 10
   * @return array associative array of years keyed by long year ('2008',  '2009',  etc)
   */
  function get_years($num_years = 10) {
    $today = getdate();
    $years = array();
    $years[''] = 'Year';
    for ($i = $today['year']; $i < $today['year'] + $num_years; $i++) {
      $years[strftime('%Y', mktime(0, 0, 0, 1, 1, $i))] = strftime('%Y', mktime(0, 0, 0, 1, 1, $i));
    }
    return $years;
  }

 /**
   * Build associative array of months used in dropdown menus
   *
   */
  function get_months() {
    return array(
      '' => 'Month',
      '01' => 'Jan',
      '02' => 'Feb',
      '03' => 'Mar',
      '04' => 'Apr',
      '05' => 'May',
      '06' => 'Jun',
      '07' => 'Jul',
      '08' => 'Aug',
      '09' => 'Sep',
      '10' => 'Oct',
      '11' => 'Nov',
      '12' => 'Dec');
  }
   /**
   * Build associative array of state names AND Canadian Provinces used in dropdown menus
   *
   * @return array associative array of state names keyed by USPS/Canadian state/province abbreviations
   */
  function get_states() {
    return array(
      '' => 'Choose your state',
      'None' => 'None',
      'AL' => 'Alabama',
      'AK' => 'Alaska',
      'AZ' => 'Arizona',
      'AR' => 'Arkansas',
      'CA' => 'California',
      'CO' => 'Colorado',
      'CT' => 'Connecticut',
      'DE' => 'Delaware',
      'DC' => 'Dist. of Columbia',
      'FL' => 'Florida',
      'GA' => 'Georgia',
      'GU' => 'Guam',
      'HI' => 'Hawaii',
      'ID' => 'Idaho',
      'IL' => 'Illinois',
      'IN' => 'Indiana',
      'IA' => 'Iowa',
      'KS' => 'Kansas',
      'KY' => 'Kentucky',
      'LA' => 'Louisiana',
      'ME' => 'Maine',
      'MD' => 'Maryland',
      'MA' => 'Massachusetts',
      'MI' => 'Michigan',
      'MN' => 'Minnesota',
      'MS' => 'Mississippi',
      'MO' => 'Missouri',
      'MT' => 'Montana',
      'NE' => 'Nebraska',
      'NV' => 'Nevada',
      'NH' => 'New Hampshire',
      'NJ' => 'New Jersey',
      'NM' => 'New Mexico',
      'NY' => 'New York',
      'NC' => 'North Carolina',
      'ND' => 'North Dakota',
      'OH' => 'Ohio',
      'OK' => 'Oklahoma',
      'OR' => 'Oregon',
      'PA' => 'Pennsylvania',
      'PR' => 'Puerto Rico',
      'RI' => 'Rhode Island',
      'SC' => 'South Carolina',
      'SD' => 'South Dakota',
      'TN' => 'Tennessee',
      'TX' => 'Texas',
      'UT' => 'Utah',
      'VT' => 'Vermont',
      'VA' => 'Virginia',
      'VI' => 'Virgin Islands',
      'WA' => 'Washington',
      'WV' => 'West Virginia',
      'WI' => 'Wisconsin',
      'WY' => 'Wyoming',
      'AB' => 'Alberta',
      'BC' => 'British Columbia',
      'MB' => 'Manitoba',
      'NB' => 'New Brunswick',
      'NL' => 'Newfoundland and Labrador',
      'NT' => 'Northwest Territories',
      'NS' => 'Nova Scotia',
      'NU' => 'Nunavut',
      'ON' => 'Ontario',
      'PE' => 'Prince Edward Island',
      'QC' => 'Quebec',
      'SK' => 'Saskatchewan',
      'YT' => 'Yukon',
      'AA' => 'U.S. Armed Forces – Americas',
      'AE' => 'U.S. Armed Forces – Europe',
      'AP' => 'U.S. Armed Forces – Pacific'        
    );
  }



  /**
   * Build associative array of country names used in dropdown menus
   * Siobhan requested this list be used: *https://ppmts.custhelp.com/cgi-bin/ppdts.cfg/php/enduser/std_adp.php?p_faqid=83&p_created=1121726693&p_sid=Whz-QZZi&p_accessibility=0&p_lva=&p_sp=cF9zcmNoPTEmcF9zb3J0X2J5PSZwX2dyaWRzb3J0PSZwX3Jvd19jbnQ9MyZwX3Byb2RzPTAmcF9jYXRzPSZwX3B2PSZwX2N2PSZwX3BhZ2U9MSZwX3NlYXJjaF90ZXh0PUNoaW5h&p_li=&p_topview=1
   * @return array associative array of country names keyed by country abbreviations
   */
  function get_countries() {
    return array(
    '' => 'Choose your country',
    'US' => 'United States of America',
    'CA' => 'Canada',
    'AD' => 'Andorra',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AI' => 'Anguilla',
    'AG' => 'Antigua and Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijana',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia and Herzegovinia',
    'BW' => 'Botswana',
    'BR' => 'Brazil',
    'VG' => 'British Virgin Islands',
    'BN' => 'Brunei',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CL' => 'Chile',
    'CN' => 'China',
    'CO' => 'Colombia',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D.Ivoire Lesotho Sao',
    'HR' => 'Croatia',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'TP' => 'East Timor',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'EE' => 'Estonia',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'GA' => 'Gabon',
    'GE' => 'Georga',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KW' => 'Kuwait',
    'LA' => 'Lao People\'s Democratic Republic',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LT' => 'Lithuanai',
    'LU' => 'Luxemborg',
    'MO' => 'Macau,  China',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MU' => 'Mauritius',
    'MX' => 'Mexico',
    'FM' => 'Micronesia,  Federated States of',
    'MD' => 'Moldova',
    'MN' => 'Mongolia',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'NA' => 'Namibia',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NO' => 'Norway',
    'MP' => 'Northern Mariana Islands',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PS' => 'Palestine',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'PH' => 'Republic of Philippines',
    'RO' => 'Romania',
    'RU' => 'Russian Federation',
    'RW' => 'Rwanda',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'CS' => 'Serbia and Montenegros',
    'SC' => 'Seychelles',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'ZA' => 'South Africa',
    'KR' => 'South Korea',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'KN' => 'St. Kitts-Nevis',
    'LC' => 'St. Lucia',
    'VC' => 'St. Vincent and the Grenadines',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'TW' => 'Taiwan',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TO' => 'Tonga',
    'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks and Caicos Islands',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'TZ' => 'United Rep. Of Tanzania',
    'UY' => 'Uruguay',
    'VI' => 'US Virgin Islands',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'WS' => 'Samoa',
    'YE' => 'Yemen Arab Republic',
    'ZM' => 'Zambia'
);
  }







  /**
   * Get file name extension from filename
   *
   * @param string file name
   * @return string extension
   */
  function get_extension($filename) {
    return (count($tmp = explode('.',  basename($filename))) > 1) ? strtolower(array_pop($tmp)) : '';
  }  // end get_extension()

?>