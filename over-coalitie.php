<?php
if(!session_id()){session_start();}
#print_r($_SESSION['input']);
if(!$_REQUEST['coalitie'] && !$_REQUEST['premier'] && !$_REQUEST['naam'] ){ echo("Geen antwoord stelling ingevoerd..."); }

require "connect.php";
$res = connect();

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

<?php
	echo '<h1>Over de coalitie '. $_SESSION['csv_partijnamen'].'</h1>';
                
                echo '<h2 class="bekijk">Vergelijk je eigen antwoorden met die van de partijen binnen de coalitie</h2>'. "\n";

                echo '<table>';

                for ($i=1; $i<=7; $i++){                    
                    echo '<tr>';
                    echo '<td class="left q'.$i.'">';
                        echo '<h4>'.get_question($res, $i-1).'</h4>'; /* tabel in database begint bij rij 0 */
                    echo '</td>'. "\n";
                    echo '<td class="antwoordveld">jouw antwoord</td>';
                        for($j=0;$j<4;$j++){
                            echo '<td class="antwoordveld">'. "\n";
                                echo 'antwoord ('.$i. ', '.$j.')';
                            echo '</td>';
                        }
                    echo '</tr>'. "\n";
                }
            echo '</table>';
?>


	</div>
      

    </div>


<!-- </div> --> <!-- container -->
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


function connect(){
    # $link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
    $link = mysql_connect('mysql9.greenhost.nl', 'zwaneveld1',
'fogNuvsus8');
    if (!$link) {    die('Could not connect: ' . mysql_error()); }
    $db = mysql_select_db('zwaneveld_net_hns');
    if (!$db) {    die('Could not connect: ' . mysql_error()); }

    #$sql0 = "SELECT * FROM stellingen WHERE ID = 1";
    $sql0 = "SELECT * FROM stellingen";
    $result0 = mysql_query($sql0);  /* alle stellingen */
    return $result0;
}

?>
