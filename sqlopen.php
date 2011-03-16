<?php
/* Open connectie met database. */
$DBhost = "localhost";
$DBuser = "consumentenbond";
$DBpass = "Amsterdam";
$DBName = "consumentenbond";

$DBhost = "mysql9.greenhost.nl";
$DBuser = "zwaneveld1";
$DBpass = "fogNuvsus8";
$DBName = "zwaneveld_net_hns";

mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database");
@mysql_select_db("$DBName") or die("Unable to select database $DBName");
?>
