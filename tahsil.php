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
here taking all the districts and putting on a array, 
so in below Tahsil loop we don't have to fetch all states again and again...
==============================================*/
$alld=mysql_query('SELECT * FROM `distric`');
while ($alldd=mysql_fetch_assoc($alld)) {
	$arr[$alldd['DictrictId']]=$alldd['DictrictName'];
}
?>

<div class="pagethings" style="width:60%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="adddibtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addTahtbl').show(500);$(this).hide(500);">Add Tahsil</button>

	<div id="addTahtbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New Tahsil</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Tahsil Name <font color="#FF0000">*</font></th>
				<th>Tahsil Code <font color="#FF0000">*</font></th>
				<th>District <font color="#FF0000">*</font></th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="tahn" >
				</td>
				<td>
					<input class="form-control frminp" id="tahc" >
				</td>
				<td>
					<select id="tahdi" class="form-control frminp" >
						<option  >Select</option>
						<?php
						foreach ($arr as $key => $value) { ?>
						  
						<option value="<?=$key?>"  ><?=$value?></option>
						
						<?php
						}
						?>

					</select>
				</td>
				<td>
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="addtah()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addTahtbl').hide(500);$('#adddibtn').show(500);" >Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addTahtbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">All Tahsils</h6>
		<table id="tahtable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>Tahsil Name <font color="#FF0000">*</font></th>
				<th style="width: 92px;">Tahsil Code <font color="#FF0000">*</font></th>
				<th style="width: 100px;">District <font color="#FF0000">*</font></th>
				<th>Action</th>

			</tr>
			</thead>
			<tbody>

			<?php
			$alltah=mysql_query('SELECT * FROM `tahsil`');

			while ($alltahd=mysql_fetch_assoc($alltah)) {
			?>
			<tr>
				<td>
					<span id="showtahn<?=$alltahd['TahsilId']?>" style="float: left;"><?=strtoupper($alltahd['TahsilName'])?></span>
					<input class="form-control frminp nshw" id="tahn<?=$alltahd['TahsilId']?>"  value="<?=strtoupper($alltahd['TahsilName'])?>">
				</td>
				<td>
					<span id="showtahc<?=$alltahd['TahsilId']?>" style="float: left;"><?=strtoupper($alltahd['TahsilCode'])?></span>
					<input class="form-control frminp nshw" id="tahc<?=$alltahd['TahsilId']?>" value="<?=strtoupper($alltahd['TahsilCode'])?>" style="width:90px;">
				</td>
				<td>
					<span id="showtahdi<?=$alltahd['TahsilId']?>" style="float: left;"><?=strtoupper($arr[$alltahd['DistrictId']])?></span>
					<select id="tahdi<?=$alltahd['TahsilId']?>" class="form-control frminp nshw"  style="width: 100px;">
						<option>Select</option>
						<?php
						foreach ($arr as $key => $value) { ?>
						  
						<option value="<?=$key?>" <?=($alltahd['DistrictId']==$key)?'selected':'';?> ><?=strtoupper($value)?></option>
						
						<?php
						}
						?>

					</select>
				</td>


				
				<td>
					<button id="ebtn<?=$alltahd['TahsilId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$alltahd['TahsilId']?>')">Edit</button>
					<button id="sbtn<?=$alltahd['TahsilId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$alltahd['TahsilId']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$alltahd['TahsilId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$alltahd['TahsilId']?>')" style="display:none;">Cancel</button>

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
	function editd(id){

		$('#showtahn'+id).hide();
		$('#showtahc'+id).hide();
		$('#showtahdi'+id).hide();

		$('#tahn'+id).show();
		$('#tahc'+id).show();
		$('#tahdi'+id).show();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){

		$('#showtahn'+id).show();
		$('#showtahc'+id).show();
		$('#showtahdi'+id).show();

		$('#tahn'+id).hide();
		$('#tahc'+id).hide();
		$('#tahdi'+id).hide();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
	}

	function saved(id){
		var tahn  = $('#tahn'+id).val();
		var tahc = $('#tahc'+id).val();
		var tahdi = $('#tahdi'+id).val();
		
		if(tahn==''){ alert("enter tahsil name"); return false; }
		if(tahc==''){ alert("enter tahsil code"); return false; }
		if(tahdi==''){ alert("select district"); return false; }
		
		$.post("mastersAjax.php",{ act:'saveTahsilDetails',tahn:tahn , tahc:tahc , tahdi:tahdi ,id:id },function(data) {
                          
			if(data.includes("updated")){

				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}
			$('#ebtn'+id).show();
			$('#sbtn'+id).hide();
			$('#cbtn'+id).hide();
          }
        );

		
	}


	function addtah(){

		var tahn  = $('#tahn').val();
		var tahc = $('#tahc').val();
		var tahdi = $('#tahdi').val();
        
		if(tahn==''){ alert("enter tahsil name"); return false; }
		if(tahc==''){ alert("enter tahsil code"); return false; }
		if(tahdi==''){ alert("select district"); return false; }

		$.post("mastersAjax.php",{ act:'addTahsil',tahn:tahn,tahc:tahc,tahdi:tahdi },function(data) {
                                                    
			if(data.includes("added")){
				$('#addTahtbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href =  "<?=basename($_SERVER['PHP_SELF'])?>";  }, 800);

			}else if(data.includes("error")){
				alert(' Something went wrong! \n Please try again after sometime. \n\n\n');
			}

			
          }
        );
		
	}


	

	function editp(th,id){
		$(th).hide();
		$('#spbtn'+id).show();
		$('#pertr'+id).show();

	}
	$(document).ready(function() {
	    $('#tahtable').DataTable();
	} );
</script>


