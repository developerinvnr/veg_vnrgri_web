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

if(isset($_POST['saveagreement'])){

$reason='';

$agreedate = date('Y-m-d',strtotime($_POST['agreedate']));
$agreeyear = date('Y',strtotime($_POST['agreedate']));
$agreefrom = date('Y-m-d',strtotime($_POST['agreefrom']));
$agreeto = date('Y-m-d',strtotime($_POST['agreeto']));

$landArea='';
if($_POST['ann7_areain_acre']>0)
{
 $f=mysql_query('SELECT * FROM farmers_land where flandid='.$_POST['ann7_areain_acre']);
 $fd=mysql_fetch_assoc($f); $landArea=$fd['land_area']; 
 $si=$fd['StateId']; $di=$fd['DictrictId']; $ti=$fd['TahsilId']; $vi=$fd['VillageId']; 
}
else
{
 $f=mysql_query("select * from state_id,distric_id,tahsil_id,village_id farmers where fid=".$_POST['secondparty']);
 $fd=mysql_fetch_assoc($f); 
 $si=$fd['state_id']; $di=$fd['distric_id']; $ti=$fd['tahsil_id']; $vi=$fd['village_id']; 
}
	//====== in below query, checking the repeatation of agreement entry ===============================
	
	
	$repsel=mysql_query("select * from `agreement_".$agreeyear."` where `first_party`='".$_POST['firstparty']."' and `second_party`='".$_POST['secondparty']."' and `ann_crop`='".$_POST['ann_crop']."' and `cr_by`='".$_SESSION['uId']."' and `cr_date`='".date('Y-m-d')."'");
	

	if(mysql_num_rows($repsel) >= 0){


        if($_POST['ann5_rate']==''){
            $_POST['ann5_rate']=0;
        }


		$ins=mysql_query("INSERT INTO `agreement_".$agreeyear."`( `first_party`, `second_party`, `prod_person`, `prod_executive`, `org_id`, `agree_date`, `start_date`, `end_date`,`water_availability`, `topography_land`, `typeof_land`, `soil_type`, `extent_cultivability`,`ann_crop`, `ann_prodcode`, `ann_fscode_f`, `ann_fscode_m`, `ann_ophyb`, `ann1_germination_per`, `ann1_genetic_purity`, `ann1_physical_purity`, `ann1_moisure`, `ann2_procmnt_price`, `ann2_qualbased_inc_price`, `ann2_payment_within_day`, `ann3_additional_fee`,`ann4_cult_area`,`ann4_cult_cost`, `ann4_estiyield_rawqty`, `ann4a_loss_ofyield`, `ann5_rate`, `ann5_parental_seed`, `ann5_noofacr_plant`, `ann5_plant_matsupply`, `ann5_total_amount`, `ann7_areain_acre`, `ann7_surveyno`, `ann7_flandid`, si, di, ti, vi, `cr_by`, `cr_date`,`sowing_acres`) VALUES ('".$_POST['firstparty']."','".$_POST['secondparty']."','".$_POST['pperson']."','".$_POST['pexecutive']."','".$_POST['organiser']."','".$agreedate."','".$agreefrom."','".$agreeto."','".$_POST['water_availability']."','".$_POST['topography_land']."','".$_POST['typeof_land']."','".$_POST['soil_type']."','".$_POST['extent_cultivability']."','".$_POST['ann_crop']."','".$_POST['ann_prodcode']."','".$_POST['fsfemale1'].$_POST['fsfemale2']."','".$_POST['fsmale1'].$_POST['fsmale2']."','".$_POST['ann_ophyb']."','".$_POST['ann1_germination_per']."','".$_POST['ann1_genetic_purity']."','".$_POST['ann1_physical_purity']."','".$_POST['ann1_moisure']."','".$_POST['ann2_procmnt_price']."','".$_POST['ann2_qualbased_inc_price']."','".$_POST['ann2_payment_within_day']."','".$_POST['ann3_additional_fee']."','".$_POST['ann4_cult_area']."','".$_POST['ann4_cult_cost']."','".$_POST['ann4_estiyield_rawqty']."','".$_POST['ann4a_loss_ofyield']."','".$_POST['ann5_rate']."','".$_POST['ann5_parental_seed']."','".$_POST['ann5_noofacr_plant']."','".$_POST['ann5_plant_matsupply']."','".$_POST['totAmtOfFSSeed']."','".$landArea."','".$_POST['ann7_surveyno']."', '".$_POST['ann7_areain_acre']."', '".$si."', '".$di."', '".$ti."', '".$vi."', '".$_SESSION['uId']."','".date('Y-m-d')."','".$landArea."')");
		
		//echo "INSERT INTO `agreement_".$agreeyear."`( `first_party`, `second_party`, `prod_person`, `prod_executive`, `org_id`, `agree_date`, `start_date`, `end_date`,`water_availability`, `topography_land`, `typeof_land`, `soil_type`, `extent_cultivability`,`ann_crop`, `ann_prodcode`, `ann_fscode_f`, `ann_fscode_m`, `ann_ophyb`, `ann1_germination_per`, `ann1_genetic_purity`, `ann1_physical_purity`, `ann1_moisure`, `ann2_procmnt_price`, `ann2_qualbased_inc_price`, `ann2_payment_within_day`, `ann3_additional_fee`,`ann4_cult_area`,`ann4_cult_cost`, `ann4_estiyield_rawqty`, `ann4a_loss_ofyield`, `ann5_rate`, `ann5_parental_seed`, `ann5_noofacr_plant`, `ann5_plant_matsupply`, `ann5_total_amount`, `ann7_areain_acre`, `ann7_surveyno`, `ann7_flandid`, si, di, ti, vi, `cr_by`, `cr_date`,`sowing_acres`) VALUES ('".$_POST['firstparty']."','".$_POST['secondparty']."','".$_POST['pperson']."','".$_POST['pexecutive']."','".$_POST['organiser']."','".$agreedate."','".$agreefrom."','".$agreeto."','".$_POST['water_availability']."','".$_POST['topography_land']."','".$_POST['typeof_land']."','".$_POST['soil_type']."','".$_POST['extent_cultivability']."','".$_POST['ann_crop']."','".$_POST['ann_prodcode']."','".$_POST['fsfemale1'].$_POST['fsfemale2']."','".$_POST['fsmale1'].$_POST['fsmale2']."','".$_POST['ann_ophyb']."','".$_POST['ann1_germination_per']."','".$_POST['ann1_genetic_purity']."','".$_POST['ann1_physical_purity']."','".$_POST['ann1_moisure']."','".$_POST['ann2_procmnt_price']."','".$_POST['ann2_qualbased_inc_price']."','".$_POST['ann2_payment_within_day']."','".$_POST['ann3_additional_fee']."','".$_POST['ann4_cult_area']."','".$_POST['ann4_cult_cost']."','".$_POST['ann4_estiyield_rawqty']."','".$_POST['ann4a_loss_ofyield']."','".$_POST['ann5_rate']."','".$_POST['ann5_parental_seed']."','".$_POST['ann5_noofacr_plant']."','".$_POST['ann5_plant_matsupply']."','".$_POST['totAmtOfFSSeed']."','".$landArea."','".$_POST['ann7_surveyno']."', '".$_POST['ann7_areain_acre']."', '".$si."', '".$di."', '".$ti."', '".$vi."', '".$_SESSION['uId']."','".date('Y-m-d')."','".$landArea."')"; die();

		
		
		$id = mysql_insert_id();
		$len=strlen($id);
		if($len==1){ $id='0000'.$id; }
		elseif($len==2){ $id='000'.$id; }
        elseif($len==3){ $id='00'.$id; }
        elseif($len==4){ $id='0'.$id; }
        elseif($len==5){ $id=$id; }
        
        
		$updt=mysql_query("update `agreement_".$agreeyear."` set agree_no='".$agreeyear.'V'.$id."' where agree_id='".$id."'");
	}else{
		$reason="alreadyexists";
	}


	if($ins){
		$action = "Created Agreement(Agreement ID:".$id.") of farmer(Farmer ID:".$_POST['secondparty'].")";
		addlog($_SESSION['uId'],$action);
		?><script>window.location.href = "addNewAgreement.php?added=yes";</script><?php
	}else{
		?><script>window.location.href = "addNewAgreement.php?added=no&reason=<?=$reason?>";</script><?php
	}

	

}elseif(isset($_POST['editagreement'])){


	$agreedate = date('Y-m-d',strtotime($_POST['agreedate']));
	$agreeyear = date('Y',strtotime($_POST['agreedate']));
	$agreefrom = date('Y-m-d',strtotime($_POST['agreefrom']));
	$agreeto = date('Y-m-d',strtotime($_POST['agreeto']));

$landArea='';	
if($_POST['ann7_areain_acre']>0)
{
 $f=mysql_query('SELECT * FROM farmers_land where flandid='.$_POST['ann7_areain_acre']);
 $fd=mysql_fetch_assoc($f); $landArea=$fd['land_area']; 
 $si=$fd['StateId']; $di=$fd['DictrictId']; $ti=$fd['TahsilId']; $vi=$fd['VillageId']; 
}
else
{
 $f=mysql_query("select * from state_id,distric_id,tahsil_id,village_id farmers where fid=".$_POST['secondparty']);
 $fd=mysql_fetch_assoc($f); 
 $si=$fd['state_id']; $di=$fd['distric_id']; $ti=$fd['tahsil_id']; $vi=$fd['village_id']; 
}
	if($_POST['ann5_rate']==''){
            $_POST['ann5_rate']=0;
        }

	$ins=mysql_query("UPDATE `agreement_".$agreeyear."` set `first_party`='".$_POST['firstparty']."',`second_party`='".$_POST['secondparty']."',`prod_person`='".$_POST['pperson']."',`prod_executive`='".$_POST['pexecutive']."',`org_id`='".$_POST['organiser']."',`agree_date`='".$agreedate."',`start_date`='".$agreefrom."',`end_date`='".$agreeto."',`water_availability`='".$_POST['water_availability']."',`topography_land`='".$_POST['topography_land']."',`typeof_land`='".$_POST['typeof_land']."',`soil_type`='".$_POST['soil_type']."',`extent_cultivability`='".$_POST['extent_cultivability']."',`ann_crop`='".$_POST['ann_crop']."',`ann_prodcode`='".$_POST['ann_prodcode']."',`ann_fscode_f`='".$_POST['fsfemale1'].$_POST['fsfemale2']."',`ann_fscode_m`='".$_POST['fsmale1'].$_POST['fsmale2']."',`ann_ophyb`='".$_POST['ann_ophyb']."',`ann1_germination_per`='".$_POST['ann1_germination_per']."',`ann1_genetic_purity`='".$_POST['ann1_genetic_purity']."',`ann1_physical_purity`='".$_POST['ann1_physical_purity']."',`ann1_moisure`='".$_POST['ann1_moisure']."',`ann2_procmnt_price`='".$_POST['ann2_procmnt_price']."',`ann2_qualbased_inc_price`='".$_POST['ann2_qualbased_inc_price']."',`ann2_payment_within_day`='".$_POST['ann2_payment_within_day']."',`ann3_additional_fee`='".$_POST['ann3_additional_fee']."',`ann4_cult_area`='".$_POST['ann4_cult_area']."',`ann4_cult_cost`='".$_POST['ann4_cult_cost']."',`ann4_estiyield_rawqty`='".$_POST['ann4_estiyield_rawqty']."',`ann4a_loss_ofyield`='".$_POST['ann4a_loss_ofyield']."',`ann5_rate`='".$_POST['ann5_rate']."',`ann5_parental_seed`='".$_POST['ann5_parental_seed']."',`ann5_noofacr_plant`='".$_POST['ann5_noofacr_plant']."',`ann5_plant_matsupply`='".$_POST['ann5_plant_matsupply']."',`ann5_total_amount`='".$_POST['totAmtOfFSSeed']."',`ann7_areain_acre`='".$landArea."',`ann7_surveyno`='".$_POST['ann7_surveyno']."', `ann7_flandid`='".$_POST['ann7_areain_acre']."',si='".$si."', di='".$di."', ti='".$ti."', vi='".$vi."',`sowing_acres`='".$landArea."' where `agree_id`='".$_POST['agree_id']."'");

	


	if($ins){
		$action = "Updated Agreement(Agreement ID:".$_POST['agree_id'].") of farmer(Farmer ID:".$_POST['secondparty'].")";
		addlog($_SESSION['uId'],$action);
		?><script>window.location.href = "editAgreement.php?agid=<?=$_POST['agree_id']?>&agyear=<?=$agreeyear?>&added=yes";</script><?php
	}else{
		?><script>window.location.href = "editAgreement.php?agid=<?=$_POST['agree_id']?>&agyear=<?=$agreeyear?>&added=no";</script><?php
	}
}

?>