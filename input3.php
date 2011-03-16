<?php
if(!session_id()){session_start();}
#if($_SESSION['input'][0]) { unset($_SESSION['input'][0]); }
$debug = 0;
define('INCLUDE_CHECK',1);
require "connect.php";     
      
    if(!$_REQUEST['coalitie'] && !$_REQUEST['premier'] && !$_REQUEST['naam'] ){ echo("Geen antwoord stelling ingevoerd..."); }

    if($_REQUEST['coalitie']) {  $coalitie = $_REQUEST['coalitie']; $_SESSION['coalitie'] = $_REQUEST['coalitie'];}
    if($_REQUEST['premier']) { $premier = $_REQUEST['premier'];  $_SESSION['premier'] = $_REQUEST['premier']; }
    if($_REQUEST['naam']) { $naam = $_REQUEST['naam'];  $_SESSION['naam'] = $_REQUEST['naam']; }

    @$coalitie = stripslashes($coalitie);   #echo get_magic_quotes_gpc();
    @$coalitie = preg_replace('/"/','', $coalitie);
    @$coalitie = (int) $coalitie + 0;

    @$premier = stripslashes($premier);   #echo get_magic_quotes_gpc();
    @$premier = preg_replace('/"/','', $premier);
    @$premier = (int) $premier + 0;

    @$naam = stripslashes($naam);   #echo get_magic_quotes_gpc();
    @$naam = preg_replace('/"/','', $naam);

    @$_SESSION['naam'] = stripslashes($_SESSION['naam']);   #echo get_magic_quotes_gpc();
    @$_SESSION['naam'] = preg_replace('/"/','', $_SESSION['naam']);

    if($coalitie){ $_SESSION['coalitie'] = $coalitie; }
    if($premier){ $_SESSION['premier'] = $premier; }
    if($naam){ $_SESSION['naam'] = $naam; }

    $url = 'http://www.mijncoalitie.nl/coalitie-van.php?coalitie='.$_SESSION['coalitie'].'&premier='.substr($_SESSION['premier'],1).'&naam='.$_SESSION['naam'];
#    echo '<a href="'.$url.'" target="_blank">'.$url.'</a>';

    echo '<p class="logos">
    <a href="http://twitter.com/home?status=Mijn+Coalitie%20-'.urlencode($url).'" title="deel je coalitie met vrienden op twitter!" target="_blank"><img class="social" src="/images/twitter.gif" /></a>
    <a href="http://www.facebook.com/share.php?u='.urlencode($url).'" title="deel je coalitie met vrienden op facebook!" target="_blank"><img class="social" src="/images/facebook.gif" /></a>
    <a href="http://www.hyves.nl/profilemanage/add/tips/?name=Mijn+Coalitie&text=+'.urlencode($url).'" title="deel je coalitie met vrienden op hyves!" target="_blank"><img class="social" src="/images/hyves.gif" /></a>
    <a href="http://nujij.nl/jij.lynkx?t=Mijn+Coalitie&u='.urlencode($url).'" title="deel je coalitie met vrienden op nujij!" target="_blank"><img class="social" src="/images/nujij.gif" /></a>

    </p>
    </div>
    <p class="url">Of gebruik onderstaande link voor je eigen netwerk, e-mail of tweet: <br />
        <b class="link"> <a href="'.$url.'" target="_blank">'.$url.'</a> </b>
    </p>';


    #$loguser = "INSERT INTO `zwaneveld_net_hns`.`user`
    #        ( `ID` ,`leeftijdid` ,`geslachtman` ,`postcode` ,`email` ,`datum` ,`antwoordcombi` ,`coalitieid` ,`meeregeerpartij1` ,`coalitiezonder1` ,`cookie`, `session` ,`ipadres`)
    #        VALUES ( '' , '2' , '1' , '1058' , '' , NOW( ) , '".$_SESSION['antwoordcombi']."', '".$_SESSION['coalitie']."', '".$_SESSION['include']."', '".$_SESSION['exclude']."', '".$_SESSION['cookiename']."' , '".$session_id()."' , '".$_SERVER['REMOTE_ADDR']."' ) WHERE session = ".session_id();

#    $loguser = "UPDATE `zwaneveld_net_hns`.`user` SET `leeftijdid` = '',  `email` = '', `geslachtman` = '', `postcode` = '',`email` ='' ,`datum` = NOW( ),`antwoordcombi` ='".$_SESSION['antwoordcombi']."',`coalitieid` = '".$_SESSION['coalitie']."',`meeregeerpartij1` = '".$_SESSION['include']."' ,`coalitiezonder1` = '".$_SESSION['exclude']."',`cookie` = '', `session` = '".session_id()."',`ipadres` = '".$_SERVER['REMOTE_ADDR']."' WHERE `session` = '".session_id()."' ";
#    # "UPDATE `table2` SET email='$row[3]', username='$row[1]', pwd='$row[2]' WHERE UID='$row[0]'" // http://forums.devarticles.com/mysql-development-50/update-multiple-columns-using-mysql-update-4197.html
#    if($debug){echo $loguser;}
#    $reslog = mysql_query($loguser);


    # LOG USER

$ressession = mysql_query("SELECT * FROM `zwaneveld_net_hns`.`user` WHERE `session` = '".session_id()."'");
$rowsession = mysql_fetch_assoc($ressession);

if($rowsession['session']){

    $loguser = "UPDATE `zwaneveld_net_hns`.`user` SET `leeftijdid` = '',  `email` = '', `geslachtman` = '', `postcode` = '',`email` ='' ,
        `datum` = NOW( ),`antwoordcombi` ='".$_SESSION['antwoordcombi']."',`coalitieid` = '".$_SESSION['coalitie']."',
            `meeregeerpartij1` = '".$_SESSION['include']."' ,`coalitiezonder1` = '".$_SESSION['exclude']."',
                `cookie` = '', `session` = '".session_id()."',`ipadres` = '".$_SERVER['REMOTE_ADDR']."' ";
    $loguser .= "WHERE `session` = '".session_id()."' ";
}
else{
    $loguser = "INSERT INTO `zwaneveld_net_hns`.`user`
                ( `ID` ,`leeftijdid` ,`geslachtman` ,`postcode` ,`email` ,`datum` ,`antwoordcombi` ,`coalitieid` ,`meeregeerpartij1` ,`coalitiezonder1` ,`cookie`, `session` ,`ipadres`)
                VALUES ( '' , '' , '' , '' , '' , NOW( ) , '".$_SESSION['antwoordcombi']."', '".$_SESSION['coalitie']."', '".$_SESSION['include']."', '".$_SESSION['exclude']."', '".$_SESSION['cookiename']."' , '".session_id()."' , '".$_SERVER['REMOTE_ADDR']."' )";
    if($debug){echo $loguser;}
}

$reslog = mysql_query($loguser);



?>