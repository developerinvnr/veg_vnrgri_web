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

if(isset($_REQUEST['act']) && $_REQUEST['act']=='saveCompanyDetails')
{

	$updt=mysql_query("UPDATE `company` SET `com_name`='".$_REQUEST['comn']."',`com_code`='".$_REQUEST['comc']."',`com_contact`='".$_REQUEST['comcont']."',`com_mail`='".$_REQUEST['commail']."',`address`='".$_REQUEST['comadd']."',`com_sts`='".$_REQUEST['coms']."' WHERE `comid`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated company details(Company ID:".$_REQUEST['id'].")";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addCompany'){

	$ins=mysql_query("INSERT INTO `company`(`com_name`, `com_code`, `com_contact`, `com_mail`, `address`, `com_sts`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['comn']."','".$_REQUEST['comc']."','".$_REQUEST['comcont']."','".$_REQUEST['commail']."','".$_REQUEST['comadd']."', '".$_REQUEST['coms']."', '".$_SESSION['uId']."','".date('Y-m-d')."')");

	if($ins){
		$action = "Added new Company(Company ID:".$_REQUEST['id'].")";
		addlog($_SESSION['uId'],$action);
		echo 'added';
	}else{
		echo 'error';
	}

}
elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveQCDetails')
{

	$updt=mysql_query("UPDATE `master_crop_qc` SET `cropid`='".$_REQUEST['crop']."', `type`='".$_REQUEST['type']."', `germination`='".$_REQUEST['germ']."',`genetic_purity`='".$_REQUEST['gene']."',`moisture`='".$_REQUEST['mois']."' WHERE `qcid`='".$_REQUEST['id']."'");
    
	if($updt){
		$action = "Updated QC Details(QC ID:".$_REQUEST['id'].")";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
	
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addQC'){

	$ins=mysql_query("INSERT INTO `master_crop_qc`(`cropid`, `type`, `germination`, `genetic_purity`, `physical_purity`, `moisture`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['crop']."','".$_REQUEST['type']."','".$_REQUEST['germ']."','".$_REQUEST['gene']."','".$_REQUEST['phys']."','".$_REQUEST['mois']."', '".$_SESSION['uId']."','".date('Y-m-d')."')");

	if($ins){
		$id = mysql_insert_id();
		$action = "Added new QC Details(QC ID:".$id.")";
		addlog($_SESSION['uId'],$action);
		echo 'added';
	}else{
		echo 'error';
	}
	
	
}
elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='findvariety')
{
 $ssv=mysql_query("select * from variety where cropid=".$_REQUEST['crop']." order by varietyname asc"); while($rrc=mysql_fetch_assoc($ssv)){ echo '<option value='.$rrc['varietyid'].'>'.$rrc['varietyname'].'</option>'; } 

}
elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='findpcode')
{
 $ssv=mysql_query("select varietycode from variety where varietyid=".$_REQUEST['prod']." "); 
 while($rrc=mysql_fetch_assoc($ssv)){ echo $rrc['varietycode']; } 

}
elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveQCICDetails')
{

	$updt=mysql_query("UPDATE `master_fsqc_transaction` SET `cropid`='".$_REQUEST['crop']."', varietyid='".$_REQUEST['hybname']."', `type`='".$_REQUEST['type']."', `yearno`='".$_REQUEST['yearno']."', `production_code`='".$_REQUEST['prodcode']."', `spcode_f1`='".$_REQUEST['f1']."', `spcode_f2`='".$_REQUEST['f2']."', `spcode_m1`='".$_REQUEST['m1']."', `spcode_m2`='".$_REQUEST['m2']."', estimated_yield='".$_REQUEST['estyield']."', genetic_purity1='".$_REQUEST['gp1']."', genetic_purity2='".$_REQUEST['gp2']."', genetic_purity3='".$_REQUEST['gp3']."' WHERE `trid`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated QCIC Details(QC ID:".$_REQUEST['id'].")";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
	
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addQCIC'){
   

	$ins=mysql_query("INSERT INTO `master_fsqc_transaction`(`cropid`, varietyid, `type`, `yearno`, `production_code`, `spcode_f1`, `spcode_f2`, `spcode_m1`, `spcode_m2`, estimated_yield, genetic_purity1, genetic_purity2, genetic_purity3, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['crop']."', '".$_REQUEST['hybname']."', '".$_REQUEST['type']."', '".$_REQUEST['yearno']."', '".$_REQUEST['prodcode']."', '".$_REQUEST['f1']."', '".$_REQUEST['f2']."', '".$_REQUEST['m1']."', '".$_REQUEST['m2']."', '".$_REQUEST['estyield']."', '".$_REQUEST['gp1']."', '".$_REQUEST['gp2']."', '".$_REQUEST['gp3']."', '".$_SESSION['uId']."','".date('Y-m-d')."')");

	if($ins){
		$id = mysql_insert_id();
		$action = "Added QCIC Details(QCIC ID:".$id.")";
		addlog($_SESSION['uId'],$action);
		echo 'added';
	}else{
		echo 'error';
	}
	
	
}
elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveOrgDetails')
{

 $dateOfBirth = date("Y-m-d",strtotime($_REQUEST['dob']));
 $today = date("Y-m-d");
 $diff = date_diff(date_create($dateOfBirth), date_create($today));
 $age=$diff->format('%y'); //'%y-%m-%d';
	
	$updt=mysql_query("UPDATE `organiser` SET `oname`='".$_REQUEST['oname']."', mobile_1='".$_REQUEST['cont1']."', `mobile_2`='".$_REQUEST['cont2']."', `email`='".$_REQUEST['mail']."', `dob`='".date("Y-m-d",strtotime($_REQUEST['dob']))."', `age`='".$age."', `fname`='".$_REQUEST['fname']."', `address`='".$_REQUEST['area']."', `state_id`='".$_REQUEST['state']."', district_id='".$_REQUEST['distric']."', tahsil_id='".$_REQUEST['tahsil']."', village_id='".$_REQUEST['village']."', city='".$_REQUEST['city']."', pincode='".$_REQUEST['pincode']."', aadhar_no='".$_REQUEST['aadhar']."', pan_no='".$_REQUEST['pan']."', bank_name='".$_REQUEST['bname']."', account_no='".$_REQUEST['bac']."', ifsc_code='".$_REQUEST['bifsc']."', bank_add='".$_REQUEST['badd']."' WHERE `oid`='".$_REQUEST['id']."'");

	if($updt){
		echo 'updated';
	}else{
		echo 'error';
	}
	
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addOrg'){
   
  $dateOfBirth = date("Y-m-d",strtotime($_REQUEST['dob']));
  $today = date("Y-m-d");
  $diff = date_diff(date_create($dateOfBirth), date_create($today));
  $age=$diff->format('%y'); //'%y-%m-%d';  
  
  $chk=mysql_query("select * from `organiser` where `oname`='".$_REQUEST['oname']."' AND (mobile_1='".$_REQUEST['cont1']."' OR mobile_2='".$_REQUEST['cont1']."')");
  $row=mysql_num_rows($chk);
  if($row==0)
  {
 
	$ins=mysql_query("INSERT INTO `organiser`(`oname`, mobile_1, `mobile_2`, `email`, `dob`, `age`, `fname`, `address`, `state_id`, district_id,tahsil_id,village_id, city, pincode, aadhar_no, pan_no, bank_name, account_no, ifsc_code, bank_add) VALUES ('".$_REQUEST['oname']."', '".$_REQUEST['cont1']."', '".$_REQUEST['cont2']."', '".$_REQUEST['mail']."', '".date("Y-m-d",strtotime($_REQUEST['dob']))."', '".$age."', '".$_REQUEST['fname']."', '".$_REQUEST['area']."', '".$_REQUEST['state']."', '".$_REQUEST['distric']."','".$_REQUEST['tahsil']."','".$_REQUEST['village']."', '".$_REQUEST['city']."', '".$_REQUEST['pincode']."', '".$_REQUEST['aadhar']."', '".$_REQUEST['pan']."', '".$_REQUEST['bname']."', '".$_REQUEST['bac']."', '".$_REQUEST['bifsc']."', '".$_REQUEST['badd']."')");

	if($ins){ echo 'added';	}else{	echo 'error'; }
	
  }	
  else
  {
	echo 'duplicate entry';
  }


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_v'){
  
  $sq=mysql_query("SELECT v.TahsilId,t.DistrictId,d.StateId FROM `village` v inner join tahsil t on v.TahsilId=t.TahsilId inner join distric d on t.DistrictId=d.DictrictId where v.VillageId=".$_REQUEST['vid']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti" value="'.$rs['StateId'].'">'; 
  echo '<input type="hidden" id="dti" value="'.$rs['DistrictId'].'">';
  echo '<input type="hidden" id="tti" value="'.$rs['TahsilId'].'">';


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_t'){
  
  $sq=mysql_query("SELECT t.DistrictId,d.StateId FROM tahsil t inner join distric d on t.DistrictId=d.DictrictId where t.TahsilId=".$_REQUEST['tid']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti" value="'.$rs['StateId'].'">'; 
  echo '<input type="hidden" id="dti" value="'.$rs['DistrictId'].'">';


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_d'){
  
  $sq=mysql_query("SELECT StateId FROM distric where DictrictId=".$_REQUEST['did']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti" value="'.$rs['StateId'].'">'; 


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_vv'){
  
  $sq=mysql_query("SELECT v.TahsilId,t.DistrictId,d.StateId FROM `village` v inner join tahsil t on v.TahsilId=t.TahsilId inner join distric d on t.DistrictId=d.DictrictId where v.VillageId=".$_REQUEST['vid']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti'.$_REQUEST['lc'].'" value="'.$rs['StateId'].'">'; 
  echo '<input type="hidden" id="dti'.$_REQUEST['lc'].'" value="'.$rs['DistrictId'].'">';
  echo '<input type="hidden" id="tti'.$_REQUEST['lc'].'" value="'.$rs['TahsilId'].'">';


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_tt'){
  
  $sq=mysql_query("SELECT t.DistrictId,d.StateId FROM tahsil t inner join distric d on t.DistrictId=d.DictrictId where t.TahsilId=".$_REQUEST['tid']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti'.$_REQUEST['lc'].'" value="'.$rs['StateId'].'">'; 
  echo '<input type="hidden" id="dti'.$_REQUEST['lc'].'" value="'.$rs['DistrictId'].'">';


}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='get_from_dd'){
  
  $sq=mysql_query("SELECT StateId FROM distric where DictrictId=".$_REQUEST['did']); $rs=mysql_fetch_assoc($sq); 
   
  echo '<input type="hidden" id="sti'.$_REQUEST['lc'].'" value="'.$rs['StateId'].'">'; 
}


//oname cont1 cont2 mail dob fname aadhar pan area state distric city pincode bname, bac, bifsc, badd
?>







