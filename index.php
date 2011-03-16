<?php
if(session_id()){session_destroy();} /* nieuw sessie starten als home page bezocht... */
if(!session_id()){session_start();}
$debug = 0;
$_SESSION['new'] = 1;
require "connect.php";

$getmostpopular = "SELECT csv_partijnamen, coalitieid, COUNT(coalitieid) AS MostPop FROM user JOIN coalitie ON coalitie.ID = user.coalitieid GROUP BY coalitieid ORDER BY COUNT(coalitieid) DESC";
$mostpop = mysql_query($getmostpopular);
$rowpop = mysql_fetch_assoc($mostpop);
if($debug){echo '<h2>'.$rowpop['coalitieid'].'</h2>'; echo '<h2>'.$rowpop['csv_partijnamen'].'</h2>';}
$rowpop['csv_partijnamen'] = preg_replace('/,/','&nbsp;&nbsp;&nbsp;', $rowpop['csv_partijnamen']);  /* vervang komma's door spaties */
$_SESSION['csv_partijnamen'] = $rowpop['csv_partijnamen'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include('include/menu.php'); ?>
<title>Mijn Coalitie</title>
    <meta name="Author" content="SHNS / Owja / Arend Zwaneveld" />
    <?php include('htmlheader.inc'); ?>
        <script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script> <!-- http://api.jquery.com/hide/ -->
        <script type="text/javascript" src="/include/js/jquery.url.packed.js"></script> <!-- http://projects.allmarkedup.com/jquery_url_parser/index.php -->

        <script type="text/javascript">
        $(document).ready ( function(){

            if(jQuery.url.param("start")){
                //alert('start = '+jQuery.url.param("start"));
                var stelling = 0;
                $('#stelling'+stelling).hide();
                $('#steps').show();              // toon de foto en de 3-stappen balk
                stelling++;
                $('#stelling'+stelling).show();
                $('#stelling'+stelling+' h2').hide();
                $('#stelling'+stelling+' h2').show('2000');
            };

           
            $('.vote').click( function(){
                var stelling;
                var antwoord;
                if($(this).attr('title') == 'eens'){antwoord = 1; }
                if($(this).attr('title') == 'oneens'){antwoord = 0; }

                var p = $(this).parent(); // parent tag http://stackoverflow.com/questions/521017/jquery-selecting-a-parent-attribute-from-a-callback
                stelling = p.attr('id');

                //$.get("input.php", { stell:'"'+stelling+'"',antw:'"'+antwoord+'"' }, function(returned_data){ alert(returned_data); });  // http://api.jquery.com/jQuery.get/
                if(stelling == '7'){
                    $.get("input.php", { stell:'"'+stelling+'"', antw:'"'+antwoord+'"' },
                            function(returned_data){
                            //alert(returned_data);
                            var antwoordcombi = returned_data;
                            $('#ajax-loader').show('4000');
                            //$('#ajax-loader').fadeIn(200).delay(5000).fadeOut(200).remove();  // http://stackoverflow.com/questions/42254/how-do-you-pause-before-fading-an-element-out-using-jquery
                            //$('#ajax-loader').fadeIn('3500');
                            window.location.replace('/mijncoalitie.php?coalitie='+antwoordcombi); return false;
                            }
                    );
                } else { $.get("input.php", { stell:'"'+stelling+'"',antw:'"'+antwoord+'"' } ); }

                $('#stelling'+stelling).hide();
                stelling++;
                $('#stelling'+stelling).show();
                $('#stelling'+stelling+' h2').hide();
                $('#stelling'+stelling+' h2').show('2000');
                $('ul.stelling li.stelling'+stelling).show('2000');
            });            
       });

    </script>

    <script type="text/javascript">
            if(jQuery.url.param("start"))(function(){
                alert('start = '+jQuery.url.param("start"));
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

<?php $res = connect(); ?>

<div id="inhoud">

        <?php
        echo '<div id="stelling0">'. "\n";
            echo '<div>';
                #$contents = getpagecontent();
                echo '<img src="/images/2k.jpg"><p class="intro">Stem op je favoriete coalitie. Alle resultaten sturen we als advies van de kiezer aan de informateur, de Koningin, en de toekomstige premier. <a href="/index.php?start=1" title="Bereken jouw coalitie">Start!</a></p>';
            echo '</div>'. "\n";
            echo '<div>'. "\n";

              /*  echo '<table id="intro" class="results">'. "\n";
                        echo '<tr><td>';
                        echo '<div class="greenbox">De meest gekozen coalitie is <br />';
                        echo '<a href="over-coalitie.php?coalitie='.$rowpop['coalitieid'].'" >'.$rowpop['csv_partijnamen'].'</a></div>';
                echo '</td><td class="right">';
                    #echo '<div class="greenbox" id="0"><a href="#" title="eens" class="vote">Stel je eigen coalitie samen <br />in slechts 7 vragen!</a></div>'. "\n";
                    echo '<div class="greenbox" ><a href="/index.php?start=1" title="eens" >Stel je eigen coalitie samen <br />in slechts 7 vragen!</a></div>'. "\n";
                echo '</td></tr></table>'. "\n"; */
            echo '</div>';
        echo '</div>'. "\n". "\n";
    ?>


<?php
echo '<ul id="steps">';
    echo '<li class="current">Beantwoord de vragen</li>';
    echo '<li>Stel jouw coalitie samen</li>';
    echo '<li>Deel jouw coalities met vrienden </li>';
echo '</ul>'. "\n". "\n";

#echo '<p><img src="/images/stemmen.jpg" /></p>';

echo '<div id="greybox">';

    for ($i=1; $i<=7; $i++){
    echo '<div id="stelling'.$i.'" class="stelling">'. "\n";
        echo '<div class="top"></div>'. "\n";
            echo '<div class="middle">'. "\n";
            progressbar($i). "\n";
            echo '<h2>'.get_question($res, $i-1).'</h2>'. "\n";     /* databases tellen vanaf rij 0 */
            echo '</div>'. "\n". "\n";

            echo '<div class="bottom">'. "\n";
                echo '<div id="'.$i.'" ><a href="';
                    #if($i<>7){echo '#" class="yes vote"';} else { echo 'mijncoalitie.php" class="yes vote to_results"';}
                    #if($i<>7){echo '#" class="yes vote"';} else { echo '#" class="yes vote to_results"';}
                    echo '#" class="vote yes"';
                    echo ' title="eens">Eens</a></div>'. "\n";
                echo '<div id="'.$i.'" ><a href="';
                    #if($i<>7){echo '#" class="no vote"';} else { echo 'mijncoalitie.php" class="no vote to_results"';} /* gebruik jquery ipv href */
                    #if($i<>7){echo '#" class="no vote"';} else { echo '#" class="no vote to_results"';} /* gebruik jquery ipv href */
                    echo '#" class="vote no"';
                    echo ' title="oneens">Oneens</a></div>'. "\n";
            echo '</div>'. "\n";

    echo '</div>'. "\n". "\n";

    }

    ?>

    <!-- <div id="ajax-loader" style="text-align: center;">
        <img src="images/ajax-loader-large2.gif" alt="Mogelijke coalities met een kamermeerderheid worden berekend... " style="float: left; padding-right: 25px; " />
        <p style="font-size: 22px; font-weight: bold; color: #333; line-height: 150%; padding-top:20px; background-color: #fff; ">
            Mijncoalitie.nl berekent nu de meerderheidscoalities die het beste aansluiten bij jouw antwoorden.<br /> Een moment geduld alsjeblieft!
        </p>
    </div> -->

    </div> <!-- closes greybox -->
    </div>


<!-- </div> --> <!-- container -->


<?php include('ga.js'); ?>

</body>
</html>



<?php

function progressbar($current){
    echo '<ul class="stelling">';
    echo '<li class="stelling">Stelling </li>';

    for($i=1; $i<=7; $i++){
        echo '<li class="stelling stelling'.$i.'">';
        #echo '<a href="'.$_SERVER['PHP_SELF'].'?stelling='.$i.'" class="stelling';
        echo '<a href="#" class="stelling';
            if($i == $current){ echo ' current';}
        echo '">';
            echo $i;
        echo '</a></li>';
    }

    echo '<li class="stelling"></li>';
    echo '</ul>';
}


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

function get_question($result, $n){
    mysql_data_seek ( $result, $n );  /* verschuif interne data pointer naar de juiste vraag */
    $row0 = mysql_fetch_assoc($result);

    echo '<h2>'.$row0['stelling'].'</h2>';
}


?>

