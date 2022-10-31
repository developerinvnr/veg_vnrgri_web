<?php 
	date_default_timezone_set('asia/calcutta');
	session_start();


	function addlog($uid,$action){
		$log=mysql_query("INSERT INTO `logbook`( `uid`, `action`, `logDateTime`) VALUES ('".$uid."','".$action."','".date("Y-m-d h:i:s")."')");
	}

	function getUName($uid){
		$u=mysql_query("select uName from users where uId ='".$uid."'");
		$ud=mysql_fetch_assoc($u);
		return $ud['uName'];

	}
	
	include "config.php";
	$tm=time();
	$dat=date('Y-m-d',$tm);
	$uname=$_POST['Username'];
	$pass=md5($_POST['Password']);
	
	$qry="select * from users where uUsername='$uname' and uPassword='$pass' and uStatus='A'";
	
	$run_qry=mysql_query($qry);
	$num=mysql_num_rows($run_qry);

	if($num>0){
		$info=mysql_fetch_array($run_qry);
		$_SESSION['uId']=$info['uId'];
		$_SESSION['uType']=$info['uType'];
		// $_SESSION['year']=$_POST['year'];
		$msg="Login Successfull";
		$action = getUName($_SESSION['uId']). " Loged In";
		addlog($_SESSION['uId'],$action);
		header('location:home.php?msg='.$msg.'');
	}else{
		$msg="Username or Password didn't match<br>Try Again";
		header('location:index.php?msg='.$msg.'&color=danger');
	}
?>