<?php
if(!session_id()){session_start();}
#print_r($_SESSION['input']);
if(!$_REQUEST['coalitie'] && !$_REQUEST['premier'] && !$_REQUEST['naam'] ){ echo("Geen antwoord stelling ingevoerd..."); }

require "connect.php";
    
$sql = "SELECT csv_partijnamen FROM coalitie WHERE ID=".$_REQUEST['coalitie'];
$coaltie = mysql_query($sql);
$partijen = mysql_fetch_assoc($coaltie);

$sql = "SELECT naam, afbeelding FROM premier WHERE ID=".$_REQUEST['premier'];
$premiers = mysql_query($sql);
$premier = mysql_fetch_assoc($premiers);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="Arend Zwaneveld Copyright 2009" />
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

    <div id="delen">
	<h1><?php echo $_REQUEST['naam']; ?>'s favoriete coalitie:</h1>
	<div class="vancoalitie">
	<h1>
            <?php 
            #$partijen['csv_partijnamen'] = preg_replace('/,/','<br/>', $partijen['csv_partijnamen']);
            $partijen['csv_partijnamen'] = preg_replace('/,/','&nbsp;&nbsp;&nbsp;', $partijen['csv_partijnamen']);
            echo $partijen['csv_partijnamen'];
            ?>

	</h1>
	</div>
        <h2 style="text-align: center; font-weight: bold;">Met <?php echo $premier['naam'];?> als minister-president</h2><br />

	<div class="vanminister">
            <img alt="<?php echo $premier['naam'];?>" src="http://www.mijncoalitie.nl/images/premier/<?php echo $premier['afbeelding'];?>" />            
        </div>
	
	
	
        
	<div id="stuur"><a href="http://www.mijncoalitie.nl/index.php?start=1">Bepaal jouw coalitie in 7 vragen!</a></div>

    </div>

</div> <!-- container -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-128478-47']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
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
