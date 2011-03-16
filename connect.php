<?php
/* Open connectie met database. */

$local = 1;  // Geef aan of de website+database lokaal draaien of 'live' staan

if($local == 1){
    $DBhost = "localhost";
    $DBuser = "root";
    $DBpass = "";
    $DBName = "zwaneveld_net_hns";
} else {
    $DBhost = "mysql9.greenhost.nl";
    $DBuser = "zwaneveld1";
    $DBpass = "fogNuvsus8";
    $DBName = "zwaneveld_net_hns";
}

mysql_connect($DBhost,$DBuser,$DBpass) or die("Unable to connect to database");
@mysql_select_db("$DBName") or die("Unable to select database $DBName");

?>
