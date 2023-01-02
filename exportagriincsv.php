<?php 
session_start();
include 'config.php'; 

function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];

}
function gethierarchy($uid){

	$id=array($uid);
	
	if($_SESSION['uType']=='S' OR $_SESSION['uId']==134){
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



$csv_output .= '"Sn",';  
$csv_output .= '"Agreement-ID",';
$csv_output .= '"Agreement Date",';
$csv_output .= '"Crop",'; 
$csv_output .= '"Hybrid Code",';
$csv_output .= '"Female FSCode",'; 
$csv_output .= '"Male FSCode",'; 
$csv_output .= '"Farmer Name",';
$csv_output .= '"Farmer Id",';
$csv_output .= '"Organiser Name",';
$csv_output .= '"Production Person",';
$csv_output .= '"Production Executive",';
$csv_output .= '"Farmer Father Name",';
 
$csv_output .= '"Farmer Village",';
$csv_output .= '"Farmer Tahsil",';
$csv_output .= '"Farmer District",';
$csv_output .= '"Farmer State",';
$csv_output .= '"Production Village",'; 
$csv_output .= '"Production Tahsil",';
$csv_output .= '"Production District",';
$csv_output .= '"Production State",';
$csv_output .= '"Sowing Acre",';
$csv_output .= '"Final Standing Acre (GPS Measure)",';

$csv_output .= '"North_Side_Variety",'; 
$csv_output .= '"Comapny_north",'; 
$csv_output .= '"Time_Isolation_north",';
$csv_output .= '"South_Side_Variety",'; 
$csv_output .= '"Company_South",'; 
$csv_output .= '"Time_Isolation_south",';
$csv_output .= '"East_Side_Variety",'; 
$csv_output .= '"Company_east",'; 
$csv_output .= '"Time_Isolation_east",';
$csv_output .= '"West_Side_Variety",'; 
$csv_output .= '"Company_west",'; 
$csv_output .= '"Time_Isolation_west",';
$csv_output .= '"VNR_Male_off_Type_Early",'; 
$csv_output .= '"Aprox_Male_early",';
$csv_output .= '"VNR_Male_off_Type_Late",'; 
$csv_output .= '"Aprox_Male_late",';
$csv_output .= '"VNR_Female_off_Type_Early",'; 
$csv_output .= '"Aprox_Female_early",';
$csv_output .= '"VNR_Female_off_Type_Late",'; 
$csv_output .= '"Aprox_Female_late",';
$csv_output .= '"Sample_collected_sent",';

$csv_output .= '"Farmer Contact No",';
$csv_output .= '"Farmer DOB",';
$csv_output .= '"Farmer Bank Name",';
$csv_output .= '"Bank A/c",';
$csv_output .= '"Bank Branch",';
$csv_output .= '"Bank IFSC",';
$csv_output .= '"Bank Address",';

//$csv_output .= '"Diff Acre",';  
$csv_output .= "\n";	


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

$from = date('Y-m-d',strtotime($_REQUEST['from']));
$agyearf = (int)date('Y',strtotime($_REQUEST['from']));

$to = date('Y-m-d',strtotime($_REQUEST['to']));
$agyeart = (int)date('Y',strtotime($_REQUEST['to']));


$from11 = date('d-m-Y',strtotime($_REQUEST['from']));
$to11 = date('d-m-Y',strtotime($_REQUEST['to']));


//==== query condition for crop filter =======================================================
if(isset($_REQUEST['crop']) && $_REQUEST['crop']!=''){
	$cropCond="agr.ann_crop=".$_REQUEST['crop'];
}
elseif(isset($_REQUEST['crop']) && $_REQUEST['crop']==''){
	$cropCond='1=1';
}
else{
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
/*
	$allids = array_unique(gethierarchy($_POST['users']));
	$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
	
if(isset($_POST['users']) && $_POST['users']!='')
{	
function get2hierarchy($uid)
 {
 $id=array($uid);
 $sel=mysql_query("select uId from users where uReporting='".$uid."'");
 if(mysql_num_rows($sel) > 0)
 {
	while($seld = mysql_fetch_assoc($sel))
	{
	 $idc = array($seld['uId']);
	 $id = array_merge($id,$idc,get2hierarchy($seld['uId']));
	}
 }
 return $id;	
}

 $allids = array_unique(get2hierarchy($_POST['users'])); //$_SESSION['uId']
 $hierarchyCond = "(agr.prod_person IN (".implode(', ', $allids).") or agr.prod_executive IN (".implode(', ', $allids)."))";	
	
}
else 
{ 
    //$hierarchyCond='1=1';
    $allids = array_unique(gethierarchy($_SESSION['uId']));
    $hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
    
}		
	
*/

   if($_SESSION['uId']!=134){
	$allids = array_unique(gethierarchy($_SESSION['uId']));
	$hierarchyCond = "agr.cr_by IN (".implode(', ', $allids).")";
   }
   else
   {
       $hierarchyCond='1=1';
       
   }

//==== query condition for getting results as per users hierarchy ================= end =======================



$qry="";
for ($i=$agyearf; $i <= $agyeart; $i++) {

	$qry.=" SELECT agr.*, u.uName, f.tem_fid, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id, f.contact_1, f.dob, f.bank_name, f.account_no, f.branch_name, f.ifsc_code, f.bank_add FROM `agreement_".$i."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond;
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
	  $cropn=$cr['cropname']; }else{ $cropn=''; }
	if($agrd['ann7_flandid']>0)
	{
	 /*
	 $fld=mysql_query('SELECT StateId as st,DictrictId as dt,TahsilId as tt,VillageId vt FROM farmers_land where flandid='.$agrd['ann7_flandid']); $rld=mysql_fetch_assoc($fld);
     if($rld['st']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$rld['st'])); 
	 $staten=$sr['StateName']; }else{ $staten=$sarr[$agrd['state_id']]; }
     if($rld['dt']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$rld['dt'])); 
	 $distn=$dr['DictrictName']; }else{ $distn=$darr[$agrd['distric_id']]; }
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
	
	
	$csv_output .= '"'.str_replace('"', '""', $sn).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['agree_no']).'",';
	//$agree_date=date("d-m-Y",strtotime($agrd['agree_date']));
	$csv_output .= '"'.str_replace('"', '""', $agrd['agree_date']).'",';
	$csv_output .= '"'.str_replace('"', '""', $cropn).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_prodcode']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_fscode_f']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_fscode_m']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['fname']).'",';
	
	$str = chunk_split($agrd['tem_fid'], 4, ' ');
	
	$csv_output .= '"'.str_replace('"', '""', $str).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['oname']).'",';
	$csv_output .= '"'.str_replace('"', '""', getUName($agrd['prod_person'])).'",';
	$csv_output .= '"'.str_replace('"', '""', getUName($agrd['prod_executive'])).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['father_name']).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $varr[$agrd['village_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $tarr[$agrd['tahsil_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $darr[$agrd['distric_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $sarr[$agrd['state_id']]).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $villagen).'",';
	$csv_output .= '"'.str_replace('"', '""', $tahsiln).'",';
	$csv_output .= '"'.str_replace('"', '""', $distn).'",';
	$csv_output .= '"'.str_replace('"', '""', $staten).'",';
	
	//$csv_output .= '"'.str_replace('"', '""', $villagen.', '.$tahsiln.', '.$distn.', '.$staten).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $agrd['sowing_acres']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['GPSMeasure']).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $agrd['North_Side_Variety']).'",'; 
    $csv_output .= '"'.str_replace('"', '""', $agrd['Comapny_north']).'",'; 
    $csv_output .= '"'.str_replace('"', '""', $agrd['Time_Isolation_north']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['South_Side_Variety']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Company_South']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Time_Isolation_south']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['East_Side_Variety']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Company_east']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Time_Isolation_east']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['West_Side_Variety']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Company_west']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Time_Isolation_west']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['VNR_Male_off_Type_Early']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Aprox_Male_early']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['VNR_Male_off_Type_Late']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Aprox_Male_late']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['VNR_Female_off_Type_Early']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Aprox_Female_early']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['VNR_Female_off_Type_Late']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['Aprox_Female_late']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Sample_collected_sent']).'",';	
	
	$csv_output .= '"'.str_replace('"', '""', $agrd['contact_1']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['dob']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['bank_name']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['account_no']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['branch_name']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ifsc_code']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['bank_add']).'",';
	
	//$Diff=$agrd['sowing_acres']-$agrd['standing_acres'];
	//$csv_output .= '"'.str_replace('"', '""', $Diff).'",';
	
$csv_output .= "\n";
$sn++;

}

# Close the MySql connection
// mysql_close($con);
# Set the headers so the file downloads
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($csv_output));
header("Content-type: text/x-csv");
$csv_filename = 'AgreeRpt_For_Import_'.$from11.'-'.$to11.'.csv'; 
header("Content-Disposition: attachment; filename=".$csv_filename);
echo $csv_output;
exit;

?>