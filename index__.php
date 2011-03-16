<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="Arend Zwaneveld Copyright 2009" />
    <?php include('htmlheader.inc'); ?>
</head>
<body>
<div class="container">
   <div class="overlap_header" style="" >
    <a href="index.php" alt="Keer terug naar de home page" class="mijn-coalitie">Mijncoalitie.nl</a>
        <div class="menu_blok">
          <?php	 buildmenu($_SERVER['PHP_SELF']); ?>
        </div>
   </div>

<?php $res = connect(); ?>
    
<div id="inhoud">
       
    <?php
    for ($i=0; $i<7; $i++){
    echo '<div id="stelling-'.$i.'">';

        echo '<div id="greybox">';
        echo '<div class="top"></div>';
            echo '<div class="middle">';
            progressbar($i);
            get_question($res, $i);
            echo '</div>';

            echo '<div class="bottom">';
                #echo '<input type="button" name="stelling'.$i.'" value="true" class="yesno"></input>';
                #echo '<input type="button" name="stelling'.$i.'" value="false" class="yesno"></input>';
                echo '<div id="'.$i.'-ja" ><a href="" class="yes">Eens</a></div>';
                echo '<div id="'.$i.'-nee"><a href="" class="no">Oneens</a></div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    }
        ?>
    
    </div>
    </div>
</div> <!-- inhoud -->


<!--    <?php $contents = getpagecontent(); ?>  -->

<?php echo $html['footer']; ?>


</div> <!-- container -->
</body>
</html>



<?php

function progressbar($current){
    echo '<ul class="stelling">';
    echo '<li class="stelling">Steling# </li>';
    
    for($i=0; $i< 7; $i++){
        echo '<li class="stelling">';
        echo '<a href="'.$_SERVER['PHP_SELF'].'?stelling='.$i.'" class="stelling';
        if($i == $current){ echo ' current';}
        echo '">';
            echo $i;
        echo '</a></li>';
    }
}


function connect(){
    # $link = mysql_connect('localhost', 'mysql_user', 'mysql_password');
    $link = mysql_connect('mysql9.greenhost.nl', 'zwaneveld1', 'fogNuvsus8');
    if (!$link) {    die('Could not connect: ' . mysql_error()); }
    $db = mysql_select_db('zwaneveld_net_hns');
    if (!$db) {    die('Could not connect: ' . mysql_error()); }

    #$sql0 = "SELECT * FROM stellingen WHERE ID = 1";
    $sql0 = "SELECT * FROM stellingen";
    $result0 = mysql_query($sql0);  /* alle stellingen */
    return $result0;
}

function get_question($result, $n){
    mysql_data_seek ( $result, $n );  /* verschuif interne data pinter naar de juiste vraag */
    $row0 = mysql_fetch_assoc($result);

    echo '<h2>'.$row0['stelling'].'</h2>';
}








$test = 1;

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

