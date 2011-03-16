<?php
if(!session_id()){session_start();}
#print_r($_SESSION['input']);
require "connect.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="SHNS / Owja" />
    <?php include('htmlheader.inc'); ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> <!-- http://api.jquery.com/hide/ -->
    <script type="text/javascript">
        $(document).ready ( function(){

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

 <div id="inhoud" >
	


<table >
<tr valign="top">
<td style="width: 50%; padding: 5px 25px 5px 0; font-size: 14px;">
<h1>Vind je favoriete coalitie met mijncoalitie.nl</h1>
<p><i>"Uiteindelijk beslissen coalities, en niet de partijen"</i></p>
<p>Vandaag lanceert Stichting Het Nieuwe Stemmen de website mijncoalitie.nl. De website helpt kiezers bij het bepalen van hun favoriete coalitie. Stef van Grieken, voorzitter van Het Nieuwe Stemmen: "In Nederland bepaalt uiteindelijk een coalitie het beleid, en niet de onafhankelijke partijen. Daarom is het belangrijk dat kiezers weten welke coalitie hun mening realiseert."</p>
<p>Kopstukken van grote partijen vallen over elkaar heen om de zwevende kiezers en de strategische stemmers voor zich te winnen. Tot vandaag was er geen gemakkelijke manier om te zien welke coalitie daadwerkelijk je mening het beste zal realiseren. De website www.mijncoalitie.nl  geeft onafhankelijk advies aan deze groeiende groep kiezers.</p>

<p>Op de website geven kiezers hun mening over een aantal onderwerpen: bijvoorbeeld het afschaffen van de hypotheekrenteaftrek, verhogen van de AOW leeftijd, en de grootte van de bezuinigingen.</p>
<p>Na afloop wordt de meerderheidscoalitie getoond die het beste past bij de voorkeuren, en krijgt de kiezer de mogelijkheid om de premier aan te stellen.</p>

</td><td style="width: 50%; padding: 5px 25px 5px 0; font-size: 14px;">



    <a href="http://www.hetnieuwestemmen.nl/home/" target="_blank"><img src="http://www.hetnieuwestemmen.nl/assets/skins/frontoffice/images/logo.gif" /></a>
<p style="font-size: 14px;">MijnCoalitie.nl is een initiatief van <strong>Stichting Het Nieuwe Stemmen</strong><br />en <strong>Owja</strong>. </p>
<p>Voor contact of meer informatie:
<ul style="margin-left: 0px; padding-left: 15px;">
    <li style="line-height: 100%;">Stef van Grieken (06-53327743, <a href="http://www.hetnieuwestemmen.nl/home/" target="_blank">Stichting Het Nieuwe Stemmen</a>)</li>
    <li style="line-height: 200%;">Benjamin Derksen (06-11911111, <a href="http://www.owja.nl" target="_blank">Owja</a>).</li>
</ul></p>
<p>Veel dank aan Arend Zwaneveld en Christiaan voor het databaseontwerp en het programmeerwerk.</p>


<h3>Hoe zijn de berekeningen tot stand gekomen?</h3>
<p style="text-align: normal; font-size: 14px;">De peilingsuitslagen zijn uit de database verwijderd. Inmiddels worden coalities berekend op basis van de verkiezingsuitslag op 9 juni 2010.</p>

</td></tr>
</table>
<br />
<img src="/images/over.jpg" />

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
