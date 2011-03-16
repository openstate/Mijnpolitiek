<?php

    $getmatch = " SELECT * FROM `coalitiepeilingen` JOIN coalitiematch ON `coalitiematch`.`coalitieID` = `coalitiepeilingen`.`ID` JOIN coalitie ON `coalitiematch`.`coalitieID` = `coalitie`.`ID` WHERE antwoordcombi = '".$_SESSION['antwoordcombi2']."' AND laatste_peiling >75 ORDER BY laatste_peiling DESC LIMIT 4";
    $resmatch = mysql_query($getmatch);

 echo '<table id="intro" class="results"><tr>'. "\n";
    echo '<th class="coalitiepartijen">Coalitie</th>'. "\n";
    echo '<th class="right">Score</th></tr>'. "\n";

    for ($i=0; $i<4; $i++){
        $row = mysql_fetch_assoc($resmatch);
        if(($row['relatievematch']*100) > 50){ $color = 'green'; } else
        if(($row['relatievematch']*100) > 30){ $color = 'yellow'; } else { $color = 'red'; }

        echo '<tr>'. "\n";
            echo '<td class="coalitiepartijen">'.$row['csv_partijnamen'].'</td>'. "\n";
            echo '<td class="right"><div class="barholder">';
                echo '<div id="bar1" class="bar '.$color.'" style="width: '.($row['relatievematch']*100).'%;">'.($row['relatievematch']*100).'%</div>';
            echo '</div>'.$row['laatste_peiling'].' zetels*</td>'. "\n";
    echo '</tr>'. "\n";
    }
echo '</tr></table>'. "\n";


?>