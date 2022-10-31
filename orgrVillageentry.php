<?php
include 'config.php'; 

$selt=mysql_query("select oid, village_id,tahsil_id from organiser");
while($seltd=mysql_fetch_assoc($selt)){
	// echo $seltd['tahsil_id'];

	$tah=mysql_query("select VillageId,VillageName from village where VillageName='".$seltd['village_id']."' ");
	if(mysql_num_rows($tah) == 0){
		$tahs=mysql_query("INSERT INTO `village`( `VillageName`, `TahsilId`, `cr_by`, `cr_date`) VALUES ('".$seltd['village_id']."','".$seltd['tahsil_id']."','1','".date("Y-m-d")."')");
		$id=mysql_insert_id();
		$tah=mysql_query("update organiser set village_id='".$id."' where oid='".$seltd['oid']."' ");
		echo 'inserted '.$seltd['village_id'];
		echo '<br>';
	}elseif(mysql_num_rows($tah) > 0){
		$tahs=mysql_fetch_assoc($tah);
		$tah=mysql_query("update organiser set  village_id='".$tahs['VillageId']."' where oid='".$seltd['oid']."' ");
		echo 'updated '.$seltd['village_id'];
		echo '<br>';

	}
}






?>