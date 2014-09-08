<?php  //new rollover code
$id = 0; // THIS IS FOR TESTING PURPOSES ONLY

  function rollover($name,$link,$alt_text,$width,$height,$type = '.gif') {

    $file = basename($_SERVER['PHP_SELF'], ".php");
    $location = '/' . $file . '.php'; //setting up the file variable to match the link variable
//    echo 'File = ' . $file;
//    echo 'Link = ' . $link;
//    echo 'Location = ' . $location;

    if ($file == 'index') $location = '/';
    if ($location == $link) {
      $over = ''; 		$off = '_over'; $down = '_over';
    } else {
      $over = '_over'; 		$off = ''; $down = '_over';
    }



    $string =  '
      <script type="text/javascript" language="javascript">
        var ' . $name . '=new Image();' . $name . '.src="images/' . $name . $off . $type .'";
        var ' . $name . '_over=new Image();' . $name . '_over.src="images/' . $name . $over . $type . '";
        var ' . $name . '_down=new Image();' . $name . '_down.src="images/' . $name . $down . $type. '";
      </script>
    <a class="image_link" onmouseover="swap(\'' . $name . '\')" onmouseout="restore(\'' . $name . '\')" onmousedown="down(\'' . $name . '\')" href="' . $link . '"><img src="images/' . $name . $off . $type .'" alt="' . $alt_text . '" width="' . $width . '" height="' . $height . '" id="' . $name . '"/></a>';
    return $string;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

<script language="JavaScript" type="text/javascript" src="javascript/rollovers.js"></script>

<title>Imbibe Magazine - Subscribe</title>
<meta name="keywords" content="imbibe magazine" />
<meta http-equiv="Content-Type" content="text/html;" />

<link rel="stylesheet" type="text/css" href="/templates/imbibe/css/global.css" />
<link rel="stylesheet" type="text/css" href="/templates/imbibe/css/template.css" />
<link rel="stylesheet" type="text/css" href="/templates/imbibe/css/ecommerce.css" />

<style type="text/css" media="all">
  body {background: url('/templates/imbibe/images/background_gradient.jpg') center repeat-y #e6e6e7; text-align: center;}
  #main {width: 1002px; margin: 0 auto; text-align: left; background: white;}
  #main1 {padding: 20px;}
  #subscriber_tools {color: #f6f3e2; font-size: 16px; font-weight: bold;}
  #tools_table {width: 100%; background-color: #325b61; row-height: 20px;}
  #subscribe_table {width: 100%;}
  #tools_table a {color: #f6f3e2; font-size: 16px; text-decoration: none; }
  #tools_table .red_arrows {color: #f6f3e2;}
  #tools_table a:hover {color: #b0282e; background: #f6f3e2;}
  #tools_options {color: #f6f3e2; font-size: 16px; font-weight: normal; padding: 2px;}

  /* FOOTER */
  #footer_nav {background: #325a61; width: 100%; clear: right; padding: 2px 0; margin-top: 10px; margin-right: 1px;}
  #footer_nav table {margin: 0 auto;}
  #footer_nav td {text-align: center;}
  #footer_nav a, #footer_nav a:link, #footer_nav a:visited {background: #325a61; padding: 1px 10px 1.5px 10px; color: #f6f3e2; font-weight: bold; font-size: 11px; text-align: center; text-decoration: none;}
  #footer_nav a:hover {text-decoration: none; color: #325a61; background: #f6f3e2;}
  #credits p {text-align: center;}
</style>
