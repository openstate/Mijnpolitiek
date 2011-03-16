<?php

############# This code is written by Arend Zwaneveld   ##########
#   You may use this code provided this header is not removed    #
#                         2009                                   #
#############             Enjoy this Code               ##########

#$site = 'index.php';
#buildmenu($site);

$urls  = array(
  home           => "index.php",
  home2          => "zwaneveld.net",
  om             => "online-marketing.php",
  projectsupport => "project-support.php",
  webdev         => "web-development.php"
);

$titles  = array(
  home             => "Data-analyse &amp; Design voor Online marketing en Strategische projecten | Arend Zwaneveld",
  om               => "Online marketing - Data-analyse &amp; Design voor Online marketing en Strategische projecten | Arend Zwaneveld",
  projectsupport   => "Project Support - Data-analyse &amp; Design voor Online marketing en Strategische projecten | Arend Zwaneveld",
  webdev           => "Web development - Data-analyse &amp; Design voor Online marketing en Strategische projecten | Arend Zwaneveld"
);

$menu  = array(
  $urls[om]               => "Online marketing",
  $urls[projectsupport]   => "Project Support",
  $urls[webdev]           => "Web development"
);

$current = basename($_SERVER["REQUEST_URI"]);


function buildmenu(){

global $current, $urls, $menu;

echo '<ul>';
  foreach($menu as $link => $text){
    echo '<li><a href="'.$link.'"';
      if($current == $link){echo 'class="current"';}
    echo '>'.$text.'</a>';
  }
echo '</ul>';
}

function getpagecontent(){

global $current, $urls, $menu;

    switch ($current) {
        case $urls[home]:
        include('intro.txt');
            break;
        case $urls[home2]:
        include('intro.txt');
            break;
        case $urls[om]:
        include('onlinemarketing.txt');
            break;
        case $urls[projectsupport]:
        include('projectsupport.txt');
            break;
        case $urls[webdev]:
        include('webdev.txt');
            break;
    }
}


function getpagetitle(){

global $current, $urls, $titles;

#echo "TEST title".$titles[home];
#print_r($titles);

    switch ($current) {
        case $urls[home]:
            return $titles[home];
            break;
        case $urls[home2]:
            echo $titles[home];
            break;
        case $urls[om]:
            echo $titles[om];
            break;
        case $urls[projectsupport]:
            echo $titles[projectsupport];
            break;
        case $urls[webdev]:
            echo $titles[webdev];
            break;
    }
}

?>