<?php
#if(!session_id()){session_start();}
require "connect.php";

if($_SESSION['new'] == 1){ $_SESSION['new'] = 0; $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
if(!$_SESSION['antwoordcombi']){  $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
#if($_REQUEST['coalitie']){ $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
#if(!$_SESSION['input']){
#if(!$_REQUEST['coalitie'] || ( $_REQUEST['coalitie'] <> '' && $_REQUEST['coalitie'] != $_SESSION['antwoordcombi'] ) || !$_SESSION['input'][1] ) {
 if(!$_SESSION['input'][1]){
    
    $sql = "SELECT * FROM antwoordcombi WHERE ID = '".$_SESSION['antwoordcombi']."'";
    $result = mysql_query($sql);
    $antwoorden = mysql_fetch_assoc($result);
#  print_r($antwoorden);
    $_SESSION['input'][1] = $antwoorden['stelling1'];
    $_SESSION['input'][2] = $antwoorden['stelling2'];
    $_SESSION['input'][3] = $antwoorden['stelling3'];
    $_SESSION['input'][4] = $antwoorden['stelling4'];
    $_SESSION['input'][5] = $antwoorden['stelling5'];
    $_SESSION['input'][6] = $antwoorden['stelling6'];
    $_SESSION['input'][7] = $antwoorden['stelling7'];
}
#print_r($_SESSION['input']); echo '<br />';
#print_r($_SESSION['new']); echo '<br />';
#if(!$_SESSION['antwoordcombi']){ $_SESSION['antwoordcombi'] = $_REQUEST['coalitie']; }
#if(!$_SESSION['antwoordcombi2']){ $_SESSION['antwoordcombi2'] = $_REQUEST['coalitie2']; }
#echo $_SESSION['antwoordcombi'];
#echo $_SESSION['antwoordcombi2'];

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
                
                //$.get("input2.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' } );
//                $.get("input2.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' }, function(returned_data){ alert(returned_data); } );  // http://api.jquery.com/jQuery.get/

                $('#'+stelling+' .selected').removeClass('selected').addClass('unselected');
                $(this).removeClass('unselected');
                $(this).addClass('selected');
/*
                $.get("input2.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' },
                    function(returned_data){
                    var antwoordcombi = returned_data;
                    //alert(returned_data);
                    window.location.replace('/mijncoalitie.php?coalitie='+antwoordcombi);
                }); 
*/

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
                        success: function(msg){
                            $("#ajax-loader").hide();
                            //alert( 'Antwoordcombi: ' + antwoordcombi );
                            //alert(antwoordcombi );
                            window.location.replace("/mijncoalitie.php?coalitie="+antwoordcombi); return false;
                            // http://benalman.com/code/test/js-jquery-url-querystring.html?mode=test&test=&a=X&c=Z
                            //jQuery.queryString(window.location.href, 'coalitie='+msg.antwoordcombi);
                        }
                    });
            });

             $('#include').change( function(){ // http://api.jquery.com/val/
                var partij = $(this).val();
                //alert(partij+'included!');
                //$.get("input2.php", { inclusief:'"'+partij+'"'} );
                //$.get("input2.php", { inclusief: '"'+partij+'"'  }, function(msg){ alert( (msg.include) ); });
                $.get("input2.php", { inclusief: '"'+partij+'"'  }, function(msg){ alert( msg ); });

/*
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
                        success: function(msg){
                          //  alert( 'vereiste partijid: ' + (msg.include) );
                        }
                    });
*/
                //stel pulldown in op juiste selected
            });

            $('#exclude').change( function(){  // http://api.jquery.com/val/
                var partij = $(this).val();  // http://marcgrabanski.com/article/jquery-select-list-values
                //alert(partij+'excluded');
                //$.get("input2.php", { exclusief: '"'+partij+'"' } );
                //$.get("input.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' }, function(returned_data){ alert(returned_data); });
                $.get("input2.php", { exclusief: '"'+partij+'"'  }, function(returned_data){ alert(returned_data);  });
                //$.get("input2.php", { exclusief: '"'+partij+'"'  }, function(returned_data){ alert( returned_data.exclude );  });
/*
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
                        success: function(msg){
                           // alert( 'uitgesloten partijid: ' + (msg.exclude) );

                        }
                    });
*/
                //stel pulldown in op juiste selected
            });

            $('.premier').click( function(){
                //alert($(this).attr('id'));
                var premierid = $(this).val();
                //alert(partij+'excluded');
                //$.get("input2.php", { premier:'"'+premierid+'"'} );

                $.ajax({
                        type: "POST",
                        url:  "input2.php",
                        data: "inclusief=" + premierid,
                        //dataType: 'json',
                        beforeSend: function(){$("#ajax-loader").show();},
                        timeout: 3000,      // http://www.ibm.com/developerworks/library/x-ajaxjquery.html
                        error: function(){
                            alert("Sorry, er is een fout opgestreden bij het wijziging van je antwoord.");
                        },
                        success: function(msg){
                            alert( 'gewenste premier: ' + msg.premierid );
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
        if($include){$getmatch .=" AND p".$include." = 1"; }
        if($exclude){$getmatch .=" AND p".$exclude." = 0"; }
        $getmatch .= " ORDER BY matchrate DESC LIMIT 5";
        echo $getmatch. "\n";
        $resmatch = mysql_query($getmatch);
        $_SESSION['top10'] = $resmatch;

# BEST
        $getbestmatch = " SELECT * FROM `coalitiepeilingen` JOIN `coalitiematch` ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN `coalitie` ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE `antwoordcombi` = '".$_SESSION['antwoordcombi']."' ORDER BY `matchrate` DESC LIMIT 1";
        echo $getbestmatch. "\n";
        $bestmatch = mysql_query($getbestmatch);   

#PARTIJEN
        #$getpartijen = "SELECT * FROM `partij` ORDER BY ID";
        $getpartijen = "SELECT * FROM `partij` ORDER BY afkorting";
        #$getpartijen = "SELECT * FROM partij JOIN peiling ON peiling.ID = partij.ID ORDER BY laatste_peiling DESC";  /* herbouw tabel peilingen!!! */
        $partijen = mysql_query($getpartijen);

        $getpremiers = "SELECT * from premier ORDER BY naam";
        $premiers = mysql_query($getpremiers);

            echo '<div class="middle">'. "\n";

                echo '<h2 class="aanpassen">Best bij jouw antwoorden passende coalitie</h2>'. "\n";
                 echo '<table id="intro" class="results">'. "\n";
                        $best = mysql_fetch_assoc($bestmatch);
                        if(($best['relatievematch']*100) > 50){ $color = 'green'; } else
                        if(($best['relatievematch']*100) > 30){ $color = 'yellow'; } else { $color = 'red'; }
                        echo '<tr>'. "\n";
                            echo '<td class="coalitiepartijen">'.$best['csv_partijnamen'].'</td>'. "\n";
                            echo '<td class="right"><div class="barholder">';
                                echo '<div id="bar'.$i.'" class="bar '.$color.'" style="width: '.number_format(($best['matchrate']*100),0).'%;">'.number_format(($best['matchrate']*100),0).'%</div>';
                            echo '</div>'.$best['laatste_peiling'].' zetels* <br />'."\n";
                            echo number_format(($best['relatievematch']*100),0).'%  <img src="images/hartje2.gif" /></td>'. "\n";
                        echo '</tr>'. "\n";
                    echo '</tr>'. "\n";
                echo '</table>'. "\n";
                echo '<br />';

                echo '<div style="clear: both;"></div>';

                echo '<h2 class="aanpassen">Best passende coalities met een kamermeerderheid</h2>'. "\n";

                if(!$resmatch){ echo '<h2 style="font-size: 28px;">Helaas: er is op basis van jouw wensen geen meerderheid te vormen!</h2><br/ >'; } else {
# TOON MATCH
                 echo '<table id="intro" class="results">'. "\n";
    
                  #for ($i=0; $i<4; $i++){  /* regel het aantal coalities in de SQL statement */
                    while($row = mysql_fetch_assoc($resmatch)){
                        if(($row['relatievematch']*100) > 50){ $color = 'green'; } else
                        if(($row['relatievematch']*100) > 30){ $color = 'yellow'; } else { $color = 'red'; }

                        echo '<tr>'. "\n";
                            echo '<td class="coalitiepartijen">'.$row['csv_partijnamen'].'</td>'. "\n";
                            echo '<td class="right"><div class="barholder">';
                                echo '<div id="bar'.$i.'" class="bar '.$color.'" style="width: '.number_format(($row['matchrate']*100),0).'%;">'.number_format(($row['matchrate']*100),0).'%</div>';
                            echo '</div>'.$row['laatste_peiling'].' zetels* <br />'."\n";
                            echo number_format(($row['relatievematch']*100),0).'%  <img src="images/hartje2.gif" /></td>'. "\n";
                        echo '</tr>'. "\n";
                        $i++;
                      }
                   #}
                echo '</table>'. "\n";
                }

                
                echo '<div style="clear: both;"></div>';

# PAS VRAGEN AAN
                echo '<ul id="change">'. "\n";
                echo '<li><h2 class="aanpassen">Pas je vragen aan voor een andere coalitie</h2><li>'. "\n";
                for ($i=1; $i<=7; $i++){
                    echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                        get_question($res, $i-1); /* tabel in database begint bij rij 0 */
                    echo '</h3></div>'. "\n";
                    echo '<div class="right">'. "\n";
                        echo '<div id="'.$i.'" >'. "\n";
                            #echo '<a href="#" class="changevote" title="oneens">Oneens</a>'. "\n";
                            echo '<a href="" class="changevote yes ';
                                if($_SESSION['input'][$i] == 1){echo ' selected'; } else { echo ' unselected'; }
                            echo '" title="eens">Eens</a>'. "\n";

                            #echo '<a href="#" class="changevote" title="oneens">Oneens</a>'. "\n";
                            echo '<a href="" class="changevote no ';
                                if($_SESSION['input'][$i] == 0){echo ' selected'; } else { echo ' unselected'; }
                            echo '" title="oneens">Oneens</a>'. "\n";
                        echo '</div>'. "\n";
                    echo '</div></li>'. "\n". "\n";
                }
                echo '</ul>'. "\n";

                echo '<div style="clear: both;"></div>';

                echo '<ul id="includeexclude">'. "\n";
                echo '<li><h2 class="aanpassen">Partijkeuze</h2></li>'. "\n";
                    echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                        echo 'Is er een partij die g&eacute;&eacute;n onderdeel mag uitmaken van jouw coalitie?';
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

                    echo '<li>'. "\n";
                    echo '<div class="left q'.$i.'"><h3>';
                        echo 'Welke partij mo&eacute;t onderdeel uitmaken van jouw coalitie?';
                    echo '</h3></div>'. "\n";
                    echo '<div class="right">'. "\n";
                        echo '<select id="exclude">'. "\n";
                        echo '<option value="-1">Geen voorkeur</option>'. "\n";
                        mysql_data_seek ( $partijen, 0 );  /* reset internal counter */
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
	<div id="stuur"><a href="/delen-met-vrienden.php">Deel deze uitslag met vrienden</a></div>
 		<div class="bottomuitslag"></div>
        <div style="clear: both;"></div>
      
          </div>



</div>
</div>

<div id="ajax-loader" >
    <img src="images/ajax-loader-large2.gif" alt="Mogelijke coalities met een kamermeerderheid worden berekend... " style="float: left; padding-right: 25px; " />
    <p>
        Mijncoalitie.nl berekent nu de meerderheidscoalities die het beste aansluiten bij jouw antwoorden.<br /> Een moment geduld alsjeblieft!
    </p>
</div>

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

$test = 0;

if($test){
    $sql = "SELECT partij.afkorting FROM partijstandpunten JOIN partij ON partij.ID = partijstandpunten.ID WHERE stelling1 = 1";

    $result = mysql_query($sql);
    if(!$result){ echo 'Query result empty...';}
    echo '<p>Test sql query: toon partij voor welke eens met stelling1 ...</p>';

    echo '<ul>';
        while($row = mysql_fetch_assoc($result)){
            echo '<li>'.$row["afkorting"].'</li>';
        }
    echo '</ul>';

}

?>
