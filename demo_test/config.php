<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
$host = "localhost";
$uname = "newagreement_veg_test";  //agrdev
$pass = "newagreement_veg_test";  //agrdev1234
$dbname = "newagreement_veg_test";

mysql_connect($host,$uname,$pass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
mysql_query("SET NAMES utf8");



?>

