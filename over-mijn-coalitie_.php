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

    <div id="inhoud">
	<h1>Vind je favoriete coalitie met mijncoalitie.nl</h1>
<p><i>"Uiteindelijk beslissen coalities, en niet de partijen"</i></p>
 
<p>Vandaag lanceert Stichting Het Nieuwe Stemmen de website mijncoalitie.nl. De website helpt kiezers bij het bepalen van hun favoriete coalitie. Stef van Grieken, voorzitter van Het Nieuwe Stemmen: "In Nederland bepaalt uiteindelijk een coalitie het beleid, en niet de onafhankelijke partijen. Daarom is het belangrijk dat kiezers weten welke coalitie hun mening realiseert."</p>
<p>Kopstukken van grote partijen vallen over elkaar heen om de zwevende kiezers en de strategische stemmers voor zich te winnen. Tot vandaag was er geen gemakkelijke manier om te zien welke coalitie daadwerkelijk je mening het beste zal realiseren. De website www.mijncoalitie.nl  geeft onafhankelijk advies aan deze groeiende groep kiezers.</p>
<p>Op de website geven kiezers hun mening over een aantal onderwerpen: bijvoorbeeld het afschaffen van de hypotheekrenteaftrek, verhogen van de AOW leeftijd, en de grootte van de bezuinigingen.</p>
<p>Na afloop wordt de meerderheidscoalitie getoond die het beste past bij de voorkeuren, en krijgt de kiezer de mogelijkheid om de premier aan te stellen.</p>
<p><img src="http://www.hetnieuwestemmen.nl/assets/skins/frontoffice/images/logo.gif"></p>
<p>MijnCoalitie.nl is een initiatief van Stichting Het Nieuwe Stemmen en Owja. Voor contact opf meer informatie: Stef van Grieken (06-53327743, <a href="http://www.hetnieuwestemmen.nl/home/" target="_blank">Stichting Het Nieuwe Stemmen</a>) of Benjamin Derksen (06-11911111, <a href="http://www.owja.nl" target="_blank">Owja</a>). Veel dank aan Arend Zwaneveld en Christiaan voor het programmeer- en databasewerk.
	<h1>Hoe zijn de berekeningen tot stand gekomen?</h1>
<p>Alle berekeningen zijn gebaseerd op een gemiddelde van de laatste peilingen van: TNS / NIPO, Peil.nl (De Hond) / Nu Poll / Politiekebarometer.nl. Nieuwe peilingen worden zo snel mogelijk in deze database opgenomen. Indien een partij (gemiddeld) 0 zetels in de peilingen heeft, dan is deze partij uitgesloten van berekeningen.</p>
<br />
	<img src="/images/over.jpg">



    </div>

<!-- <?php echo $html['footer']; ?> -->

</div> <!-- container -->
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
