<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');

function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];
}


function gethierarchy($uid)
{
	$id=array($uid);
	if($_SESSION['uType']=='S')
	{
		$sel=mysql_query("select uId from users");
		while($seld = mysql_fetch_assoc($sel))
		{
			$idc = array($seld['uId']);
			$id = array_merge($id,$idc);
		}
	}else{
		$sel=mysql_query("select uId from users where uReporting='".$uid."'");
		if(mysql_num_rows($sel) > 0)
		{
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

$csv_output .= '"fscode_female",';
$csv_output .= '"fscode_male",'; 

$csv_output .= '"Hybrid Code",';
$csv_output .= '"Farmer Name",';
$csv_output .= '"Farmer Id",';
$csv_output .= '"Organiser Name",';
$csv_output .= '"Farmer Father Name",';
$csv_output .= '"Production Person",';
$csv_output .= '"Production Executive",';
$csv_output .= '"Farmer Village",';
$csv_output .= '"Farmer Tahsil",';
$csv_output .= '"Farmer District",';
$csv_output .= '"Farmer State",';
$csv_output .= '"Production Location Village",';
$csv_output .= '"Production Location Tahsil",';
$csv_output .= '"Production Location District",';
$csv_output .= '"Production Location State",';


//sowing Female
$csv_output .= '"Sowing method female",';
$csv_output .= '"Foundation female LOT",';
$csv_output .= '"No. Of tray female",';
$csv_output .= '"Nursery sowing date female",';
$csv_output .= '"Female Seed Qty(Kg)",';
$csv_output .= '"No Of cell female",';
$csv_output .= '"Remark",';

//sowing male
$csv_output .= '"Sowing method male",';
$csv_output .= '"Foundation male LOT",';
$csv_output .= '"No. Of tray male",';
$csv_output .= '"Nursery sowing date male",';
$csv_output .= '"Male Seed Qty(Kg)",';
$csv_output .= '"No Of cell male",';
$csv_output .= '"Remark",';

//Germination
$csv_output .= '"Observ. date female",';
$csv_output .= '"Germination (%) female",';
$csv_output .= '"Observ. date male",';
$csv_output .= '"Germination (%) male",';

//Transplanting
$csv_output .= '"Tranp. date female",';
$csv_output .= '"Tranp. Acrage female",';
$csv_output .= '"Spacing R*R female(in fit)",';
$csv_output .= '"Spacing P*P female(in fit)",';
$csv_output .= '"Plant population female",';
$csv_output .= '"Tranp. date male",';
$csv_output .= '"Tranp. Acrage male",';
$csv_output .= '"Spacing R*R male(in fit)",';
$csv_output .= '"Spacing P*P male(in fit)",';
$csv_output .= '"Plant population male",';
$csv_output .= '"Total Standing Acrage(female+male)",';
$csv_output .= '"Current Location",';
$csv_output .= '"Remark",';

//Vegitative
$csv_output .= '"V_Sown tranpl. Acrage",';
$csv_output .= '"V_GPS Acrage",';
$csv_output .= '"V_Diff Acarge",';
$csv_output .= '"V_PLD Acrage",';
$csv_output .= '"V_Diff Acarge",';
$csv_output .= '"V_Tot. off type female",';
$csv_output .= '"V_Tot. off type male",';
$csv_output .= '"V_Disease Obs. female",';
$csv_output .= '"V_Disease Obs. male",';
$csv_output .= '"V_Remark",';
$csv_output .= '"V_Excellent",';
$csv_output .= '"V_Good",';
$csv_output .= '"V_Average",';
$csv_output .= '"V_Poor",';
$csv_output .= '"V_UpdateOn",';


//Flowering & Pollination
$csv_output .= '"Flowering start date female",';
$csv_output .= '"Flowering start date male",';
$csv_output .= '"Crossing start date",';
$csv_output .= '"Crossing end date",';
$csv_output .= '"Plant population",';
$csv_output .= '"Standing Acrage",';
$csv_output .= '"PLD Acrage",';
$csv_output .= '"Final standing (Gps Measure)",';
$csv_output .= '"Off type female",';
$csv_output .= '"Off type male",';
$csv_output .= '"Disease Obs. female",';
$csv_output .= '"Disease Obs. male",';
$csv_output .= '"Male removal date",';
$csv_output .= '"No. of seed/Fruit",';
$csv_output .= '"No. of fruit/plant",';
$csv_output .= '"Total no. of plants",';
$csv_output .= '"100 seed weight/gm",';
$csv_output .= '"Estimated yield/Kg",';
$csv_output .= '"Remark",';
$csv_output .= '"Excellent",';
$csv_output .= '"Good",';
$csv_output .= '"Average",';
$csv_output .= '"Poor",';
$csv_output .= '"UpdateOn",';

//Post Flowering
$csv_output .= '"Plant population",';
$csv_output .= '"Standing Acrage",';
$csv_output .= '"Pld Ac",';
$csv_output .= '"Final Gps Measure",';
$csv_output .= '"Off type female",';
$csv_output .= '"Off type male",';
$csv_output .= '"Disease Obs. female",';
$csv_output .= '"Disease Obs. male",';
$csv_output .= '"No. of seed/Fruit",';
$csv_output .= '"No. of fruit/plant",';
$csv_output .= '"Total no. of plants",';
$csv_output .= '"100 seed weight/gm",';
$csv_output .= '"Estimated yield/Kg",';
$csv_output .= '"Total off type female",';
$csv_output .= '"Total off type male",';
$csv_output .= '"Remark",';
$csv_output .= '"Excellent",';
$csv_output .= '"Good",';
$csv_output .= '"Average",';
$csv_output .= '"Poor",';
$csv_output .= '"UpdateOn",';


//Harvesting
$csv_output .= '"Plant population female",';
$csv_output .= '"Harvesting start date",';
$csv_output .= '"Harvesting end date",';
$csv_output .= '"Harvesting acrage female",';
$csv_output .= '"Final yield/kg",';
$csv_output .= '"Remark",';


//Dispatch
$csv_output .= '"Dispatch Qty",';
$csv_output .= '"Dispatch No of Bag",';

//Add Incidense
$csv_output .= '"Remark",';


$csv_output .= "\n";	


$from = date('Y-m-d',strtotime($_REQUEST['from']));
$agyearf = (int)date('Y',strtotime($_REQUEST['from']));

$to = date('Y-m-d',strtotime($_REQUEST['to']));
$agyeart = (int)date('Y',strtotime($_REQUEST['to']));


$from11 = date('d-m-Y',strtotime($_REQUEST['from']));
$to11 = date('d-m-Y',strtotime($_REQUEST['to']));

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
}else{ $pexecutive='1=1'; }


//==== query condition for organiser filter ==================================================
if(isset($_REQUEST['secondparty']) && $_REQUEST['secondparty']!=''){
	$farmerCond="agr.second_party=".$_REQUEST['secondparty'];
}else{ $farmerCond='1=1'; }

$userCond='1=1';
$a='';

//==== query condition for keyword search START==================================================
    if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){ $keyArea="agr.vi like '%".$_REQUEST['vii']."%'";}
	elseif(isset($_REQUEST['tii']) && $_REQUEST['tii']!=''){ $keyArea="agr.ti like '%".$_REQUEST['tii']."%'";}
	elseif(isset($_REQUEST['dii']) && $_REQUEST['dii']!=''){ $keyArea="agr.di like '%".$_REQUEST['dii']."%'";}
	elseif(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){ $keyArea="agr.si like '%".$_REQUEST['sii']."%'";}
	else{$keyArea='1=1';}

if(isset($_REQUEST['keywordSearch']) && $_REQUEST['keywordSearch']!='')
{
  $keyCond="(f.fname like '%".$_REQUEST['keywordSearch']."%' or f.father_name like '%".$_REQUEST['keywordSearch']."%' or o.oname like '%".$_REQUEST['keywordSearch']."%' or s.StateName like '%".$_REQUEST['keywordSearch']."%' or d.DictrictName like '%".$_REQUEST['keywordSearch']."%' or t.TahsilName like '%".$_REQUEST['keywordSearch']."%' or v.VillageName like '%".$_REQUEST['keywordSearch']."%')";
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
	for($i=$agyearf; $i <= $agyeart; $i++)
	{ 
		
	  $qry.=" SELECT agr.*, u.uName, f.tem_fid, f.fname, f.father_name, o.oname, f.village_id, f.tahsil_id, f.distric_id, f.state_id FROM `agreement_".$i."` agr, users u, farmers f, organiser o, village v, tahsil t, distric d, state s where f.village_id=v.VillageId and f.tahsil_id=t.TahsilId and f.distric_id=d.DictrictId and f.state_id=s.StateId and agr.agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid and ".$cropCond." and ".$orgrCond." and ".$farmerCond." and ".$hierarchyCond." and ".$userCond." and ".$prodcode." and ".$pperson." and ".$keyArea." and ".$pexecutive." and ".$keyCond;
	  
	  //if($i!=$agyeart){ $qry.=' UNION'; }
	} //for
    
	
	$agr=mysql_query($qry); 
    $sn=1;
	while($agrd=mysql_fetch_assoc($agr)) 
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


    $csv_output .= '"'.str_replace('"', '""', $sn).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['agree_no']).'",'; 
	$csv_output .= '"'.str_replace('"', '""', $agrd['agree_date']).'",';
	$csv_output .= '"'.str_replace('"', '""', $cropn).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_fscode_f']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_fscode_m']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['ann_prodcode']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['fname']).'",';
	$str = chunk_split($agrd['tem_fid'], 4, ' ');
	$csv_output .= '"'.str_replace('"', '""', $str).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['oname']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['father_name']).'",';
	$csv_output .= '"'.str_replace('"', '""', getUName($agrd['prod_person'])).'",';
	$csv_output .= '"'.str_replace('"', '""', getUName($agrd['prod_executive'])).'",';

	$csv_output .= '"'.str_replace('"', '""', $varr[$agrd['village_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $tarr[$agrd['tahsil_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $darr[$agrd['distric_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $sarr[$agrd['state_id']]).'",';
	$csv_output .= '"'.str_replace('"', '""', $villagen).'",';
	$csv_output .= '"'.str_replace('"', '""', $tahsiln).'",';
	$csv_output .= '"'.str_replace('"', '""', $distn).'",';
	$csv_output .= '"'.str_replace('"', '""', $staten).'",';

    //sowing female
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_sowing_method_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_foundation_female_lot']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_numberof_treys_female']).'",';
	
	
	$NDm1='0000-00-00'; $NDm2='0000-00-00'; $NDm3='0000-00-00'; 
	$NDm4='0000-00-00'; $NDm5='0000-00-00'; $NDm6='0000-00-00'; 
	$NDm7='0000-00-00'; $NDm8='0000-00-00'; $NDm9='0000-00-00'; 
	$NDm10='0000-00-00'; $NDm11='0000-00-00'; $NDm12='0000-00-00'; 
	$NDm13='0000-00-00'; $NDm14='0000-00-00'; $NDm15='0000-00-00'; 
	
	
	if($agrd['S_nursery_sowingdate_female']>='2022-01-01')
	{ $NDm1=$agrd['S_nursery_sowingdate_female']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm1).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['S_nursery_sowingdate_female']).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_seed_qty_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_numberof_cell_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_FRemark']).'",';
		
	//sowing male
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_sowing_method_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_foundation_male_lot']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_numberof_treys_male']).'",';
	
	if($agrd['S_nursery_sowingdate_male']>='2022-01-01')
	{ $NDm2=$agrd['S_nursery_sowingdate_male']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm2).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['S_nursery_sowingdate_male']).'",';
	
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_seed_qty_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_numberof_cell_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_MRemark']).'",';
	
	//Germination
	if($agrd['S_ObsvtionDate_female']>='2022-01-01')
	{ $NDm3=$agrd['S_ObsvtionDate_female']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm3).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['S_ObsvtionDate_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_germ_per_female']).'",';
	
	if($agrd['S_ObsvtionDate_male']>='2022-01-01')
	{ $NDm4=$agrd['S_ObsvtionDate_male']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm4).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['S_ObsvtionDate_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['S_germ_per_male']).'",';
	
	//transplanting
	if($agrd['T_date_female']>='2022-01-01')
	{ $NDm5=$agrd['T_date_female']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm5).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['T_date_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_acrage_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_spacing_rr_no_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_spacing_pp_no_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_plant_population_female']).'",';
	
	if($agrd['T_date_male']>='2022-01-01')
	{ $NDm6=$agrd['T_date_male']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm6).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['T_date_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_acrage_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_spacing_rr_no_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_spacing_pp_no_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_plant_population_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_total_standing_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['L_location_add']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['T_Remark']).'",';	
	
	//vegitative
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_sown_transp_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_gps_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_giff_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_pld_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_Diff_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_off_type_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_off_type_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_disease_observed_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['V_disease_observed_male']).'",';
	
	if($agrd['V_Remark']!=''){ $csv_output .= '"'.str_replace('"', '""', $agrd['V_Remark']).'",'; }
	else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	
	$agr_y = substr($agrd['agree_no'], 0, 4);
	 
	$sV=mysql_query("SELECT * FROM agreement_vegetative_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rV=mysql_fetch_assoc($sV))
	{ 
	  $arr_Ve[]=$rV['V_excellent_cond_ac']; $arr_Vg[]=$rV['V_good_cond_ac'];
	  $arr_Va[]=$rV['V_average_cond_ac']; $arr_Vp[]=$rV['V_poor_cond_ac']; $arr_Vu[]=$rV['V_update']; 
	}  
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Ve)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Vg)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Va)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Vp)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Vu)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	
	
	//flowering & pollination
	if($agrd['F_flowering_start_date_female']>='2022-01-01')
	{ $NDm7=$agrd['F_flowering_start_date_female']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm7).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['F_flowering_start_date_female']).'",';
	
	if($agrd['F_flowering_start_date_male']>='2022-01-01')
	{ $NDm8=$agrd['F_flowering_start_date_male']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm8).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['F_flowering_start_date_male']).'",';
	
	if($agrd['F_crossing_start_date']>='2022-01-01')
	{ $NDm9=$agrd['F_crossing_start_date']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm9).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['F_crossing_start_date']).'",';
	
	if($agrd['F_crossing_end_date']>='2022-01-01')
	{ $NDm10=$agrd['F_crossing_end_date']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm10).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['F_crossing_end_date']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_plant_population']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_standing_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_pld_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['GPS_Measure']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_off_type_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_off_type_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_disease_observed_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_disease_observed_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_male_removal_date']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_number_of_seed_fruit']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_number_of_fruits_plant']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_total_number_of_plants']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_100seed_weight']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_estimated_yield']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['F_Remark']).'",';
	
	$sF=mysql_query("SELECT * FROM agreement_flowering_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rF=mysql_fetch_assoc($sF))
	{ 
	  $arr_Fe[]=$rF['F_excellent_cond_ac']; $arr_Fg[]=$rF['F_good_cond_ac'];
	  $arr_Fa[]=$rF['F_average_cond_ac']; $arr_Fp[]=$rF['F_poor_cond_ac']; $arr_Fu[]=$rF['F_update']; 
	}  
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Fe)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Fg)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Fa)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Fp)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_Fu)).'",';
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	
	//Post Flowering
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_plant_population']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_standing_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_pld_ac']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Final_GPS_Measure']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_off_type_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_off_type_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_disease_observed_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_disease_observed_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_number_of_seed_fruit']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_number_of_fruits_plant']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_total_number_of_plant']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_100seed_weight']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_estimated_yield']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_total_off_type_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_total_off_type_male']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['Pf_Remark']).'",';
	
	
	$spF=mysql_query("SELECT * FROM agreement_postflowering_".$agr_y." where agree_id='".$agrd['agree_id']."'"); 
	while($rpF=mysql_fetch_assoc($spF))
	{ 
	  $arr_pFe[]=$rpF['Pf_excellent_cond_ac']; $arr_pFg[]=$rpF['Pf_good_cond_ac'];
	  $arr_pFa[]=$rpF['Pf_average_cond_ac']; $arr_pFp[]=$rpF['Pf_poor_cond_ac']; $arr_pFu[]=$rpF['Pf_update']; 
	}
	  
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pFe)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pFg)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pFa)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pFp)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pFu)).'",'; 
	//else{ $csv_output .= '"'.str_replace('"', '""', '').'",'; }
	
	//Harvesting
	$csv_output .= '"'.str_replace('"', '""', $agrd['H_plant_population_female']).'",';
	
	if($agrd['H_harvesting_start_date']>='2022-01-01')
	{ $NDm11=$agrd['H_harvesting_start_date']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm11).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['H_harvesting_start_date']).'",';
	
	if($agrd['H_harvesting_end_date']>='2022-01-01')
	{ $NDm12=$agrd['H_harvesting_end_date']; }
	$csv_output .= '"'.str_replace('"', '""', $NDm12).'",';
	//$csv_output .= '"'.str_replace('"', '""', $agrd['H_harvesting_end_date']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['H_harvesting_acrage_female']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['H_final_yield']).'",';
	$csv_output .= '"'.str_replace('"', '""', $agrd['H_Remark']).'",';
	
	$slot=mysql_query("SELECT SUM(noofbag) as tbag, SUM(qty) as tqty FROM agreementlot_".$agr_y." where agree_no='".$agrd['agree_no']."'"); $rowlot=mysql_num_rows($slot); 
	if($rowlot>0){ $rlot=mysql_fetch_assoc($slot); $bbag=$rlot['tbag']; $bqty=$rlot['tqty']; }
	else{ $bbag=0; $bqty=0; }
	
	//Dispatch
	$csv_output .= '"'.str_replace('"', '""', $bqty).'",';
	$csv_output .= '"'.str_replace('"', '""', $bbag).'",';
	
	//Incidence
	$spR=mysql_query("SELECT * FROM agreement_remark where agree_no='".$agrd['agree_no']."'"); 
	$arr_pR=array();
	while($rpR=mysql_fetch_assoc($spR))
	{ 
	  $arr_pR[]=$rpR['Remark'];  
	}
	$csv_output .= '"'.str_replace('"', '""', implode(',', $arr_pR)).'",';

	$csv_output .= "\n";
    $sn++;
	} //while

   

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($csv_output));
header("Content-type: text/x-csv");
$csv_filename = 'Agreement_reports_'.$from11.'-'.$to11.'.csv'; 
header("Content-Disposition: attachment; filename=".$csv_filename);
echo $csv_output;
exit;  


?>





