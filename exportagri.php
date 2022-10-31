<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');

function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];

}

function gethierarchy($uid){

	$id=array($uid);
	
	if($_SESSION['uType']=='S'){
		$sel=mysql_query("select uId from users");
		while($seld = mysql_fetch_assoc($sel)){

			$idc = array($seld['uId']);

			$id = array_merge($id,$idc);

		}

	}else{
		$sel=mysql_query("select uId from users where uReporting='".$uid."'");

		if(mysql_num_rows($sel) > 0){
			while($seld = mysql_fetch_assoc($sel)){

				$idc = array($seld['uId']);

				$id = array_merge($id,$idc,gethierarchy($seld['uId']));

			}

		}
	}

	return $id;	

}


$from = date('Y-m-d',strtotime($_REQUEST['from']));
$agyearf = (int)date('Y',strtotime($_REQUEST['from']));

$to = date('Y-m-d',strtotime($_REQUEST['to']));
$agyeart = (int)date('Y',strtotime($_REQUEST['to']));


$from11 = date('d-m-Y',strtotime($_REQUEST['from']));
$to11 = date('d-m-Y',strtotime($_REQUEST['to']));


$xls_filename = 'Agreement_reports_'.$from11.'-'.$to11.'.xls'; 

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t"; 

echo "Sn\tAgreement-ID\tAgreement Date\tCrop\tFemale FSCode\tMale FSCodet\tHybrid Code\tFarmer Name\tFarmer Id\tOrganiser Name\tFarmer Father Name\tProduction Person\tProduction Executive\tFarmer Village\tFarmer Tahsil\tFarmer District\tFarmer State\tProduction Location\tSowing Acre\tFinal Standing Acre (GPS Measure)\tDiff Acre\tNorth Side Variety\tComapny north\tTime Isolation north\tSouth Side Variety\tCompany South\tTime Isolation south\tEast Side Variety\tCompany east\tTime Isolation east\tWest Side_Variety\tCompany west\tTime Isolation west\tVNR Male off Type Early\tAprox Male early\tVNR Male off Type Late\tAprox Male late\tVNR Female off Type Early\tAprox Female early\tVNR Female off Type Late\tAprox Female late\tSample collected sent";
print("\n");


$alls=mysql_query('SELECT * FROM `state`');
while ($allsd=mysql_fetch_assoc($alls)) {
	$sarr[$allsd['StateId']]=$allsd['StateName'];
}

$alld=mysql_query('SELECT * FROM `distric`');
while ($alldd=mysql_fetch_assoc($alld)) {
	$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
}

$allt=mysql_query('SELECT * FROM `tahsil`');
while ($alltd=mysql_fetch_assoc($allt)) {
	$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
}

$allv=mysql_query('SELECT * FROM `village`');
while ($allvd=mysql_fetch_assoc($allv)) {
	$varr[$allvd['VillageId']]=$allvd['VillageName'];
}

//==== query condition for crop filter =======================================================
if(isset($_REQUEST['crop']) && $_REQUEST['crop']!=''){
	$cropCond="agr.ann_crop=".$_REQUEST['crop'];
}else{
	$cropCond='1=1';
}

//==== query condition for organiser filter ==================================================
if(isset($_REQUEST['orgr']) && $_REQUEST['orgr']!=''){
	$orgrCond="agr.org_id=".$_REQUEST['orgr'];
}else{
	$orgrCond='1=1';
}

//==== query condition for organiser filter ==================================================
if(isset($_REQUEST['secondparty']) && $_REQUEST['secondparty']!=''){
	$farmerCond="agr.second_party=".$_REQUEST['secondparty'];
}else{
	$farmerCond='1=1';
}


//==== query condition for getting results as per users hierarchy ================= start =====================

	$allids = array_unique(gethierarchy($_SESSION['uId']));
	$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";

//==== query condition for getting results as per users hierarchy ================= end =======================

	$qry="";
	for ($i=$agyearf; $i <= $agyeart; $i++) {

		$qry.=" SELECT agr.*, u.uName, f.tem_fid, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$i."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond;
		if($i!=$agyeart){
			$qry.=' UNION';
		}

		// echo $i.'<br>';
	}

	$agr=mysql_query($qry);

    $sn=1;
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	
	
	
	if($agrd['ann_crop']>0)
	{ $cr=mysql_fetch_assoc(mysql_query("select cropname,cropcode from crop where cropid=".$agrd['ann_crop'])); 
	  $cropn=$cr['cropcode']; }else{ $cropn=''; }
	if($agrd['ann7_flandid']>0)
	{
	 
	 /*
	 $fld=mysql_query('SELECT StateId as st,DictrictId as dt,TahsilId as tt,VillageId vt FROM farmers_land where flandid='.$agrd['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
     if($rld['st']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$rld['st'])); 
	 $staten=$sr['StateName']; }else{ $staten=$sarr[$agrd['state_id']]; }
     if($rld['dt']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$rld['dt'])); 
	 $distn=$dr['DictrictName']; }else{ $distn=$darr[$agrd['distric_id']];  }
     if($rld['tt']>0){ $tr=mysql_fetch_assoc(mysql_query("select TahsilName from tahsil where TahsilId=".$rld['tt']));
	 $tahsiln=$tr['TahsilName']; }else{ $tahsiln=$tarr[$agrd['tahsil_id']]; }
     if($rld['vt']>0){ $vr=mysql_fetch_assoc(mysql_query("select VillageName from village where VillageId=".$rld['vt']));
	 $villagen=$vr['VillageName']; }else{ $villagen=$varr[$agrd['village_id']]; }*/
	 
	 $staten=$sarr[$agrd['si']]; $distn=$darr[$agrd['di']]; 
	 $tahsiln=$tarr[$agrd['ti']]; $villagen=$varr[$agrd['vi']];
	 
	}
	else
	{
	 //$staten=''; $distn=''; $tahsiln=''; $villagen='';
	 $staten=$sarr[$agrd['state_id']]; $distn=$darr[$agrd['distric_id']]; 
	 $tahsiln=$tarr[$agrd['tahsil_id']]; $villagen=$varr[$agrd['village_id']];
	}

    echo $sn.$sep;
	echo $agrd['agree_no'].$sep;
	//$agree_date=date("d-m-Y",strtotime($agrd['agree_date']));
	echo $agrd['agree_date'].$sep;
	echo $cropn.$sep;
	echo $agrd['ann_fscode_f'].$sep;
	echo $agrd['ann_fscode_m'].$sep;
	
	echo $agrd['ann_prodcode'].$sep;
	
	echo $agrd['fname'].$sep;
	
	$str = chunk_split($agrd['tem_fid'], 4, ' ');
	
	echo $str.$sep;  //second_party
	echo $agrd['oname'].$sep;
	echo $agrd['father_name'].$sep;
	echo $agrd['uName'].$sep;
	echo getUName($agrd['prod_executive']).$sep;

	
	echo $varr[$agrd['village_id']].$sep;
	echo $tarr[$agrd['tahsil_id']].$sep;
	echo $darr[$agrd['distric_id']].$sep;
	echo $sarr[$agrd['state_id']].$sep;
	
	echo $villagen.', '.$tahsiln.', '.$distn.', '.$staten.$sep;
	
	echo $agrd['sowing_acres'].$sep;
	echo $agrd['GPSMeasure'].$sep;
	
	$Diff=$agrd['sowing_acres']-$agrd['GPSMeasure'];
	echo $Diff.$sep;
	
	echo $agrd['North_Side_Variety'].$sep; 
	echo $agrd['Comapny_north'].$sep;
	echo $agrd['Time_Isolation_north'].$sep;
	echo $agrd['South_Side_Variety'].$sep; 
	echo $agrd['Company_South'].$sep; 
	echo $agrd['Time_Isolation_south'].$sep;
	echo $agrd['East_Side_Variety'].$sep; 
	echo $agrd['Company_east'].$sep; 
	echo $agrd['Time_Isolation_east'].$sep;
	echo $agrd['West_Side_Variety'].$sep; 
	echo $agrd['Company_west'].$sep; 
	echo $agrd['Time_Isolation_west'].$sep;
	echo $agrd['VNR_Male_off_Type_Early'].$sep; 
	echo $agrd['Aprox_Male_early'].$sep;
	echo $agrd['VNR_Male_off_Type_Late'].$sep; 
	echo $agrd['Aprox_Male_late'].$sep;
	echo $agrd['VNR_Female_off_Type_Early'].$sep; 
	echo $agrd['Aprox_Female_early'].$sep;
	echo $agrd['VNR_Female_off_Type_Late'].$sep; 
	echo $agrd['Aprox_Female_late'].$sep;
	echo $agrd['Sample_collected_sent'].$sep;
	
	print("\n");
	
	$sn++;

}


?>


