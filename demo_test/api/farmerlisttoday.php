<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');
header("Content-type:application/json");
//  if($_GET['userid'] == '' || $_GET['value'] == '')
//  {
//   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
//  }
//  elseif($_GET['userid']!= '' || $_GET['value'] == 'farmerlist')
//  {
//   $stid= mysql_query("SELECT state_id from user_location where uid=".$_GET['userid']);
//   $rows=mysql_num_rows($stid);
   
//   if($rows>0)
//   {
   
//     while($rec=mysql_fetch_array($stid)){ $array_s[]=$rec['state_id']; }
//     $state = implode(',', $array_s);
   
    $run_qry=mysql_query("select `fname`,`doc_passbook`, `cr_date` from farmers where cr_date='".date('Y-m-d')."'");
    $num=mysql_num_rows($run_qry);
    $farray = array();
    if($num>0)
    {
	
      while($res=mysql_fetch_assoc($run_qry)){ $farray[]=$res; }
	 echo json_encode(array( "farmer_list" => $farray) ); 
	 
	  
	}
    else 
    {
     echo json_encode(array( "data" => "100", "msg" => "zero entries!") );
    }
	
//   }
//  }


	
?>




