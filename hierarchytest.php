<?php
session_start();
include 'config.php'; 


// $allids = array_unique(gethierarchy($_SESSION['uId']));


function gethierarchy($uid){

	$id=array($uid);
	$sel=mysql_query("select uId from users where uReporting='".$uid."'");

	if(mysql_num_rows($sel) > 0){
		while($seld = mysql_fetch_assoc($sel)){

			$idc = array($seld['uId']);

			$id = array_merge($id,$idc,gethierarchy($seld['uId']));

		}

		return $id;
	}else{
		return $id;
	}

}

$allids = array_unique(gethierarchy($_SESSION['uId']));
print_r($allids);

echo '<br><br>';
echo implode(', ', $allids);

?>