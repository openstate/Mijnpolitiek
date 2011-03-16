<?php

############# This code is written by Arend Zwaneveld   ##########
#   You may use this code provided this header is not removed    #
#                         2009                                   #
#############             Enjoy this Code               ##########

$urls  = array(
  home           => "index.php",
  home2          => "/",
  start          => "index.php?start=1",
  overons        => "over-mijn-coalitie.php",
  verkiezingen   => "verkiezingen.php"
);

$titles  = array(
  home             => "Vind de coalitie die bij je past! | Mijncoalitie.nl",
  start            => "Over Mijncoalitie en Stichting Het Nieuwe Stemmen",
  overons          => "Over Mijncoalitie en Stichting Het Nieuwe Stemmen",
  verkiezingen     => "Mijncoalitie 2.0 | Blijf via de mijncoalitie facebook, hyves en twitter op de hoogte van de verkiezingen!"
);

$menu  = array(
  $urls[home]           => "Home",
  $urls[start]          => "Start",
  $urls[overons]        => "Over",
);

$current = basename($_SERVER["REQUEST_URI"]);
$current2 = $_SERVER["REQUEST_URI"];
#echo "TEST current1".$current;
#echo "TEST current2".$current2;

function buildmenu(){

global $current2, $current, $urls, $menu;

#echo "TEST array ".print_r($urls);
#echo "TEST current1".$current;
#echo "TEST current2".$current2;

echo '<ul>';
  foreach($menu as $link => $text){
    echo '<li><a href="'.$link.'"';
      if($current == $link){echo 'class="current"';}  /* voor home is dit zowel index.php als "/ */
    echo '>'.$text.'</a></li>';
  }
echo '</ul>';

}

function getpagecontent(){ /* niet gebruikt op mijncoalitie.nl*/

global $current, $urls, $menu;

    switch ($current) {
        case $urls[home]:
        include('intro.txt');
            break;
        case $urls[home2]:
        include('intro.txt');
            break;
        case $urls[start]:
        include('onlinemarketing.txt');
            break;
        case $urls[overons]:
        include('projectsupport.txt');
            break;
        case $urls[verkiezingen]:
        include('webdev.txt');
            break;
    }
}


function getpagetitle(){

global $current, $urls, $titles;

#echo "TEST current".$current;
#echo "TEST title".$titles[home];
#print_r($titles);

    switch ($current) {
        case $urls[home]:
            echo $titles[home];
            break;
        case $urls[home2]:
            echo $titles[home];
            break;
        case $urls[start]:
            echo $titles[start];
            break;
        case $urls[overons]:
            echo $titles[overons];
            break;
        case $urls[verkiezingen]:
            echo $titles[verkiezingen];
            break;
    }
}

?>