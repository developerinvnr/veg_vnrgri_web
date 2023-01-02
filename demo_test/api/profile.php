<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 if($_GET['farmerid'] == '')
 {
   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
 }
 else
 {
 
   $qry="select * from farmers where fid=".$_GET['farmerid'];
   $run_qry=mysql_query($qry);
   $num=mysql_num_rows($run_qry);
   $farray = array();
   if($num>0)
   {
    $res=mysql_fetch_assoc($run_qry);
	//if($res['state_id']>0){ 
	$s=mysql_query("select StateName from state where StateId=".$res['state_id']); $sr=mysql_fetch_assoc($s);
	//} if($res['distric_id']){
	$d=mysql_query("select DictrictName from distric where DictrictId=".$res['distric_id']); $dr=mysql_fetch_assoc($d);
	//} if($res['tahsil_id']){
	$t=mysql_query("select TahsilName from tahsil where TahsilId=".$res['tahsil_id']); $tr=mysql_fetch_assoc($t);
	//} if($res['village_id']){
	$v=mysql_query("select VillageName from village where VillageId=".$res['village_id']); $vr=mysql_fetch_assoc($v);
	//} if($res['oid']){
	$o=mysql_query("select oname from organiser where oid=".$res['oid']); $or=mysql_fetch_assoc($o);
    //}
	
	echo json_encode(array( "fname" => $res['fname'], "contact" => $res['contact_1'], "dob" => $res['dob'], "father" => $res['father_name'], "organiser" => $or['oname'], "address" => $res['address'], "state" => $sr['StateName'], "distric" => $dr['DistrictName'], "tahsil" => $tr['TahsilName'], "village" => $vr['VillageName'], "aadhar" => $res['aadhar_no'], "bankname" => $res['bank_name'], "accountno" => $res['account_no'], "ifsc" => $res['ifsc_code'],  "msg" => "record fetch successfully!") ); 
   }
   else 
   {
    echo json_encode(array( "data" => "100", "msg" => "Invalid id!") );
   }
  
 }


	
?>




