<?php
include 'sidemenu.php';



 /*
====================================================================================================================
====================================================================================================================
   
    the page   'changeFarmerDocNames.php'    is for renaming the uploaded images as per the combination of 
    "uploaded id"+"category name"
    to make the uploaded file names unique

====================================================================================================================
====================================================================================================================
*/
include 'changeFarmerDocNames.php'



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
	.lightlabel{
		background-color: #ccc !important;
		padding-left: 5px !important;
		font-size: 12px;
		font-weight: bold;
		padding: 0px;
	}
	.fstable tbody th{
	  color: #000;
	  font-size: 12px;
	  font-weight: bold;
	  padding: 5px !important;
	}

	.fstable tbody td{
	  padding: 1px;
	}

</style>

<?php
/*============================================
here taking all the states, districts, tahsils, village and putting on a array, 
so in below loops we don't have to fetch all states again and again...
==============================================*/

$sarr=$_SESSION['sarr'];
$darr=$_SESSION['darr'];

// $alls=mysql_query('SELECT * FROM `state`');
// while ($allsd=mysql_fetch_assoc($alls)) {
// 	$sarr[$allsd['StateId']]=$allsd['StateName'];
// }

// $alld=mysql_query('SELECT * FROM `distric`');
// while ($alldd=mysql_fetch_assoc($alld)) {
// 	$darr[$alldd['DictrictId']]=$alldd['DictrictName'];
// }

/*

$allt=mysql_query('SELECT * FROM `tahsil`');
while ($alltd=mysql_fetch_assoc($allt)) {
	$tarr[$alltd['TahsilId']]=$alltd['TahsilName'];
}

$allv=mysql_query('SELECT * FROM `village`');
while ($allvd=mysql_fetch_assoc($allv)) {
	$varr[$allvd['VillageId']]=$allvd['VillageName'];
}

*/

?>

<div class="pagethings">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="addfarbtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addfartbl').show(800);$('#actiontext').html('&nbsp;New Farmer');$(this).hide(500);$('#addFarmIframe').attr('src','addFarmer_two.php');">Add Farmer</button>

	<div id="addfartbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;" id="actiontext"></h6>
		
		<iframe id="addFarmIframe" src="" style="width:100%;height:420px;border:0px;"></iframe>
	</div>

	<div id="addfartbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;width:100%;">
		<h6 style="font-weight: bold;">All Farmer &nbsp;&nbsp;&nbsp;&nbsp;
		 <font style="font-size:12px;">
		 Date From:&nbsp;<input id="df" name="df" style="width:130px;text-align:center;" value="<?=date("d-m-Y",strtotime($_REQUEST['df']));?>" readonly/>
		 &nbsp;&nbsp;
		 To:&nbsp;<input type="text" id="dt" name="dt" style="width:130px;text-align:center;" value="<?=date("d-m-Y",strtotime($_REQUEST['dt']));?>" readonly/>
		 &nbsp;
		 <input type="button" value="show" onclick="FunClickFT()" style="width:60px;"/> 
		 </font>
		<script language="javascript">
		 $('#df').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#df').val(); });
		 $('#dt').datepicker({format:'dd-mm-yyyy',}).on('change', function(){ var date = $('#dt').val(); });
		 function FunClickFT()
		 {
		  var df=$('#df').val(); var dt=$('#dt').val();
		  window.location="farmer.php?df="+df+"&dt="+dt;
		 }
		</script>
		</h6>
		
		<table id="tahtable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
			<th style="width:50px;">Sn</th>
			<th style="width:60px;">Farmer ID</th>
			<th style="width:130px;">Temporary ID</th>
			<th style="width:150px;">Farmer Name</th>
			<th style="width:80px;">Contact</th>
			<th style="width:150px;">Father of/ Wife of</th>
			<th style="width:100px;">State</th>
			<th>District</th>
			<!--<th>Tahsil</th>
			<th>Village</th>-->
			<th style="width:100px;">File</th>
			<th style="width:50px;">Action</th>
			</tr>
			</thead>
			<tbody>

			<?php if($_REQUEST['df']!='' && $_REQUEST['dt']!='')
			{ 
			 $allvar=mysql_query("SELECT * FROM `farmers` where cr_date between '".date("Y-m-d",strtotime($_REQUEST['df']))."' AND '".date("Y-m-d",strtotime($_REQUEST['dt']))."' order by fname asc");
             $sn=1;
			 while($allf=mysql_fetch_assoc($allvar)){ 
			
			 $len=strlen($allf['fid']);
			 if($len==1){$fid='0000'.$allf['fid'];}elseif($len==2){$fid='000'.$allf['fid'];}
			 elseif($len==3){$fid='00'.$allf['fid'];}elseif($len==4){$fid='0'.$allf['fid'];}else{$fid=$allf['fid'];}
			?>
			<tr>
                
				<td>
					<?=$sn?>
				</td>
				<td>
					<?=$fid?>
				</td>
				
				<td  style="text-align:left;">
					<?php
					$str = chunk_split($allf['tem_fid'], 4, ' ');
					echo $str;
					?>
				</td>
				
				<td style="text-align:left;">
					<?=$allf['fname']?>
				</td>
				<td>
					<?=$allf['contact_1']?>
				</td>
				<td style="text-align:left;">
					<?=$allf['father_name']?>
				</td>
				<td>
					<?=$sarr[$allf['state_id']]?>
				</td>
				<td>
					<?=$darr[$allf['distric_id']]?>
				</td>
				
				<?php /* ?>
				<td>
					<?=$tarr[$allf['tahsil_id']]?>
				</td>
				<td>
					<?=$varr[$allf['village_id']]?>
				</td>
				<?php */ ?>
				
				<td>
					<?php if($allf['doc_passbook']!=''){ ?>
					<a href="JavaScript:void(0);"  onclick="openthis('<?=$allf['doc_passbook']?>')">Passbook</a>

					<?php }if($allf['doc_idproof']!=''){ ?>
					&nbsp;&nbsp;&nbsp;<a href="JavaScript:void(0);" onclick="openthis('<?=$allf['doc_idproof']?>')">ID</a>

					<?php }if($allf['doc_addproof']!=''){ ?>
					&nbsp;&nbsp;&nbsp;<a href="JavaScript:void(0);" onclick="openthis('<?=$allf['doc_addproof']?>')">Address</a>
					<?php } ?>
				</td>
				
				<td>
					<button id="ebtn<?=$allf['fid']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allf['fid']?>')">Edit</button>
				</td>
				
			</tr>
			
			<?php $sn++;
			 }
			
			} //if($_REQUEST['df']!='' && $_REQUEST['dt']!='') 
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	function editd(id){
		$('#addfartbl').show(800);
		$('#actiontext').html('&nbsp;Edit Farmer');
		$('#addfarbtn').hide(500);
		$('#addFarmIframe').attr('src','editFarmer.php?fid='+id);
	}

	$(document).ready(function() {
	    $('#tahtable').DataTable();
	} );
	

	function openthis(file){
		window.open('files/'+file,'Farmer Details', 'width=800, height=600');
	}
	
	
</script>







