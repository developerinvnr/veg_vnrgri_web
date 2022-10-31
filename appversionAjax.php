<?php

session_start();

include 'config.php'; 

date_default_timezone_set('Asia/Calcutta');



if(isset($_REQUEST['act']) && $_REQUEST['act']=='vdetails'){
	$updt=mysql_query("UPDATE `app_version` SET `VersionD`='".$_REQUEST['crn']."', Kharif_From='".date("Y-m-d",strtotime($_REQUEST['kdf']))."', Kharif_To='".date("Y-m-d",strtotime($_REQUEST['kdt']))."', Rabi_From='".date("Y-m-d",strtotime($_REQUEST['rdf']))."', Rabi_To='".date("Y-m-d",strtotime($_REQUEST['rdt']))."', Summer_From='".date("Y-m-d",strtotime($_REQUEST['sdf']))."', Summer_To='".date("Y-m-d",strtotime($_REQUEST['sdt']))."', CrBy=".$_REQUEST['id'].", CrDate='".date("Y-m-d")."' WHERE `VersionId`='".$_REQUEST['id']."'");

	if($updt){

		echo 'updated';

	}else{

		echo 'error';

	}

}