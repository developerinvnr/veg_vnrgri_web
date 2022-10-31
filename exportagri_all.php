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

echo "Sn\tAgreement-ID\tAgreement Date\tCrop\tFemale FSCode\tMale FSCode\tHybrid Code\tFarmer Name\tFarmer Id\tOrganiser Name\tFarmer Father Name\tFARMER Contact\tFARMER Email\tDOB\tAADHAR No\tPAN\tBank name\tAccount no\tBranch name\tIFSC code\tBank Address\tProduction Person\tProduction Executive\tFarmer Village\tFarmer Tahsil\tFarmer District\tFarmer State\tProduction Location Village\tProduction Location Tahsil\tProduction Location District\tProduction Location State";


echo "\tSowing method female\tFoundation female LOT\tNo. Of tray female\tNursery sowing date female\tFemale Seed Qty(Kg)\tNo Of cell female\tRemark";

echo "\tSowing method male\tFoundation male LOT\tNo. Of tray male\tNursery sowing date male\tMale Seed Qty(Kg)\tNo Of cell male\tRemark";

echo "\tObserv. date female\tGermination (%) female\tObserv. date male\tGermination (%) male";

echo "\tTranp. date female\tTranp. Acrage female\tSpacing R*R female(in fit)\tSpacing P*P female(in fit)\tPlant population female\tTranp. date male\tTranp. Acrage male\tSpacing R*R male(in fit)\tSpacing P*P male(in fit)\tPlant population male\tTotal Standing Acrage(female+male)\tCurrent Location\tRemark";

echo "\tV_Sown tranpl. Acrage\tV_GPS Acrage\tV_Diff Acarge\tV_PLD Acrage\tV_Diff Acarge\tV_Tot. off type female\tV_Tot. off type male\tV_Disease Obs. female\tV_Disease Obs. male\tV_Remark\tV_Excellent\tV_Good\tV_Average\tV_Poor\tV_UpdateOn";

echo "\tFlowering start date female\tFlowering start date male\tCrossing start date\tCrossing end date\tPlant population\tStanding Acrage\tPLD Acrage\tFinal standing (Gps Measure)\tOff type female\tOff type male\tDisease Obs. female\tDisease Obs. male\tMale removal date\tNo. of seed/Fruit\tNo. of fruit/plant\tTotal no. of plants\t100 seed weight/gm\tEstimated yield/Kg\tRemark\tExcellent\tGood\tAverage\tPoor\tUpdateOn";

echo "\tPlant population\tStanding Acrage\tPld Ac\tFinal Gps Measure\tOff type female\tOff type male\tDisease Obs. female\tDisease Obs. male\tNo. of seed/Fruit\tNo. of fruit/plant\tTotal no. of plants\t100 seed weight/gm\tEstimated yield/Kg\tTotal off type female\tTotal off type male\tRemark\tExcellent\tGood\tAverage\tPoor\tUpdateOn";

echo "\tPlant population female\tHarvesting start date\tHarvesting end date\tHarvesting acrage female\tFinal yield/kg\tRemark";

echo "\tDispatch Qty\tDispatch No of Bag";
echo "\tRemark";

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

//==== query condition for production code filter =======================================================
if(isset($_REQUEST['prodcode']) && $_REQUEST['prodcode']!=''){
	$prodcode="agr.ann_prodcode='".$_REQUEST['prodcode']."'";
}else{
	$prodcode='1=1';
}


//==== query condition for organiser filter ==================================================
if(isset($_REQUEST['orgr']) && $_REQUEST['orgr']!=''){
	$orgrCond="agr.org_id=".$_REQUEST['orgr'];
}else{
	$orgrCond='1=1';
}


//==== query condition for production person filter ==================================================
if(isset($_REQUEST['pperson']) && $_REQUEST['pperson']!=''){
	$pperson="agr.prod_person=".$_REQUEST['pperson'];
}else{
	$pperson='1=1';
}


//==== query condition for production executive filter ==================================================
if(isset($_REQUEST['pexe']) && $_REQUEST['pexe']!=''){
	$pexecutive="agr.prod_executive=".$_REQUEST['pexe'];
}else{
	$pexecutive='1=1';
}

//==== query condition for organiser filter ==================================================
if(isset($_REQUEST['secondparty']) && $_REQUEST['secondparty']!=''){
	$farmerCond="agr.second_party=".$_REQUEST['secondparty'];
}else{
	$farmerCond='1=1';
}


$userCond='1=1';


//==== query condition for keyword search START==================================================
    if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){ $keyArea="agr.vi like '%".$_REQUEST['vii']."%'";}
	elseif(isset($_REQUEST['tii']) && $_REQUEST['tii']!=''){ $keyArea="agr.ti like '%".$_REQUEST['tii']."%'";}
	elseif(isset($_REQUEST['dii']) && $_REQUEST['dii']!=''){ $keyArea="agr.di like '%".$_REQUEST['dii']."%'";}
	elseif(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){ $keyArea="agr.si like '%".$_REQUEST['sii']."%'";}
	else{$keyArea='1=1';}


if(isset($_REQUEST['keywordSearch']) && $_REQUEST['keywordSearch']!='')
{

  $keyCond="(f.fname like '%".$_REQUEST['keywordSearch']."%' or o.oname like '%".$_REQUEST['keywordSearch']."%' or agr.ann_prodcode like '%".$_REQUEST['keywordSearch']."%' or agr.agree_no like '%".$_REQUEST['keywordSearch']."%' or s.StateName like '%".$_REQUEST['keywordSearch']."%' or d.DictrictName like '%".$_REQUEST['keywordSearch']."%' or t.TahsilName like '%".$_REQUEST['keywordSearch']."%' or v.VillageName like '%".$_REQUEST['keywordSearch']."%')";
}
else
{
  $keyCond='1=1';
}


if(isset($_REQUEST['users']) && $_REQUEST['users']!='')
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

 $allids = array_unique(get2hierarchy($_REQUEST['users'])); //$_SESSION['uId']
 $hierarchyCond = "(agr.prod_person IN (".implode(', ', $allids).") or agr.prod_executive IN (".implode(', ', $allids)."))";	
}
else { $hierarchyCond='1=1'; }		


$arr_Ve=array(); $arr_Vg=array(); $arr_Va=array(); $arr_Vp=array(); $arr_Vu=array();	
$arr_Fe=array(); $arr_Fg=array(); $arr_Fa=array(); $arr_Fp=array(); $arr_Fu=array();	
$arr_pFe=array(); $arr_pFg=array(); $arr_pFa=array(); $arr_pFp=array(); $arr_pFu=array();
	
//==== query condition for getting results as per users hierarchy ================= end =======================
	$qry="";
	for ($i=$agyearf; $i <= $agyeart; $i++) 
	{

      $qry.=" SELECT agr.*, u.uName, f.tem_fid, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id, f.contact_1, f.email, f.dob, f.aadhar_no, f.pan_no, f.bank_name, f.account_no, f.branch_name, f.ifsc_code, f.bank_add, f.idproof_name, f.idproof_no FROM `agreement_".$i."` agr, users u, farmers f, organiser o, village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and agr.agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond." and ".$userCond." and ".$prodcode." and ".$pperson." and ".$keyArea." and ".$pexecutive." and ".$keyCond;

	  if($i!=$agyeart)
	  {
		$qry.=' UNION';
	  }

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
	 $staten=$sarr[$agrd['si']]; $distn=$darr[$agrd['di']]; 
	 $tahsiln=$tarr[$agrd['ti']]; $villagen=$varr[$agrd['vi']];
	}
	else
	{
	 $staten=$sarr[$agrd['state_id']]; $distn=$darr[$agrd['distric_id']]; 
	 $tahsiln=$tarr[$agrd['tahsil_id']]; $villagen=$varr[$agrd['village_id']];
	}


    echo $sn.$sep;
	echo $agrd['agree_no'].$sep;
	echo $agrd['agree_date'].$sep;
	echo $cropn.$sep;
	echo $agrd['ann_fscode_f'].$sep;
	echo $agrd['ann_fscode_m'].$sep;
	echo $agrd['ann_prodcode'].$sep;
	echo $agrd['fname'].$sep;
	$str = chunk_split($agrd['tem_fid'], 4, ' ');
	echo $str.$sep;  //second_party
	echo trim($agrd['oname']).$sep;
	echo trim($agrd['father_name']).$sep;
	echo '`'.$agrd['contact_1'].'`'.$sep;
	echo trim($agrd['email']).$sep;
	echo trim($agrd['dob']).$sep;
	if($agrd['aadhar_no']!=''){ $Aadhar=trim($agrd['aadhar_no']); }
	elseif($agrd['idproof_name']=='Aadhar'){ $Aadhar=trim($agrd['idproof_no']); }
	else{ $Aadhar=''; }
	echo '`'.$Aadhar.'`'.$sep;
	if($agrd['pan_no']!=''){ $Pan=trim($agrd['pan_no']); }
	elseif($agrd['idproof_name']=='Pan'){ $Pan=trim($agrd['idproof_no']); }
	else{ $Pan=''; }
	echo trim($Pan).$sep;
	echo trim($agrd['bank_name']).$sep;
	echo '`'.trim($agrd['account_no']).'`'.$sep;
	echo trim($agrd['branch_name']).$sep;
	echo trim($agrd['ifsc_code']).$sep;
	echo trim($agrd['bank_add']).$sep;
	echo trim($agrd['uName']).$sep;
	echo getUName(trim($agrd['prod_executive'])).$sep;
	echo $varr[trim($agrd['village_id'])].$sep;
	echo $tarr[trim($agrd['tahsil_id'])].$sep;
	echo $darr[trim($agrd['distric_id'])].$sep;
	echo $sarr[trim($agrd['state_id'])].$sep;
	echo trim($villagen).$sep;
	echo trim($tahsiln).$sep;
	echo trim($distn).$sep;
	echo trim($staten).$sep;
    
	//sowing female
	echo trim($agrd['S_sowing_method_female']).$sep;
	echo trim($agrd['S_foundation_female_lot']).$sep;
	echo trim($agrd['S_numberof_treys_female']).$sep;
	
	$NDm1='0000-00-00'; $NDm2='0000-00-00'; $NDm3='0000-00-00'; 
	$NDm4='0000-00-00'; $NDm5='0000-00-00'; $NDm6='0000-00-00'; 
	$NDm7='0000-00-00'; $NDm8='0000-00-00'; $NDm9='0000-00-00'; 
	$NDm10='0000-00-00'; $NDm11='0000-00-00'; $NDm12='0000-00-00'; 
	$NDm13='0000-00-00'; $NDm14='0000-00-00'; $NDm15='0000-00-00'; 
	
	if($agrd['S_nursery_sowingdate_female']>='2022-01-01')
	{ $NDm1=$agrd['S_nursery_sowingdate_female']; }
	echo $NDm1.$sep;
	//echo $agrd['S_nursery_sowingdate_female'].$sep;
	echo trim($agrd['S_seed_qty_female']).$sep;
	echo trim($agrd['S_numberof_cell_female']).$sep;
	echo trim($agrd['S_FRemark']).$sep;
		
	//sowing male
	echo trim($agrd['S_sowing_method_male']).$sep;
	echo trim($agrd['S_foundation_male_lot']).$sep;
	echo trim($agrd['S_numberof_treys_male']).$sep;
	
	if($agrd['S_nursery_sowingdate_male']>='2022-01-01')
	{ $NDm2=trim($agrd['S_nursery_sowingdate_male']); }
	echo $NDm2.$sep;
	//echo $agrd['S_nursery_sowingdate_male'].$sep;
	echo trim($agrd['S_seed_qty_male']).$sep;
	echo trim($agrd['S_numberof_cell_male']).$sep;
	echo trim($agrd['S_MRemark']).$sep;
	
	//Germination
	if($agrd['S_ObsvtionDate_female']>='2022-01-01')
	{ $NDm3=trim($agrd['S_ObsvtionDate_female']); }
	echo $NDm3.$sep;
	//echo $agrd['S_ObsvtionDate_female'].$sep;
	echo trim($agrd['S_germ_per_female']).$sep;
	
	if($agrd['S_ObsvtionDate_male']>='2022-01-01')
	{ $NDm4=trim($agrd['S_ObsvtionDate_male']); }
	echo $NDm4.$sep;
	//echo $agrd['S_ObsvtionDate_male'].$sep;
	echo trim($agrd['S_germ_per_male']).$sep;
	
	//transplanting
	if($agrd['T_date_female']>='2022-01-01')
	{ $NDm5=trim($agrd['T_date_female']); }
	echo $NDm5.$sep;
	//echo $agrd['T_date_female'].$sep;
	echo trim($agrd['T_acrage_female']).$sep;
	echo trim($agrd['T_spacing_rr_no_female']).$sep;
	echo trim($agrd['T_spacing_pp_no_female']).$sep;
	echo trim($agrd['T_plant_population_female']).$sep;
	
	if($agrd['T_date_male']>='2022-01-01')
	{ $NDm6=trim($agrd['T_date_male']); }
	echo $NDm6.$sep;
	//echo $agrd['T_date_male'].$sep;
	echo trim($agrd['T_acrage_male']).$sep;
	echo trim($agrd['T_spacing_rr_no_male']).$sep;
	echo trim($agrd['T_spacing_pp_no_male']).$sep;
	echo trim($agrd['T_plant_population_male']).$sep;
	echo trim($agrd['T_total_standing_ac']).$sep;
	echo trim($agrd['L_location_add']).$sep;
	echo trim($agrd['T_Remark']).$sep;	
	
	//vegitative
	echo trim($agrd['V_sown_transp_ac']).$sep;
	echo trim($agrd['V_gps_ac']).$sep;
	echo trim($agrd['V_giff_ac']).$sep;
	echo trim($agrd['V_pld_ac']).$sep;
	echo trim($agrd['V_Diff_ac']).$sep;
	echo trim($agrd['V_off_type_female']).$sep;
	echo trim($agrd['V_off_type_male']).$sep;
	echo trim($agrd['V_disease_observed_female']).$sep;
	echo trim($agrd['V_disease_observed_male']).$sep;
	
	if($agrd['V_Remark']!=''){ echo trim($agrd['V_Remark']).$sep; }
	else{ echo ''.$sep; }
	
	$agr_y = substr($agrd['agree_no'], 0, 4);
	 
	$sV=mysql_query("SELECT * FROM agreement_vegetative_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rV=mysql_fetch_assoc($sV))
	{ 
	  $arr_Ve[]=$rV['V_excellent_cond_ac']; $arr_Vg[]=$rV['V_good_cond_ac'];
	  $arr_Va[]=$rV['V_average_cond_ac']; $arr_Vp[]=$rV['V_poor_cond_ac']; $arr_Vu[]=$rV['V_update']; 
	}  
	echo implode(',', $arr_Ve).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Vg).$sep;
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Va).$sep;
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Vp).$sep;
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Vu).$sep;
	//else{ echo ''.$sep; }
	
	
	//flowering & pollination
	if($agrd['F_flowering_start_date_female']>='2022-01-01')
	{ $NDm7=$agrd['F_flowering_start_date_female']; }
	echo $NDm7.$sep;
	//echo $agrd['F_flowering_start_date_female'].$sep;
	
	if($agrd['F_flowering_start_date_male']>='2022-01-01')
	{ $NDm8=$agrd['F_flowering_start_date_male']; }
	echo $NDm8.$sep;
	//echo $agrd['F_flowering_start_date_male'].$sep;
	
	if($agrd['F_crossing_start_date']>='2022-01-01')
	{ $NDm9=$agrd['F_crossing_start_date']; }
	echo $NDm9.$sep;
	//echo $agrd['F_crossing_start_date'].$sep;
	
	if($agrd['F_crossing_end_date']>='2022-01-01')
	{ $NDm10=$agrd['F_crossing_end_date']; }
	echo $NDm10.$sep;
	//echo $agrd['F_crossing_end_date'].$sep;
	echo trim($agrd['F_plant_population']).$sep;
	echo trim($agrd['F_standing_ac']).$sep;
	echo trim($agrd['F_pld_ac']).$sep;
	echo trim($agrd['GPS_Measure']).$sep;
	echo trim($agrd['F_off_type_female']).$sep;
	echo trim($agrd['F_off_type_male']).$sep;
	echo trim($agrd['F_disease_observed_female']).$sep;
	echo trim($agrd['F_disease_observed_male']).$sep;
	
	if($agrd['F_male_removal_date']>='2022-01-01')
	{ $NDm11=$agrd['F_male_removal_date']; }
	echo $NDm11.$sep;
	//echo $agrd['F_male_removal_date'].$sep;
	echo trim($agrd['F_number_of_seed_fruit']).$sep;
	echo trim($agrd['F_number_of_fruits_plant']).$sep;
	echo trim($agrd['F_total_number_of_plants']).$sep;
	echo trim($agrd['F_100seed_weight']).$sep;
	echo trim($agrd['F_estimated_yield']).$sep;
	echo trim($agrd['F_Remark']).$sep;
	
	$sF=mysql_query("SELECT * FROM agreement_flowering_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rF=mysql_fetch_assoc($sF))
	{ 
	  $arr_Fe[]=$rF['F_excellent_cond_ac']; $arr_Fg[]=$rF['F_good_cond_ac'];
	  $arr_Fa[]=$rF['F_average_cond_ac']; $arr_Fp[]=$rF['F_poor_cond_ac']; $arr_Fu[]=$rF['F_update']; 
	}  
	echo implode(',', $arr_Fe).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Fg).$sep;
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Fa).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Fp).$sep;
	//else{ echo ''.$sep; }
	echo implode(',', $arr_Fu).$sep;
	//else{ echo ''.$sep; }
	
	//Post Flowering
	echo trim($agrd['Pf_plant_population']).$sep;
	echo trim($agrd['Pf_standing_ac']).$sep;
	echo trim($agrd['Pf_pld_ac']).$sep;
	echo trim($agrd['Final_GPS_Measure']).$sep;
	echo trim($agrd['Pf_off_type_female']).$sep;
	echo trim($agrd['Pf_off_type_male']).$sep;
	echo trim($agrd['Pf_disease_observed_female']).$sep;
	echo trim($agrd['Pf_disease_observed_male']).$sep;
	echo trim($agrd['Pf_number_of_seed_fruit']).$sep;
	echo trim($agrd['Pf_number_of_fruits_plant']).$sep;
	echo trim($agrd['Pf_total_number_of_plant']).$sep;
	echo trim($agrd['Pf_100seed_weight']).$sep;
	echo trim($agrd['Pf_estimated_yield']).$sep;
	echo trim($agrd['Pf_total_off_type_female']).$sep;
	echo trim($agrd['Pf_total_off_type_male']).$sep;
	echo trim($agrd['Pf_Remark']).$sep;
	
	
	$spF=mysql_query("SELECT * FROM agreement_postflowering_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rpF=mysql_fetch_assoc($spF))
	{ 
	  $arr_pFe[]=$rpF['Pf_excellent_cond_ac']; $arr_pFg[]=$rpF['Pf_good_cond_ac'];
	  $arr_pFa[]=$rpF['Pf_average_cond_ac']; $arr_pFp[]=$rpF['Pf_poor_cond_ac']; $arr_pFu[]=$rpF['Pf_update']; 
	}
	  
	echo implode(',', $arr_pFe).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_pFg).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_pFa).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_pFp).$sep; 
	//else{ echo ''.$sep; }
	echo implode(',', $arr_pFu).$sep; 
	//else{ echo ''.$sep; }
	
	//Harvesting
	echo $agrd['H_plant_population_female'].$sep;
	
	if($agrd['H_harvesting_start_date']>='2022-01-01')
	{ $NDm12=$agrd['H_harvesting_start_date']; }
	echo $NDm12.$sep;
	//echo $agrd['H_harvesting_start_date'].$sep;
	
	if($agrd['H_harvesting_end_date']>='2022-01-01')
	{ $NDm13=$agrd['H_harvesting_end_date']; }
	echo $NDm13.$sep;
	//echo $agrd['H_harvesting_end_date'].$sep;
	echo $agrd['H_harvesting_acrage_female'].$sep;
	echo $agrd['H_final_yield'].$sep;
	echo $agrd['H_Remark'].$sep;
	
	$slot=mysql_query("SELECT SUM(noofbag) as tbag, SUM(qty) as tqty FROM agreementlot_".$agr_y." where agree_no='".$agrd['agree_no']."'"); $rowlot=mysql_num_rows($slot); 
	if($rowlot>0){ $rlot=mysql_fetch_assoc($slot); $bbag=$rlot['tbag']; $bqty=$rlot['tqty']; }
	else{ $bbag=0; $bqty=0; }
	
	//Dispatch
	echo $bqty.$sep;
	echo $bbag.$sep;
	
	//Incidence
	$spR=mysql_query("SELECT * FROM agreement_remark where agree_no='".$agrd['agree_no']."'"); 
	$arr_pR=array();
	while($rpR=mysql_fetch_assoc($spR))
	{ 
	  $arr_pR[]=$rpR['Remark'];  
	}
	echo implode(',', $arr_pR).$sep;

	print("\n");
	$sn++;
}







?>





