<?php
session_start();
include 'config.php'; 


if(isset($_REQUEST['act']) && $_REQUEST['act']=='deletedd'){

	$sqlDel=mysql_query("delete from visit_details where VisitId=".$_REQUEST['vid']);

	if($sqlDel){
		echo 'done';
	}else{
		echo 'error';
	}
}
?>
