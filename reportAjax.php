<?php
session_start();
include 'config.php'; 


if(isset($_POST['act']) && $_POST['act']=='get_report'){

	$alls=mysql_query('SELECT * FROM `state`');
	while ($allsd=mysql_fetch_assoc($alls)) {
		$sarr[$allsd['StateId']]=$allsd['StateName'];
	}

	$alld=mysql_query('SELECT * FROM `distric`');
	while ($alldd=mysql_fetch_assoc($alld)) {
		$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
	}

	$allt=mysql_query('SELECT * FROM `tahsil`');
	while ($alltd=mysql_fetch_assoc($allt)) {
		$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
	}

	$allv=mysql_query('SELECT * FROM `village`');
	while ($allvd=mysql_fetch_assoc($allv)) {
		$varr[$allvd['VillageId']]=$allvd['VillageName'];
	}

	$from = date('Y-m-d',strtotime($_POST['from']));
	$to = date('Y-m-d',strtotime($_POST['to']));

	

	$agr=mysql_query("SELECT agr.*, u.uName, f.fname, f.father_name, f.village_id, f.tahsil_id, f.distric_id, f.state_id, o.oname  FROM `agreement_".$_SESSION['year']."` agr, users u, farmers f, organiser o where agree_date between '".$from."' and '".$to."' and agr.prod_person=u.uId and agr.second_party=f.fid and agr.org_id=o.oid");



	while ($agrd=mysql_fetch_assoc($agr)) {
	?>
	<tr>
		<td><?=$agrd['agree_no']?></td>
		<td><?=$agrd['oname']?></td>
		<td><?=$agrd['uName']?></td>
		<td><?=$agrd['second_party']?></td>
		<td><?=$agrd['fname']?></td>
		<td><?=$agrd['father_name']?></td>
		<td><?=$varr[$agrd['village_id']]?></td>
		<td><?=$tarr[$agrd['tahsil_id']]?></td>
		<td><?=$darr[$agrd['distric_id']]?></td>
		<td><?=$sarr[$agrd['state_id']]?></td>
		<td><?=$agrd['sowing_acres']?></td>
		<td><?=$agrd['standing_acres']?></td>
	</tr>

	<?php
	}

}
?>	