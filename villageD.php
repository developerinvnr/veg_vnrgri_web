<?php
include 'sidemenu.php';
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
/*
$alls=mysql_query('SELECT * FROM `tahsil` order by TahsilName');
while ($allvid=mysql_fetch_assoc($alls)) {
	$arr[$allvid['TahsilId']]=$allvid['TahsilName'];
}
*/

$alls=mysql_query('SELECT t.*,DictrictName FROM `tahsil` t inner join distric d on t.DistrictId=d.DictrictId order by TahsilName');
while ($allvid=mysql_fetch_assoc($alls)) {
	$arr[$allvid['TahsilId']]=$allvid['TahsilName'].' - ('.$allvid['DictrictName'].')';
}
?>

<div class="pagethings" style="width:60%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

    <?php /*
	<button id="adddibtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addvitbl').show(500);$(this).hide(500);">Add Village</button>*/ ?>

	<div id="addvitbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Village</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Village Name <font color="#FF0000">*</font></th>
				<th>Tahsil Name - (District) <font color="#FF0000">*</font></th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="vina" >
				</td>
				<td>
					<select id="vita" class="form-control frminp" >
						<option  >Select</option>
						<?php
						foreach ($arr as $key => $value) { ?>
						  
						<option value="<?=$key?>"  ><?=$value.'-'.$key?></option>
						
						<?php
						}
						?>

					</select>
				</td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addvi()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addvitbl').hide(500);$('#adddibtn').show(500);" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

<script>
function FunState(s)
{
window.location="villageD.php?s="+s;    
}
</script>

	<div id="addvitbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;float:center;">
		<h6 style="font-weight: bold;">All Villages</h6>
		
		
		<?php $sarr=$_SESSION['sarr']; ?>
		<span style="float:center;">
		<select class="form-control frminp" name="state_id" id="state_id" onChange="FunState(this.value)" style="width:150px;">
					<option value="">Select State</option>
					<?php foreach ($sarr as $key => $value) { ?> 
					<option value="<?=$key?>"  ><?=$value?></option>
					<?php }	?>
					<option value="999"  >All State</option>
				</select>
		</span>
		
		

		<table id="villtable" class="estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Village Name <font color="#FF0000">*</font></th>
				<th>Tahsil Name - (District) <font color="#FF0000">*</font></th>
				<th>Action</th>

			</tr>
			</thead>
			<tbody>

			<?php  if($_REQUEST['s']>0){
			    
			    if($_REQUEST['s']==999)
			    {
			        
			        $allvi=mysql_query("SELECT * FROM `village` order by VillageName");
			        
			    }
			    else
			    {
			$allvi=mysql_query("SELECT * FROM `village` v inner join tahsil t on v.TahsilId=t.TahsilId inner join distric d on t.DistrictId=d.DictrictId where d.StateId=".$_REQUEST['s']." order by VillageName");
			    }

			while ($allvid=mysql_fetch_assoc($allvi)) { 
			?>
			<tr>
				<td>
					<span id="showvina<?=$allvid['VillageId']?>" style="float: left;"><?=strtoupper($allvid['VillageName'])?></span>
					<input class="form-control frminp nshw" id="vina<?=$allvid['VillageId']?>" value="<?=strtoupper($allvid['VillageName'])?>" >
				</td>
				
				<td>
					<span id="showvita<?=$allvid['VillageId']?>" style="float: left;"><?=strtoupper($arr[$allvid['TahsilId']])?></span>
					<select id="vita<?=$allvid['VillageId']?>" class="form-control frminp nshw" >
						<option disabled >Select</option>
						<?php
						foreach ($arr as $key => $value) {?>
						   
						
						<option value="<?=$key?>" <?=($allvid['TahsilId']==$key)?'selected':'';?> ><?=strtoupper($value)?></option>
						
						<?php
						 } 
						?>

					</select>
				</td>
				<td>
					<button id="ebtn<?=$allvid['VillageId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$allvid['VillageId']?>')">Edit</button>
					<button id="sbtn<?=$allvid['VillageId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$allvid['VillageId']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$allvid['VillageId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$allvid['VillageId']?>')" style="display:none;">Cancel</button>
				</td>
				
			</tr>
			
			<?php
			
			 } //if($_REQUEST['s']>0)
			} 
			?>	
			</tbody>
		</table>
	</div>
	
	

</div>

<script type="text/javascript">
	function editd(id){
		$('#vina'+id).show();
		$('#vita'+id).show();

		$('#showvina'+id).hide();
		$('#showvita'+id).hide();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#vina'+id).hide();
		$('#vita'+id).hide();

		$('#showvina'+id).show();
		$('#showvita'+id).show();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
		
	}

	function saved(id){
		var vina  = $('#vina'+id).val();
		var vita = $('#vita'+id).val();
		
		if(vina==''){ alert("enter village name"); return false; }
		if(vita==''){ alert("select tahsil name"); return false; }
		
		$.post("mastersAjax.php",{ act:'saveVillageDetails',vina:vina , vita:vita ,id:id },function(data) {
                          
			if(data.includes("updated")){

				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>'; }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
          }
        );

		
	}


	function addvi(){
		var vina  = $('#vina').val();
		var vita = $('#vita').val();
		
		if(vina==''){ alert("enter village name"); return false; }
		if(vita==''){ alert("select tahsil name"); return false; }

		$.post("mastersAjax.php",{ act:'addVillage',vina:vina , vita:vita },function(data) { alert(data);
                                                    
			if(data.includes("added")){
				$('#addvitbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}



	$(document).ready(function() {
	    $('#villtable').DataTable();
	} );
</script>


