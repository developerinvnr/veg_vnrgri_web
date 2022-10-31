<?php
session_start();
include 'config.php'; 

date_default_timezone_set('Asia/Calcutta');

function addlog($uid,$action){
	$log=mysql_query("INSERT INTO `logbook`( `uid`, `action`, `logDateTime`) VALUES ('".$uid."','".$action."','".date("Y-m-d h:i:s")."')");
}

function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];

}

$action = getUName($_SESSION['uId']). " Loged Out";
		addlog($_SESSION['uId'],$action);


unset($_SESSION['uId']);
$msg='Logged Out Successfully!';
header('location:index.php?msg='.$msg.'&color=success');
?>