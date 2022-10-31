<?php
$randomPass="cHMkmICu96";
$email_to = "balakrishna8524@gmail.com";
$email_from = 'support@vnragri.co.in';
$email_subject = "Forgot Password";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
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
		<h3>Forgot Password Request Accepted</h3>
				<p style="font-size: 18px;display: inline;">
			Hello Bala,<br>Your <b>"Agreement Software"</b> password is been refreshed for your request of forgot password. <br>Your temprary password is: <div style="background-color:#3F779E;color:#ffffff;display:inline;border-radius:5px;padding:4px 6px;" ><b>cHMkmICu96</b></div><br>Kindly login with this temprary password and change it as soon as possible in your profile section.<br><br><br><span style="font-weight:bold;">VNR Agreement Support Team</span>		</p>
		<br>
		<br>
		<br>
	</div>
	</div>
</body>
</html>';

$ok = @mail($email_to, $email_subject, $email_message, $headers);

if($ok){
    echo 'mail sent';
}else{
    echo 'mail not sent';
}
?>