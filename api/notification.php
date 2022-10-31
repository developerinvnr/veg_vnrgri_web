<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 if($_REQUEST['userid'] == '' || $_REQUEST['value'] == '')
 {
   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
 }
 elseif($_REQUEST['userid']!= '' || $_REQUEST['value'] == 'count')
 {
 
   $stid= mysql_query("SELECT state_id from user_location where state_id>0 and sts='A' and uid=".$_REQUEST['userid']);
   $dtid= mysql_query("SELECT district_id from user_location where district_id>0 and sts='A' and uid=".$_REQUEST['userid']);
   $ttid= mysql_query("SELECT tahsil_id from user_location where tahsil_id>0 and sts='A' and uid=".$_REQUEST['userid']);
   $vtid= mysql_query("SELECT village_id from user_location where village_id>0 and sts='A' and uid=".$_REQUEST['userid']);
   $rows=mysql_num_rows($stid); $rowd=mysql_num_rows($dtid); 
   $rowt=mysql_num_rows($ttid); $rowv=mysql_num_rows($vtid);
   
     
   if($rowv>0)
   {  
      while($rv=mysql_fetch_array($vtid)){ $array_v[]=$rv['village_id']; } 
      $vv = implode(',', $array_v); $qry='village_id'; $qryy='agr.vi';   
   } 
   else if($rowt>0)
   {  
      while($rt=mysql_fetch_array($ttid)){ $array_t[]=$rt['tahsil_id']; } 
      $vv = implode(',', $array_t); $qry='tahsil_id'; $qryy='agr.ti';
   }
   else if($rowd>0)
   {
      while($rd=mysql_fetch_array($dtid)){ $array_d[]=$rd['district_id']; } 
      $vv = implode(',', $array_d); $qry='distric_id'; $qryy='agr.di';
   }
   else
   {
      while($rs=mysql_fetch_array($stid)){ $array_s[]=$rs['state_id']; } 
      $vv = implode(',', $array_s); $qry='state_id'; $qryy='agr.si';
   }
 
 
   /*******************************************************************/
   $farray = array();
   $run_qry=mysql_query("select count(*) as totalF from farmers where (".$qry." in (".$vv.") or cr_by='".$_REQUEST['userid']."')"); $num=mysql_num_rows($run_qry);
   if($num>0){ $res=mysql_fetch_assoc($run_qry); $TotF=$res['totalF']; } else{ $TotF=0;}
     
	 
  $sqls=mysql_query("select * from view_season where SesId=1"); $ress=mysql_fetch_assoc($sqls);
  $y=date("Y")+1; 
  
  /*
  if($ress['Kharif']=='Y'){ //$from='01-04-'.date("Y"); $to='30-08-'.date("Y"); 
  $from='2019-04-01'; $to='2019-08-30';
  $agyearf = (int)date('Y',strtotime($from)); $agyeart = (int)date('Y',strtotime($to)); }
  elseif($ress['Rabi']=='Y'){ //$from='15-09-'.date("Y"); $to='30-03-'.$y;
  $from='2019-09-15'; $to='2020-03-30';  
  $agyearf = (int)date('Y',strtotime($from)); $agyeart = (int)date('Y',strtotime($to)); }
  else
  {   
   $from = date('Y-m-d',strtotime($_REQUEST['dfrom'])); $agyearf = (int)date('Y',strtotime($_REQUEST['dfrom']));
   $to = date('Y-m-d',strtotime($_REQUEST['dto']));     $agyeart = (int)date('Y',strtotime($_REQUEST['dto']));
  } 
  */
  
  $sVd=mysql_query("select * from app_version where VersionId=1"); 
  $rVd=mysql_fetch_assoc($sVd); 
  $Kdf=date("Y-m-d",strtotime($rVd['Kharif_From'])); 
  $Kdt=date("Y-m-d",strtotime($rVd['Kharif_To']));
  $Rdf=date("Y-m-d",strtotime($rVd['Rabi_From']));
  $Rdt=date("Y-m-d",strtotime($rVd['Rabi_To'])); 
  
  if($ress['Kharif']=='Y'){ $from=$Kdf; $to=$Kdt; }
  elseif($ress['Rabi']=='Y'){ $from=$Rdf; $to=$Rdt;  }
  else
  {
   $from = date('Y-m-d',strtotime($_REQUEST['dfrom'])); 
   $to = date('Y-m-d',strtotime($_REQUEST['dto']));     
  } 
   
   $agyearf = (int)date('2019',strtotime($from));
   $agyeart = (int)date('2020',strtotime($to));
  
   $qry22=""; 
   for($i=$agyearf; $i <= $agyeart; $i++)
   {   
     
	 $qry22.="SELECT agree_id FROM `agreement_".$i."` agr, farmers f where agree_date between '".$from."' and '".$to."' and agr.second_party=f.fid and ".$qryy." in (".$vv.")";
	 if($i!=$agyeart){ $qry22.=' UNION '; }
   }
   
   $run_qry22=mysql_query($qry22); $num22=mysql_num_rows($run_qry22); 
   if($num22>0){ $res22=mysql_fetch_assoc($run_qry22); $TotA=$num22; } else{ $TotA=0;}
   
   echo json_encode(array( "data" => "300", "TotF" => $TotF, "TotA" => $TotA) );
   
   /*******************************************************************/ 
 
 }
 else 
 {
   echo json_encode(array( "data" => "100", "msg" => "Missing Value!") );
 }

?>









