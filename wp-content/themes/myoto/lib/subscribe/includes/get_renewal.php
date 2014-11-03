<?php

function GetRenewal($SubscriptionNum) {

  $link = mysql_connect('localhost', DB_USERNAME, DB_PASSWORD);
  if ($link) {
    mysql_select_db(DB_NAME);

    if ($SubscriptionNum) {
      $search_sql = 'SELECT *
           FROM `customer_renewals`
           WHERE `SubscriptionNum` = ' . escape_output($SubscriptionNum);
      $query = mysql_query($search_sql);
      while ($row = mysql_fetch_assoc($query)) {
        $results[] = $row;
      }
        return $results[0];
      }
    } else {
      return FALSE;
    }
}

function GetInvoice($SubscriptionNum) {

  $link = mysql_connect('localhost', DB_USERNAME, DB_PASSWORD);
  if ($link) {
    mysql_select_db(DB_NAME);

    if ($SubscriptionNum) {
      $search_sql = 'SELECT *
           FROM `customer_invoices`
           WHERE `SubscriptionNum` = ' . escape_output($SubscriptionNum);
      $query = mysql_query($search_sql);
      while ($row = mysql_fetch_assoc($query)) {
        $results[] = $row;
      }
        return $results[0];
      }
    } else {
      return FALSE;
    }
}
?>