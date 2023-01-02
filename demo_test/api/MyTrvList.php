<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');

if($_REQUEST['userid']!='' && $_REQUEST['value'] == 'InsMyTrv')
{
  //userid, date, description, purpose, remark, value=InsMyTrv
 
  if($_REQUEST['date']!='')
  {
   $d=date("d",strtotime($_REQUEST['date'])); $d=intval($d); 
   $m=date("m",strtotime($_REQUEST['date'])); $m=intval($m);
   $y=date("Y",strtotime($_REQUEST['date']));
   $sql=mysql_query("select * from tourplan where UserId=".$_REQUEST['userid']." AND Date='".date("Y-m-d",strtotime($_REQUEST['date']))."'");
   $row=mysql_fetch_assoc($sql);
   if($row==0){ $sInsUp=mysql_query("insert into tourplan(UserId, Month, Year, Date, Description, Purpose, Remark) values(".$_REQUEST['userid'].", ".$m.", ".$y.", '".date("Y-m-d",strtotime($_REQUEST['date']))."', '".addslashes($_REQUEST['description'])."', '".addslashes($_REQUEST['purpose'])."', '".addslashes($_REQUEST['remark'])."')"); }
   else{ $sInsUp=mysql_query("update tourplan set Description='".addslashes($_REQUEST['description'])."', Purpose='".addslashes($_REQUEST['purpose'])."', Remark='".addslashes($_REQUEST['remark'])."' where UserId=".$_REQUEST['userid']." AND Date='".date("Y-m-d",strtotime($_REQUEST['date']))."'"); }
   if($sInsUp){ echo json_encode(array("code"=>"300", "return"=>"success") ); }
  }
  else
  {
   echo json_encode(array("return"=>"date missing") );
  }
  
}
elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'MyTrvList')
{
  //userid, month, year, value=MyTrvList
  if($_REQUEST['month']>0 AND $_REQUEST['year']>0)
  {
   $sql=mysql_query("select * from tourplan where UserId=".$_REQUEST['userid']." AND Month=".$_REQUEST['month']." AND Year=".$_REQUEST['year'].""); $row=mysql_num_rows($sql); $Tarray = array();
   if($row>0)
   {
     while($res=mysql_fetch_assoc($sql)){ $Tarray[]=$res; }
	 echo json_encode(array( "MyTour_list" => $Tarray) ); 
   }
   else
   {
    echo json_encode(array("return"=>"no data found") );
   }
  }
  
}
elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'MyTeam')
{
  //userid, value=MyTeam
  $sql=mysql_query("select state_id from user_location where uid=".$_REQUEST['userid']." AND sts='A' AND state_id>0 group by state_id");
  $row=mysql_num_rows($sql);
  if($row>0)
  {  
   while($res=mysql_fetch_array($sql)){ $array_s[]=$res['state_id']; } 
   $ss = implode(',', $array_s);   
  } 
  
  $sqlu=mysql_query("select u.uid,u.uName from user_location ul inner join users u on ul.uid=u.uid where ul.state_id in (".$ss.") and (u.uPost='1' OR u.uPost='5' OR u.uPost='6' OR u.uPost='7' OR u.uPost='8' OR u.uPost='10') and uStatus='A' and u.uid!=".$_REQUEST['userid']." and ul.sts='A' group by u.uName order by u.uName"); $Uarray = array(); $rowu=mysql_num_rows($sqlu);
  if($rowu>0)
  {
   while($resu=mysql_fetch_assoc($sqlu)){ $Uarray[]=$resu; }
   echo json_encode(array( "MyTeam_list" => $Uarray) );
  }
  else
  {
   echo json_encode(array("return"=>"no data found") );
  }
  
}
elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'MyTeamTrvList')
{
 //userid, TeamId, month, year, value=MyTeamTrvList
 if($_REQUEST['month']>0 AND $_REQUEST['year']>0)
 {
  $sql=mysql_query("select * from tourplan where UserId=".$_REQUEST['TeamId']." AND Month=".$_REQUEST['month']." AND Year=".$_REQUEST['year'].""); $row=mysql_num_rows($sql); $Tarray = array();
  if($row>0)
  {
    while($res=mysql_fetch_assoc($sql)){ $Tarray[]=$res; }
	echo json_encode(array( "MyTeamTour_list" => $Tarray) ); 
  }
  else
  {
   echo json_encode(array("return"=>"no data found") );
  }
 }
 
}
else
{
 echo json_encode(array("return"=>"value missing") );
}

?>
