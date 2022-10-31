<?php
session_start();
include 'config.php'; 


if(isset($_POST['act']) && $_POST['act']=='addfarmer'){

	$sourcePath = $_FILES['idoc']['tmp_name'];
	$targetPath = "files/".$_FILES['idoc']['name'];

	$ext = substr($targetPath, strrpos($targetPath, '.') + 1);
	$without_ext = basename($targetPath, '.'.$ext);
	
	
	if($ext=='jpg' || $ext=='jpeg' || $ext=='JPG' || $ext=='JPEG' || $ext=='png' || $ext=='PNG' || $ext=='gif' || $ext=='GIF'){ 

		if(move_uploaded_file($sourcePath,$targetPath)){
			echo 'added img';
		}else{echo "error img";}

	}elseif($ext=='pdf' || $ext=='PDF'){

		if(move_uploaded_file($sourcePath,$targetPath)){
			echo 'added pdf';
		}else{echo "error pdf";}

	}else{echo "error noone";}


	$ins=mysql_query("INSERT INTO `farmers`(`fname`, `doc_idproof`) VALUES ('".$_POST['farmer']."','".$targetPath."')");

	
}









?>