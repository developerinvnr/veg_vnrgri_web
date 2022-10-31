<?php
include 'config.php'; 

$selt=mysql_query("select oid, tahsil_id,district_id from organiser");
while($seltd=mysql_fetch_assoc($selt)){
	// echo $seltd['tahsil_id'];

	$tah=mysql_query("select TahsilId,TahsilName from tahsil where TahsilName='".$seltd['tahsil_id']."' ");
	if(mysql_num_rows($tah) == 0){
		$tahs=mysql_query("INSERT INTO `tahsil`( `TahsilName`, `TahsilCode`, `DistrictId`, `cr_by`, `cr_date`) VALUES ('".$seltd['tahsil_id']."','','".$seltd['district_id']."','1','".date("Y-m-d")."')");
		$id=mysql_insert_id();
		$tah=mysql_query("update organiser set tahsil_id='".$id."' where oid='".$seltd['oid']."' ");
		echo 'inserted '.$seltd['tahsil_id'];
		echo '<br>';
	}elseif(mysql_num_rows($tah) > 0){
		$tahs=mysql_fetch_assoc($tah);
		$tah=mysql_query("update organiser set  tahsil_id='".$tahs['TahsilId']."' where oid='".$seltd['oid']."' ");
		echo 'updated '.$seltd['tahsil_id'];
		echo '<br>';

	}
}






?>