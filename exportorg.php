<?php
session_start();
include "config.php";
date_default_timezone_set('Asia/Calcutta');

$xls_filename = 'Organiser_Reports.xls'; 

header("Content-Type: application/csv");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
$sep = "\t"; 

echo "Sn\tName\tContact\tEmail\tDOB\tAadhar No\tPAN No\tState\tDistrict\tAddress\tBank Name\tAcc No\tIFSC\tBranch";
print("\n");


	$alls=mysql_query('SELECT * FROM `organiser` order by oname asc');
	$sn=1; while($allsd=mysql_fetch_assoc($alls))
	{
	
    echo $sn.$sep;
	echo strtoupper($allsd['oname']).$sep;
	echo $allsd['mobile_1'].$sep;
	echo $allsd['email'].$sep;
	echo $allsd['dob'].$sep;
	echo '`'.$allsd['aadhar_no'].'`'.$sep;
	echo $allsd['pan_no'].$sep;
	echo $allsd['StateName'].$sep;
	echo $allsd['DictrictName'].$sep;
	echo strtoupper($allsd['address'].', '.$allsd['StateName'].', '.$allsd['DictrictName'].', '.$allsd['city'].'-'.$allsd['pincode']).$sep;
	echo strtoupper($allsd['bank_name']).$sep;
	echo '`'.$allsd['account_no'].'`'.$sep;
	echo strtoupper($allsd['ifsc_code']).$sep;
	echo strtoupper($allsd['bank_add']).$sep;
	print("\n");
	$sn++;
    }


?>


