<?php
session_start();
include 'config.php'; 

if(isset($_POST['act']) && $_POST['act']=='save22Pass')
{
 $newpass=md5($_POST['newpass']);
 //echo "UPDATE `users` SET `uPassword`='".$newpass."' WHERE `uId`=".$_POST['uuId'];
 $qry=mysql_query("UPDATE `users` SET `uPassword`='".$newpass."' WHERE `uId`=".$_POST['uuId']);
 if($qry){ echo 'updatedd'; }else{ echo 'errorr'; } 
}

?>