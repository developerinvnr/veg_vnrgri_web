<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');

$xls_filename = 'Farmer_Reports.xls'; 

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t"; 

echo "Sn\tFarmer-ID\tFamrer Name\tContact\tDOB\tFather name\tOrganiser Name\tFarmer Address\tState\tDistict\tTahsil-Block\tVillage\tPinCode\tAADHAR No\tPAN\tBank name\tAccount no\tBranch name\tIFSC code\tBank Address";

print("\n");

if(isset($_REQUEST['orgr']) && $_REQUEST['orgr']!=''){
	$orgrCond="f.oid=".$_REQUEST['orgr'];
}else{
	$orgrCond='1=1';
}

    if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){ $keyArea="f.village_id like '%".$_REQUEST['vii']."%'";}
	elseif(isset($_REQUEST['tii']) && $_REQUEST['tii']!=''){ $keyArea="f.tahsil_id like '%".$_REQUEST['tii']."%'";}
	elseif(isset($_REQUEST['dii']) && $_REQUEST['dii']!=''){ $keyArea="f.distric_id like '%".$_REQUEST['dii']."%'";}
	elseif(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){ $keyArea="f.state_id like '%".$_REQUEST['sii']."%'";}
	else{$keyArea='1=1';}

    $qry.=" SELECT f.*, o.oname, v.VillageName, t.TahsilName, d.DictrictName, s.StateName FROM farmers f, organiser o,village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and f.oid=o.oid and ".$orgrCond." and ".$keyArea." ";
		
	
	$agr=mysql_query($qry);

    $sn=1;
	while ($agrd=mysql_fetch_assoc($agr)) 
	{
	  $str = chunk_split($agrd['tem_fid'], 4, ' ');
	
      echo $sn.$sep;
	  echo $str.$sep;
	  echo ucfirst(strtolower($agrd['fname'])).$sep;
	  echo $agrd['contact_1'].'"'.$sep;
	  echo $agrd['dob'].$sep;
	  echo $agrd['father_name'].$sep;
	  echo $agrd['oname'].$sep;
	  
	  echo $agrd['address'].$sep;
	  echo ucfirst(strtolower($agrd['StateName'])).$sep;
	  echo ucfirst(strtolower($agrd['DictrictName'])).$sep;
	  echo ucfirst(strtolower($agrd['StateName'])).$sep;
	  echo ucfirst(strtolower($agrd['VillageName'])).$sep;
	  echo $agrd['pincode'].$sep;
	  
	  if($agrd['aadhar_no']!=''){ $Aadhar="'".$agrd['aadhar_no']."'"; }
	  elseif($agrd['idproof_name']=='Aadhar'){ $Aadhar="'".$agrd['idproof_no']."'"; }
	  else{ $Aadhar=''; }
	  echo $Aadhar.$sep;
	  
	  if($agrd['pan_no']!=''){ $Pan=$agrd['pan_no']; }
	  elseif($agrd['idproof_name']=='Pan'){ $Pan=$agrd['idproof_no']; }
	  else{ $Pan=''; }
	  echo $Pan.$sep;
	  
	  echo $agrd['bank_name'].$sep;
	  echo "'".$agrd['account_no']."'".$sep;
	  echo $agrd['branch_name'].$sep;
	  echo $agrd['ifsc_code'].$sep;
	  echo $agrd['bank_add'].$sep;
	  print("\n");
	  $sn++;
     }

?>

