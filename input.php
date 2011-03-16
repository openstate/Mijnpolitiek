<?php
if(!session_id()){session_start();}
#if($_SESSION['input'][0]) { unset($_SESSION['input'][0]); }
#$test = 0;
define('INCLUDE_CHECK',1);
require "connect.php";

    if(!$_REQUEST['stell']) die("Geen antwoord stelling ingevoerd...");
    $stell = $_REQUEST['stell'];
    $antw = $_REQUEST['antw'];

    @$stell = stripslashes($stell);   #echo get_magic_quotes_gpc();
    @$stell = preg_replace('/"/','', $stell);
    @$stell = (int) $stell + 0;

    @$antw = stripslashes($antw);   #echo get_magic_quotes_gpc();
    @$antw = preg_replace('/"/','', $antw);
    @$antw = (int) $antw + 0;
    
    $_SESSION['input'][$stell] = $antw;

    #$sql = "SELECT ID FROM `antwoordcombi` WHERE `stelling1` = '".$_SESSION['input'][0]."' AND `stelling2` = '".$_SESSION['input'][1]."' AND `stelling3` = '".$_SESSION['input'][2]."'  AND `stelling4` = '".$_SESSION['input'][3]."'  AND `stelling5` = '".$_SESSION['input'][4]."' AND `stelling6` = '".$_SESSION['input'][5]."' AND `stelling7` = '".$_SESSION['input'][6]."' ";
    
    $sql = "SELECT ID FROM `antwoordcombi` WHERE `stelling1` = '".$_SESSION['input'][1]."' AND `stelling2` = '".$_SESSION['input'][2]."' AND `stelling3` = '".$_SESSION['input'][3]."'  AND `stelling4` = '".$_SESSION['input'][4]."'  AND `stelling5` = '".$_SESSION['input'][5]."' AND `stelling6` = '".$_SESSION['input'][6]."' AND `stelling7` = '".$_SESSION['input'][7]."' ";   

    $resantw = mysql_query($sql);
    $row = mysql_fetch_assoc($resantw);
    $_SESSION['antwoordcombi'] = $row['ID'];
    echo $row['ID'];
    #echo 'test!';
    #echo 'antwoordcombi:'. $row['ID'];


?>