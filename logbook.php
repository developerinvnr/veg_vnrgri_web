<?php
include 'sidemenu.php';
date_default_timezone_set('Asia/Calcutta');

function getUName($uid){
	$u=mysql_query("select uName from users where uId ='".$uid."'");
	$ud=mysql_fetch_assoc($u);
	return $ud['uName'];

}
?>

<style type="text/css">
	.pagethings{
		position: absolute;
		left: 200px;
		padding: 20px;
	}
	.nshw{
		display: none;
	}

</style>

<?php
/*============================================
here taking all the states and putting on a array, 
so in below district loop we don't have to fetch all states again and again...
==============================================*/
$alls=mysql_query('SELECT * FROM `state`');
while ($alldid=mysql_fetch_assoc($alls)) {
	$arr[$alldid['StateId']]=$alldid['StateName'];
}
?>

<div class="pagethings" style="width:60%;">
		
	

	<div id="addditbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">All Logs</h6>
		<table id="disttable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>User <font color="#FF0000">*</font></th>
				<th>Action <font color="#FF0000">*</font></th>
				<th>Date Time</th>

			</tr>
			</thead>
			<tbody>

			<?php
			$q = "SELECT * FROM `logbook`";

			$selu = mysql_query("select uType from users where uId=".$_SESSION['uId']);
			$selud = mysql_fetch_assoc($selu);
			if($selud['uType'] != 'S'){
				$q .= " where uid =".$_SESSION['uId'];
			}

			$l=mysql_query($q);

			while ($log=mysql_fetch_assoc($l)) {
			?>
			<tr>
				<td>
					<?php echo getUName($log['uid']); ?>
				</td>
				
				<td style="text-align:left;">
					<?php echo $log['action']; ?>
				</td>
				<td>
					<?php echo date("d-m-Y h:i:s", strtotime($log['logDateTime'])); ?>
				</td>
				
			</tr>
			
			<?php
			}
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	

	$(document).ready(function() {
	    $('#disttable').DataTable();
	} );
</script>


