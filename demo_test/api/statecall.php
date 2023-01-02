<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid']!='' && $_REQUEST['value'] == 'statedetails' && $_REQUEST['v']!='')
{

 $qry=mysql_query("select StateName from state where StateName like '".$_REQUEST['v']."%' AND StateStatus='A'");
 $rows=mysql_num_rows($qry);
 if($rows>0)
 { 
  $array_s=array();
  while($rec=mysql_fetch_assoc($qry)){ $array_s[]=$rec; }
  echo json_encode(array( "code" => "300", "state" => $array_s) );
 } 
 else{ echo json_encode(array( "code" => "100", "msg" => "") ); } 

}


elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'statedetails_all')
{

 $qry=mysql_query("select StateName from state where StateStatus='A'");
 $rows=mysql_num_rows($qry);
 if($rows>0)
 { 
  $array_s=array();
  while($rec=mysql_fetch_assoc($qry)){ $array_s[]=$rec; }
  echo json_encode(array( "code" => "300", "state" => $array_s) );
 } 
 else{ echo json_encode(array( "code" => "100", "msg" => "") ); } 

}
else{ echo json_encode(array( "code" => "100", "msg" => "Value Missing!") ); }
 
?>




