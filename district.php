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
$alls=mysql_query('SELECT * FROM `state`');
while ($alldid=mysql_fetch_assoc($alls)) {
	$arr[$alldid['StateId']]=$alldid['StateName'];
}
?>

<div class="pagethings" style="width:60%;">
		
	<div id="savmsg" class="alert alert-success frminp" style="display:none ;">Saved Successfully!</div>

	<button id="adddibtn" class="frmbtn btn btn-sm btn-primary " onclick="$('#addditbl').show(500);$(this).hide(500);">Add District</button>

	<div id="addditbl" style="display: none;margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;">
		<h6 style="font-weight: bold;">New District</h6>
		<table class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>District Name <font color="#FF0000">*</font></th>
				<th>State Name <font color="#FF0000">*</font></th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			
			<tr>
				<td>
					<input class="form-control frminp" id="dina" >
				</td>
				<td>
					<select id="dista" class="form-control frminp" >
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
					<button id="addbtn" class="frmbtn btn btn-primary btn-sm" onclick="adddi()">Save</button>
					<button class="frmbtn btn btn-sm btn-danger" onclick="$('#addditbl').hide(500);$('#adddibtn').show(500);">Cancel</button>
				</td>
				
			</tr>
			
			</tbody>
			
		</table>
		
	</div>

	<div id="addditbl" style="margin-bottom: 10px;padding:2px;background-color: #EDEDED;border:2px solid #ccc;overflow:scroll;">
		<h6 style="font-weight: bold;">All Districts</h6>
		<table id="disttable" class=" estable table table-bordered" style="width:100%;">
			<thead>
			<tr>
				<th>District Name <font color="#FF0000">*</font></th>
				<th>State Name <font color="#FF0000">*</font></th>
				<th>Action</th>

			</tr>
			</thead>
			<tbody>

			<?php
			$alldi=mysql_query('SELECT * FROM `distric`');

			while ($alldid=mysql_fetch_assoc($alldi)) {
			?>
			<tr>
				<td>
					<span id="showdina<?=$alldid['DictrictId']?>" style="float: left;"><?=strtoupper($alldid['DictrictName'])?></span>
					<input class="form-control frminp nshw" id="dina<?=$alldid['DictrictId']?>" value="<?=strtoupper($alldid['DictrictName'])?>" >
				</td>
				
				<td>
					<span id="showdista<?=$alldid['DictrictId']?>" style="float: left;"><?=$arr[$alldid['StateId']]?></span>
					<select id="dista<?=$alldid['DictrictId']?>" class="form-control frminp nshw" >
						<option disabled >Select</option>
						<?php
						foreach ($arr as $key => $value) {?>
						   
						
						<option value="<?=$key?>" <?=($alldid['StateId']==$key)?'selected':'';?> ><?=$value?></option>
						
						<?php
						}
						?>

					</select>
				</td>
				<td>
					<button id="ebtn<?=$alldid['DictrictId']?>" class="frmbtn btn btn-primary btn-sm" onclick="editd('<?=$alldid['DictrictId']?>')">Edit</button>
					<button id="sbtn<?=$alldid['DictrictId']?>" class="frmbtn btn btn-success btn-sm" onclick="saved('<?=$alldid['DictrictId']?>')" style="display:none;" >Save</button>
					<button id="cbtn<?=$alldid['DictrictId']?>" class="frmbtn btn btn-sm btn-danger" onclick="cancd('<?=$alldid['DictrictId']?>')" style="display:none;">Cancel</button>
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
		$('#dina'+id).show();
		$('#dista'+id).show();

		$('#showdina'+id).hide();
		$('#showdista'+id).hide();

		$('#ebtn'+id).hide();
		$('#sbtn'+id).show();
		$('#cbtn'+id).show();
	}

	function cancd(id){
		$('#dina'+id).hide();
		$('#dista'+id).hide();

		$('#showdina'+id).show();
		$('#showdista'+id).show();

		$('#ebtn'+id).show();
		$('#sbtn'+id).hide();
		$('#cbtn'+id).hide();
		
	}

	function saved(id){
		var dina  = $('#dina'+id).val();
		var dista = $('#dista'+id).val();
		
		if(dina==''){ alert("enter district name"); return false; }
		if(dista==''){ alert("select state name"); return false; }
		
		$.post("mastersAjax.php",{ act:'saveDistrictDetails',dina:dina , dista:dista ,id:id },function(data) {
                          
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


	function adddi(){
		var dina  = $('#dina').val();
		var dista = $('#dista').val();
		
		if(dina==''){ alert("enter district name"); return false; }
		if(dista==''){ alert("select state name"); return false; }

		$.post("mastersAjax.php",{ act:'addDistrict',dina:dina , dista:dista },function(data) {
                                                    
			if(data.includes("added")){
				$('#addditbl').hide();
				$("#savmsg").show(300);
				setTimeout(function(){ window.location.href = '<?=basename($_SERVER['PHP_SELF'])?>';  }, 800);

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
	    $('#disttable').DataTable();
	} );
</script>


