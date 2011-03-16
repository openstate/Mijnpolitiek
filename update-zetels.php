<?php
require "connect.php";

$zetels = file("zetels.txt");

$q = mysql_query("SELECT * FROM coalitie");
for($x=0; $x < mysql_num_rows($q);$x++)
{
	$row = mysql_fetch_assoc($q);
	$totaalZetels = $zetels[$row['partij1']] + $zetels[$row['partij2']] + $zetels[$row['partij3']] + $zetels[$row['partij4']] + $zetels[$row['partij5']] + $zetels[$row['partij6']];
	echo $x.": ".$totaalZetels."<br>";
	mysql_query("UPDATE coalitiepeilingen SET laatste_peiling = '$totaalZetels' WHERE id='".$row['ID']."'") or die(mysql_error());
}
$q = mysql_query("SELECT * FROM coalitie");
for($x=0; $x < mysql_num_rows($q);$x++)
{
	$row = mysql_fetch_assoc($q);
	for($y = 1; $y< 6; $y++)
	{
		if($row['partij'.$y] > 0 && $zetels[$row['partij'.$y]] == 0)
			mysql_query("UPDATE coalitiepeilingen SET laatste_peiling = '0' WHERE id='".$row['ID']."'") or die(mysql_error());
	}
}

?>