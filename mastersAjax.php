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


if(isset($_REQUEST['act']) && $_REQUEST['act']=='saveUserDetails'){
    
    if($_REQUEST['up']==1 OR $_REQUEST['up']==5 OR $_REQUEST['up']==6 OR $_REQUEST['up']==7 OR $_REQUEST['up']==8 OR $_REQUEST['up']==10){ $advPln=1; }else{ $advPln=0; }

	$updt=mysql_query("UPDATE `users` SET `uName`='".$_REQUEST['un']."',`uUsername`='".$_REQUEST['usn']."',`uType`='".$_REQUEST['ut']."',`uContact`='".$_REQUEST['uc']."',`uEmail`='".$_REQUEST['ue']."',`uPost`='".$_REQUEST['up']."', AdvancePlan='".$advPln."', `uReporting`='".$_REQUEST['ur']."',`uStatus`='".$_REQUEST['us']."', QADept='".$_REQUEST['QADept']."', Qs1='".$_REQUEST['Qs1']."', Qs2='".$_REQUEST['Qs2']."', Qs3='".$_REQUEST['Qs3']."', Qs4='".$_REQUEST['Qs4']."', Qs5='".$_REQUEST['Qs5']."' WHERE `uId`='".$_REQUEST['id']."'");

	if($updt){
		$action = getUName($_REQUEST['id']). " details updated";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addUser'){
    
    if($_REQUEST['upadd']==1 OR $_REQUEST['upadd']==5 OR $_REQUEST['upadd']==6 OR $_REQUEST['upadd']==7 OR $_REQUEST['upadd']==8 OR $_REQUEST['upadd']==10){ $advPln=1; }else{ $advPln=0; }

	$pass=md5($_POST['upwadd']);
	$ins=mysql_query("INSERT INTO `users`(`uName`, `uUsername`, `uPassword`, `uType`, `uContact`, `uEmail`, `uPost`, AdvancePlan, `uReporting`, `uStatus`, `uCrby`, QADept, Qs1, Qs2, Qs3, Qs4, Qs5) VALUES ('".$_REQUEST['unadd']."','".$_REQUEST['usnadd']."','".$pass."','".$_REQUEST['utadd']."','".$_REQUEST['ucadd']."','".$_REQUEST['ueadd']."','".$_REQUEST['upadd']."', '".$advPln."', '".$_REQUEST['uradd']."','".$_REQUEST['usadd']."','".$_SESSION['uId']."','".$_REQUEST['QADept']."','".$_REQUEST['Qs1']."','".$_REQUEST['Qs2']."','".$_REQUEST['Qs3']."','".$_REQUEST['Qs4']."','".$_REQUEST['Qs5']."')");

	if($ins){
		$id=mysql_insert_id();
		$action = "Added new user: ".getUName($id);
		addlog($_SESSION['uId'],$action);
		echo 'added';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveStateDetails'){

	$updt=mysql_query("UPDATE `state` SET `StateName`='".$_REQUEST['stn']."',`StateCode`='".$_REQUEST['stc']."',`CountryId`='".$_REQUEST['cyid']."',`StateStatus`='".$_REQUEST['ssts']."' WHERE `StateId`='".$_REQUEST['id']."'");

	if($updt){
		$action = " State details updated: ".$_REQUEST['stn'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addState'){

	$ins=mysql_query("INSERT INTO `state`(`StateName`, `StateCode`, `CountryId`, `StateStatus`, `CreatedBy`, `CreatedDate`) VALUES ('".$_REQUEST['stn']."','".$_REQUEST['stc']."','".$_REQUEST['cyid']."','".$_REQUEST['ssts']."','".$_SESSION['uId']."','".date('Y-m-d')."')");

	if($_REQUEST['from']=='addFarmerPage'){

		// $sel=mysql_query("SELECT * FROM `user_location` where `state_id`='".$sid."' and `district_id`='".$did."' and `tahsil_id`='".$tid."' and  uid='".$_REQUEST['uid']."'");
		$id = mysql_insert_id();
		$action = "Added new State: ".$_REQUEST['stn'];
		addlog($_SESSION['uId'],$action);
		$sel=mysql_query("SELECT * FROM `user_location` where `state_id`='".$id."' and  uid='".$_SESSION['uId']."'");

		if(mysql_num_rows($sel)==0){
			$add=mysql_query("INSERT INTO `user_location`(`uid`,`state_id`, `sts`, `cr_by`, `cr_date`) VALUES ('".$_SESSION['uId']."','".$id."','A','".$_SESSION['uId']."','".date('Y-m-d')."')");
		}else{
			$updt=mysql_query("UPDATE `user_location` SET `sts`='A' where `state_id`='".$id."' and uid='".$_SESSION['uId']."'");
		}

	}

	if($ins){
		echo 'added';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveDistrictDetails'){

	$updt=mysql_query("UPDATE `distric` SET `DictrictName`='".$_REQUEST['dina']."',`StateId`='".$_REQUEST['dista']."' WHERE `DictrictId`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Update Distict Details: ".$_REQUEST['dina'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
		
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addDistrict'){

	$ins=mysql_query("INSERT INTO `distric`(`DictrictName`, `StateId`) VALUES ('".$_REQUEST['dina']."','".$_REQUEST['dista']."')");

	if($ins){
		$id = mysql_insert_id();
		$action = "Added new Distict: ".$_REQUEST['dina'];
		addlog($_SESSION['uId'],$action);
		
	}

	if($_REQUEST['from']=='addFarmerPage'){

		// $sel=mysql_query("SELECT * FROM `user_location` where `state_id`='".$sid."' and `district_id`='".$did."' and `tahsil_id`='".$tid."' and  uid='".$_REQUEST['uid']."'");
		$id = mysql_insert_id();
		$sel=mysql_query("SELECT * FROM `user_location` where `district_id`='".$id."' and  uid='".$_SESSION['uId']."'");

		if(mysql_num_rows($sel)==0){
			$add=mysql_query("INSERT INTO `user_location`(`uid`,`district_id`, `sts`, `cr_by`, `cr_date`) VALUES ('".$_SESSION['uId']."','".$id."','A','".$_SESSION['uId']."','".date('Y-m-d')."')");
			$action = "Added Distict (District ID-'".$id."')  into ".getUName($_SESSION['uId'])."'s location ";
			addlog($_SESSION['uId'],$action);
		}else{
			$updt=mysql_query("UPDATE `user_location` SET `sts`='A' where `district_id`='".$id."' and uid='".$_SESSION['uId']."'");
			$action = "Updated Status:Active of Distict (District ID-'".$id."') into ".getUName($_SESSION['uId'])."'s location";
			addlog($_SESSION['uId'],$action);
		}

	}

	if($ins){
		echo 'added';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addTahsil'){

	$ins=mysql_query("INSERT INTO `tahsil`(`TahsilName`, `TahsilCode`, `DistrictId`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['tahn']."','".$_REQUEST['tahc']."','".$_REQUEST['tahdi']."','".$_SESSION['uId']."','".date('Y-m-d')."')");

	if($_REQUEST['from']=='addFarmerPage'){

		// $sel=mysql_query("SELECT * FROM `user_location` where `state_id`='".$sid."' and `district_id`='".$did."' and `tahsil_id`='".$tid."' and  uid='".$_REQUEST['uid']."'");
		$id = mysql_insert_id();
		$action = "Added Tahsil: ".$_REQUEST['tahn'];
		addlog($_SESSION['uId'],$action);
		$sel=mysql_query("SELECT * FROM `user_location` where `tahsil_id`='".$id."' and  uid='".$_SESSION['uId']."'");

		if(mysql_num_rows($sel)==0){
			$add=mysql_query("INSERT INTO `user_location`(`uid`,`tahsil_id`, `sts`, `cr_by`, `cr_date`) VALUES ('".$_SESSION['uId']."','".$id."','A','".$_SESSION['uId']."','".date('Y-m-d')."')");
			$action = "Added Tahsil (Tahsil ID-'".$id."')  into ".getUName($_SESSION['uId'])."'s location ";
			addlog($_SESSION['uId'],$action);
		}else{
			$updt=mysql_query("UPDATE `user_location` SET `sts`='A' where `tahsil_id`='".$id."' and uid='".$_SESSION['uId']."'");
			$action = "Updated Status:Active of Tahsil (Tahsil ID-'".$id."') into ".getUName($_SESSION['uId'])."'s location";
			addlog($_SESSION['uId'],$action);
		}

	}

	if($ins){
		echo 'added';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveTahsilDetails'){

	$updt=mysql_query("UPDATE `tahsil` SET `TahsilName`='".$_REQUEST['tahn']."',`TahsilCode`='".$_REQUEST['tahc']."',`DistrictId`='".$_REQUEST['tahdi']."' WHERE `TahsilId`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated Tahsil Details: ".$_REQUEST['tahn'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addVillage'){
    
    $chkk=mysql_query("select * from `village` where `VillageName`='".$_REQUEST['vina']."' AND `TahsilId`='".$_REQUEST['vita']."' ");
	$row=mysql_num_rows($chkk);
	if($row==0)
	{ 
    
	  $ins=mysql_query("INSERT INTO `village`(`VillageName`, `TahsilId`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['vina']."','".$_REQUEST['vita']."','".$_SESSION['uId']."','".date('Y-m-d')."')");

	   if($ins){
		$action = "Added new: ".$_REQUEST['vina'];
		addlog($_SESSION['uId'],$action);
		echo 'added';
	   }else{echo 'error'; }
	   
	}
	else
	{
	  echo 'error, duplicate entry!';
	}   
	
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveVillageDetails'){

	$updt=mysql_query("UPDATE `village` SET `VillageName`='".$_REQUEST['vina']."',`TahsilId`='".$_REQUEST['vita']."' WHERE `VillageId`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated village details: ".$_REQUEST['vina'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addCrop'){

    $chkk=mysql_query("select * from `crop` where `cropname`='".$_REQUEST['crn']."'");
	$row=mysql_num_rows($chkk);
	if($row==0)
	{ 

	  $ins=mysql_query("INSERT INTO `crop`( `cropname`, `cropcode`, `group`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['crn']."','".$_REQUEST['crc']."','".$_REQUEST['cgid']."','".$_SESSION['uId']."','".date('Y-m-d')."')");

	  if($ins){
		$action = "Added new Crop: ".$_REQUEST['crn'];
		 addlog($_SESSION['uId'],$action);
		 echo 'added';
	  }else{ echo 'error'; }
	
	}
	else
	{
	  echo 'error, duplicate entry!';
	} 
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveCropDetails'){

	$updt=mysql_query("UPDATE `crop` SET `cropname`='".$_REQUEST['crn']."',`cropcode`='".$_REQUEST['crc']."',`group`='".$_REQUEST['cgid']."' WHERE `cropid`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated Crop details: ".$_REQUEST['crn'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addVariety'){

    
    $chkk=mysql_query("select * from `variety` where `varietyname`='".$_REQUEST['varn']."'");
	$row=mysql_num_rows($chkk);
	if($row==0)
	{ 
    
	  $ins=mysql_query("INSERT INTO `variety`( `cropid`, `varietyname`, `varietycode`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['varcid']."','".$_REQUEST['varn']."','".$_REQUEST['varc']."','".$_SESSION['uId']."','".date('Y-m-d')."')");

	  if($ins){
		   $action = "Added new variety: ".$_REQUEST['varn'];
		   addlog($_SESSION['uId'],$action);
		   echo 'added new variety';
	  }else{echo 'error';	}
	 
	}
	else
	{
	  echo 'error, duplicate entry!';
	} 
	
	
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='saveVarietyDetails'){

	$updt=mysql_query("UPDATE `variety` SET `cropid`='".$_REQUEST['varcid']."',`varietyname`='".$_REQUEST['varn']."',`varietycode`='".$_REQUEST['varc']."' WHERE `varietyid`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated Variety details: ".$_REQUEST['varn'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_POST['act']) && $_POST['act']=='addfarmer'){
	
	
	// ==============farmer details insert start=========================================================
	$dob=date('Y-m-d',strtotime($_POST['dob']));

	$time=$_SESSION['uId'].'U'.date('dmyhis');

	//====== in below query, checking the repeatation of farmer entry ===============================
	$repsel=mysql_query("select * from `farmers` where `fname`='".$_POST['fname']."' and `contact_1`='".$_POST['contact_1']."' and `account_no`='".$_POST['account_no']."'");

	if(mysql_num_rows($repsel) == 0){

		$ins=mysql_query("INSERT INTO `farmers`( `tem_fid`,`fname`, `contact_1`, `contact_2`, `dob`, `age`, `father_name`, `address`, `state_id`, `distric_id`, `tahsil_id`, `village_id`, `pincode`, `idproof_name`, `idproof_no`, `addproof_name`, `addproof_no`, `bank_name`, `account_no`, `branch_name`, `ifsc_code`, `bank_add`, `cr_by`, `cr_date`, `oid`) VALUES ('".$time."','".$_POST['fname']."','".$_POST['contact_1']."','".$_POST['contact_2']."','".$dob."','".$_POST['age']."','".$_POST['father_name']."','".$_POST['address']."','".$_POST['state_id']."','".$_POST['distric_id']."','".$_POST['tahsil_id']."','".$_POST['village_id']."','".$_POST['pincode']."','".$_POST['idproof_name']."','".$_POST['idproof_no']."','".$_POST['addproof_name']."','".$_POST['addproof_no']."','".$_POST['bank_name']."','".$_POST['account_no']."','".$_POST['branch_name']."','".$_POST['ifsc_code']."','".$_POST['bank_add']."','".$_SESSION['uId']."','".date('Y-m-d')."','".$_POST['oid']."')");

	}

	// ==============farmer details insert end=========================================================
	

	if($ins){
		$id = mysql_insert_id();
		$action = "Added new farmer (Farmer-ID:".$id.")";
		addlog($_SESSION['uId'],$action);

		// ==============farmer files upload start=========================================================

		if(isset($_FILES['doc_idproof']['name'])){
		  $sourcePath = $_FILES['doc_idproof']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_idproof']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_idproof=$id.'doc_idproof.'.$ext;
		  $targetPath = "files_2/".$doc_idproof;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_idproof='".$doc_idproof."' where fid=".$id);
		  }
		}
		if(isset($_FILES['doc_addproof']['name'])){
		  $sourcePath = $_FILES['doc_addproof']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_addproof']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_addproof=$id.'doc_addproof.'.$ext;
		  $targetPath = "files_2/".$doc_addproof;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_addproof='".$doc_addproof."' where fid=".$id);
		  }
		}
		if(isset($_FILES['doc_passbook']['name'])){
		  $sourcePath = $_FILES['doc_passbook']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_passbook']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_passbook=$id.'doc_passbook.'.$ext;
		  $targetPath = "files_2/".$doc_passbook;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_passbook='".$doc_passbook."' where fid=".$id);
		  }
		}

		// ==============farmer files upload end=========================================================


		// ==============farmer land details upload start=========================================================

		$landcount = (int)$_POST['landcount'];

		for ($lc=1; $lc <= $landcount; $lc++) { 

			if($_POST['landarea_idla'.$lc]!='' && $_POST['state_idla'.$lc]!='' && $_POST['distric_idla'.$lc]!='' && $_POST['tahsil_idla'.$lc]!='' && $_POST['village_idla'.$lc]!=''){
				$ins=mysql_query("INSERT INTO `farmers_land`(`fid`, `khasra_no`, `land_area`, `StateId`, `DictrictId`, `TahsilId`, `VillageId`) VALUES ('".$id."','".$_POST['khasrano_idla'.$lc]."','".$_POST['landarea_idla'.$lc]."','".$_POST['state_idla'.$lc]."','".$_POST['distric_idla'.$lc]."','".$_POST['tahsil_idla'.$lc]."','".$_POST['village_idla'.$lc]."')");
			}
			
			
		}

		// ==============farmer land details upload end=========================================================


		?><script>window.location.href = "addFarmer.php?added=yes";</script><?php
	}else{
		?><script>window.location.href = "addFarmer.php?added=no";</script><?php
	}

}elseif(isset($_POST['act']) && $_POST['act']=='editfarmer'){
	

	// ==============farmer details insert start=========================================================
	$dob=date('Y-m-d',strtotime($_POST['dob']));



	$ins=mysql_query("UPDATE `farmers` set `fname`='".$_POST['fname']."', `contact_1`='".$_POST['contact_1']."', `contact_2`='".$_POST['contact_2']."', `dob`='".$dob."', `age`='".$_POST['age']."', `father_name`='".$_POST['father_name']."', `address`='".$_POST['address']."', `state_id`='".$_POST['state_id']."', `distric_id`='".$_POST['distric_id']."', `tahsil_id`='".$_POST['tahsil_id']."', `village_id`='".$_POST['village_id']."', `pincode`='".$_POST['pincode']."', `idproof_name`='".$_POST['idproof_name']."', `idproof_no`='".$_POST['idproof_no']."', `addproof_name`='".$_POST['addproof_name']."', `addproof_no`='".$_POST['addproof_no']."', `bank_name`='".$_POST['bank_name']."', `account_no`='".$_POST['account_no']."', `branch_name`='".$_POST['branch_name']."', `ifsc_code`='".$_POST['ifsc_code']."', `bank_add`='".$_POST['bank_add']."',`oid`='".$_POST['oid']."' where `fid`='".$_POST['editid']."'");

	// ==============farmer details insert end=========================================================
	

	if($ins){
		$id = $_POST['editid'];
		$action = "Edited farmer details (Farmer-ID:".$id.")";
		addlog($_SESSION['uId'],$action);

		// ==============farmer files upload start=========================================================

		if(isset($_FILES['doc_idproof']['name'])){
		  $sourcePath = $_FILES['doc_idproof']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_idproof']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_idproof=$id.'doc_idproof.'.$ext;
		  $targetPath = "files_2/".$doc_idproof;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_idproof='".$doc_idproof."' where fid=".$id);
		  }
		}
		if(isset($_FILES['doc_addproof']['name'])){
		  $sourcePath = $_FILES['doc_addproof']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_addproof']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_addproof=$id.'doc_addproof.'.$ext;
		  $targetPath = "files_2/".$doc_addproof;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_addproof='".$doc_addproof."' where fid=".$id);
		  }
		}
		if(isset($_FILES['doc_passbook']['name'])){
		  $sourcePath = $_FILES['doc_passbook']['tmp_name'];
		  $targetPath = "files_2/".$_FILES['doc_passbook']['name'];
		  $ext = substr($targetPath, strrpos($targetPath, '.') + 1);
		  // $without_ext = basename($targetPath, '.'.$ext);
		  $doc_passbook=$id.'doc_passbook.'.$ext;
		  $targetPath = "files_2/".$doc_passbook;
		  if(move_uploaded_file($sourcePath,$targetPath)){
			  $updt=mysql_query("update farmers set doc_passbook='".$doc_passbook."' where fid=".$id);
		  }
		}

		// ==============farmer files upload end=========================================================


		// ==============farmer land details upload start=========================================================

		$landcount = (int)$_POST['landcount'];

		for ($lc=1; $lc <= $landcount; $lc++) { 

			if($_POST['landarea_idla'.$lc]!='' && $_POST['state_idla'.$lc]!='' && $_POST['distric_idla'.$lc]!='' && $_POST['tahsil_idla'.$lc]!='' && $_POST['village_idla'.$lc]!=''){


				//$sameland=mysql_query("SELECT * from `farmers_land` where `fid`='".$id."' and `khasra_no`='".$_POST['khasrano_idla'.$lc]."' and `VillageId`='".$_POST['village_idla'.$lc]."' and `land_area`='".$_POST['landarea_idla'.$lc]."' ");
				//if(mysql_num_rows($sameland) > 0){
 
				if($_POST['flandid'.$lc]>0){
					//$ins=mysql_query("UPDATE `farmers_land` SET `land_area`='".$_POST['landarea_idla'.$lc]."' where `fid`='".$id."' and `khasra_no`='".$_POST['khasrano_idla'.$lc]."' and `VillageId`='".$_POST['village_idla'.$lc]."'");
					$ins=mysql_query("UPDATE `farmers_land` SET `StateId`='".$_POST['state_idla'.$lc]."', `DictrictId`='".$_POST['distric_idla'.$lc]."', `TahsilId`='".$_POST['tahsil_idla'.$lc]."', `VillageId`='".$_POST['village_idla'.$lc]."', `land_area`='".$_POST['landarea_idla'.$lc]."', khasra_no='".$_POST['khasrano_idla']."' where flandid=".$_POST['flandid'.$lc]); 
					
				}else{
					$ins=mysql_query("INSERT INTO `farmers_land`(`fid`, `khasra_no`, `land_area`, `StateId`, `DictrictId`, `TahsilId`, `VillageId`) VALUES ('".$id."','".$_POST['khasrano_idla'.$lc]."','".$_POST['landarea_idla'.$lc]."','".$_POST['state_idla'.$lc]."','".$_POST['distric_idla'.$lc]."','".$_POST['tahsil_idla'.$lc]."','".$_POST['village_idla'.$lc]."')");
				}
				
			}
			
			
		}

		// ==============farmer land details upload end=========================================================


		?><script>window.location.href = "editFarmer.php?fid=<?=$_POST['editid']?>&added=yes";</script><?php
	}else{
		?><script>window.location.href = "editFarmer.php?fid=<?=$_POST['editid']?>&added=no";</script><?php
	}

}elseif(isset($_POST['act']) && $_POST['act']=='getFState'){


	$alls=mysql_query("SELECT * FROM `state` s inner join user_location l on l.state_id=s.StateId where l.uid=".$_SESSION['uId']." AND l.sts='A' order by StateName asc"); 
	while ($allsd=mysql_fetch_assoc($alls)){
		?><option value="<?=$allsd['StateId']?>"  ><?=strtoupper($allsd['StateName']);?></option><?php
		
	}

}elseif(isset($_POST['act']) && $_POST['act']=='getdist'){
	//$alld=mysql_query("SELECT * FROM `distric` d, user_location ul where `StateId`=".$_POST['sid']." and ul.district_id=d.DictrictId and ul.sts='A' and ul.uid='".$_SESSION['uId']."' order by DictrictName asc");
	
	$alld=mysql_query("SELECT * FROM `distric` where `StateId`=".$_POST['sid']." order by DictrictName asc");
	
	?><option  disabled selected>Select</option><?php
	while ($alldd=mysql_fetch_assoc($alld)) {
		?><option value="<?=$alldd['DictrictId']?>"  ><?=strtoupper($alldd['DictrictName']);?></option><?php
	}
}elseif(isset($_POST['act']) && $_POST['act']=='gettahsil'){
	//$allt=mysql_query("SELECT * FROM `tahsil` t, user_location ul where `DistrictId`=".$_POST['did']." and ul.tahsil_id=t.TahsilId and ul.sts='A' and ul.uid='".$_SESSION['uId']."' order by TahsilName asc");
	
	$allt=mysql_query("SELECT * FROM `tahsil` where `DistrictId`=".$_POST['did']."  order by TahsilName asc");
	
	?><option  disabled selected>Select</option><?php
	while ($alltd=mysql_fetch_assoc($allt)) {
		?><option value="<?=$alltd['TahsilId']?>"  ><?=$alltd['TahsilName']?></option><?php
	}
}elseif(isset($_POST['act']) && $_POST['act']=='getvillage'){
    
	//$allv=mysql_query("SELECT * FROM `village` v, user_location ul where `TahsilId`=".$_POST['tid']." and ul.village_id=v.VillageId and ul.sts='A' and ul.uid='".$_SESSION['uId']."' order by VillageName asc");
	
	$allv=mysql_query("SELECT * FROM `village` order by VillageName asc");
	?><option  disabled selected>Select</option><?php
	while ($allvd=mysql_fetch_assoc($allv)) {
		?><option value="<?=$allvd['VillageId']?>"><?=$allvd['VillageName']?></option><?php
	}
}elseif(isset($_POST['act']) && $_POST['act']=='addFarmerLand'){
	

	
	$sarr=$_SESSION['sarr'];
	$darr=$_SESSION['darr'];
	$tarr=$_SESSION['tarr'];
	$varr=$_SESSION['varrtarr'];

	
	?>


	<tr>
		<td style="width: 150px !important;">
			<select class="form-control frminp" name="state_idla<?=$_REQUEST['lc']?>" id="state_idla<?=$_REQUEST['lc']?>" form="farmertable" >
				<option>Select</option>
				<?php
				foreach ($sarr as $key => $value) { ?>
				  
				<option value="<?=$key?>"  ><?=$value?></option>
				
				<?php
				}
				?>
			</select>
			<script type="text/javascript">
				$('#state_idla<?=$_REQUEST['lc']?>').on('change', function() {
					var sid=$('#state_idla<?=$_REQUEST['lc']?>').val();
				  	$.post("mastersAjax.php",{ act:'getdist',sid:sid },function(data) {
						$('#distric_idla<?=$_REQUEST['lc']?>').html(data);
			          }
			        );
				});
			</script>
		</td>
		<td style="width: 150px !important;">
			<select class="form-control frminp" name="distric_idla<?=$_REQUEST['lc']?>" id="distric_idla<?=$_REQUEST['lc']?>"  form="farmertable" >
			
			<option>Select</option>
				<?php
				foreach ($darr as $key => $value) { ?>
				  
				<option value="<?=$key?>"  ><?=$value?></option>
				
				<?php
				}
				?>
			
			</select>
			<script type="text/javascript">
				$('#distric_idla<?=$_REQUEST['lc']?>').on('change', function() {
					var did=$('#distric_idla<?=$_REQUEST['lc']?>').val();
				  	$.post("mastersAjax.php",{ act:'gettahsil',did:did },function(data) {
				  		// console.log(data);
						$('#tahsil_idla<?=$_REQUEST['lc']?>').html(data);
						
						FunNxtDis(did,<?=$_REQUEST['lc']?>);
			          }
			        );
				});
			</script>
		</td>
		<td style="width: 150px !important;">
			<select class="form-control frminp" name="tahsil_idla<?=$_REQUEST['lc']?>" id="tahsil_idla<?=$_REQUEST['lc']?>"  form="farmertable" >
			
			<option>Select</option>
				<?php foreach ($tarr as $key => $value) { ?>
				<option value="<?=$key?>"  ><?=$value?></option>
				<?php } ?>
			
			</select>
			<script type="text/javascript">
				$('#tahsil_idla<?=$_REQUEST['lc']?>').on('change', function() {
					var tid=$('#tahsil_idla<?=$_REQUEST['lc']?>').val();
				  	$.post("mastersAjax.php",{ act:'getvillage',tid:tid },function(data) {
				  		// console.log(data);
						$('#village_idla<?=$_REQUEST['lc']?>').html(data);
						
						FunNxtTh(tid,<?=$_REQUEST['lc']?>);
						
			          }
			        );
				});
				
				
				
				
			</script>
		</td>
		<td style="width: 150px !important;">
			<select class="form-control frminp" name="village_idla<?=$_REQUEST['lc']?>" id="village_idla<?=$_REQUEST['lc']?>" form="farmertable" >
			 <option>Select</option>
				<?php
				foreach ($varr as $key => $value) { ?>
				  
				<option value="<?=$key?>"  ><?=$value?></option>
				
				<?php
				}
				?>
			</select>
			
			<script type="text/javascript">
					$('#village_idla<?=$_REQUEST['lc']?>').on('change', function() {
						var vid=$('#village_idla<?=$_REQUEST['lc']?>').val();
					  	$.post("mastersAjaxx.php",{ act:'get_from_vv',vid:vid,lc:<?=$_REQUEST['lc']?> },function(data) {
					  		// console.log(data);
							$('#detailspan<?=$_REQUEST['lc']?>').html(data);
							$('#state_idla<?=$_REQUEST['lc']?>').val($('#sti<?=$_REQUEST['lc']?>').val());
							$('#distric_idla<?=$_REQUEST['lc']?>').val($('#dti<?=$_REQUEST['lc']?>').val());
							$('#tahsil_idla<?=$_REQUEST['lc']?>').val($('#tti<?=$_REQUEST['lc']?>').val());
				          }
				        );
					});
				</script>
			<span id="detailspan<?=$_REQUEST['lc']?>">
			
			</span>
		</td>
		<td>
			<input class="form-control frminp" name="landarea_idla<?=$_REQUEST['lc']?>" form="farmertable" required>
		</td>
		<td>
			<input class="form-control frminp" name="khasrano_idla<?=$_REQUEST['lc']?>" form="farmertable" >
		</td>
		
		<td>
			<button type="button" onclick="removethistr(this)" class="btn btn-sm btn-danger frmbtn"><i class="fa fa-times" aria-hidden="true"></i></button>
		</td>
	</tr>


	<?php
}elseif(isset($_POST['act']) && $_POST['act']=='getStateDistricts'){
	?><span class="stdiss<?=$_POST['sid']?>"><?php
	?>

	<!-- =======printing all checkbox of the district============================================== -->
	<div style="background-color: #d9d9d9;font-size:13px;font-weight: bold;width:100%;">
		<input id="alldis<?=$_POST['sid']?>" type="checkbox" name="" onclick="checkalldi('<?='state'.$_POST['sid']?>',this)"><?=$_POST['sname']?>
		<script type="text/javascript">
			function checkalldi(sid,th){
				if($(th).prop('checked') == true){
					$("."+sid).prop('checked', true);
					$("."+sid).trigger('change');
				}else if($(th).prop('checked') == false){
					$("."+sid).prop('checked', false);
					$("."+sid).trigger('change');
				}
				
			}
		</script>
	</div>
	<!-- =======printing all checkbox of the district============================================== -->

	<?php
	//=======printing all districts of the state=======================================================
	
	$alld=mysql_query('SELECT * FROM `distric` where `StateId`='.$_POST['sid'].' order by DictrictName asc');
	if(mysql_num_rows($alld)==0){
		?>
		<label style="width: 100%;color:#b5b5b5;">------No Districts------</label>
		<?php
	}
	while ($alldd=mysql_fetch_assoc($alld)) {
		?>
		<label style="width: 100%;">
			<input id="chkdi<?=$alldd['DictrictId']?>" type="checkbox" class="state<?=$_POST['sid']?> districts" value="<?=$alldd['DictrictId']?>" onchange="ldistrict(this.value,this,'<?=$alldd['DictrictName']?>','<?=$_REQUEST['uid']?>')" >
			<?=$alldd['DictrictName']?>
		</label><br>
		<?php
	}
	?></span><?php
	//=======printing all districts of the state=======================================================

	//=======chccking all districts of the state=======================================================
	$sel=mysql_query("SELECT ul.*,d.DictrictName FROM `user_location` ul, distric d where ul.sts='A' and ul.uid='".$_REQUEST['uid']."' and ul.district_id=d.DictrictId and d.`StateId`='".$_POST['sid']."'");
	$seludi=mysql_num_rows($sel);
	while ($seld=mysql_fetch_assoc($sel)) {
		?>
		<script type="text/javascript">
			$("<?='#chkdi'.$seld['district_id']?>").prop("checked",true);
			ldistrict('<?=$seld['district_id']?>','<?='#chkdi'.$seld['district_id']?>','<?=$seld['DictrictName']?>','<?=$_REQUEST['uid']?>');
		</script>
		<?php
	}
	//=======chccking all districts of the state=======================================================


	//=======checking all districts checkbox checked=========================================================
	$selda=mysql_query("SELECT d.DictrictName FROM distric d where d.`StateId`='".$_POST['sid']."'");
	$selalldi=mysql_num_rows($selda);
	if($seludi == $selalldi){
		?>
		<script type="text/javascript">
			$("<?='#alldis'.$_POST['sid']?>").prop("checked",true);
		</script>
		<?php
	}
	//=======checking all districts checkbox checked=========================================================



}elseif(isset($_POST['act']) && $_POST['act']=='getDistrictTahsils'){
	?><span class="ditahs<?=$_POST['did']?>"><?php

	?>
	<!-- =======printing all checkbox of the district============================================== -->
	<div style="background-color: #d9d9d9;font-size:13px;font-weight: bold;width:100%;">
		<input id="alltah<?=$_POST['did']?>"  type="checkbox"  onclick="checkalltah('<?='dist'.$_POST['did']?>',this)"><?=$_POST['dname']?>
		<script type="text/javascript">
			function checkalltah(did,th){
				if($(th).prop('checked') == true){
					$("."+did).prop('checked', true);
					$("."+did).trigger('change');
				}else if($(th).prop('checked') == false){
					$("."+did).prop('checked', false);
					$("."+did).trigger('change');
				}
			}
		</script>
	</div>
	<!-- =======printing all checkbox of the district============================================== -->


	<?php
	//=======printing all tahsils of the district=======================================================
	$allt=mysql_query('SELECT * FROM `tahsil` where `DistrictId`='.$_POST['did'].' order by TahsilName asc');
	if(mysql_num_rows($allt)==0){
		?>
		<label style="width: 100%;color:#b5b5b5;">------No Tahsil------</label>
		<?php
	}
	while ($alltd=mysql_fetch_assoc($allt)) {
		?>
		<label style="width: 100%;">
			<input id="chkta<?=$alltd['TahsilId']?>" type="checkbox" class="dist<?=$_POST['did']?> tahsils" name="state" value="<?=$alltd['TahsilId']?>" onchange="ltahsil(this.value,this,'<?=$alltd['TahsilName']?>','<?=$_REQUEST['uid']?>')">
			<?=$alltd['TahsilName']?>
		</label><br>
		<?php
	}
	?></span><?php
	//=======printing all tahsils of the district=======================================================


	//=======chccking all tahsils of the district=========================================================
	$sel=mysql_query("SELECT ul.*,t.TahsilName FROM `user_location` ul, tahsil t where ul.sts='A' and ul.uid='".$_REQUEST['uid']."' and ul.tahsil_id=t.TahsilId and t.`DistrictId`='".$_POST['did']."'");
	$seluta=mysql_num_rows($sel);
	while ($selt=mysql_fetch_assoc($sel)) {
		?>
		<script type="text/javascript">
			$("<?='#chkta'.$selt['tahsil_id']?>").prop("checked",true);
			ltahsil('<?=$selt['tahsil_id']?>','<?='#chkta'.$selt['tahsil_id']?>','<?=$selt['TahsilName']?>','<?=$_REQUEST['uid']?>');
		</script>
		<?php
	}
	//=======chccking all tahsils of the district=========================================================


	//=======checking all tahsil checkbox checked=========================================================
	$selta=mysql_query("SELECT TahsilName FROM tahsil where `DistrictId`='".$_POST['did']."'");
	$selallta=mysql_num_rows($selta);
	if($seluta == $selallta && $selallta!=0){
		?>
		<script type="text/javascript">
			$("<?='#alltah'.$_POST['did']?>").prop("checked",true);
		</script>
		<?php
	}
	//=======checking all tahsil checkbox checked=========================================================






}elseif(isset($_POST['act']) && $_POST['act']=='getTahsilVillages'){
	?><span class="ditahs<?=$_POST['tid']?>"><?php

	?>
	<!-- =======printing all checkbox of the tahsil============================================== -->
	<div style="background-color: #d9d9d9;font-size:13px;font-weight: bold;width:100%;">
		<input id="allvill<?=$_POST['tid']?>"  type="checkbox"  onclick="checkallvill('<?='tah'.$_POST['tid']?>',this)"><?=$_POST['tname']?>
		<script type="text/javascript">
			function checkallvill(tid,th){
				if($(th).prop('checked') == true){
					$("."+tid).prop('checked', true);
					$("."+tid).trigger('change');
				}else if($(th).prop('checked') == false){
					$("."+tid).prop('checked', false);
					$("."+tid).trigger('change');
				}
			}
		</script>
	</div>
	<!-- =======printing all checkbox of the tahsil============================================== -->


	<?php
	//=======printing all villages of the tahsil=======================================================
	$allt=mysql_query('SELECT * FROM `village` where `TahsilId`='.$_POST['tid'].' order by VillageName asc');
	if(mysql_num_rows($allt)==0){
		?>
		<label style="width: 100%;color:#b5b5b5;">------No Village------</label>
		<?php
	}
	while ($alltd=mysql_fetch_assoc($allt)) {
		?>
		<label style="width: 100%;">
			<input id="chkvill<?=$alltd['VillageId']?>" type="checkbox" class="tah<?=$_POST['tid']?> villages" name="state" value="<?=$alltd['VillageId']?>" onchange="lvillage(this.value,this,'<?=$alltd['VillageName']?>','<?=$_REQUEST['uid']?>')">
			<?=$alltd['VillageName']?>
		</label><br>
		<?php
	}
	?></span><?php
	//=======printing all villages of the tahsil=======================================================


	//=======chccking all villages of the tahsil=========================================================
	$sel=mysql_query("SELECT ul.*,v.VillageName FROM `user_location` ul, village v where ul.sts='A' and ul.uid='".$_REQUEST['uid']."' and ul.village_id=v.VillageId and v.`TahsilId`='".$_POST['tid']."'");
	$seluta=mysql_num_rows($sel);
	while ($selt=mysql_fetch_assoc($sel)) {
		?>
		<script type="text/javascript">
			$("<?='#chkvill'.$selt['village_id']?>").prop("checked",true);
			lvillage('<?=$selt['village_id']?>','<?='#chkvill'.$selt['village_id']?>','<?=$selt['VillageName']?>','<?=$_REQUEST['uid']?>');
		</script>
		<?php
	}
	//=======chccking all villages of the tahsil=========================================================


	//=======checking all villages checkbox checked=========================================================
	$selta=mysql_query("SELECT VillageName FROM village where `TahsilId`='".$_POST['tid']."'");
	$selallta=mysql_num_rows($selta);
	if($seluta == $selallta && $selallta!=0){
		?>
		<script type="text/javascript">
			$("<?='#allvill'.$_POST['tid']?>").prop("checked",true);
		</script>
		<?php
	}
	//=======checking all villages checkbox checked=========================================================






}elseif(isset($_POST['act']) && $_POST['act']=='addlocation'){

	$sid=(isset($_POST['sid']))?$_POST['sid']:0;
	$did=(isset($_POST['did']))?$_POST['did']:0;
	$tid=(isset($_POST['tid']))?$_POST['tid']:0;
	$vid=(isset($_POST['vid']))?$_POST['vid']:0;

	$sel=mysql_query("SELECT * FROM `user_location` where `state_id`='".$sid."' and `district_id`='".$did."' and `tahsil_id`='".$tid."' and `village_id`='".$vid."' and  uid='".$_REQUEST['uid']."'");

	if(mysql_num_rows($sel)==0){
		$add=mysql_query("INSERT INTO `user_location`(`uid`,`state_id`, `district_id`, `tahsil_id`, `village_id`, `sts`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['uid']."','".$sid."','".$did."','".$tid."','".$vid."','A','".$_SESSION['uId']."','".date('Y-m-d')."')");
		$action = "Given location permission of ";
		if($sid!=0){ $action .= "State(State ID:".$sid.")";}
		if($did!=0){ $action .= "District(District ID:".$did.")";}
		if($tid!=0){ $action .= "Tahsil(Tahsil ID:".$tid.")";}
		if($vid!=0){ $action .= "Village(Village ID:".$vid.")";}
		$action .= " to user:".getUName($_REQUEST['uid']);
		addlog($_SESSION['uId'],$action);
	}else{
		$updt=mysql_query("UPDATE `user_location` SET `sts`='A' where `state_id`='".$sid."' and  `district_id`='".$did."' and  `tahsil_id`='".$tid."' and  `village_id`='".$vid."' and uid='".$_REQUEST['uid']."'");
		$action = "Given location permission of ";
		if($sid!=0){ $action .= "State(State ID:".$sid.")";}
		if($did!=0){ $action .= "District(District ID:".$did.")";}
		if($tid!=0){ $action .= "Tahsil(Tahsil ID:".$tid.")";}
		if($vid!=0){ $action .= "Village(Village ID:".$vid.")";}
		$action .= " to user:".getUName($_REQUEST['uid']);
		addlog($_SESSION['uId'],$action);
	}
		

	

}elseif(isset($_POST['act']) && $_POST['act']=='removelocation'){
	

	if(isset($_POST['sid'])){
		$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `state_id`='".$_POST['sid']."' and uid='".$_REQUEST['uid']."'");

		$alld=mysql_query('SELECT * FROM `distric` where `StateId`='.$_POST['sid']);
		echo $alldd['DictrictName'];
		while ($alldd=mysql_fetch_assoc($alld)) {
			$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `district_id`='".$alldd['DictrictId']."' and uid='".$_REQUEST['uid']."'");
			?><script type="text/javascript">$('.ditahs<?=$alldd['DictrictId']?>').hide();</script><?php
			$allt=mysql_query('SELECT * FROM `tahsil` where `DistrictId`='.$alldd['DictrictId']);
			while ($alltd=mysql_fetch_assoc($allt)) {
				$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `tahsil_id`='".$alltd['TahsilId']."' and uid='".$_REQUEST['uid']."'");
			}
		}
	}
	if(isset($_POST['did'])){
		
		$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `district_id`='".$_POST['did']."' and uid='".$_REQUEST['uid']."'");
		$allt=mysql_query('SELECT * FROM `tahsil` where `DistrictId`='.$_POST['did']);
		while ($alltd=mysql_fetch_assoc($allt)) {
			$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `tahsil_id`='".$alltd['TahsilId']."' and uid='".$_REQUEST['uid']."'");
		}
		
	}

	if(isset($_POST['tid'])){
		$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `tahsil_id`='".$_POST['tid']."' and uid='".$_REQUEST['uid']."'");
	}


	if(isset($_POST['vid'])){
		$updt=mysql_query("UPDATE `user_location` SET `sts`='D' where `village_id`='".$_POST['vid']."' and uid='".$_REQUEST['uid']."'");
	}

	$action = "Removed location permission of ";
	if(isset($_POST['sid'])){ $action .= "State(State ID:".$_POST['sid'].")";}
	if(isset($_POST['did'])){ $action .= "District(District ID:".$_POST['did'].")";}
	if(isset($_POST['tid'])){ $action .= "Tahsil(Tahsil ID:".$_POST['tid'].")";}
	if(isset($_POST['vid'])){ $action .= "Village(Village ID:".$_POST['vid'].")";}
	$action .= " to user:".getUName($_REQUEST['uid']);
	addlog($_SESSION['uId'],$action);

}elseif(isset($_POST['act']) && $_POST['act']=='addpage'){

	$sel=mysql_query("SELECT * FROM `user_pages` where `pid`='".$_POST['pid']."' and `uId`='".$_POST['uid']."'");

	if(mysql_num_rows($sel)==0){
		$add=mysql_query("INSERT INTO `user_pages`(`pid`, `uId`, `sts`) VALUES ('".$_REQUEST['pid']."','".$_REQUEST['uid']."','A')");
	}else{
		$updt=mysql_query("UPDATE `user_pages` SET `sts`='A'  where `pid`='".$_POST['pid']."' and `uId`='".$_POST['uid']."'");
	}

	$action = "Given page permission of page(Page ID:".$_POST['pid'].")";
	$action .= " to user:".getUName($_POST['uid']);
	addlog($_SESSION['uId'],$action);

}elseif(isset($_POST['act']) && $_POST['act']=='removepage'){

	$updt=mysql_query("UPDATE `user_pages` SET `sts`='D' where `pid`='".$_POST['pid']."' and `uId`='".$_POST['uid']."'");
	$action = "Removed page permission of page(Page ID:".$_POST['pid'].")";
	$action .= " to user:".getUName($_POST['uid']);
	addlog($_SESSION['uId'],$action);

}elseif(isset($_POST['act']) && $_POST['act']=='addusercrop'){

	$sel=mysql_query("SELECT * FROM `user_crop` where `cropid`='".$_POST['cid']."' and `uid`='".$_POST['uid']."'");

	if(mysql_num_rows($sel)==0){
		$add=mysql_query("INSERT INTO `user_crop`(`cropid`, `uid`, `sts`, `cr_by`, `cr_date`) VALUES ('".$_REQUEST['cid']."','".$_REQUEST['uid']."','A','".$_SESSION['uId']."','".date('Y-m-d')."')");
	}else{
		$updt=mysql_query("UPDATE `user_crop` SET `sts`='A'  where `cropid`='".$_POST['cid']."' and `uid`='".$_POST['uid']."'");
	}
	$action = "Added crop permission (Crop ID:".$_REQUEST['cid'].")";
	$action .= " to user:".getUName($_POST['uid']);
	addlog($_SESSION['uId'],$action);

}elseif(isset($_POST['act']) && $_POST['act']=='removeusercrop'){

	$updt=mysql_query("UPDATE `user_crop` SET `sts`='D' where `cropid`='".$_POST['cid']."' and `uid`='".$_POST['uid']."'");
	$action = "Removed crop permission (Crop ID:".$_POST['cid'].")";
	$action .= " to user:".getUName($_POST['uid']);
	addlog($_SESSION['uId'],$action);

}elseif(isset($_POST['act']) && $_POST['act']=='getPageParent'){

	$sel=mysql_query("SELECT * FROM `master_pages` where `pid`='".$_POST['pid']."'");
	$seld=mysql_fetch_assoc($sel);
	echo $seld['pageParent'];

}elseif(isset($_POST['act']) && $_POST['act']=='getUserCropsCountCheckWithAll'){

	$selAllCrop=mysql_query("SELECT * FROM `crop` ");
	$selAllCropCount=mysql_num_rows($selAllCrop);

	$sel=mysql_query("SELECT * FROM `user_crop` where `uId`='".$_REQUEST['uid']."' and sts='A'");
	$userCrops=mysql_num_rows($sel);

	if($selAllCropCount == $userCrops){
		echo 'allselected';
	}

}elseif(isset($_POST['act']) && $_POST['act']=='addAadharPermission'){

	$updt=mysql_query("UPDATE `aadhar_permission` SET `permission`='A'  where `id`='".$_POST['sid']."'");

	if($updt){
		$action = "Added aadhar mandatory to state (State ID:".$_POST['sid'].")";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}

}elseif(isset($_POST['act']) && $_POST['act']=='removeAadharPermission'){

	$updt=mysql_query("UPDATE `aadhar_permission` SET `permission`='D'  where `id`='".$_POST['sid']."'");

	if($updt){
		$action = "Removed aadhar mandatory to state (State ID:".$_POST['sid'].")";
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}

}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='addPost'){

	$ins=mysql_query("INSERT INTO `user_posts`( `postName`, `postShortName`, `crdate`) VALUES ('".$_REQUEST['crn']."','".$_REQUEST['crc']."','".date('Y-m-d')."')");

	if($ins){
		$action = "Added User Post :".$_REQUEST['crn'];
		addlog($_SESSION['uId'],$action);
		echo 'added';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='savePostDetails'){

	$updt=mysql_query("UPDATE `user_posts` SET `postName`='".$_REQUEST['crn']."',`postShortName`='".$_REQUEST['crc']."' WHERE `upid`='".$_REQUEST['id']."'");

	if($updt){
		$action = "Updated Post Details :".$_REQUEST['crn'];
		addlog($_SESSION['uId'],$action);
		echo 'updated';
	}else{
		echo 'error';
	}
}elseif(isset($_REQUEST['act']) && $_REQUEST['act']=='removeFarmerLand'){

	$del=mysql_query("DELETE FROM `farmers_land` WHERE flandid='".$_POST['flid']."'");
	if($del){echo 'deleted';}
}





?>







