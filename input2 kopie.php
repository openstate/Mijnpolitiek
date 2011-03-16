<?php
if(!session_id()){session_start();}
#if($_SESSION['input'][0]) { unset($_SESSION['input'][0]); }
$debug = 0;
define('INCLUDE_CHECK',1);
require "connect.php";     
  
    if(!$_REQUEST['stell'] && !$_REQUEST['antw'] && !$_REQUEST['inclusief'] && !$_REQUEST['exclusief'] && !$_REQUEST['premier']  ){ echo "Geen antwoord stelling ingevoerd..."; };

    $stell = $_REQUEST['stell'];
    $antw = $_REQUEST['antw'];
    $inclusief = $_REQUEST['inclusief'];
    $exclusief = $_REQUEST['exclusief'];
    $premier = $_REQUEST['premierid'];
    
    @$stell = stripslashes($stell);   #echo get_magic_quotes_gpc();
    @$stell = preg_replace('/"/','', $stell);
    @$stell = (int) $stell + 0;

    @$antw = stripslashes($antw);   #echo get_magic_quotes_gpc();
    @$antw = preg_replace('/"/','', $antw);
    @$antw = (int) $antw + 0;

    @$inclusief = stripslashes($inclusief);   #echo get_magic_quotes_gpc();
    @$inclusief = preg_replace('/"/','', $inclusief);
    @$inclusief = (int) $inclusief + 0;

    @$exclusief = stripslashes($exclusief);   #echo get_magic_quotes_gpc();
    @$exclusief = preg_replace('/"/','', $exclusief);
    @$exclusief = (int) $exclusief + 0;

    @$premier = stripslashes($premier);   #echo get_magic_quotes_gpc();
    @$premier = preg_replace('/"/','', $premier);
    @$premier = (int) $premier + 0;

    if($exclusief){ $_SESSION['exclude'] = $exclusief; }
    if($inclusief){ $_SESSION['include'] = $inclusief; }
    if($premier){ $_SESSION['premier'] = $premier; }

    if($exclusief == -1){ unset($_SESSION['exclude']); } /* reset naar 'geen voorkeur' */
    if($inclusief == -1){ unset($_SESSION['include']); }

# Nieuw antwoord
    $_SESSION['input'][$stell] = $antw;                /* OVERSCHRIJF HET VORIGE ANTWOORD OP DE STELLING */

# ANTWOORDCOMBI
    $sql = "SELECT ID FROM `antwoordcombi` WHERE `stelling1` = '".$_SESSION['input'][1]."' AND `stelling2` = '".$_SESSION['input'][2]."' AND `stelling3` = '".$_SESSION['input'][3]."'  AND `stelling4` = '".$_SESSION['input'][4]."'  AND `stelling5` = '".$_SESSION['input'][5]."' AND `stelling6` = '".$_SESSION['input'][6]."' AND `stelling7` = '".$_SESSION['input'][7]."' ";
    $resantw = mysql_query($sql);
    $rowant = mysql_fetch_assoc($resantw);

    $_SESSION['antwoordcombi'] = $rowant['ID'];    

# MATCH
        $getmatch = " SELECT * FROM `coalitiepeilingen` JOIN coalitiematch ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN coalitie ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE antwoordcombi = '".$_SESSION['antwoordcombi']."' AND laatste_peiling >75";
        if($_SESSION['include']){$getmatch .=" AND p".$_SESSION['include']." = 1"; }
        if($_SESSION['exclude']){$getmatch .=" AND p".$_SESSION['exclude']." = 0"; }        
        $getmatch .= " ORDER BY matchrate DESC LIMIT 5";
        if($debug){ echo $getmatch. "\n"; }
        $resmatch = mysql_query($getmatch);
        $_SESSION['top10'] = $resmatch;

# BEST
        $getbestmatch = " SELECT * FROM `coalitiepeilingen` JOIN `coalitiematch` ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN `coalitie` ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE `antwoordcombi` = '".$_SESSION['antwoordcombi']."' ORDER BY `matchrate` DESC LIMIT 1";
        if($debug){ echo $getbestmatch. "\n"; }
        $bestmatch = mysql_query($getbestmatch);

#PARTIJEN     
        $getpartijen = "SELECT * FROM `partij` WHERE ID =".$_SESSION['exclude'];
        $partijen = mysql_query($getpartijen);

        $getpremiers = "SELECT * from premier ORDER BY naam";
        $premiers = mysql_query($getpremiers);

    #echo '{status:1, antwoordcombi:'.$row['ID'].', include:'. $include.', exclude:'. $exclude.' }' ;

# TOON TOP 5 MATCHES
                 echo '<table id="results" class="results">'. "\n";

                 if(!mysql_fetch_assoc($resmatch)){ echo 'error'; } else {

                  mysql_data_seek ( $resmatch, 0 );       /* reset interne data pointer (positieteller) */
                  #for ($i=0; $i<4; $i++){  /* regel het aantal coalities in de SQL statement */
                    while($row = mysql_fetch_assoc($resmatch)){
                        if(($row['relatievematch']*100) > 50){ $color = 'green'; } else
                        if(($row['relatievematch']*100) > 30){ $color = 'yellow'; } else { $color = 'red'; }

                        echo '<tr>'. "\n";
                            echo '<td class="coalitiepartijen">'.$row['csv_partijnamen'].'</td>'. "\n";
                            echo '<td class="right"><div class="barholder">';
                                echo '<div id="bar'.$i.'" class="bar '.$color.'" style="width: '.number_format(($row['matchrate']*100),0).'%;">'.number_format(($row['matchrate']*100),0).'%</div>';
                            echo '</div>'.$row['laatste_peiling'].' zetels*'."\n";
                            #echo '<br />'.number_format(($row['relatievematch']*100),0).'%  <img src="images/hartje2.gif" />';
                            echo '</td>'. "\n";
                        echo '</tr>'. "\n";
                        $i++;
                      }
                   #}
                echo '<tr><td colspan="2"><div id="legenda"><div class="box green"></div> Eensgezind <div class="box yellow"></div> Moeizaam <div class="box red"></div> Zeer onwaarschijnlijke coalitie</div></td></tr>';
                echo '</table>'. "\n";
             } /* closes else */

    $loguser = "UPDATE `zwaneveld_net_hns`.`user` SET `leeftijdid` = '',  `email` = '', `geslachtman` = '', `postcode` = '',`email` ='' ,
        `datum` = NOW( ),`antwoordcombi` ='".$_SESSION['antwoordcombi']."',`coalitieid` = '".$_SESSION['coalitie']."',
            `meeregeerpartij1` = '".$_SESSION['include']."' ,`coalitiezonder1` = '".$_SESSION['exclude']."',
                `cookie` = '', `session` = '".session_id()."',`ipadres` = '".$_SERVER['REMOTE_ADDR']."' ";
    $loguser .= "WHERE `session` = '".session_id()."' ";
    # "UPDATE `table2` SET email='$row[3]', username='$row[1]', pwd='$row[2]' WHERE UID='$row[0]'" // http://forums.devarticles.com/mysql-development-50/update-multiple-columns-using-mysql-update-4197.html
    if($debug){echo $loguser;}
    $reslog = mysql_query($loguser);

?>