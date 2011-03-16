<?php
    #$current = $_REQUEST['stelling'];
    #echo 'Maak javascript zodat div stelling'.$current.'wordt getoond...';
    #echo "TEST REQUEST[] = ".$current;
    #if(!$current){ $current=1; echo 'Current init: '.$current; }

    #hide stelling $_REQUEST['stelling']
    #unhide stelling $_REQUEST['stelling'] +1
    $test = 0;
    ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
    <title><?php $title = getpagetitle(); echo $title; ?></title>
    <meta name="Author" content="Arend Zwaneveld Copyright 2009" />
    <?php include('htmlheader.inc'); ?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> <!-- http://api.jquery.com/hide/ -->
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/development-bundle/ui/ui.core.js"></script>
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/development-bundle/ui/ui.draggable.js"></script>
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/development-bundle/ui/ui.droppable.js"></script>
    <script type="text/javascript" src="jquery-ui-1.7.2.custom/development-bundle/ui/ui.sortable.js"></script>

    <script type="text/javascript">

        $(document).ready ( function(){

            //$('#form1-no').submit( function(){
            //$('#form1-no :hidden').submit( function(){
            $('form').submit( function(){
                var stelling;
                var antwoord;

                stelling = $(this).attr('id');
                antwoord = $('input[type=hidden]', this).attr('value');

                alert('Je hebt op knop '+antwoord+' gedrukt van formulier met id '+stelling+'!');
                //$.get("input.php",{stell:'"'+stelling+'"'}, function(returned_data){ alert(returned_data); });
                //$.get("input.php",{ stell: "444" }, function(returned_data){ alert(returned_data); });
                $.get("/input.php",{ stell: "24" } );
                //$.get("cool.php",{id:'"'+product_id+'"'}, function(returned_data){ alert(returned_data); });
                //$.get("input.php",{stell:'"'+stelling+'"'});
                //$.get("input.php", { 'input': ['"'+stelling+'", "'+antwoord+'"']} ); // NOTE missing [] http://api.jquery.com/jQuery.get/
                //$.get("input.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' } );  // http://api.jquery.com/jQuery.get/
                //$.get("input.php", { stell: "3", antw: "3" } );  // http://api.jquery.com/jQuery.get/
                //$.get("input.php", { stell:'"2"', antw:'"4"'} );  // http://api.jquery.com/jQuery.get/
                //$.get("input.php", { stell: '"'+2+'"', antw: '"'+4+'"' } );  // http://api.jquery.com/jQuery.get/
                //$.get("input.php", { stell: "2", antw: "-7" } );  // http://api.jquery.com/jQuery.get/
                return true;
            });
       });

    </script>


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
    echo '<div id="greybox">';
    echo '<div class="top"></div>';

    for ($i=1; $i<=7; $i++){
    #echo '<div id="stelling'.$i.'" class="stelling">';
    #echo '<div id="greybox">';
    #echo '<div class="top"></div>';

        echo '<div id="stelling'.$i.'" class="stelling">';
        echo '<div class="middle">';
                progressbar($i);
                get_question($res, $i-1); /* databases tellen vanaf rij 0 */
            echo '</div>';

            echo '<div class="bottom">';
                #echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" id="form'.$i.'-yes"/>';
                echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" id="'.$i.'" >';
                #echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" />';
                #echo '<input type="hidden" name="stelling" value="'.$i.'" />';
                    echo '<input type="hidden" name="antwoord" value="1" />';
                    #echo '<input type="submit" value="Eens" class="yesno yes" onClick="$(\'#stelling'.$i.'\').hide(); $(\'#stelling'.($i+1).'\').show(); return false;" />';
                    #echo '<input type="button" value="Eens" class="yesno yes" onClick="$(\'#stelling'.$i.'\').hide(); $(\'#stelling'.($i+1).'\').show(); return false;" />';
                    echo '<input type="submit" value="Eens" class="yesno yes" />';
                echo '</form>';

                #echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" id="form'.$i.'-no">';
                echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" id="'.$i.'" >';
                #echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get" >';
                    #echo '<input type="hidden" name="stelling" value="'.$i.'" />';
                    echo '<input type="hidden" name="antwoord" value="-1" />';
                    #echo '<input type="submit" value="Oneens" class="yesno no" onClick="$(\'#stelling'.$i.'\').hide(); $(\'#stelling'.($i+1).'\').show(); $(\'#stelling'.($i+1).'.ul\').show(\'slow\'); return false;" />';
                    #echo '<input type="button" value="Oneens" class="yesno no" onClick="$(\'#stelling'.$i.'\').hide(); $(\'#stelling'.($i+1).'\').show(); $(\'#stelling'.($i+1).'.ul\').show(\'slow\'); return false;" />';
                    #echo '<input type="submit" value="Oneens" class="yesno no" onClick="nextQuestion('.$i.');"/>';
                    #echo '<input type="submit" value="Oneens" class="yesno no" />';
                    echo '<input type="submit" value="Oneens" class="yesno no" />';
                echo '</form>';
            echo '</div>';
        echo '</div>';
    #echo '</div>';
    echo '

';
    }
        ?>

    </div>
</div>



<!--    <?php $contents = getpagecontent(); ?>  -->

<?php # echo $html['footer']; ?>


<!-- </div> --> <!-- container -->
</body>
</html>



<?php

function progressbar($current){
    echo '<ul class="stelling">';
    echo '<li class="stelling">Steling# </li>';

    for($i=1; $i<= 7; $i++){
        echo '<li class="stelling">';
        echo '<a href="'.$_SERVER['PHP_SELF'].'?stelling='.$i.'" class="stelling';
        #if($i ==  $_SESSION['current'] ){ echo ' current';}
        if($i ==  $current ){ echo ' current';}
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



    if(!$stelling){ $stelling = '44';}
    if(!$antwoord){ $antwoord = '2';}

    $stelling = stripslashes($stelling);   #echo get_magic_quotes_gpc();
    $stelling = preg_replace('/"/','', $stelling);
    $stelling = (int) $stelling + 0;

    $antwoord = stripslashes($antwoord);   #echo get_magic_quotes_gpc();
    $antwoord = preg_replace('/"/','', $antwoord);
    $antwoord = (int) $antwoord + 0;

    #echo 'Test item ='.$stelling.' is NOT cool, but dragged OK!<br/>';

    #$sql0 = "INSERT INTO zwaneveld_net_hns.test VALUES ('.$stelling.')";
    #$sql0 = "INSERT INTO zwaneveld_net_hns.test VALUES ('$antwoord')";
    #$sql0 = "INSERT INTO zwaneveld_net_hns.test VALUES ('-2')";
    #$sql0 = "INSERT INTO `zwaneveld_net_hns`.`test` (`ID`, `stelling`, `antwoord`) VALUES (NULL, '4', '9')";
    #$sql0 = "INSERT INTO `zwaneveld_net_hns`.`test` (`ID`, `stelling`, `antwoord`) VALUES (NULL, '2', '5')";
    #$sql0 = "INSERT INTO zwaneveld_net_hns.test (ID,stelling, antwoord) VALUES (NULL, '2', '5')";
    #$sql0 = "INSERT INTO `zwaneveld_net_hns`.`test` (`ID`,`stelling`, `antwoord`) VALUES (NULL, '$stelling', '$antwoord')";
    #$sql0 = "INSERT INTO zwaneveld_net_hns.test (ID,stelling, antwoord) VALUES (NULL, '$stelling', '$antwoord')";
    #$sql0 = "INSERT INTO zwaneveld_net_hns.test (ID,stelling, antwoord) VALUES (NULL, '".$stelling."', '".$antwoord."')";
    $sql0 = "INSERT INTO `zwaneveld_net_hns`.`test` (`ID`,`stelling`, `antwoord`) VALUES (NULL, '".$stelling."', '".$antwoord."')";
    #$sql0 = "SELECT * FROM stellingen";
    $result0 = mysql_query($sql0);


}

?>

