<?php
if(!session_id()){session_start();}
$debug = 0;
if($debug){
echo '<br/>1 '.print_r($_SESSION['input']).'<br/>';
#echo '<br/>3 '.print_r($_SESSION['antwoordcombi']).'<br/>';
echo '<br/>5 '.print_r($_SESSION['premier']).'<br/>';
echo '<br/>8 '.print_r($_SESSION['coalitie']).'<br/>';
echo '<br/>8 '.print_r($_SESSION['naam']).'<br/>';
#echo $_SESSION['coalitie'];
}
require "connect.php";
# MATCH
        $getmatch = " SELECT * FROM `coalitiepeilingen` JOIN coalitiematch ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN coalitie ON `coalitiematch`.`coalitieID` = `coalitie`.`ID`
            WHERE antwoordcombi = '".$_SESSION['antwoordcombi']."' AND laatste_peiling >75";
        if($_SESSION['include']){$getmatch .=" AND p".$_SESSION['include']." = 1"; }
        if($_SESSION['exclude']){$getmatch .=" AND p".$_SESSION['exclude']." = 0"; }
        $getmatch .= " ORDER BY matchrate DESC LIMIT 7";
        if($debug){echo $getmatch. "\n";}
        $resmatch = mysql_query($getmatch);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="SHNS / Owja / Arend Zwaneveld" />
    <?php include('htmlheader.inc'); ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> <!-- http://api.jquery.com/hide/ -->
    <script type="text/javascript">
        var urldata =new Array();

        $(document).ready ( function(){

            $('li.premier').click ( function(){ // http://api.jquery.com/val/
                var premierid = $(this).attr('id');
              
               $('li.premier').removeClass('selected');
               $('#'+premierid ).addClass('selected');

                $.ajax({
                    type: "POST",
                    url: "input3.php",
                    data: "premier=" + premierid,
                    beforeSend: function(){$('#ajax-loader').show();},
                    error: function(){ alert("Sorry, de verbinding met de database is verbroken tijdens het verwerken van je antwoord. Ververs de pagina met de F5-toets en probeer het opnieuw."); },
                    success: function(returned_data){
                        $("#ajax-loader").hide();                    
                        $("#output").html(returned_data);
                    }
                });
            });


            $('#coalitie').change( function(){ // http://api.jquery.com/val/
                var coalitieid = $(this).val();

                //$.get("input3.php", { coalitie: '"'+coalitieid+'"'  }, function(msg){ alert( msg.coalitie ); });
                $('#coalitie').addClass('selected');     // add red under line to select box

                $.ajax({
                    type: "POST",
                    url: "input3.php",
                    data: "coalitie=" + coalitieid,
                    beforeSend: function(){$('#ajax-loader').show();},
                    error: function(){ alert("Sorry, de verbinding met de database is verbroken tijdens het verwerken van je antwoord. Ververs de pagina met de F5-toets en probeer het opnieuw."); },
                    success: function(returned_data){
                        $("#ajax-loader").hide();                        
                        $("#output").html(returned_data);
                    }
                });

            });


            $('#naam').change( function(){ // http://api.jquery.com/val/            
                var naam = $(this).val();
                
                $.ajax({
                    type: "POST",
                    url: "input3.php",
                    data: "naam=" + naam,
                    beforeSend: function(){$('#ajax-loader').show();},
                    error: function(){ alert("Sorry, de verbinding met de database is verbroken tijdens het verwerken van je antwoord. Ververs de pagina met de F5-toets en probeer het opnieuw."); },
                    success: function(returned_data){
                        $("#ajax-loader").hide();                    
                        $("#output").html(returned_data);
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

	<ul id="steps">
            <li>Beantwoord de vragen</li>
            <li>Stel jouw coalitie samen</li>
            <li class="current">Deel jouw coalities met vrienden </li>
        </ul>
	
    <div id="coalities">
	<h1>Kies de beste coalitie</h1>
	<center>
            <select class="kiezen" id="coalitie">
                <option value="-1">Stem op je favoriete coalitie uit de berekende top 7</option>
<?php
            mysql_data_seek ( $resmatch, 0 );       /* reset interne data pointer (positieteller) */
            while($row = mysql_fetch_assoc($resmatch)){
                    echo '<option value="'.$row['ID'].'" ';
                        #if($row['ID'] == $_SESSION['coalitie']){echo 'selected = "selected" '; }
                    echo '>'.$row['csv_partijnamen'].'  ('.number_format($row['matchrate']*100,0).'%)</option>'. "\n";
              }
?>
            </select>
        </center>
        
<h1>En wie moet het land gaan leiden?</h1>
<?
        $getpremiers = "SELECT * from premier ORDER BY naam";
        $premiers = mysql_query($getpremiers);

        if(@!mysql_data_seek ( $resmatch, 0 )){ echo '<h3 class="warning">De sessie is verlopen, ga terug naar <a href="/index.php">start</a> en vul de vragen opnieuw in</h3>'; } else {

        mysql_data_seek ( $resmatch, 0 );
        for ($i=0; $i<4; $i++){
            $row = mysql_fetch_assoc($resmatch);
                    $uniek[] = $row['partij1'];
                    $uniek[] = $row['partij2'];
                    $uniek[] = $row['partij3'];
                    $uniek[] = $row['partij4'];
                    $uniek[] = $row['partij5'];
                    $uniek[] = $row['partij6'];
                }
        $uniek = array_unique($uniek);


               echo '<ul id="premiers" >'. "\n";
 
                    mysql_data_seek ( $premiers, 0 );
                    $i = 0;
                    while ($premier = mysql_fetch_assoc($premiers)){                        
                            #if($premier['afbeelding'] && ($premier['ID'] == $row['partij1'] || $premier['ID'] == $row['partij2'] || $premier['ID'] == $row['partij3'] || $premier['ID'] == $row['partij4'] || $premier['ID'] == $row['partij5'] ) ){ echo '<li><img id="premier'.$premier['ID'].'" alt="'.$premier['naam'].'" class="premier" src="/images/premier/'.$premier['afbeelding'].'" /></li>'. "\n"; }
                            #if($premier['afbeelding'] && in_array($premier['ID'], array($row['partij1'],$row['partij2'],$row['partij3'],$row['partij4'],$row['partij5'],$row['partij6']) ) ){ echo '<li><img id="premier'.$premier['ID'].'" alt="'.$premier['naam'].'" class="premier" src="/images/premier/'.$premier['afbeelding'].'" /></li>'. "\n"; }
                            if($premier['afbeelding'] && in_array($premier['ID'], $uniek )) { $i++; echo '<li  id="p'.$premier['ID'].'" class="premier'.$i.' premier"';
                                #if(($i % 6) == 5){ echo ' clearright" '; }
                            echo '><img alt="'.$premier['naam'].'" src="/images/premier/'.$premier['afbeelding'].'" /></li>'. "\n"; }
                            if(($i % 5) == 4){ echo '<div style="clear: both;"></div>'. "\n"; }
                    }
                
                echo '</ul>'. "\n";
        }
?>


<div style="clear: both;"></div>

<p></p>
<h1>Share je coalitie!</h1>
<div style="display: block; font-size: 18px; border: 1px dotted #555; padding: 10px; text-align: center; ">Voer je naam in:   <input type="text" id="naam" style="display: inline-block; margin: 10px auto; width: 200px; "></input> <span style="font-size: 16px;">(wordt gebruikt als afzender in het bericht naar je vrienden)</span>
<div id="output">
<p class="logos">
<a href="http://twitter.com/home?status=Mijn+favoriete+coalitie%20-<?php echo urlencode($url); ?>" title="Deel je favoriete coalitie met vrienden op twitter!" target="_blank"><img class="social" src="/images/twitter.gif" /></a>
<a href="http://www.facebook.com/share.php?u=<?php echo urlencode($url); ?>" title="Deel je favoriete coalitie met vrienden op facebook!" target="_blank"><img class="social" src="/images/facebook.gif" /></a>
<a href="http://www.hyves.nl/profilemanage/add/tips/?name=Mijn+favoriete+coalitie&text=+<?php echo urlencode($url); ?>" title="Deel je favoriete coalitie met vrienden op hyves!" target="_blank"><img class="social" src="/images/hyves.gif" /></a>
<a href="http://nujij.nl/jij.lynkx?t=Mijn+favoriete+coalitie&u=<?php echo urlencode($url); ?>" title="Deel je favoriete coalitie met vrienden op nujij!" target="_blank"><img class="social" src="/images/nujij.gif" /></a>

</p>

<p class="url">Of gebruik onderstaande link voor je eigen netwerk, e-mail of tweet: <br />
    <b> <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a> </b>
</p>
</div>
</div>
</div>
    

</div> <!-- container -->

<?php include('ga.js'); ?>

</body>
</html>




<?php

function get_question($result, $n){
    mysql_data_seek ( $result, $n );  /* verschuif interne data pinter naar de juiste vraag */
    $row0 = mysql_fetch_assoc($result);

    echo '<h2>'.$row0['stelling'].'</h2>';
}

?>






<?php

$debug = 0;

if($debug){
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
