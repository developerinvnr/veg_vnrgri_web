<?php
session_start();
include 'config.php'; 

if(isset($_POST['act']) && $_POST['act']=='saveProfile'){

	$qry=mysql_query("UPDATE `users` SET `uName`='".$_POST['name']."',`uUsername`='".$_POST['uname']."',`uContact`='".$_POST['contact']."',`uEmail`='".$_POST['email']."' WHERE `uId`=".$_SESSION['uId']);

	if($qry){
		echo 'updated';
	}else{
		echo 'error';
	}

}else if(isset($_POST['act']) && $_POST['act']=='savePass'){


	$curpass=md5($_POST['curpass']);
	$newpass=md5($_POST['newpass']);

	$sel=mysql_query("Select uPassword from `users`  WHERE `uId`=".$_SESSION['uId']);
	$seld=mysql_fetch_assoc($sel);

	if($seld['uPassword']==$curpass){
		$qry=mysql_query("UPDATE `users` SET `uPassword`='".$newpass."' WHERE `uId`=".$_SESSION['uId']);
		if($qry){
			echo 'updated';
		}else{
			echo 'error';
		}
	}else{
		echo 'invalidpass';
	}
	

}else if(isset($_POST['act']) && $_POST['act']=='forgetPass'){

	$sel=mysql_query("Select * from `users`  WHERE `uEmail`='".$_POST['email']."'");
	$selc=mysql_num_rows($sel);

	if($selc>0){

		function getRandomString($n) { 
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		    $randomString = ''; 
		  
		    for ($i = 0; $i < $n; $i++) { 
		        $index = rand(0, strlen($characters) - 1); 
		        $randomString .= $characters[$index]; 
		    } 
		  
		    return $randomString; 
		} 

		$randomPass = getRandomString(10);
		$randomPassE = md5($randomPass);

		$updt=mysql_query("update `users` set `uPassword`='".$randomPassE."' WHERE `uEmail`='".$_POST['email']."'");

		if($updt){
			$seld= mysql_fetch_assoc($sel);

			$email_to = $_POST['email'];
			// $email_from = 'support@vnragri.co.in';
			$email_subject = "Forgot Password";
			$headers = 'From: VNR Agreement <support@vnragri.co.in>' . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$message ="<p style='font-size: 18px;display: inline;'>Hello ".$seld['uName'].",</p><br>";
			$message .="<p style='font-size: 18px;display: inline;'>Your <b>\"Agreement Software\"</b> password is been refreshed for your request of forgot password. </p><br>";
			$message .="<p style='font-size: 18px;display: inline;'>Your temporary password is:</p> 
			<div style='font-size: 18px; background-color:#3F779E; color:#ffffff; display:inline; border-radius:5px; padding:4px 6px;' ><b>".$randomPass."</b></div><br>";
			$message .="<p style='font-size: 18px;display: inline;'>Kindly login with this temporary password and change it as soon as possible in your profile section.</p>
			<br><br><br>
			<p style='font-weight:bold;font-size: 18px;'>VNR Agreement Support Team</p>";




			$email_message ='<!DOCTYPE html>
			<html>
			<head>
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
				<link href="https://fonts.googleapis.com/css?family=Poppins:700&display=swap" rel="stylesheet">
			</head>
			<body>
				<div style="border: 2px solid #000000;">
				<h2 style="background-color: #B3CDE0;color:#3f779e;font-family: \'Poppins\', sans-serif;font-size: 50px;padding:50px;">Agreement</h2>
				<div style="padding:40px;">
					<h2>Forgot Password Request Accepted</h2>
							'.$message.'
					<br>
					<br>
					<br>
					<br>
					<br>
				</div>
				</div>
			</body>
			</html>';

			$ok = @mail($email_to, $email_subject, $email_message, $headers);

			if($ok){
				echo 'mailsent';
			}else{
				echo 'mailnotsent';
			}

		}else{
			echo 'notupdated';
		}
		

	}else{
		echo 'notfound';
	}

	
	

}






?>