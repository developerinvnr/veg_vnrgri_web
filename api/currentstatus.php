<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid'] == '' || $_REQUEST['value'] == '')
{
  echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
}



elseif($_REQUEST['userid']!= '' && $_REQUEST['value'] == 'cs')
{
  
  $sql=mysql_query("select * from view_season where SesId=1"); $res=mysql_fetch_assoc($sql);
  $sVd=mysql_query("select * from app_version where VersionId=1"); $rVd=mysql_fetch_assoc($sVd); 
  
  $Kf=date("Y-m-d",strtotime($rVd['Kharif_From'])); 
  $Kt=date("Y-m-d",strtotime($rVd['Kharif_To']));
  $Rf=date("Y-m-d",strtotime($rVd['Rabi_From']));  
  $Rt=date("Y-m-d",strtotime($rVd['Rabi_To'])); 
  $Sf=date("Y-m-d",strtotime($rVd['Summer_From']));
  $St=date("Y-m-d",strtotime($rVd['Summer_To']));
  
  if($res['Kharif']=='Y' AND $res['Rabi']=='Y')
  { 
     $from=date('Y-m-d',strtotime($rVd['Kharif_From']));  
     $to=date('Y-m-d',strtotime($rVd['Rabi_To']));
     //$Dfy=$Kdfy; $Dty=$Rdty; 
  }
  elseif($res['Rabi']=='Y' AND $res['Summer']=='Y')
  { 
     $from=date('Y-m-d',strtotime($rVd['Rabi_From']));   
     $to=date('Y-m-d',strtotime($rVd['Summer_To'])); 
     //$Dfy=$Rdfy; $Dty=$Sdty;
  }
  elseif($res['Summer']=='Y' AND $res['Kharif']=='Y')
  { 
     $from=date('Y-m-d',strtotime($rVd['Summer_From']));    
     $to=date('Y-m-d',strtotime($rVd['Kharif_To'])); 
     //$Dfy=$Sdfy; $Dty=$Kdty;
  }
  else 
  { 
    $from=date("Y-m-d"); $to=date("Y-m-d");  
  }
  
  $y=date("Y")+1;
  
  
  
   /********************** 0000000000000000000000000000 11111 Open Open ***/
   /********************** 0000000000000000000000000000 11111 Open Open ***/
   
     echo json_encode(array( "Rabi" => $res['Rabi'], "Kharif" => $res['Kharif'], "Summer" => $res['Summer'], "from_date" => $from, "to_date" => $to) ); 
  
   /********************** 0000000000000000000000000000 11111 Close Close ***/
   /********************** 0000000000000000000000000000 11111 Close Close ***/
   
}
 
 
 
elseif($_REQUEST['userid']!= '' && $_REQUEST['value'] == 'croplist')
{
    $sql=mysql_query("select cropid,cropname from crop order by cropname"); 
    $crry=array(); 
    while($res=mysql_fetch_assoc($sql)){ $carry[]=$res; }
    echo json_encode(array( "Crop_List" => $carry, "Code" => 300) ); 
}
 
 
 
 
 
 
 
 else 
 {
   echo json_encode(array( "data" => "100", "msg" => "Missing Value!") );
 }
?>









