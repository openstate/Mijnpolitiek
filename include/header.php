<?php
$path = pathinfo($_SERVER['PHP_SELF']);
$base = $path['basename'];

$navbar[0] = array('url' => '1.php',    'text' =>  $text1 );
$navbar[1] = array('url' => '2.php',    'text' =>  $text2 );
$navbar[2] = array('url' => '3.php',    'text' =>  $text3 );
$navbar[3] = array('url' => '4.php',    'text' =>  $text4 );
$navbar[4] = array('url' => 'destroy_session.php" onClick="return proceed()', 'text' => $logouttext );


/*
echo '  <div id="container">';
echo '  <div id="toptext">';
	echo '<a href="/"><img src="/images/logo.png" alt="'.$welcomegp.'" style="float: left; border: 0; width: 250px;"></a>';
#	echo '<img src="/images/logo.jpg" alt="'.$welcome.'" style="float: left; border: 0; width: 250px;">';
	echo '<div style="float: right; padding-top: 20px;">';
		echo ' <strong style="color: #CCC;"><a href="help.php" style="text-decoration: none; color: #CCC;">Help en FAQs</a>';
		echo ' | ';
		echo '  <a href="contact.php" style="text-decoration: none; color: #CCC;">Contact</a></strong>';
	echo '</div>';
echo '</div>';
*/

echo '<h1>'.$headertext.'</h1>';

echo '  <div id="navbar">';
	echo '<ul>';
                for($i=0; $i<count($navbar); $i++){
                        echo '<li><a href="'.$navbar[$i]['url'].'" ';
                                  if($base == $navbar[$i]['url'] ){echo 'class="current" ';}
                        echo '>';
                        echo $navbar[$i]['text'].'</a></li>';    }
        echo '</ul>';
echo '</div>';

?>