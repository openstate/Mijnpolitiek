<?php
if(!session_id()){session_start();}
#$test = 0;
define('INCLUDE_CHECK',1);
require "connect.php";

/*  jos_vm_coolwall
    ID              bigint(20)
    productID       int(11)
    product_desc    varchar(255)
    image           varchar(100)
    time            timestamp
    sessionID       varchar(32)
    IPaddress       varchar(15)
    cool            tinyint (Bool)
*/

if($test!=1){
    if(!$_REQUEST['id']) die("There is no such product!");
    #$dragged_id = (int) $_REQUEST['id'];
    $dragged_id = $_REQUEST['id'];
}else{
    $dragged_id = 53;
}


    $dragged_id = stripslashes($dragged_id);   #echo get_magic_quotes_gpc();
    #echo preg_replace($pattern, $replacement, $string);  $dragged_id = $dragged_id + 0;
    $dragged_id = preg_replace('/"/','', $dragged_id);
    $dragged_id = (int) $dragged_id + 0;    
    #echo 'Test item ='.$dragged_id.' is NOT cool, but dragged OK!<br/>';

$result0 = mysql_query("SELECT * FROM jos_vm_product INNER JOIN jos_vm_product_price ON jos_vm_product.product_id = jos_vm_product_price.product_id WHERE jos_vm_product_price.product_id =".$dragged_id);
$item = mysql_fetch_assoc($result0);
#echo 'Test item ='.$item['product_id'].' is NOT cool, but dragged OK!<br/>';
#$item['product_desc'] = htmlentities($item['product_desc']);
$item['product_desc'] = preg_replace('/(<p>)/','',$item['product_desc']);
$item['product_desc'] = preg_replace('/(</p>)/','',$item['product_desc']);

$result = mysql_query("INSERT INTO `gooodstuff_nl`.`jos_vm_coolwall` (`ID` ,`productID` ,`product_desc` ,`image` ,`time` ,`sessionID` ,`IPaddress` ,`cool`)
VALUES (NULL , '".$item['product_id']."', '".$item['product_desc']."', '".$item['product_thumb_image']."',CURRENT_TIMESTAMP , '".session_id()."', '".$_SERVER['REMOTE_ADDR']."', '0')");


?>