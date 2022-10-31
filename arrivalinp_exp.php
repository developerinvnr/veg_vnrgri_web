<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');

function gethierarchy($uid)
{
 $id=array($uid);
	
 if($_SESSION['uType']=='S')
 {
  $sel=mysql_query("select uId from users");
  while($seld = mysql_fetch_assoc($sel)){ $idc = array($seld['uId']); $id = array_merge($id,$idc); }
 }
 else
 { 
   $sel=mysql_query("select uId from users where uReporting='".$uid."'");
   if(mysql_num_rows($sel) > 0)
   {
    while($seld = mysql_fetch_assoc($sel))
    {
     $idc = array($seld['uId']);
     $id = array_merge($id,$idc,gethierarchy($seld['uId']));
    }
   }
  }
  return $id;	
}


function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];

}

$xls_filename = 'Dispatch_with_arrival_reports_'.date("d-m-Y").'.xls'; 

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t"; 


echo "Sn\tLot Number\tDispatch Date\tFarmer Name\tFarmerID\tOrganiser Name\tProduction Loc-State\tProduct Name\tProduct Code\tNo Of Bag\tQty in Kg\tExecutive Name\tProduction Person\t From\tDestination\tVehicle No\tDriver Name\tDriver Cell No\tVehicle reached date at Plant\tActual Qty in Kg at Plant\tRemark";
print("\n");

  if(isset($_REQUEST['vii']) && $_REQUEST['vii']!=''){ $keyArea="agr.vi like '%".$_REQUEST['vii']."%'";}
  elseif(isset($_REQUEST['tii']) && $_REQUEST['tii']!=''){ $keyArea="agr.ti like '%".$_REQUEST['tii']."%'";}
  elseif(isset($_REQUEST['dii']) && $_REQUEST['dii']!=''){ $keyArea="agr.di like '%".$_REQUEST['dii']."%'";}
  elseif(isset($_REQUEST['sii']) && $_REQUEST['sii']!=''){ $keyArea="agr.si like '%".$_REQUEST['sii']."%'";}
  else{$keyArea='1=1';}
  
  $from = date('Y-m-d',strtotime($_REQUEST['from'])); $agyearf = (int)date('Y',strtotime($_REQUEST['from']));
  $to = date('Y-m-d',strtotime($_REQUEST['to'])); $agyeart = (int)date('Y',strtotime($_REQUEST['to']));
  
  if(isset($_REQUEST['crop']) && $_REQUEST['crop']!='' && $_REQUEST['crop']!='null' && $_REQUEST['crop']>0){ $cropCond="agr.ann_crop=".$_REQUEST['crop']; }
  else{ $cropCond='1=1'; } 

  if(isset($_REQUEST['prodcode']) && $_REQUEST['prodcode']!='' && $_REQUEST['prodcode']!='null' && $_REQUEST['prodcode']>0){ $prodcode="agr.ann_prodcode='".$_REQUEST['prodcode']."'"; }
  else{ $prodcode='1=1'; }
  
  if(isset($_REQUEST['orgr']) && $_REQUEST['orgr']!=''){ $orgrCond="agr.org_id=".$_REQUEST['orgr']; }
  else{ $orgrCond='1=1'; }
  
  if(isset($_REQUEST['driv']) && $_REQUEST['driv']!=''){ $driv="l.driver_no='".$_REQUEST['driv']."'"; }
  else{ $driv='1=1'; }

  if(isset($_REQUEST['pperson']) && $_REQUEST['pperson']!=''){ $pperson="agr.prod_person=".$_REQUEST['pperson']; }
  else{ $pperson='1=1'; }
	
  if(isset($_REQUEST['pexe']) && $_REQUEST['pexe']!=''){ $pexecutive="agr.prod_executive=".$_REQUEST['pexe']; }
  else{ $pexecutive='1=1'; }
  
  /***************** user Check *********************/
  if(isset($_REQUEST['users']) && $_REQUEST['users']!='' && $_REQUEST['users']>0)
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
  
  
  /****************** Query ******************************/
  /****************** Query ******************************/
  $qry=""; $datey=$agyeart;  //$agyeart
  
  for($i=2019; $i<=$datey; $i++) //$agyearf
  {
	$qry.=" SELECT l.*, ann_prodcode, cropname, cropcode, prod_person, prod_executive, si, di, ti, vi, f.fname, f.tem_fid, o.oname FROM agreementlot_".$i." l inner join agreement_".$i." agr on l.agree_no=agr.agree_no inner join crop c on agr.ann_crop=c.cropid inner join farmers f on agr.second_party=f.fid inner join organiser o on agr.org_id=o.oid where l.dispatch_date between '".$from."' and '".$to."' and ".$keyArea." and ".$cropCond." and ".$prodcode." and ".$orgrCond." and ".$driv." and ".$pperson." and ".$pexecutive." and ".$hierarchyCond;

	if($i!=$datey){ $qry.=' UNION'; }

  }
   ini_set('memory_limit', '-1');
  //echo $qry; die(); 
  $agra=mysql_query($qry);
  $agcou=mysql_num_rows($agra);
  if($agcou>20){ $pages=ceil($agcou/20); }else{ $pages=1; }
  /****************** Query ******************************/
  /****************** Query ******************************/
  
  $agr=mysql_query($qry); $sn=1;
  while ($agrd=mysql_fetch_assoc($agr))
  {

    if($agrd['si']>0){ $sr=mysql_fetch_assoc(mysql_query("select StateName from state where StateId=".$agrd['si'])); }
    if($agrd['di']>0){ $dr=mysql_fetch_assoc(mysql_query("select DictrictName from distric where DictrictId=".$agrd['di']));}
    if($agrd['ti']>0){ $tr=mysql_fetch_assoc(mysql_query("select TahsilName from tahsil where TahsilId=".$agrd['ti'])); }
    if($agrd['vi']>0){ $vr=mysql_fetch_assoc(mysql_query("select VillageName from village where VillageId=".$agrd['vi'])); }
	$distn=$dr['DictrictName'].' - '.$sr['StateName'];
    $villagen=$vr['VillageName'].' - '.$tr['TahsilName'];;
	
    echo $sn.$sep;
    echo $agrd['lot_no'].$sep;
	echo $agrd['dispatch_date'].$sep;
	
	echo $agrd['fname'].$sep;
	
	$str = chunk_split($agrd['tem_fid'], 4, ' ');
	echo $str.$sep;
	echo $agrd['oname'].$sep;
	
	echo $villagen.' - '.$distn.$sep;
	
	echo $agrd['cropname'].$sep;
	echo $agrd['ann_prodcode'].$sep;
	echo $agrd['noofbag'].$sep;
	echo $agrd['qty'].$sep;
	echo getUName($agrd['prod_executive']).$sep;
	echo getUName($agrd['prod_person']).$sep; 
	echo $villagen.$sep;
	
	$DesLoc='';
	if($agrd['arrival_upby']>0 && $agrd['arrival_qty']>0)
	{ $sL=mysql_query("select uLocation from users where uId=".$agrd['arrival_upby']); $rL=mysql_fetch_assoc($sL); 
	  $DesLoc=$rL['uLocation'];
	}
	echo $DesLoc.$sep;
	
	/*
	if($agrd['arrival_upby']>0)
	{ $sL=mysql_query("select uLocation from users where uId=".$agrd['arrival_upby']); $rL=mysql_fetch_assoc($sL); }
	echo $rL['uLocation'].$sep;
	*/
	
	echo $agrd['lorry_no'].$sep;
	echo $agrd['driver_name'].$sep;
	echo "`".$agrd['driver_no']."`".$sep;
	echo $agrd['arrival_date'].$sep;
	echo $agrd['arrival_qty'].$sep;
	echo $agrd['arrival_rmk'].$sep;

	print("\n");
	
	$sn++;

   }

?>


