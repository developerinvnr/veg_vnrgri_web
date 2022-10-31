<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 
 if($_REQUEST['userid']!='' && $_REQUEST['value'] == 'userdetails')
 {

   $qry="select * from users where uId='".$_REQUEST['userid']."' AND uStatus='A'";
   $run_qry=mysql_query($qry);
   $num=mysql_num_rows($run_qry);
   if($num>0)
   {
     
    $res=mysql_fetch_assoc($run_qry);
	$stid= mysql_query("SELECT StateName from user_location u,state s where uid='".$res['uId']."' and sts='A' and u.state_id=s.StateId");
    $rows=mysql_num_rows($stid);
	if($rows>0)
    { 
	  $array_s=array();
      while($rec=mysql_fetch_assoc($stid)){ 
      $array_s[]=$rec; 
      }
    } 
	
	echo json_encode(array( "code" => "300", "userid" => $res['uId'], "username" => $res['uName'],  "contact" => $res['uContact'], "email" => $res['uEmail'], "status" => $res['uStatus'], "Post" => $res['uPost'], "AdvancePlan" => $res['AdvancePlan'], "QADept" => $res['QADept'], "Qs1" => $res['Qs1'], "Qs2" => $res['Qs2'], "Qs3" => $res['Qs3'], "Qs4" => $res['Qs4'], "Qs5" => $res['Qs5'], "AccessAll" => $res['AccessAll'], "OnlyField" => $res['OnlyField'], "state" =>$array_s,  "msg" => "User Details Find Successfully!") );  
	//echo json_encode(array("data" => $uarray)); 
   }
   else
   {
    echo json_encode(array( "code" => "100", "msg" => "Invalid user!") );
   }
  
 }
 
 elseif($_REQUEST['userid']!='' && $_REQUEST['value'] == 'QARemark' && $_REQUEST['agree_no']!='' && $_REQUEST['Remark']!='')
 {
 
   $yer=substr($_REQUEST['agree_no'], 0, 4);
   $run_qry=mysql_query("update agreement_".$yer." set QA_Remark='".$_REQUEST['Remark']."' where agree_no='".$_REQUEST['agree_no']."'");
   if($run_qry)
   {
    echo json_encode(array( "code" => "300", "msg" => "QA remark update successfully!", "agree_no" => $_REQUEST['agree_no']) );
   }
   
 }
 else
 {
  echo json_encode(array( "code" => "100", "msg" => "Invalid user!") );
 }

?>




