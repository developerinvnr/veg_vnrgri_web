<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid']!='' && $_REQUEST['value'] == 'visit')
{

  $Crop=0;
  if($_REQUEST['Hyb_code']!=''){ $sc=mysql_query("select cropid from master_fsqc_transaction where production_code='".$_REQUEST['Hyb_code']."'"); $rc=mysql_fetch_assoc($sc); $Crop=$rc['cropid']; }
  
  $sqlChk=mysql_query("select * from visit_details where VUserId='".$_REQUEST['User_id']."' AND VDate='".date("Y-m-d",strtotime($_REQUEST['Date']))."' AND VTime='".$_REQUEST['Time']."' AND VCrop='".$Crop."' AND VHyb_code='".$_REQUEST['Hyb_code']."' AND VVillage='".$_REQUEST['Village']."' AND VState='".$_REQUEST['State']."' AND VTot_acrg='".$_REQUEST['Tot_acrg']."'");
  $rowChk=mysql_num_rows($sqlChk);
  if($rowChk==0)
  {
  
   $sMx=mysql_query("select MAX(VisitId) as maxId from visit_details");
   $rMx=mysql_fetch_assoc($sMx); $NextMx=$rMx['maxId']+1;

   $sql=mysql_query("insert into visit_details(VisitId, VUserId, VDate, VTime, VCrop, VHyb_code, VVillage, VState, VTot_acrg, VGPS_loc, VGPS_loc_lat, VGPS_loc_long, Remark) values(".$NextMx.", '".$_REQUEST['userid']."', '".date("Y-m-d",strtotime($_REQUEST['Date']))."', '".$_REQUEST['Time']."', '".$Crop."', '".$_REQUEST['Hyb_code']."', '".$_REQUEST['Village']."', '".$_REQUEST['State']."', '".$_REQUEST['Tot_acrg']."', '".$_REQUEST['GPS_loc']."', '".$_REQUEST['GPS_loc_lat']."', '".$_REQUEST['GPS_loc_long']."', '".$_REQUEST['remark']."')");
   if($sql)
   {
     echo json_encode(array("code" => "300","return"=>"success","VisitId"=>$NextMx) );
   }
  
  }//if($rowChk==0) 
}

elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'visit_details')
{

 $sqls=mysql_query("select * from view_season where SesId=1"); $ress=mysql_fetch_assoc($sqls);
 $sVd=mysql_query("select * from app_version where VersionId=1"); $rVd=mysql_fetch_assoc($sVd); 
 $Kdf=date("Y-m-d",strtotime($rVd['Kharif_From'])); $Kdt=date("Y-m-d",strtotime($rVd['Kharif_To']));
 $Rdf=date("Y-m-d",strtotime($rVd['Rabi_From'])); $Rdt=date("Y-m-d",strtotime($rVd['Rabi_To'])); 

 if($ress['Kharif']=='Y'){ $from=$Kdf; $to=$Kdt; }
 elseif($ress['Rabi']=='Y'){ $from=$Rdf; $to=$Rdt; }

  $sql=mysql_query("select * from visit_details where VUserId='".$_REQUEST['userid']."' AND VDate between '".$from."' and '".$to."' group by VDate,VTime,VCrop,VHyb_code,VVillage,VState,VTot_acrg order by VDate"); $num=mysql_num_rows($sql); $Varray = array();
  if($num)
  {
    while($res=mysql_fetch_assoc($sql))
    {
	 $Varray[]=$res; 
	}
	echo json_encode(array("visited_list" => $Varray) ); 
  }
}
else
{
 echo json_encode(array("code" => "100", "return"=>"value missing") );
}

?>
