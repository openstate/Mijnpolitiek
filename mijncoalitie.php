<?php
if(!session_id()){session_start();}
$debug = 0;
require "connect.php";

if($_SESSION['new'] == 1){ $_SESSION['new'] = 0; $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
if(!$_SESSION['antwoordcombi']){  $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
 if(!$_SESSION['input'][1]){
    
    $sql = "SELECT * FROM antwoordcombi WHERE ID = '".$_SESSION['antwoordcombi']."'";
    $result = mysql_query($sql);
    $antwoorden = mysql_fetch_assoc($result);
    if($debug){print_r($antwoorden);}
    $input[1] = $antwoorden['stelling1'];
    $input[2] = $antwoorden['stelling2'];
    $input[3] = $antwoorden['stelling3'];
    $input[4] = $antwoorden['stelling4'];
    $input[5] = $antwoorden['stelling5'];
    $input[6] = $antwoorden['stelling6'];
    $input[7] = $antwoorden['stelling7'];
}

if($debug){print_r($_SESSION['input']); echo '<br />'; }

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="Arend Zwaneveld Copyright 2009" />
    <?php include('htmlheader.inc'); ?> 
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> <!-- http://api.jquery.com/hide/ -->
   <script type="text/javascript" src="/include/js/jquery.url.packed.js"></script> <!-- http://projects.allmarkedup.com/jquery_url_parser/index.php -->

   <script type="text/javascript">

        $(document).ready ( function(){

           // $.ajaxSetup({cache: false}); // http://api.jquery.com/jQuery.get/

           //$('li a.stelling').click( function(e){    e.preventDefault();   });  // http://stackoverflow.com/questions/970388/jquery-disable-a-link
            $('.changevote').click( function(){
                var stelling;
                var antwoord;
                if($(this).attr('title') == 'eens'){antwoord = 1; }
                if($(this).attr('title') == 'oneens'){antwoord = 0; }
                var p = $(this).parent(); // parent tag  http://stackoverflow.com/questions/521017/jquery-selecting-a-parent-attribute-from-a-callback
                stelling = p.attr('id');

                //alert('Je hebt op knop '+antwoord+' gedrukt van formulier met id '+stelling+'!');

                $('#'+stelling+' .selected').removeClass('selected').addClass('unselected');
                $(this).removeClass('unselected');
                $(this).addClass('selected');

                    $.ajax({
                        type: "POST",
                        url:  "input2.php",
                        data: "stell=" + stelling + "&antw=" + antwoord,
                        //dataType: 'json',
                        beforeSend: function(){$("#ajax-loader").show();},
                        //beforeSend: function(){$('#ajax-loader').fadeIn(200).delay(1000).fadeOut(200).remove();},
                        timeout: 3000,      // http://www.ibm.com/developerworks/library/x-ajaxjquery.html
                        error: function(){
                            alert("Sorry, er is een fout opgestreden bij het wijziging van je antwoord.");
                        },
                        success: function(returned_data){
                            $("#ajax-loader").hide();
                            $("#results").html(returned_data);
                        }
                    });
            });

             $('#include').change( function(){ // http://api.jquery.com/val/
                var partij = $(this).val();

                $.ajax({ 
                        type: "POST",
                        url:  "input2.php",
                        data: "inclusief=" + partij,
                        //dataType: 'json',
                        beforeSend: function(){$("#ajax-loader").show();},
                        timeout: 3000,      // http://www.ibm.com/developerworks/library/x-ajaxjquery.html
                        error: function(){
                            alert("Sorry, er is een fout opgestreden bij het wijziging van je antwoord.");
                        },
                        success: function(returned_data){
                            $("#ajax-loader").hide();
                            $("#results").html(returned_data);
                        }
                    });
            });

            $('#exclude').change( function(){  // http://api.jquery.com/val/
                var partij = $(this).val();  // http://marcgrabanski.com/article/jquery-select-list-values

                $.ajax({
                        type: "POST",
                        url:  "input2.php",
                        data: "exclusief=" + partij,
                        //dataType: 'json',
                        beforeSend: function(){$("#ajax-loader").show();},
                        timeout: 3000,      // http://www.ibm.com/developerworks/library/x-ajaxjquery.html
                        error: function(){
                            alert("Sorry, de verbindng met de database is verbroken tijdens het verwerken van je antwoord. Ververs de pagina met de F5-toets en probeer het opnieuw.");
                        },
                        success: function(returned_data){
                            $("#ajax-loader").hide();
                            $("#results").html(returned_data);
                        }
                    });
            });

   });


    </script>
</head>
<body>
<div class="container">
   <div class="overlap_header" style="" >
        <div class="menu_blok">
          <?php	 buildmenu($_SERVER['PHP_SELF']); ?>
        </div>
   </div>

    <div id="inhoud">
    
    <?php
    echo '<ul id="steps">';
        echo '<li>Beantwoord de vragen</li>';
        echo '<li class="current">Stel jouw coalitie samen</li>';
        echo '<li>Deel jouw coalities met vrienden </li>';
    echo '</ul>'. "\n". "\n";

        $sql0 = "SELECT * FROM stellingen";
        $res = mysql_query($sql0);          /* alle stellingen */
    ?>

    <div id="greybox">
    	
    	<div class="top"></div>
       
        <div style="clear: both;"></div>

        <?php

        if($_SESSION['include']){ $include = $_SESSION['include']; }
        if($_SESSION['exclude']){ $exclude = $_SESSION['exclude']; }

            @$include = stripslashes($include);   #echo get_magic_quotes_gpc();
            @$include = preg_replace('/"/','', $include);
            @$include = (int) $include + 0;

            @$exclude = stripslashes($exclude);   #echo get_magic_quotes_gpc();
            @$exclude = preg_replace('/"/','', $exclude);
            @$exclude = (int) $exclude + 0;

# MATCH
        $getmatch = " SELECT * FROM `coalitiepeilingen` JOIN coalitiematch ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN coalitie ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE antwoordcombi = '".$_SESSION['antwoordcombi']."' AND laatste_peiling >75";
        if($_SESSION['include']){$getmatch .=" AND p".$_SESSION['include']." = 1"; }
        if($_SESSION['exclude']){$getmatch .=" AND p".$_SESSION['exclude']." = 0"; }
        $getmatch .= " ORDER BY matchrate DESC LIMIT 7";
        if($debug){echo $getmatch. "\n"; }
        $resmatch = mysql_query($getmatch);
        $_SESSION['top10'] = $resmatch;

        if($debug){echo "RESMATCH array: ".print_r($resmatch); }

# BEST
        $getbestmatch = " SELECT * FROM `coalitiepeilingen` JOIN `coalitiematch` ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN `coalitie` ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE `antwoordcombi` = '".$_SESSION['antwoordcombi']."' ORDER BY `matchrate` DESC LIMIT 1";
        if($debug){ echo $getbestmatch. "\n"; }
        $bestmatch = mysql_query($getbestmatch);   

#PARTIJEN
        #$getpartijen = "SELECT * FROM `partij` ORDER BY ID";
        $getpartijen = "SELECT * FROM `partij` ORDER BY afkorting";
        #$getpartijen = "SELECT * FROM partij JOIN peiling ON peiling.ID = partij.ID ORDER BY laatste_peiling DESC";  /* herbouw tabel peilingen!!! */
        $partijen = mysql_query($getpartijen);

        $getpremiers = "SELECT * from premier ORDER BY naam";
        $premiers = mysql_query($getpremiers);

            echo '<div class="middle">'. "\n";
            echo "<div id='results'>";
#SHOW BEST MATCH
#                echo '<h2 class="aanpassen">Best bij jouw antwoorden passende coalitie</h2>'. "\n";
#                 echo '<table id="bestresult" class="results">'. "\n";
#                        $best = mysql_fetch_assoc($bestmatch);
#                        if(($best['relatievematch']*100) > 25){ $color = 'green'; } else
#                       if(($best['relatievematch']*100) > 15){ $color = 'yellow'; } else { $color = 'red'; }
#                        echo '<tr>'. "\n";
#                            echo '<td class="coalitiepartijen1">'.$best['csv_partijnamen'].'</td>'. "\n";
#                            echo '<td class="right"><div class="barholder">';
#                            echo '<div id="bar'.$i.'" class="bar '.$color.'" style="width: '.number_format(($best['matchrate']*100),0).'%;">'.number_format(($best['matchrate']*100),0).'%</div>';
                            #echo '</div>'.$best['laatste_peiling'].' zetels*'."\n";
                            #echo  '<br />'.number_format(($best['relatievematch']*100),0).'%  <img src="images/hartje2.gif" />';
#                            echo '</td>'. "\n";
                            
#                        echo '</tr>'. "\n";
#                echo '</table>'. "\n";
#                echo '<br />';

#                echo '<div style="clear: both;"></div>'. "\n". "\n";

                echo '<h2 class="aanpassen">Best passende coalities met een kamermeerderheid</h2>'. "\n";

                if(!$resmatch){ echo '<h2 style="font-size: 16px; font-weight: 100; color: #FF0000;">Oeps! De mogelijke coalities voor als je overal <u>oneens</u> hebt ingevoerd is nog niet geupload.</h2><br/ >'; }

                else {

# TOON TOP 5 MATCHES
                 echo '<table class="results">'. "\n";

#                 if(!mysql_fetch_assoc($resmatch)){ echo 'error'; } else {

                 mysql_data_seek ( $resmatch, 0 );       /* reset interne data pointer (positieteller) */
                 #for ($i=0; $i<4; $i++){  /* regel het aantal coalities in de SQL statement */
                    while($row = mysql_fetch_assoc($resmatch)){
                        if(($row['relatievematch']*100) > 75){ $color = 'green'; } else
                        if(($row['relatievematch']*100) > 35){ $color = 'yellow'; } else { $color = 'red'; }

                        echo '<tr>'. "\n";
                            echo '<td class="coalitiepartijen">'.$row['csv_partijnamen'].'</td>'. "\n";
                            echo '<td class="right"><div class="barholder">';
                                echo '<div id="bar'.$i.'" class="bar '.$color.'" style="width: '.number_format(($row['matchrate']*100),0).'%;">'.number_format(($row['matchrate']*100),0).'%</div>';
                            echo '</div>'.$row['laatste_peiling'].' zetels'."\n";
                            #echo '<br />'.number_format(($row['relatievematch']*100),0).'%  <img src="images/hartje2.gif" />';
                            echo '</td>'. "\n";
                        echo '</tr>'. "\n";
                        $i++;
                      }
                   #}
                echo '<tr><td colspan="2"><br /><div id="legenda"><img src="/images/legenda.gif"></div></td></tr>';
                echo '</table>'. "\n";
                }                                 /* closes else */
 #               }
 				echo "<p></p></div>";
                echo '<div style="clear: both;"></div>';

# PAS VRAGEN AAN
                echo '<h2 class="aanpassen">Pas je vragen aan voor een andere coalitie</h2>'. "\n";
                echo '<ul id="change">'. "\n";
                for ($i=1; $i<=7; $i++){
                    echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                        get_question($res, $i-1); /* tabel in database begint bij rij 0 */
                    echo '</h3></div>'. "\n";
                    echo '<div class="right">'. "\n";
                        echo '<div id="'.$i.'" >'. "\n";

                            echo '<div class="changevote yes ';
                                if($_SESSION['input'][$i] == 1){echo ' selected'; } else { echo ' unselected'; }
                            echo '" title="eens">Eens</div>'. "\n";

                            echo '<div class="changevote no ';
                                if($_SESSION['input'][$i] == 0){echo ' selected'; } else { echo ' unselected'; }
                            echo '" title="oneens">Oneens</div>'. "\n";
                            
                        echo '</div>'. "\n";
                    echo '</div></li>'. "\n". "\n";
                }
                echo '</ul>'. "\n";

                echo '<div style="clear: both;"></div>';


# PULL DOWNS
                echo '<ul id="includeexclude">'. "\n";
/*
                echo '<li><h2 class="aanpassen">Partijkeuze</h2></li>'. "\n";
                   echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                       echo 'Welke partij mo&eacute;t onderdeel uitmaken van jouw coalitie?';
                    echo '</h3></div>'. "\n";
                    echo '<div class="right">'. "\n";
                    
                        echo '<select id="include">'. "\n";
                        echo '<option value="-1">Geen bezwaar</option>'. "\n";
                        while ($row = mysql_fetch_assoc($partijen)){
                             echo '<option ';
                             if($row['ID'] == $include){echo 'selected = "selected" '; }
                             echo 'value="'.$row['ID'].'">'.$row['afkorting'].'</option>'. "\n";
                         }                        
                        echo '</select>'. "\n";
                    echo '</div></li>'. "\n". "\n";
*/
                    echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                        echo 'Is er een partij die g&eacute;&eacute;n onderdeel mag uitmaken van jouw coalitie?';
                    echo '</h3></div>'. "\n";
                    echo '<div class="right">'. "\n";
                        echo '<select id="exclude">'. "\n";
                        echo '<option value="-1">Geen voorkeur</option>'. "\n";
                        mysql_data_seek ( $partijen, 0 );  
                        while ($row = mysql_fetch_assoc($partijen)){
                             #echo '<option value="'.$row['ID'].'">'.$row['afkorting'].'</option>'. "\n";
                             echo '<option ';
                             if($row['ID'] == $exclude){echo 'selected = "selected" '; }
                             echo 'value="'.$row['ID'].'">'.$row['afkorting'].'</option>'. "\n";
                        }    
                        echo '</select>'. "\n";
                    echo '</div></li>'. "\n". "\n";
                echo '</ul>'. "\n";




                echo '<div style="clear: both;"></div>';
              
            echo '</div>' /* closes middle */;
        ?>
	<div id="stuur"><a href="/delen-met-vrienden.php">Stem op je favoriete coalitie</a></div>
 		<div class="bottomuitslag"></div>
        <div style="clear: both;"></div>
      
          </div>



</div>
</div>

<!-- <div id="ajax-loader" >
    <p>
        Mijncoalitie.nl berekent nu de meerderheidscoalities die het beste aansluiten bij jouw antwoorden.<br /> Een moment geduld alsjeblieft!
    </p>
</div> -->

<!-- </div> -->  <!-- container -->

<?php include('ga.js'); ?>

</body>
</html>




<?php

function get_question($result, $n){
    mysql_data_seek ( $result, $n );  /* verschuif interne data pinter naar de juiste vraag */
    $row0 = mysql_fetch_assoc($result);
    echo $row0['stelling'];
}

# http://benalman.com/code/test/js-jquery-url-querystring.html?mode=test&test=&a=X&c=Z
# http://stackoverflow.com/questions/1090948/change-url-parameters-with-jquery
# http://railscasts.com/episodes/175-ajax-history-and-bookmarks
# http://marcgrabanski.com/article/list-of-useful-jquery-plugins

?>






<?php

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
