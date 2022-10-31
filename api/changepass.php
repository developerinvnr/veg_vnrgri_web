<?php 
include '../config.php';
date_default_timezone_set('asia/calcutta');


if($_POST['uid'] == '' || $_POST['password'] == ''|| $_POST['password'] == ''){
   echo json_encode(array( "code" => "50","msg" => "Parameter missing!") );
}else{

  $pass=md5($_POST['password']);
  $npass=md5($_POST['newpassword']);

  $qry="select * from users where uId='".$_POST['uid']."' and uPassword='".$pass."'";
  $run_qry=mysql_query($qry);
  $num=mysql_num_rows($run_qry);

  if($num>0){
	
  	$updt= mysql_query("update users set uPassword='".$npass."' where uId='".$_POST['uid']."'");
    if($updt){
      echo json_encode(array( "code" => "300", "msg" => "password change successfully") ); 
    }else{
      echo json_encode(array( "code" => "200", "msg" => "password not changed") );
    }
	
  }else{
    echo json_encode(array( "code" => "100", "msg" => "Invalid password!") );
  }
  
}


?>




