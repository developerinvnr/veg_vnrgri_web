<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 if($_REQUEST['userid'] == '' || $_REQUEST['value'] == '')
 {
   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
 }
 elseif($_REQUEST['userid']!= '' || $_REQUEST['value'] == 'farmerlist')
 {
 
   /************* <!--------------------------------------------> ****************/
  /************* <!--------------------------------------------> ****************/
   
   $uchk=mysql_query("SELECT QADept,Qs1,Qs2,Qs3,Qs4,Qs5 from users where uId=".$_REQUEST['userid']); $ruchk=mysql_fetch_assoc($uchk);
   
   if($ruchk['QADept']=='N')
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
        $vv = implode(',', $array_v); $qry='village_id';   
     } 
     else if($rowt>0)
     {  
        while($rt=mysql_fetch_array($ttid)){ $array_t[]=$rt['tahsil_id']; } 
        $vv = implode(',', $array_t); $qry='tahsil_id';
     }
     else if($rowd>0)
     {
        while($rd=mysql_fetch_array($dtid)){ $array_d[]=$rd['district_id']; } 
        $vv = implode(',', $array_d); $qry='distric_id';
     }
     else
     {
        while($rs=mysql_fetch_array($stid)){ $array_s[]=$rs['state_id']; } 
        $vv = implode(',', $array_s); $qry='state_id';
     }
     
   } //if($ruchk=='N')
   
   elseif($ruchk['QADept']=='Y')
   {  
      if($ruchk['Qs1']>0){$s1=$ruchk['Qs1'];}else{$s1=0;}
      if($ruchk['Qs2']>0){$s2=$ruchk['Qs2'];}else{$s2=0;}
      if($ruchk['Qs3']>0){$s3=$ruchk['Qs3'];}else{$s3=0;}
      if($ruchk['Qs4']>0){$s4=$ruchk['Qs4'];}else{$s4=0;}
      if($ruchk['Qs5']>0){$s5=$ruchk['Qs5'];}else{$s5=0;}

      $vv = $s1.','.$s2.','.$s3.','.$s4.','.$s5; 
      $qry='state_id';
   }
     
  /************* <!--------------------------------------------> ****************/
  /************* <!--------------------------------------------> ****************/     
 
 
   /*******************************************************************/
   $farray = array();
   $run_qry=mysql_query("select * from farmers where (".$qry." in (".$vv.") or cr_by='".$_REQUEST['userid']."')"); $num=mysql_num_rows($run_qry);
   
   ini_set('memory_limit', '-1');
   
   if($num>0)
   {
     while($res=mysql_fetch_assoc($run_qry)){ $farray[]=$res; }
     echo json_encode(array( "farmer_list" => $farray) ); 
   }
   else 
   {
     echo json_encode(array( "data" => "100", "msg" => "Invalid id!") );
   }
   /*******************************************************************/ 
 
 }
 else 
 {
   echo json_encode(array( "data" => "100", "msg" => "Missing Value!") );
 }

?>









