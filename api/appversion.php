<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


 if($_REQUEST['value'] == '')
 {
   echo json_encode(array( "status" => "100","msg" => "Parameter missing!") );
 }
 elseif($_REQUEST['value'] == 'version')
 {
 
   /**********************************************************************/
  $schkr=mysql_query('SELECT * FROM `app_version`'); $rowchkr=mysql_num_rows($schkr); 
  /**********************************************************************/
   
   if($rowchkr>0)
   {
     $rchkr=mysql_fetch_assoc($schkr); 
	 echo json_encode(array( "data" => "300", "version_no" => $rchkr['VersionD']) );
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









